<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\graphics\Common\BzwAttributesAwareTrait;
use allejo\bzflag\graphics\Common\IBzwAttributesAware;
use allejo\bzflag\graphics\Common\WorldBoundary;
use allejo\bzflag\graphics\SVG\ISVGRenderable;
use allejo\bzflag\world\GroupDefinitionNotFoundException;
use allejo\bzflag\world\Object\GroupDefinition;
use allejo\bzflag\world\Object\Obstacle;
use allejo\bzflag\world\Object\ObstacleType;
use SVG\Nodes\Structures\SVGGroup;
use SVG\Nodes\SVGNode;

/**
 * @internal
 *
 * @implements ISVGRenderable<\allejo\bzflag\world\Object\GroupDefinition>
 */
class GroupDefinitionRenderer implements IBzwAttributesAware, ISVGRenderable
{
    use BzwAttributesAwareTrait;

    /** @var GroupDefinition */
    protected $obstacle;

    /** @phpstan-var WorldBoundary */
    protected $worldBoundary;

    /** @var array<ObstacleType::*, class-string> */
    private static $mapping = [
        ObstacleType::BOX_TYPE => BoxRenderer::class,
        ObstacleType::PYR_TYPE => PyramidRenderer::class,
        ObstacleType::BASE_TYPE => BaseRenderer::class,
        ObstacleType::TELE_TYPE => TeleporterRenderer::class,
    ];

    /**
     * @param GroupDefinition $groupDefinition
     */
    public function __construct($groupDefinition, WorldBoundary $worldBoundary)
    {
        $this->obstacle = $groupDefinition;
        $this->worldBoundary = $worldBoundary;
    }

    /**
     * @throws GroupDefinitionNotFoundException
     */
    public function exportSVG(): SVGNode
    {
        $group = new SVGGroup();
        $obstaclesByType = $this->obstacle->getObstacles();

        foreach ($obstaclesByType as $obstacleType => $obstacles)
        {
            foreach ($obstacles as $obstacle)
            {
                $renderer = $this->getObjectRenderer($obstacle);

                if ($renderer === null)
                {
                    continue;
                }

                $renderer->enableBzwAttributes($this->bzwAttributesEnabled);
                $group->addChild($renderer->exportSVG());
            }
        }

        foreach ($this->obstacle->getGroupInstances() as $groupInstance)
        {
            $instance = new GroupInstanceRenderer($groupInstance, $this->worldBoundary);
            $instance->enableBzwAttributes($this->bzwAttributesEnabled);

            $group->addChild($instance->exportSVG());
        }

        return $group;
    }

    /**
     * @phpstan-return ISVGRenderable<Obstacle>|null
     */
    private function getObjectRenderer(Obstacle $obstacle): ?ISVGRenderable
    {
        $renderer = self::$mapping[$obstacle->getObjectType()] ?? null;

        if ($renderer === null)
        {
            return null;
        }

        return new $renderer($obstacle, $this->worldBoundary);
    }
}
