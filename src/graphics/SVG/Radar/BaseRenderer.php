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
use allejo\bzflag\graphics\SVG\Radar\Styles\BaseStyle;
use allejo\bzflag\graphics\SVG\Radar\Styles\BoxStyle;
use allejo\bzflag\graphics\SVG\SVGStylableUtilities;
use allejo\bzflag\world\Object\BaseBuilding;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @internal
 *
 * @extends ObstacleRenderer<BaseBuilding>
 * @implements ISVGStylable<BaseBuilding>
 */
class BaseRenderer extends ObstacleRenderer implements ISVGStylable
{
    /** @var BaseStyle */
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
            self::$STYLE = new BaseStyle();
        }

        parent::__construct($base, $worldBoundary);
    }

    public function exportSVG(): SVGNode
    {
        $svg = $this->objectToSvgNode(SVGRect::class);

        self::stylizeSVGNode($svg, $this->obstacle);

        if ($this->bzwAttributesEnabled)
        {
            self::attachBzwAttributes($svg, $this->obstacle);
        }

        return $svg;
    }

    /**
     * @param BaseBuilding $obstacle
     */
    public static function attachBzwAttributes(SVGNode $node, $obstacle): void
    {
        $node->setAttribute('bzw:position', implode(' ', $obstacle->getPosition()));
        $node->setAttribute('bzw:size', implode(' ', $obstacle->getSize()));
        $node->setAttribute('bzw:rotation', (string)$obstacle->getRotation());
        $node->setAttribute('bzw:team', (string)$obstacle->getTeam());
    }

    /**
     * @param BaseBuilding $obstacle
     */
    public static function stylizeSVGNode(SVGNode $svg, $obstacle): void
    {
        $teamColor = $obstacle->getTeam();

        $bdrColor = self::$STYLE->getBorderColor($obstacle->getTeam());
        $bdrWidth = self::$STYLE->getBorderWidth();
        $fillColor = self::$STYLE->getFillColor($obstacle->getTeam());

        // If it's an invalid team color, draw it as a box
        if (!($teamColor >= 1 && $teamColor <= 4))
        {
            $boxStyle = new BoxStyle();

            $fillColor = $boxStyle->getFillColor();
            $bdrColor = $boxStyle->getBorderColor();
            $bdrWidth = $boxStyle->getBorderWidth();
        }

        SVGStylableUtilities::applyFill($svg, $fillColor);
        SVGStylableUtilities::applyStroke($svg, $bdrColor, $bdrWidth);
    }
}
