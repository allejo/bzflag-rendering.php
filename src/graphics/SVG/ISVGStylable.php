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
 * @phpstan-template T of \allejo\bzflag\world\Object\Obstacle
 *
 * @since 0.1.1
 */
interface ISVGStylable
{
    /**
     * @phpstan-param T $obstacle
     *
     * @since 0.1.1
     *
     * @param mixed $obstacle
     */
    public static function attachBzwAttributes(SVGNode $node, $obstacle): void;

    /**
     * @phpstan-param T $obstacle
     *
     * @since 0.1.1
     *
     * @param mixed $obstacle
     */
    public static function stylizeSVGNode(SVGNode $node, $obstacle): void;
}
