<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG;

use allejo\bzflag\graphics\Common\WorldBoundary;
use SVG\Nodes\SVGNode;

/**
 * @template T
 *
 * @since 0.1.0
 */
interface ISVGRenderable
{
    /**
     * @param T $obstacle
     */
    public function __construct($obstacle, WorldBoundary $worldBoundary);

    /**
     * Add BZW information as `data-` attributes to the SVG objects.
     *
     * @since 0.1.0
     */
    public function enableBzwAttributes(bool $enabled): void;

    /**
     * Get an SVG rendering of how this obstacle should look.
     *
     * @since 0.1.0
     */
    public function exportSVG(): SVGNode;
}
