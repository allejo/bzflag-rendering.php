<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\graphics\Common\WorldBoundary;
use allejo\bzflag\graphics\SVG\ISVGStylable;
use allejo\bzflag\graphics\SVG\Radar\Styles\DefaultBaseStyle;
use allejo\bzflag\graphics\SVG\Radar\Styles\IBaseStyle;
use allejo\bzflag\graphics\SVG\SVGStylableUtilities;
use allejo\bzflag\world\Object\BaseBuilding;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @internal
 *
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
     */
    public function __construct($base, WorldBoundary $worldBoundary)
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
     * @param null|BaseBuilding $obstacle
     */
    public static function attachBzwAttributes(SVGNode $svg, $obstacle): void
    {
        $svg->setAttribute('bzw:position', implode(' ', $obstacle->getPosition()));
        $svg->setAttribute('bzw:size', implode(' ', $obstacle->getSize()));
        $svg->setAttribute('bzw:rotation', (string)$obstacle->getRotation());
        $svg->setAttribute('bzw:team', (string)$obstacle->getTeam());
    }

    /**
     * @param null|BaseBuilding $obstacle
     */
    public static function stylizeSVGNode(SVGNode $svg, $obstacle): void
    {
        $bdrColor = self::$STYLE->getBorderColor($obstacle->getTeam());
        $bdrWidth = self::$STYLE->getBorderWidth();
        $fillColor = self::$STYLE->getFillColor($obstacle->getTeam());

        SVGStylableUtilities::applyFill($svg, $fillColor);
        SVGStylableUtilities::applyStroke($svg, $bdrColor, $bdrWidth);
    }
}
