<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Radar\SVG;

use SVG\Nodes\SVGNode;

/**
 * @phpstan-template T of \allejo\bzflag\world\Object\Obstacle
 * @phpstan-implements ISVGRenderable<T>
 */
abstract class ObstacleRenderer implements ISVGRenderable
{
    /** @phpstan-var T */
    protected $obstacle;

    /** @phpstan-var WorldBoundary */
    protected $worldBoundary;

    /**
     * @param T             $obstacle
     * @param WorldBoundary $worldBoundary
     */
    public function __construct(&$obstacle, array $worldBoundary)
    {
        $this->obstacle = &$obstacle;
        $this->worldBoundary = $worldBoundary;
    }

    abstract public function exportSVG(): SVGNode;

    /**
     * Translate the position, sizing, and rotation of a BZFlag world object to
     * the SVG equivalent via `transform` alterations.
     *
     * @phpstan-param class-string $cls
     */
    protected function objectToSvgNode(string $cls): SVGNode
    {
        list($sizeX, $sizeY) = $this->obstacle->getSize();
        list($posX, $posY) = $this->obstacle->getPosition();

        $worldBX = $this->worldBoundary['x'];
        $worldBY = $this->worldBoundary['y'];

        $svgPosX = $posX + ($worldBX / 2);
        $svgPosY = abs($posY + ($worldBY / -2));

        $rot = -1 * $this->obstacle->getRotation();

        $svg = new $cls($svgPosX, $svgPosY, $sizeX, $sizeY);
        $svg->setAttribute(
            'transform',
            implode(' ', [
                sprintf('translate(%.6f %.6f)', -1 * ($svgPosX + $sizeX), -1 * ($svgPosY + $sizeY)),
                'scale(2 2)',
                sprintf('rotate(%.6f %.6f %.6f)', $rot, $svgPosX + ($sizeX / 2), $svgPosY + ($sizeY / 2)),
            ])
        );

        return $svg;
    }
}
