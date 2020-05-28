<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Radar\SVG;

use allejo\bzflag\world\Object\PyramidBuilding;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @extends ObstacleRenderer<PyramidBuilding>
 */
class PyramidRenderer extends ObstacleRenderer
{
    /**
     * @param PyramidBuilding $pyramid
     * @param WorldBoundary   $worldBoundary
     */
    public function __construct(&$pyramid, array $worldBoundary)
    {
        parent::__construct($pyramid, $worldBoundary);
    }

    public function exportSVG(): SVGNode
    {
        $svg = $this->objectToSvgNode(SVGRect::class);
        $svg->setStyle('fill', '#04CCFF');

        return $svg;
    }
}
