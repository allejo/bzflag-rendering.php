<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Radar\SVG;

use allejo\bzflag\world\Object\Obstacle;
use SVG\Nodes\SVGNode;

abstract class BaseRenderer implements ISVGRenderable
{
    /** @var Obstacle */
    protected $obstacle;

    /** @var array{x: int, y: int} */
    protected $worldBoundary;

    public function __construct(&$obstacle, array $worldBoundary)
    {
        $this->obstacle = &$obstacle;
        $this->worldBoundary = $worldBoundary;
    }

    abstract public function exportSVG(): SVGNode;

    public function getNormalizedSvgX(): float
    {
        $length = $this->worldBoundary['x'] / 2;

        return $this->obstacle->getPosition()[0] + $length;
    }

    public function getNormalizedSvgY(): float
    {
        $length = $this->worldBoundary['y'] / -2;

        return abs($this->obstacle->getPosition()[1] + $length);
    }
}
