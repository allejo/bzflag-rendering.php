<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Utilities;

/**
 * @internal
 */
class BzwToSvgCoordinates
{
    /** @var array{float, float, float} */
    private $bzwPosition;

    /** @var array{float, float, float} */
    private $bzwSize;

    /** @var float */
    private $bzwRotation;

    /** @var array{float, float} */
    private $svgPosition;

    /** @var array{float, float} */
    private $svgSize;

    /** @var array{float, float} */
    private $svgTranslate;

    /** @var array{float, float, float} */
    private $svgRotate;

    /**
     * @param array{float|int, float|int, float|int} $bzwPos
     * @param array{float|int, float|int, float|int} $bzwSize
     */
    public function __construct(array $bzwPos, array $bzwSize, float $bzwRot)
    {
        [$sizeX, $sizeY] = $bzwSize;
        [$posX, $posY] = $bzwPos;

        $this->bzwPosition = $bzwPos;
        $this->bzwSize = $bzwSize;
        $this->bzwRotation = $bzwRot;
        $this->svgPosition = [
            (float)-1 * $sizeX,
            (float)-1 * $sizeY,
        ];
        $this->svgSize = [
            (float)$sizeX * 2,
            (float)$sizeY * 2,
        ];
        $this->svgTranslate = [
            (float)$posX,
            (float)$posY,
        ];
        $this->svgRotate = [
            $bzwRot,
            0,
            0,
        ];
    }

    /**
     * @return array{float, float, float}
     */
    public function getBzwPosition(): array
    {
        return $this->bzwPosition;
    }

    /**
     * @return array{float, float, float}
     */
    public function getBzwSize(): array
    {
        return $this->bzwSize;
    }

    public function getBzwRotation(): float
    {
        return $this->bzwRotation;
    }

    /**
     * @return array{float, float}
     */
    public function getSvgPosition(): array
    {
        return $this->svgPosition;
    }

    /**
     * @return array{float, float}
     */
    public function getSvgSize(): array
    {
        return $this->svgSize;
    }

    /**
     * @return array{float, float}
     */
    public function getSvgTranslate(): array
    {
        return $this->svgTranslate;
    }

    /**
     * @return array{float, float, float}
     */
    public function getSvgRotation(): array
    {
        return $this->svgRotate;
    }
}
