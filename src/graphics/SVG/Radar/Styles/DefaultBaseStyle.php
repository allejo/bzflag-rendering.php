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
