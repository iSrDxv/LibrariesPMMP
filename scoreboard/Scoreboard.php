<?php

/* 
*   ___ ___  ___ _      _  _   _ 
*  / __| _ \/ __| |    /_\| | | |
*  \__ \   / (__| |__ / _ \ |_| |
*  |___/_|_\\___|____/_/ \_\___/ 
*
* @author: iSrDxv (SrClau)
* @status: Beta
*/

namespace libs\scoreboard;

use pocketmine\player\Player;

use pocketmine\network\protocol\{
  SetObjectivePacket,
  SetScorePacket,
  SetScoreboardIdentityPacket,
  RemoveObjectivePacket
};
use pocketmine\network\protocol\types\ScorePacketEntry;

class Scoreboard
{
  
  public static function create(Player $player, string $title): self
  {
    $self = new self($player);
    $self->title = $title; 
    return $self;
  }
  
  /** @var Player **/
  public Player $player;
  
  public string $title;
  
  public bool $spawned = false;
  
  /** @var Array int **/
  public array $lines = [];
  
  public function __construct(Player $player)
  {
  $this->player = $player;
  $this->init();
  }
  
  public function getPlayer(): Player
  {
    return $this->player;
  }
  
  public function isSpawned(): bool
  {
    return $this->spawned;
  }
  
  public function init(): void 
  {
    if (!$this->spawned) {
      $pk = SetObjectivePacket::create(SetObjectivePacket::DISPLAY_SLOT_SIDEBAR, $this->getPlayer()->getName(), $this->title, "dummy", SetObjectivePacket::SORT_ORDER_ASCENDING);
      $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
      $this->spawned = true;
      return;
    } 
  }
  
  public function remove(): void
  { 
    if (!$this->spawned) {
      return;
    }
    $this->spawned = false;
    $pk = RemoveObjectivePacket::create($this->getPlayer()->getName());
    $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
  }
  
  public function setLine(int $line, string $description): void
  {
    if (isset($this->line[$id])) {
      $pk = new SetScorePacket(SetScorePacket::TYPE_REMOVE, [$this->lines[$id]]);
      $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
      unset($this->lines[$id]);
      return;
    }
    $entry = new ScorePacketEntry();
    $entry->type = ScorePacketEntry::TYPE_PLAYER;
    
    $entry->scoreboardId = $line;
    $entry->score = $line;
    $entry->objectiveName = $this->getPlayer()->getName();
    $this->lines[$line] = $entry;
    
    $pk = SetScorePacket::create(SetScorePacket::TYPE_CHANGE, [$entry]);
    $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
  }
  
  public function removeLine(int $line): void
  {
    $line = $this->lines[$id];
    if (isset($line)) {
      $pk = SetScorePacket::create(SetScorePacket::TYPE_REMOVE, [$line]);
      $this->getPlayer()->getNetworkSession()->sendDataPacket();
      unset($line);
    }
  }
  
  public function removeAllLine(): void
  {
    if (empty($this->lines) & ($this->spawned !== true)) {
      return;
    }
    $pk = SetScorePacket::create(SetScorePacket::TYPE_REMOVE, $this->lines);
    $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
    $this->lines = [];
  }
  
}