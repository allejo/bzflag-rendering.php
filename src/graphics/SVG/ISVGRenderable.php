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
 * @since 0.1.0
 */
interface ISVGRenderable
{
    /**
     * @phpstan-param T             $obstacle
     * @phpstan-param WorldBoundary $worldBoundary
     *
     * @param object $obstacle
     */
    public function __construct($obstacle, array $worldBoundary);

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
