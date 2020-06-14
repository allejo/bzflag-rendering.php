<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Utilities;

use allejo\bzflag\graphics\Common\BzwAttributesAwareTrait;
use allejo\bzflag\graphics\Common\IBzwAttributesAware;
use SVG\Nodes\SVGNode;

/**
 * @internal
 */
class SVGTransformWrapper implements IBzwAttributesAware
{
    use BzwAttributesAwareTrait;

    /** @var SVGNode */
    private $svgNode;

    /** @var array<int, array{string, string}> */
    private $transforms;

    /** @var array<int, array{string, string}> */
    private $bzwAttributes;

    public function __construct(SVGNode $svgNode)
    {
        $this->svgNode = $svgNode;
        $this->transforms = [];
    }

    public function rotate(float $deg, float $x = 0, float $y = 0): void
    {
        $args = array_filter([$deg, $x, $y]);
        $this->transforms[] = ['rotate', $args];

        if ($this->bzwAttributesEnabled)
        {
            $this->bzwAttributes[] = ['spin', "{$deg} 0 0 1"];
        }
    }

    public function shift(float $x, float $y, float $z): void
    {
        $this->transforms[] = ['translate', [$x, $y]];

        if ($this->bzwAttributesEnabled)
        {
            $this->bzwAttributes[] = ['shift', "{$x} {$y} {$z}"];
        }
    }

    public function scale(float $x, float $y, float $z): void
    {
        $this->transforms[] = ['scale', array_filter([$x, $y])];

        if ($this->bzwAttributesEnabled)
        {
            $this->bzwAttributes[] = ['scale', "{$x} {$y} {$z}"];
        }
    }

    public function apply(): void
    {
        $reverse = array_reverse($this->transforms);
        $transforms = [];

        foreach ($reverse as [$directive, $args])
        {
            switch ($directive) {
                case 'rotate':
                    if (count($args) > 0)
                    {
                        $argPattern = trim(str_repeat('%.3g ', count($args)));
                        $transforms[] = vsprintf(sprintf('rotate(%s)', $argPattern), $args);
                    }

                    break;
                case 'translate':
                    $transforms[] = vsprintf('translate(%.3g %.3g)', $args);

                    break;
                case 'scale':
                    $argPattern = trim(str_repeat('%.3g ', count($args)));
                    $transforms[] = vsprintf(sprintf('scale(%s)', $argPattern), $args);

                    break;
                default:
                    break;
            }
        }

        $transform = implode(' ', $transforms);
        $this->svgNode->setAttribute('transform', $transform);

        if ($this->bzwAttributesEnabled)
        {
            foreach ($this->bzwAttributes as [$name, $value])
            {
                $this->svgNode->setAttribute("bzw:{$name}", $value);
            }
        }
    }
}
