<?php

namespace libs;

use pocketmine\math\Vector3;
use pocketmine\entity\Location;
use pocketmine\world\Position;

//TODO: finish this
class Vector3 {
  
  public function vectorToArray(Vector3 $vector): array
  {
    return [
      $vector->x,
      $vector->y,
      $vector->z
    ];
  }
  
  public function arrayToVector3(array $vector): Vector3
  {
    return new Vector3($vector[0], $vector[1], $vector[2]);
  }
  
  /**
   * @param [x, y, z, world, yaw, pitch]
   */
  public function arrayToLocation(array $vector): Location
  {
    return new Location($vector[0], $vector[1], $vector[2], $vector[3], $vector[4], $vector[5]);
  }
  
  public function arrayToPosition(array $vector): Position
  {
    return new Position($vector[0], $vector[1], $vector[2], $vector[3]);
  }
  
}