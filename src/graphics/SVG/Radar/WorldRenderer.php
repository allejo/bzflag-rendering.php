<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\graphics\Common\BzwAttributesAwareTrait;
use allejo\bzflag\graphics\Common\IBzwAttributesAware;
use allejo\bzflag\graphics\Common\IWorldRenderer;
use allejo\bzflag\graphics\Common\WorldBoundary;
use allejo\bzflag\graphics\SVG\Radar\Styles\WorldStyle;
use allejo\bzflag\graphics\SVG\SVGStylableUtilities;
use allejo\bzflag\graphics\SVG\Utilities\BzwToSvgCoordinates;
use allejo\bzflag\world\WorldDatabase;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

/**
 * @since 0.1.0
 */
class WorldRenderer implements IBzwAttributesAware, IWorldRenderer
{
    use BzwAttributesAwareTrait;

    /** @var WorldStyle */
    public static $STYLE;

    /** @var WorldDatabase */
    private $worldDatabase;

    /** @var WorldBoundary */
    private $worldBoundary;

    /** @var SVGDocumentFragment */
    private $document;

    /** @var SVG */
    private $svg;

    public function __construct(WorldDatabase $database)
    {
        if (self::$STYLE === null)
        {
            self::$STYLE = new WorldStyle();
        }

        $this->worldDatabase = $database;
        $this->worldBoundary = WorldBoundary::fromWorldDatabase($database);
        $this->bzwAttributesEnabled = false;

        $this->svg = new SVG(
            "{$this->worldBoundary->getWorldWidthX()}px",
            "{$this->worldBoundary->getWorldWidthY()}px"
        );
        $this->document = $this->svg->getDocument();
        $this->document->setAttribute(
            'viewBox',
            vsprintf('%d %d %d %d', [
                $this->worldBoundary->getWorldWidthX() / -2,
                $this->worldBoundary->getWorldWidthY() / -2,
                $this->worldBoundary->getWorldWidthX(),
                $this->worldBoundary->getWorldWidthY(),
            ])
        );

        $this->drawGround();
    }

    public function getWorldBoundary(): WorldBoundary
    {
        return $this->worldBoundary;
    }

    public function exportStringSVG(): string
    {
        if ($this->bzwAttributesEnabled)
        {
            $this->document->setAttribute('xmlns:bzw', 'http://schemas.allejo.dev/php/bzflag-rendering');
        }

        $this->renderObstacleSVGs();

        return (string)$this->svg;
    }

    public function writeToFile(string $filePath): bool
    {
        return file_put_contents($filePath, $this->exportStringSVG()) !== false;
    }

    private function drawGround(): void
    {
        $converter = new BzwToSvgCoordinates(
            [0, 0, 0],
            [
                ($this->worldBoundary->getWorldWidthX() / 2),
                ($this->worldBoundary->getWorldWidthY() / 2),
                0,
            ],
            0
        );

        $ground = new SVGRect(
            (string)$converter->getSvgPosition()[0],
            (string)$converter->getSvgPosition()[1],
            (string)$converter->getSvgSize()[0],
            (string)$converter->getSvgSize()[1]
        );

        SVGStylableUtilities::applyFill($ground, self::$STYLE->getFillColor());
        SVGStylableUtilities::applyStroke(
            $ground,
            self::$STYLE->getBorderColor(),
            self::$STYLE->getBorderWidth()
        );

        $this->document->addChild($ground);
    }

    private function renderObstacleSVGs(): void
    {
        $world = $this->worldDatabase
            ->getObstacleManager()
            ->getWorld()
        ;

        // The raw world definition outside of any group definitions
        $worldRoot = new GroupDefinitionRenderer($world, $this->worldBoundary);
        $worldRoot->enableBzwAttributes($this->bzwAttributesEnabled);

        // Invert the map along the X axis so our coordinates in the SVG
        // document follow the cartesian coordinate system
        $worldRootSvg = $worldRoot->exportSVG();
        $worldRootSvg->setAttribute('transform', 'scale(1, -1)');

        $this->document->addChild($worldRootSvg);
    }
}
