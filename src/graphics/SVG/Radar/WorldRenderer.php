<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\graphics\SVG\ISVGRenderable;
use allejo\bzflag\world\Object\Obstacle;
use allejo\bzflag\world\Object\ObstacleType;
use allejo\bzflag\world\Object\WallObstacle;
use allejo\bzflag\world\WorldDatabase;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

class WorldRenderer
{
    /** @var WorldDatabase */
    private $worldDatabase;

    /** @phpstan-var WorldBoundary */
    private $worldBoundary;

    /** @var SVGDocumentFragment */
    private $document;

    /** @var SVG */
    private $svg;

    /** @var array<ObstacleType::*, class-string> */
    private static $mapping = [
        ObstacleType::BOX_TYPE => BoxRenderer::class,
        ObstacleType::PYR_TYPE => PyramidRenderer::class,
        ObstacleType::BASE_TYPE => BaseRenderer::class,
    ];

    public function __construct(WorldDatabase $database)
    {
        $this->worldDatabase = $database;
        $this->worldBoundary = $this->calcWorldBoundary();

        $this->svg = new SVG("{$this->worldBoundary['x']}px", "{$this->worldBoundary['y']}px");
        $this->document = $this->svg->getDocument();
        $this->document->setStyle('border', '1px solid rgb(0, 204, 255)');
        $this->document->setAttribute(
            'viewBox',
            sprintf('0 0 %d %d', $this->worldBoundary['x'], $this->worldBoundary['y'])
        );

        $this->renderObstacleSVGs();
    }

    public function exportStringSVG(): string
    {
        return (string)$this->svg;
    }

    /**
     * @phpstan-return WorldBoundary
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

    private function renderObstacleSVGs(): void
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

                $renderable->enableBzwAttributes(true);
                $this->document->addChild($renderable->exportSVG());
            }
        }
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
