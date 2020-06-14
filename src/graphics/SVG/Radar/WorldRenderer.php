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
use allejo\bzflag\graphics\SVG\Radar\Styles\DefaultWorldStyle;
use allejo\bzflag\graphics\SVG\Radar\Styles\IWorldStyle;
use allejo\bzflag\world\Object\ObstacleType;
use allejo\bzflag\world\Object\WallObstacle;
use allejo\bzflag\world\WorldDatabase;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

class WorldRenderer implements IBzwAttributesAware
{
    use BzwAttributesAwareTrait;

    /** @var IWorldStyle */
    public static $STYLE;

    /** @var WorldDatabase */
    private $worldDatabase;

    /** @phpstan-var WorldBoundary */
    private $worldBoundary;

    /** @var SVGDocumentFragment */
    private $document;

    /** @var SVG */
    private $svg;

    public function __construct(WorldDatabase $database)
    {
        if (self::$STYLE === null)
        {
            self::$STYLE = new DefaultWorldStyle();
        }

        $this->worldDatabase = $database;
        $this->worldBoundary = $this->calcWorldBoundary();
        $this->bzwAttributesEnabled = false;

        $this->svg = new SVG("{$this->worldBoundary['x']}px", "{$this->worldBoundary['y']}px");
        $this->document = $this->svg->getDocument();
        $this->document->setStyle('border', sprintf('1px solid %s', self::$STYLE->getBorderColor()));
        $this->document->setStyle('box-sizing', 'border-box');
        $this->document->setAttribute(
            'viewBox',
            vsprintf('%d %d %d %d', [
                $this->worldBoundary['x'] / -2,
                $this->worldBoundary['y'] / -2,
                $this->worldBoundary['x'],
                $this->worldBoundary['y'],
            ])
        );
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

    /**
     * @phpstan-return WorldBoundary
     */
    private function calcWorldBoundary(): array
    {
        /** @var WallObstacle[] $walls */
        $walls = $this->worldDatabase
            ->getObstacleManager()
            ->getWorld()
            ->getObstaclesByType(ObstacleType::WALL_TYPE)
        ;

        if (count($walls) !== 4)
        {
            throw new \InvalidArgumentException('This library does not support drawing worlds with more than 4 walls');
        }

        $dimensions = [
            'x' => 0,
            'y' => 0,
        ];

        foreach ($walls as $wall)
        {
            if ($wall->getPosition()[0] === 0.0)
            {
                $dimensions['x'] += $wall->getBreadth();
            }
            elseif ($wall->getPosition()[1] === 0.0)
            {
                $dimensions['y'] += $wall->getBreadth();
            }
        }

        return $dimensions;
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
