<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\world\Object\BoxBuilding;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @extends ObstacleRenderer<\allejo\bzflag\world\Object\BoxBuilding>
 */
class BoxRenderer extends ObstacleRenderer
{
    /**
     * @param BoxBuilding $box
     * @phpstan-param WorldBoundary $worldBoundary
     */
    public function __construct($box, array $worldBoundary)
    {
        parent::__construct($box, $worldBoundary);
    }

    public function exportSVG(): SVGNode
    {
        $svg = $this->objectToSvgNode(SVGRect::class);
        $svg->setStyle('fill', '#04CCFF');

        return $svg;
    }
}
