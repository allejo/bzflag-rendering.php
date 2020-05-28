<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Radar\SVG;

use allejo\bzflag\world\Object\Obstacle;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

trait RectangularSVGTrait
{
    /** @var Obstacle */
    protected $obstacle;

    /** @var array{x: int, y: int} */
    protected $worldBoundary;

    public function exportSVG(): SVGNode
    {
        list($sizeX, $sizeY) = $this->obstacle->getSize();
        list($posX, $posY) = $this->obstacle->getPosition();

        $worldBX = $this->worldBoundary['x'];
        $worldBY = $this->worldBoundary['y'];

        $svgPosX = $posX + ($worldBX / 2);
        $svgPosY = abs($posY + ($worldBY / -2));

        $rot = -1 * $this->obstacle->getRotation();

        $svg = new SVGRect($svgPosX, $svgPosY, $sizeX, $sizeY);
        $svg->setStyle('fill', 'rgb(0, 204, 255)');
        $svg->setAttribute(
            'transform',
            implode(' ', [
                sprintf('translate(%d %d)', -1 * ($svgPosX + $sizeX), -1 * ($svgPosY + $sizeY)),
                'scale(2 2)',
                sprintf('rotate(%d %d %d)', $rot, $svgPosX + ($sizeX / 2), $svgPosY + ($sizeY / 2)),
            ])
        );

        return $svg;
    }
}
