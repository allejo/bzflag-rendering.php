<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Common;

/**
 * Implements the {@see IBzwAttributesAware} interface.
 */
trait BzwAttributesAwareTrait
{
    /** @var bool */
    protected $bzwAttributesEnabled;

    public function enableBzwAttributes(bool $enabled): void
    {
        $this->bzwAttributesEnabled = $enabled;
    }

    public function hasBzwAttributesEnabled(): bool
    {
        return $this->bzwAttributesEnabled;
    }
}
