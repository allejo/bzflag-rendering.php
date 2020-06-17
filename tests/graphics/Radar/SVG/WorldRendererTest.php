<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\test\graphics\Radar\SVG;

use allejo\bzflag\graphics\SVG\Radar\WorldRenderer;
use allejo\bzflag\replays\Replay;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class WorldRendererTest extends TestCase
{
    public function testStart()
    {
        $replay = new Replay(__DIR__ . '/../../fixtures/pillbox.rec');
        $world = $replay->getHeader()->getWorldDatabase();

        $renderer = new WorldRenderer($world);
        $renderer->enableBzwAttributes(true);
        $rawSVG = $renderer->exportStringSVG();

        self::assertTrue(false);
    }
}
