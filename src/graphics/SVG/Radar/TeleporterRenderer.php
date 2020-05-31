<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\world\Object\Teleporter;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @extends ObstacleRenderer<\allejo\bzflag\world\Object\Teleporter>
 */
class TeleporterRenderer extends ObstacleRenderer
{
    /**
     * @param Teleporter $teleporter
     * @phpstan-param WorldBoundary $worldBoundary
     */
    public function __construct($teleporter, array $worldBoundary)
    {
        parent::__construct($teleporter, $worldBoundary);
    }

    public function exportSVG(): SVGNode
    {
        $svg = $this->objectToSvgNode(SVGRect::class);
        $svg->setAttribute('stroke', 'yellow');

        return $svg;
    }
}
