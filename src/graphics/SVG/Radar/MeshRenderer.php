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
use allejo\bzflag\graphics\SVG\Radar\Styles\MeshStyle;
use allejo\bzflag\graphics\SVG\SVGStylableUtilities;
use allejo\bzflag\world\Object\MeshObstacle;
use SVG\Nodes\Shapes\SVGPolygon;
use SVG\Nodes\Structures\SVGGroup;
use SVG\Nodes\SVGNode;

/**
 * @internal
 *
 * @extends ObstacleRenderer<MeshObstacle>
 * @implements ISVGStylable<MeshObstacle>
 */
class MeshRenderer extends ObstacleRenderer implements ISVGStylable
{
    /** @var MeshStyle */
    public static $STYLE;

    /** @var MeshObstacle */
    protected $obstacle;

    /**
     * @param MeshObstacle $mesh
     */
    public function __construct($mesh, WorldBoundary $worldBoundary)
    {
        if (self::$STYLE === null)
        {
            self::$STYLE = new MeshStyle();
        }

        parent::__construct($mesh, $worldBoundary);
    }

    public function exportSVG(): SVGNode
    {
        $svg = $this->meshToSVGNode();

        self::stylizeSVGNode($svg, $this->obstacle);

        if ($this->bzwAttributesEnabled)
        {
            self::attachBzwAttributes($svg, $this->obstacle);
        }

        return $svg;
    }

    /**
     * @param MeshObstacle $obstacle
     */
    public static function attachBzwAttributes(SVGNode $node, $obstacle): void
    {
        $node->setAttribute('bzw:type', (string)$obstacle->getObjectType());
        $node->setAttribute('bzw:vertices', json_encode($obstacle->getVertices()) ?: null);
        $node->setAttribute('bzw:faces', json_encode($obstacle->getFaces()) ?: null);
    }

    /**
     * @param MeshObstacle $obstacle
     */
    public static function stylizeSVGNode(SVGNode $node, $obstacle): void
    {
        SVGStylableUtilities::applyFill($node, self::$STYLE->getFillColor());
        SVGStylableUtilities::applyStroke($node, self::$STYLE->getBorderColor(), self::$STYLE->getBorderWidth());
    }

    protected function meshToSVGNode(): SVGNode
    {
        $svg = new SVGGroup();

        foreach ($this->obstacle->getFaces() as $meshFace)
        {
            // Don't draw the face if it's intended to be hidden from the radar
            if ($meshFace->getMaterial()->isNoRadar())
            {
                continue;
            }

            $mesh = new SVGPolygon($meshFace->getVertices());
            $svg->addChild($mesh);
        }

        return $svg;
    }
}
