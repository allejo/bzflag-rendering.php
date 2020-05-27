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

    abstract public function getNormalizedSvgX(): float;

    abstract public function getNormalizedSvgY(): float;

    public function exportSVG(): SVGNode
    {
        list($sizeX, $sizeY) = $this->obstacle->getSize();
        $posX = $this->getNormalizedSvgX();
        $posY = $this->getNormalizedSvgY();
        $rot = $this->obstacle->getRotation();

        $svg = new SVGRect(
            $this->getNormalizedSvgX(),
            $this->getNormalizedSvgY(),
            $sizeX,
            $sizeY
        );
        $svg->setStyle('fill', 'rgb(0, 204, 255)');
        $svg->setAttribute(
            'transform',
            sprintf('rotate(%d %d %d)', $rot, $posX, $posY)
        );

        return $svg;
    }
}
