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
    private $svgTranslate;

    /** @var array{float, float, float} */
    private $svgRotate;

    public function __construct(array $bzwPos, array $bzwSize, float $bzwRot, array $worldBoundary)
    {
        [$sizeX, $sizeY, $sizeZ] = $bzwSize;
        [$posX, $posY, $posZ] = $bzwPos;

        $worldBX = $worldBoundary['x'];
        $worldBY = $worldBoundary['y'];

        $svgPosX = $posX + ($worldBX / 2);
        $svgPosY = abs($posY + ($worldBY / -2));

        $rot = -1 * $bzwRot;

        $this->bzwPosition = $bzwPos;
        $this->bzwSize = $bzwSize;
        $this->bzwRotation = $bzwRot;
        $this->svgPosition = [
            $svgPosX,
            $svgPosY,
        ];
        $this->svgTranslate = [
            -1 * ($svgPosX + $sizeX),
            -1 * ($svgPosY + $sizeY),
        ];
        $this->svgRotate = [
            $rot,
            $svgPosX + ($sizeX / 2),
            $svgPosY + ($sizeY / 2),
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
