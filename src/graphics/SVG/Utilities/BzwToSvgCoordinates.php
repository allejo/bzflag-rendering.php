<?php

namespace allejo\bzflag\graphics\SVG\Utilities;

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

    public function __construct(array $bzwPos, array $bzwSize, float $bzwRot)
    {
        [$sizeX, $sizeY] = $bzwSize;
        [$posX, $posY] = $bzwPos;

        $this->bzwPosition = $bzwPos;
        $this->bzwSize = $bzwSize;
        $this->bzwRotation = $bzwRot;
        $this->svgPosition = [
            -1 * $sizeX,
            -1 * $sizeY,
        ];
        $this->svgSize = [
            $sizeX * 2,
            $sizeY * 2,
        ];
        $this->svgTranslate = [
            $posX,
            $posY,
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
    public function getSvgRotate(): array
    {
        return $this->svgRotate;
    }
}
