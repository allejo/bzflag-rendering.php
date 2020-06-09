<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\world\Object\GroupInstance;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @extends ObstacleRenderer<\allejo\bzflag\world\Object\GroupInstance>
 */
class GroupInstanceRenderer extends ObstacleRenderer
{
    /** @var GroupInstance */
    protected $obstacle;

    /**
     * @param GroupInstance $instance
     * @phpstan-param WorldBoundary $worldBoundary
     */
    public function __construct($instance, array $worldBoundary)
    {
        parent::__construct($instance, $worldBoundary);
    }

    public function exportSVG(): SVGNode
    {
        $worldDB = $this->obstacle->getWorldDatabase();

        // TODO: Implement exportSVG() method.

        return new SVGRect();
    }
}
