<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar\Styles;

interface IBaseStyle
{
    public function getBorderColor(int $team): string;

    public function getBorderWidth(): int;

    public function getFillColor(int $team): string;

    public function getRedTeamColor(): string;

    public function getGreenTeamColor(): string;

    public function getBlueTeamColor(): string;

    public function getPurpleTeamColor(): string;

    public function getFallbackBoxStyle(): IBoxStyle;
}
