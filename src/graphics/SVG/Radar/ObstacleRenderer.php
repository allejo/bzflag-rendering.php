<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar;

use allejo\bzflag\graphics\SVG\ISVGRenderable;
use allejo\bzflag\graphics\SVG\Utilities\BzwToSvgCoordinates;
use SVG\Nodes\SVGNode;

/**
 * @phpstan-template T of \allejo\bzflag\world\Object\Obstacle
 * @phpstan-implements ISVGRenderable<T>
 */
abstract class ObstacleRenderer implements ISVGRenderable
{
    /** @phpstan-var T */
    protected $obstacle;

    /** @phpstan-var WorldBoundary */
    protected $worldBoundary;

    /** @var bool */
    protected $bzwAttributesEnabled;

    /**
     * @phpstan-param T             $obstacle
     * @phpstan-param WorldBoundary $worldBoundary
     *
     * @param object $obstacle
     */
    public function __construct($obstacle, array $worldBoundary)
    {
        $this->obstacle = $obstacle;
        $this->worldBoundary = $worldBoundary;
        $this->bzwAttributesEnabled = false;
    }

    public function enableBzwAttributes(bool $enabled): void
    {
        $this->bzwAttributesEnabled = $enabled;
    }

    abstract public function exportSVG(): SVGNode;

    /**
     * Translate the position, sizing, and rotation of a BZFlag world object to
     * the SVG equivalent via `transform` alterations.
     *
     * @phpstan-param class-string $cls
     */
    protected function objectToSvgNode(string $cls): SVGNode
    {
        $converter = new BzwToSvgCoordinates(
            $this->obstacle->getPosition(),
            $this->obstacle->getSize(),
            $this->obstacle->getRotation()
        );

        $svg = new $cls(
            $converter->getSvgPosition()[0],
            $converter->getSvgPosition()[1],
            $converter->getSvgSize()[0],
            $converter->getSvgSize()[1]
        );
        $svg->setAttribute(
            'transform',
            implode(' ', [
                vsprintf('translate(%.6g %.6g)', $converter->getSvgTranslate()),
                vsprintf('rotate(%.6g %.6g %.6g)', $converter->getSvgRotation()),
            ])
        );

        if ($this->bzwAttributesEnabled)
        {
            $svg->setAttribute('bzw:type', (string)$this->obstacle->getObjectType());
            $svg->setAttribute('bzw:position', vsprintf('%.3g %.3g %.3g', $converter->getBzwPosition()));
            $svg->setAttribute('bzw:size', vsprintf('%.3g %.3g %.3g', $converter->getBzwSize()));
            $svg->setAttribute('bzw:rotation', (string)round($converter->getBzwRotation()));
        }

        return $svg;
    }
}
