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
use allejo\bzflag\graphics\SVG\Radar\Styles\DefaultTeleporterStyle;
use allejo\bzflag\graphics\SVG\Radar\Styles\ITeleporterStyle;
use allejo\bzflag\world\Object\Teleporter;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @internal
 *
 * @extends ObstacleRenderer<\allejo\bzflag\world\Object\Teleporter>
 * @implements ISVGStylable<\allejo\bzflag\world\Object\PyramidBuilding>
 */
class TeleporterRenderer extends ObstacleRenderer implements ISVGStylable
{
    /** @var ITeleporterStyle */
    public static $STYLE;

    /** @var Teleporter */
    protected $obstacle;

    /**
     * @param Teleporter $teleporter
     */
    public function __construct($teleporter, WorldBoundary $worldBoundary)
    {
        if (self::$STYLE === null)
        {
            self::$STYLE = new DefaultTeleporterStyle();
        }

        parent::__construct($teleporter, $worldBoundary);
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
     * @param null|Teleporter $obstacle
     */
    public static function attachBzwAttributes(SVGNode $node, $obstacle): void
    {
        if ($obstacle === null)
        {
            return;
        }

        $node->setAttribute('bzw:name', $obstacle->getName());
        $node->setAttribute('bzw:border', (string)$obstacle->getBorder());
        $node->setAttribute('bzw:position', implode(' ', $obstacle->getPosition()));
        $node->setAttribute('bzw:size', implode(' ', $obstacle->getSize()));
        $node->setAttribute('bzw:rotation', (string)$obstacle->getRotation());
    }

    /**
     * @param null|Teleporter $obstacle
     */
    public static function stylizeSVGNode(SVGNode $node, $obstacle): void
    {
        $node->setAttribute('fill', self::$STYLE->getColor());
        $node->setAttribute('stroke', self::$STYLE->getColor());
    }
}
