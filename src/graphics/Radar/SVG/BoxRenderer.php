<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Radar\SVG;

use allejo\bzflag\world\Object\BoxBuilding;

class BoxRenderer extends BaseRenderer
{
    use RectangularSVGTrait;

    public function __construct(BoxBuilding &$box, array $worldBoundary)
    {
        parent::__construct($box, $worldBoundary);
    }
}
