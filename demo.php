<?php

use allejo\bzflag\graphics\SVG\Radar\WorldRenderer;
use allejo\bzflag\replays\Replay;

require_once __DIR__ . '/vendor/autoload.php';

$mapName = 'unknown_mini';
//$mapName = 'pillbox';
//$mapName = 'hix';
//$mapName = 'random_map';

$replay = new Replay(__DIR__ . "/tests/graphics/fixtures/{$mapName}.rec");
$world = $replay->getHeader()->getWorldDatabase();

$renderer = new WorldRenderer($world);
$renderer->enableBzwAttributes(true);

if (PHP_SAPI === 'cli')
{
    $renderer->writeToFile("examples/{$mapName}.svg");
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
