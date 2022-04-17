<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\SVG\Radar\Styles;

/**
 * @since 0.2.1
 */
class MeshStyle
{
    /**
     * @since 0.2.1
     */
    public function getBorderColor(): string
    {
        return 'transparent';
    }

    /**
     * @since 0.2.1
     */
    public function getBorderWidth(): int
    {
        return 0;
    }

    /**
     * @since 0.2.1
     */
    public function getFillColor(): string
    {
        return '#04CCFF';
    }
}
