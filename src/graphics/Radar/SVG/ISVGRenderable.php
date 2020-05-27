<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Radar\SVG;

use SVG\Nodes\SVGNode;

interface ISVGRenderable
{
    public function getNormalizedSvgX(): float;

    public function getNormalizedSvgY(): float;

    public function exportSVG(): SVGNode;
}
