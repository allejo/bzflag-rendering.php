<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Radar\SVG;

use allejo\bzflag\world\Object\Obstacle;
use allejo\bzflag\world\Object\ObstacleType;
use allejo\bzflag\world\Object\WallObstacle;
use allejo\bzflag\world\WorldDatabase;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

class WorldRenderer
{
    /** @var WorldDatabase */
    private $worldDatabase;

    /** @var array{x: int, y: int} */
    private $worldBoundary;

    /** @var SVGDocumentFragment */
    private $document;

    /** @var SVG */
    private $svg;

    /** @var array<int, ObstacleType::*> */
    private static $mapping = [
        ObstacleType::BOX_TYPE => BoxRenderer::class,
        ObstacleType::PYR_TYPE => PyramidRenderer::class,
    ];

    public function __construct(WorldDatabase &$database)
    {
        $this->worldDatabase = &$database;
        $this->worldBoundary = $this->calcWorldBoundary();

        $this->svg = new SVG($this->worldBoundary['x'], $this->worldBoundary['y']);
        $this->document = $this->svg->getDocument();
        $this->document->setStyle('border', '1px solid rgb(0, 204, 255)');

        $rect = new SVGRect(0, 0, 30, 30);
        $rect->setStyle('fill', 'rgb(0, 204, 255)');
        $rect->setAttribute(
            'transform',
            'translate(-15 -15) scale(2 2) rotate(45 15 15)'
        );

//        $this->document->addChild($rect);

        $this->renderObstacleSVGs();
    }

    public function exportStringSVG(): string
    {
        return (string)$this->svg;
    }

    /**
     * @return array{x: int, y: int}
     */
    private function calcWorldBoundary(): array
    {
        /** @var WallObstacle[] $walls */
        $walls = $this->worldDatabase
            ->getObstacleManager()
            ->getWorld()
            ->getObstaclesByType(ObstacleType::WALL_TYPE)
        ;

        if (count($walls) !== 4)
        {
            throw new \InvalidArgumentException('This library does not support drawing worlds with more than 4 walls');
        }

        $dimensions = [
            'x' => 0,
            'y' => 0,
        ];

        foreach ($walls as $wall)
        {
            if ($wall->getPosition()[0] === 0.0)
            {
                $dimensions['x'] += $wall->getBreadth();
            }
            elseif ($wall->getPosition()[1] === 0.0)
            {
                $dimensions['y'] += $wall->getBreadth();
            }
        }

        return $dimensions;
    }

    private function renderObstacleSVGs()
    {
        $obstaclesByType = $this->worldDatabase
            ->getObstacleManager()
            ->getWorld()
            ->getObstaclesByType()
        ;

        foreach ($obstaclesByType as $obstacles)
        {
            foreach ($obstacles as $obstacle)
            {
                $renderable = $this->getObjectRenderer($obstacle);

                if ($renderable === null)
                {
                    continue;
                }

                $this->document->addChild($renderable->exportSVG());
            }
        }
    }

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
