<?php

/**
 * [GameClass description]
 * Sera armazenado as informações que forem encontradas durante a leitura do log
 */
class Game {
  private $id;
  private $total_kills;
  private $players = array();
  private $kills = array();

  public function getId() {
      return $this->id;
  }

  public function setId($id) {
      $this->id = $id;
  }

  public function getTotal_kills() {
      return is_null($this->total_kills) ? 0 : $this->total_kills;
  }

  public function setTotal_kills($total_kills) {
      $this->total_kills = $total_kills;
  }

  public function getPlayers() {
      return $this->players;
  }

  public function setPlayers($players) {
      $this->players[] = $players;
  }

  public function getKills() {
      return $this->kills;
  }

  public function setKills($kills) {
      $this->kills = $kills;
  }

}
