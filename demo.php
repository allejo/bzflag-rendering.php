<?php

use allejo\bzflag\graphics\SVG\Radar\WorldRenderer;
use allejo\bzflag\replays\Replay;

require_once __DIR__ . '/vendor/autoload.php';

$replay = new Replay(__DIR__ . '/tests/graphics/fixtures/hix.rec');
$world = $replay->getHeader()->getWorld();

$renderer = new WorldRenderer($world);

echo $renderer->exportStringSVG();
