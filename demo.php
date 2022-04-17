<?php

use allejo\bzflag\graphics\SVG\Radar\WorldRenderer;
use allejo\bzflag\replays\Replay;

require_once __DIR__ . '/vendor/autoload.php';

$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/unknown_mini.rec');
//$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/pillbox.rec');
//$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/hix.rec');
//$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/random_map.rec');
$world = $replay->getHeader()->getWorldDatabase();

$renderer = new WorldRenderer($world);
$renderer->enableBzwAttributes(true);

if (PHP_SAPI === 'cli')
{
    $renderer->writeToFile('examples/unknown_mini.svg');
}
else
{
    echo <<<'EOF'
    <style>
      body { text-align: center; }
    </style>
EOF;
    echo $renderer->exportStringSVG();
}
