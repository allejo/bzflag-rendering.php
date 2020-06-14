<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Common;

/**
 * An interface for objects that can handle BZW attributes.
 *
 * @since 0.1.1
 */
interface IBzwAttributesAware
{
    /**
     * Enable/disable BZW attributes being injected into images if the image
     * type supports it.
     *
     * @since 0.1.1
     */
    public function enableBzwAttributes(bool $enabled): void;

    /**
     * Whether or not BZW attribute injection is enabled.
     *
     * @since 0.1.1
     */
    public function hasBzwAttributesEnabled(): bool;
}
