<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\graphics\SVG\ISVGStylable;
use allejo\bzflag\graphics\SVG\Radar\Styles\DefaultPyramidStyle;
use allejo\bzflag\graphics\SVG\Radar\Styles\IPyramidStyle;
use allejo\bzflag\world\Object\PyramidBuilding;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\SVGNode;

/**
 * @phpstan-extends ObstacleRenderer<\allejo\bzflag\world\Object\PyramidBuilding>
 * @phpstan-implements ISVGStylable<\allejo\bzflag\world\Object\PyramidBuilding>
 */
class PyramidRenderer extends ObstacleRenderer implements ISVGStylable
{
    /** @var IPyramidStyle */
    public static $STYLE;

    /** @var PyramidBuilding */
    protected $obstacle;

    /**
     * @param PyramidBuilding $pyramid
     * @phpstan-param WorldBoundary $worldBoundary
     */
    public function __construct($pyramid, array $worldBoundary)
    {
        if (self::$STYLE === null)
        {
            self::$STYLE = new DefaultPyramidStyle();
        }

        parent::__construct($pyramid, $worldBoundary);
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
     * @param null|PyramidBuilding $obstacle
     */
    public static function attachBzwAttributes(SVGNode $node, $obstacle): void
    {
        if ($obstacle === null)
        {
            return;
        }

        $node->setAttribute('bzw:position', implode(' ', $obstacle->getPosition()));
        $node->setAttribute('bzw:size', implode(' ', $obstacle->getSize()));
        $node->setAttribute('bzw:rotation', (string)$obstacle->getRotation());
        $node->setAttribute('bzw:zflip', (string)$obstacle->getZFlip());
    }

    /**
     * @param null|PyramidBuilding $obstacle
     */
    public static function stylizeSVGNode(SVGNode $node, $obstacle): void
    {
        $node->setAttribute('fill', self::$STYLE->getColor());
    }
}
