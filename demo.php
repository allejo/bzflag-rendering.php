<?php

use allejo\bzflag\graphics\SVG\Radar\WorldRenderer;
use allejo\bzflag\replays\Replay;

require_once __DIR__ . '/vendor/autoload.php';

$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/pillbox.rec');
//$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/hix.rec');
//$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/random_map.rec');
$world = $replay->getHeader()->getWorldDatabase();

$renderer = new WorldRenderer($world);
$renderer->enableBzwAttributes(true);

echo <<<EOF
<style>
  body { text-align: center; }
</style>
EOF;
echo $renderer->exportStringSVG();
