<?php declare(strict_types=1);

/*
 * (c) Vladimir "allejo" Jimenez <me@allejo.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 */

namespace allejo\bzflag\graphics\Common;

use allejo\bzflag\world\Object\ObstacleType;
use allejo\bzflag\world\Object\WallObstacle;
use allejo\bzflag\world\WorldDatabase;

class WorldBoundary
{
    /** @var WallObstacle[] */
    private $worldWalls;

    /** @var float */
    private $x;

    /** @var float */
    private $y;

    /**
     * @param WallObstacle[] $worldWalls
     */
    public function __construct(float $x, float $y, array $worldWalls)
    {
        $this->x = $x;
        $this->y = $y;
        $this->worldWalls = $worldWalls;
    }

    public function getWorldWidthX(): float
    {
        return $this->x;
    }

    public function getWorldWidthY(): float
    {
        return $this->y;
    }

    /**
     * @return WallObstacle[]
     */
    public function getWorldWalls(): array
    {
        return $this->worldWalls;
    }

    public static function fromWorldDatabase(WorldDatabase $database): WorldBoundary
    {
        $x = $y = $database->getBZDBManager()->getBZDBVariable('_worldSize');

        /** @var WallObstacle[] $walls */
        $walls = $database
            ->getObstacleManager()
            ->getWorld()
            ->getObstaclesByType(ObstacleType::WALL_TYPE)
        ;

        if (count($walls) > 0)
        {
            $x = 0;
            $y = 0;

            foreach ($walls as $wall)
            {
                if ($wall->getPosition()[0] === 0.0)
                {
                    $x += $wall->getBreadth();
                }
                elseif ($wall->getPosition()[1] === 0.0)
                {
                    $y += $wall->getBreadth();
                }
            }
        }

        return new self($x, $y, $walls);
    }
}
