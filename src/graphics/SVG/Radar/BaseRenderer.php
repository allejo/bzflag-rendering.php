<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\world\Object\BaseBuilding;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @extends ObstacleRenderer<\allejo\bzflag\world\Object\BaseBuilding>
 */
class BaseRenderer extends ObstacleRenderer
{
    /** @var array<int, string> */
    private static $teamColors = [
        1 => '#FF0000',
        2 => '#00CA00',
        3 => '#3368ff',
        4 => '#FF01FF',
    ];

    /**
     * @param BaseBuilding $base
     * @phpstan-param WorldBoundary $worldBoundary
     */
    public function __construct($base, array $worldBoundary)
    {
        parent::__construct($base, $worldBoundary);
    }

    public function exportSVG(): SVGNode
    {
        $teamColor = $this->obstacle->getTeam();

        $svg = $this->objectToSvgNode(SVGRect::class);
        $svg->setAttribute('fill-opacity', '0');
        $svg->setAttribute('stroke', $this->getTeamColor($teamColor));

        if ($this->bzwAttributesEnabled)
        {
            $svg->setAttribute('data-bzw-team', (string)$teamColor);
        }

        return $svg;
    }

    private function getTeamColor(int $teamColor): string
    {
        return self::$teamColors[$teamColor];
    }
}
