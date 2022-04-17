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
use allejo\bzflag\graphics\SVG\Radar\Styles\BoxStyle;
use allejo\bzflag\graphics\SVG\SVGStylableUtilities;
use allejo\bzflag\world\Object\BoxBuilding;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @since 0.1.0
 *
 * @internal
 *
 * @extends ObstacleRenderer<BoxBuilding>
 * @implements ISVGStylable<BoxBuilding>
 */
class BoxRenderer extends ObstacleRenderer implements ISVGStylable
{
    /** @var BoxStyle */
    public static $STYLE;

    /** @var BoxBuilding */
    protected $obstacle;

    /**
     * @since 0.1.0
     *
     * @param BoxBuilding $box
     */
    public function __construct($box, WorldBoundary $worldBoundary)
    {
        if (self::$STYLE === null)
        {
            self::$STYLE = new BoxStyle();
        }

        parent::__construct($box, $worldBoundary);
    }

    /**
     * @since 0.1.0
     */
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
     * @since 0.1.1
     *
     * @param BoxBuilding $obstacle
     */
    public static function attachBzwAttributes(SVGNode $node, $obstacle): void
    {
        $node->setAttribute('bzw:position', implode(' ', $obstacle->getPosition()));
        $node->setAttribute('bzw:size', implode(' ', $obstacle->getSize()));
        $node->setAttribute('bzw:rotation', (string)$obstacle->getRotation());
    }

    /**
     * @since 0.1.1
     *
     * @param BoxBuilding $obstacle
     */
    public static function stylizeSVGNode(SVGNode $node, $obstacle): void
    {
        SVGStylableUtilities::applyFill($node, self::$STYLE->getFillColor());
        SVGStylableUtilities::applyStroke($node, self::$STYLE->getBorderColor(), self::$STYLE->getBorderWidth());
    }
}
