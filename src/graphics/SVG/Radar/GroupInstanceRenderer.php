<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\world\GroupDefinitionNotFoundException;
use allejo\bzflag\world\Object\BaseBuilding;
use allejo\bzflag\world\Object\GroupDefinition;
use allejo\bzflag\world\Object\GroupInstance;
use allejo\bzflag\world\Object\ObstacleType;
use SVG\Nodes\SVGNode;

/**
 * @extends ObstacleRenderer<\allejo\bzflag\world\Object\GroupInstance>
 */
class GroupInstanceRenderer extends ObstacleRenderer
{
    /** @var GroupInstance */
    protected $obstacle;

    /**
     * @param GroupInstance $instance
     * @phpstan-param WorldBoundary $worldBoundary
     */
    public function __construct($instance, array $worldBoundary)
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

        if ($this->bzwAttributesEnabled)
        {
            if (!empty($groupDefName))
            {
                $svgNode->setAttribute('bzw:name', $groupDefName);
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
}
