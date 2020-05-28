<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Radar\SVG;

use SVG\Nodes\SVGNode;

/**
 * @phpstan-template T of \allejo\bzflag\world\Object\Obstacle
 *
 * @since 0.0.0
 */
interface ISVGRenderable
{
    /**
     * @param T             $obstacle
     * @param WorldBoundary $worldBoundary
     */
    public function __construct(&$obstacle, array $worldBoundary);

    /**
     * Get an SVG rendering of how this obstacle should look.
     *
     * @since 0.0.0
     */
    public function exportSVG(): SVGNode;
}
