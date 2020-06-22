<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG;

use SVG\Nodes\SVGNode;

abstract class SVGStylableUtilities
{
    public static function applyFill(SVGNode $node, string $fillColor): void
    {
        if ($fillColor === 'transparent')
        {
            $node->setAttribute('fill-opacity', '0');
        }
        else
        {
            $node->setAttribute('fill', $fillColor);
        }
    }

    public static function applyStroke(SVGNode $node, string $color, int $width): void
    {
        if ($color === 'transparent')
        {
            $node->setAttribute('stroke-width', '0');
        }
        else
        {
            $node->setAttribute('stroke', $color);
            $node->setAttribute('stroke-width', (string)$width);
        }
    }
}
