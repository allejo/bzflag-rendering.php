<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\graphics\Common\WorldBoundary;
use allejo\bzflag\graphics\SVG\Utilities\SVGTransformWrapper;
use allejo\bzflag\world\Exceptions\GroupDefinitionNotFoundException;
use allejo\bzflag\world\Modifiers\TransformType;
use allejo\bzflag\world\Object\BaseBuilding;
use allejo\bzflag\world\Object\GroupDefinition;
use allejo\bzflag\world\Object\GroupInstance;
use allejo\bzflag\world\Object\ObstacleType;
use SVG\Nodes\SVGNode;

/**
 * @internal
 *
 * @extends ObstacleRenderer<\allejo\bzflag\world\Object\GroupInstance>
 */
class GroupInstanceRenderer extends ObstacleRenderer
{
    /** @var GroupInstance */
    protected $obstacle;

    /**
     * @param GroupInstance $instance
     */
    public function __construct($instance, WorldBoundary $worldBoundary)
    {
        parent::__construct($instance, $worldBoundary);
    }

    /**
     * @throws GroupDefinitionNotFoundException
     */
    public function exportSVG(): SVGNode
    {
        $worldDB = $this->obstacle->getWorldDatabase();
        $groupDefName = $this->obstacle->getGroupDefinitionName();
        $groupDefinition = clone $worldDB->getObstacleManager()->getGroupDefinition($groupDefName);

        $this->applyTeamModification($groupDefinition);

        $output = new GroupDefinitionRenderer($groupDefinition, $this->worldBoundary);
        $output->enableBzwAttributes($this->bzwAttributesEnabled);
        $svgNode = $output->exportSVG();

        $this->applyTransformations($svgNode);

        if ($this->bzwAttributesEnabled)
        {
            if (!empty($groupDefName))
            {
                $svgNode->setAttribute('bzw:name', $groupDefName);
            }

            if ($this->obstacle->isModifyTeam())
            {
                $svgNode->setAttribute('bzw:team', (string)$this->obstacle->getTeam());
            }
        }

        return $svgNode;
    }

    private function applyTeamModification(GroupDefinition $groupDefinition): void
    {
        if (!$this->obstacle->isModifyTeam())
        {
            return;
        }

        /** @var BaseBuilding[] $bases */
        $bases = $groupDefinition->getObstaclesByType(ObstacleType::BASE_TYPE);

        /**
         * @var int          $i
         * @var BaseBuilding $base
         */
        foreach ($bases as $i => $base)
        {
            $newBase = clone $base;
            $newBase->setTeam($this->obstacle->getTeam());

            $bases[$i] = $newBase;
        }

        $groupDefinition->setObstaclesByType($bases, ObstacleType::BASE_TYPE);
    }

    private function applyTransformations(SVGNode $svgNode): void
    {
        $transforms = $this->obstacle->getTransform()->getTransforms();
        $transformWrapper = new SVGTransformWrapper($svgNode);
        $transformWrapper->enableBzwAttributes($this->bzwAttributesEnabled);

        foreach ($transforms as $transform)
        {
            switch ($transform->type) {
                case TransformType::SPIN_TRANSFORM:
                    $transformWrapper->rotate(rad2deg($transform->data[3]));

                    break;
                case TransformType::SHIFT_TRANSFORM:
                    $transformWrapper->shift(...$transform->data);

                    break;
                case TransformType::SCALE_TRANSFORM:
                    $transformWrapper->scale(...$transform->data);

                    break;
                default:
                    break;
            }
        }

        $transformWrapper->apply();
    }
}
