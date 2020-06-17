<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Common;

use allejo\bzflag\world\WorldDatabase;

/**
 * @since 0.2.0
 */
interface IWorldRenderer
{
    public function __construct(WorldDatabase $database);

    /**
     * Get world boundary information for the current world.
     *
     * @since 0.2.0
     */
    public function getWorldBoundary(): WorldBoundary;

    /**
     * Write out image to a file path.
     *
     * @param string $filePath The file path to write
     *
     * @since 0.2.0
     *
     * @return bool true when writing the file was successful
     */
    public function writeToFile(string $filePath): bool;
}
