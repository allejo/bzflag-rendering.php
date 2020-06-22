<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar\Styles;

class DefaultWorldStyle implements IWorldStyle
{
    public function getBorderColor(): string
    {
        return '#04CCFF';
    }

    public function getBorderWidth(): int
    {
        return 1;
    }

    public function getFillColor(): string
    {
        return 'transparent';
    }
}
