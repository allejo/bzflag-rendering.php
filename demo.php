<?php

use allejo\bzflag\graphics\SVG\Radar\WorldRenderer;
use allejo\bzflag\replays\Replay;

require_once __DIR__ . '/vendor/autoload.php';

$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/pillbox.rec');
$world = $replay->getHeader()->getWorldDatabase();

$renderer = new WorldRenderer($world);
$renderer->enableBzwAttributes(true);

echo $renderer->exportStringSVG();
