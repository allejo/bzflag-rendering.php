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

    abstract public function getNormalizedPosX(): float;

    abstract public function getNormalizedPosY(): float;

    public function exportSVG(): SVGNode
    {
        $size = $this->obstacle->getSize();

        $svg = new SVGRect(
            $this->getNormalizedPosX(),
            $this->getNormalizedPosY(),
            $size[0],
            $size[1]
        );
        $svg->setStyle('fill', 'rgb(0, 204, 255)');
        $svg->setAttribute(
            'transform',
            sprintf('rotate(%d %d %d)', $this->obstacle->getRotation(), $this->getNormalizedPosX(), $this->getNormalizedPosY())
        );

        return $svg;
    }
}
