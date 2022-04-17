<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar\Styles;

/**
 * @since 0.2.0
 */
class BaseStyle
{
    /**
     * @since 0.2.0
     */
    public function getBorderColor(int $team): string
    {
        switch ($team) {
            case 1:
                return $this->getRedTeamColor();
            case 2:
                return $this->getGreenTeamColor();
            case 3:
                return $this->getBlueTeamColor();
            case 4:
                return $this->getPurpleTeamColor();
            default:
                return 'transparent';
        }
    }

    /**
     * @since 0.2.0
     */
    public function getBorderWidth(): int
    {
        return 2;
    }

    /**
     * @since 0.2.0
     */
    public function getFillColor(int $team): string
    {
        return 'transparent';
    }

    /**
     * @since 0.2.0
     */
    public function getRedTeamColor(): string
    {
        return '#FF0000';
    }

    /**
     * @since 0.2.0
     */
    public function getGreenTeamColor(): string
    {
        return '#00CA00';
    }

    /**
     * @since 0.2.0
     */
    public function getBlueTeamColor(): string
    {
        return '#3368ff';
    }

    /**
     * @since 0.2.0
     */
    public function getPurpleTeamColor(): string
    {
        return '#FF01FF';
    }

    /**
     * @since 0.2.0
     */
    public function getFallbackBoxStyle(): BoxStyle
    {
        return new BoxStyle();
    }
}
