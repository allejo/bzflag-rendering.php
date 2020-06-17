<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\PNG\Radar;

use allejo\bzflag\graphics\Common\BzwAttributesAwareTrait;
use allejo\bzflag\graphics\Common\IBzwAttributesAware;
use allejo\bzflag\graphics\Common\IWorldRenderer;
use allejo\bzflag\graphics\Common\RequiredExtensionMissingException;
use allejo\bzflag\graphics\Common\WorldBoundary;
use allejo\bzflag\graphics\SVG\Radar\WorldRenderer as SVGWorldRenderer;
use allejo\bzflag\world\WorldDatabase;

/**
 * @since 0.2.0
 */
class WorldRenderer implements IBzwAttributesAware, IWorldRenderer
{
    use BzwAttributesAwareTrait;

    /** @var WorldDatabase */
    protected $worldDatabase;

    /** @var SVGWorldRenderer */
    protected $renderer;

    /**
     * @throws RequiredExtensionMissingException when the imagick PHP extension is not available
     */
    public function __construct(WorldDatabase $database)
    {
        if (!extension_loaded('imagick'))
        {
            throw new RequiredExtensionMissingException(
                sprintf('The %s class needs the Imagick extension to be loaded.', __CLASS__)
            );
        }

        $this->worldDatabase = $database;
        $this->renderer = new SVGWorldRenderer($this->worldDatabase);
    }

    public function getWorldBoundary(): WorldBoundary
    {
        return $this->renderer->getWorldBoundary();
    }

    public function writeToFile(string $filePath): bool
    {
        $im = new \Imagick();

        try
        {
            $im->readImageBlob($this->renderer->exportStringSVG());
        }
        catch (\ImagickException $e)
        {
            return false;
        }

        $im->setImageFormat('png24');

        $successful = $im->writeImage($filePath);

        $im->clear();
        $im->destroy();

        return $successful;
    }
}
