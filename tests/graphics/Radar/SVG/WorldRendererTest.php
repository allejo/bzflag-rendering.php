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
use RuntimeException;
use Symfony\Component\Finder\Finder;

/**
 * @internal
 * @coversNothing
 */
class WorldRendererTest extends TestCase
{
    /**
     * @return iterable<array{string, string}>
     */
    public static function provideExampleRenderingsCases(): iterable
    {
        $fixturesDir = __DIR__ . '/../../fixtures/';
        $examplesDir = __DIR__ . '/../../../../examples/';

        $fsi = new Finder();
        $fsi
            ->in($fixturesDir)
            ->name('*.rec')
            ->files()
        ;

        foreach ($fsi->getIterator() as $item)
        {
            $fileNameNoExt = $item->getBasename('.rec');
            $replayPath = $item->getRealPath();
            $examplePath = realpath($examplesDir . $fileNameNoExt . '.svg');

            if ($replayPath === false || $examplePath === false)
            {
                throw new RuntimeException("Could not evaluate replay or example path for: {$fileNameNoExt}");
            }

            yield [$replayPath, $examplePath];
        }
    }

    /**
     * @dataProvider provideExampleRenderingsCases
     */
    public function testExampleRenderings(string $replayPath, string $expectedSvgPath): void
    {
        $replay = new Replay($replayPath);
        $world = $replay->getWorldDatabase();

        $renderer = new WorldRenderer($world);
        $renderer->enableBzwAttributes(true);

        $expected = file_get_contents($expectedSvgPath);
        $actual = $renderer->exportStringSVG();

        self::assertEquals($expected, $actual);
    }
}
