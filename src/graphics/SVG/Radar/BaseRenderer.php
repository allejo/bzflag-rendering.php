<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\graphics\SVG\ISVGStylable;
use allejo\bzflag\graphics\SVG\Radar\Styles\DefaultBaseStyle;
use allejo\bzflag\graphics\SVG\Radar\Styles\IBaseStyle;
use allejo\bzflag\world\Object\BaseBuilding;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @extends ObstacleRenderer<\allejo\bzflag\world\Object\BaseBuilding>
 * @implements ISVGStylable<\allejo\bzflag\world\Object\BaseBuilding>
 */
class BaseRenderer extends ObstacleRenderer implements ISVGStylable
{
    /** @var IBaseStyle */
    public static $STYLE;

    /** @var BaseBuilding */
    protected $obstacle;

    /**
     * @param BaseBuilding $base
     * @phpstan-param WorldBoundary $worldBoundary
     */
    public function __construct($base, array $worldBoundary)
    {
        if (self::$STYLE === null)
        {
            self::$STYLE = new DefaultBaseStyle();
        }

        parent::__construct($base, $worldBoundary);
    }

    public function exportSVG(): SVGNode
    {
        $teamColor = $this->obstacle->getTeam();
        $svg = $this->objectToSvgNode(SVGRect::class);

        if (!($teamColor >= 1 && $teamColor <= 4))
        {
            BoxRenderer::stylizeSVGNode($svg, null);
        }
        else
        {
            self::stylizeSVGNode($svg, $this->obstacle);
        }

        if ($this->bzwAttributesEnabled)
        {
            self::attachBzwAttributes($svg, $this->obstacle);
        }

        return $svg;
    }

    /**
     * @phpstan-param T $obstacle
     *
     * @param BaseBuilding $obstacle
     */
    public static function attachBzwAttributes(SVGNode $svg, $obstacle): void
    {
        $svg->setAttribute('bzw:position', implode(' ', $obstacle->getPosition()));
        $svg->setAttribute('bzw:size', implode(' ', $obstacle->getSize()));
        $svg->setAttribute('bzw:rotation', (string)$obstacle->getRotation());
        $svg->setAttribute('bzw:team', (string)$obstacle->getTeam());
    }

    /**
     * @phpstan-param T $obstacle
     *
     * @param BaseBuilding $obstacle
     */
    public static function stylizeSVGNode(SVGNode $svg, $obstacle): void
    {
        $svg->setAttribute('fill-opacity', '0');
        $svg->setAttribute('stroke', self::getTeamColor($obstacle->getTeam()));
        $svg->setAttribute('stroke-width', '2');
    }

    private static function getTeamColor(int $teamColor): string
    {
        switch ($teamColor) {
            case 1:
                return self::$STYLE->getRedTeamColor();
            case 2:
                return self::$STYLE->getGreenTeamColor();
            case 3:
                return self::$STYLE->getBlueTeamColor();
            case 4:
                return self::$STYLE->getPurpleTeamColor();
            default:
                return '';
        }
    }
}
