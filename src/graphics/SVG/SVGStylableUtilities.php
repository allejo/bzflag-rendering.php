<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG;

use SVG\Nodes\SVGNode;

/**
 * @since 0.2.0
 */
abstract class SVGStylableUtilities
{
    /**
     * @since 0.2.0
     */
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

    /**
     * @since 0.2.0
     */
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

            //
            // Manipulate our SVGNode to shrink its size to account for the extra width added by the object stroke
            //

            // Get current values
            $nodeX = (int)$node->getAttribute('x');
            $nodeY = (int)$node->getAttribute('y');
            $nodeHeight = (int)$node->getAttribute('height');
            $nodeWidth = (int)$node->getAttribute('width');

            // Move the X + Y positions by half of the stroke width. Strokes in SVGs are applied at the center of the
            // path, meaning half the stroke will be on the inside of the object and the other half on the outside of
            // the path.
            $newX = $nodeX + ($width / 2);
            $newY = $nodeY + ($width / 2);

            // Calculate the size of the node by taking into account the stroke on both sides
            $newHeight = $nodeHeight - $width;
            $newWidth = $nodeWidth - $width;

            $node->setAttribute('x', (string)$newX);
            $node->setAttribute('y', (string)$newY);
            $node->setAttribute('height', (string)$newHeight);
            $node->setAttribute('width', (string)$newWidth);
        }
    }
}
