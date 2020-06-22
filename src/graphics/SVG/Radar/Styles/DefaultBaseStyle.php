<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar\Styles;

class DefaultBaseStyle implements IBaseStyle
{
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

    public function getBorderWidth(): int
    {
        return 2;
    }

    public function getFillColor(int $team): string
    {
        return 'transparent';
    }

    public function getRedTeamColor(): string
    {
        return '#FF0000';
    }

    public function getGreenTeamColor(): string
    {
        return '#00CA00';
    }

    public function getBlueTeamColor(): string
    {
        return '#3368ff';
    }

    public function getPurpleTeamColor(): string
    {
        return '#FF01FF';
    }

    public function getFallbackBoxStyle(): IBoxStyle
    {
        return new DefaultBoxStyle();
    }
}
