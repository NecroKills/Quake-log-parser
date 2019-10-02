<?php

namespace App\Business;

use App\Model\Game;

/**
 * Class ParserLogBusiness
 *
 * @package App\Business
 */
class ParserLogBusiness
{
  /**
   * @var Game
   */
   private $game;
   private $kills;
   private $countGame = 0;

  /**
   * ParserLogBusiness constructor.
   *
   * @param Game $game
   */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }


    /**
     * Inicia o parser no arquivo games.log, fazendo a abertuda do arquivo
     * e chama a função lerLog.
     * @param  [type] $req [description]
     * @return [type]      [description]
     */
    public function analisarArquivo($req)
    {
      $file_name = $req['file'];

      // Verifica se informou o arquivo e se é válido
      if ($req->hasFile('file') && $req->file('file')->isValid()) {

        // É salvo em storage/app/public/data/games.log
        $upload = $req->file->storeAs('data', 'games.log');

        // Verifica se o upload deu certo (Redireciona de volta)
        if (!$upload ){
          return redirect()->back()->with('error', 'Falha ao fazer upload')
                ->withInput();
        }

        //Abre o arquivo
        $log = fopen($file_name, 'r');
        //verifica se o arquivo foi aberto
        if (!$log) {
            throw new Exception('Não foi possivel abrir o arquivo.');
        }

        // Verifica se existe conteudo no arquivo
        if (trim(file_get_contents($file_name)) == false) {
            throw new Exception('Arquivo vazio.');
        }

        /**
         * Envia a variavel $log para a função readLog
         * @var $log [type]
         */
        $this->lerLog($log);

      }
    }

    /**
     * [lerLog description]
     * @param  [type] $log [description]
     * @return [type]      [description]
     */
    public function lerLog($log)
    {
      // Percorre o arquivo e pega cada linha do log
      while (!feof($log)) {
        $row = fgets($log, 4096);
        //divide e retira o espaço da string, limitando o tamanho do array em 3
        $value = explode(":", trim($row), 3);
        //divide a string, limitando o tamanho do array em 2
        $timeGame = explode(" ", $value[0], 2);
        // Verifica se a variavel foi iniciada
        $timeGame = isset($timeGame[1]) ? $timeGame[1] : $timeGame[0];
        // Retira espaço da string e concatena com a variavel $value[1]
        $timeGame = trim($timeGame . ":" . $value[1]);
        //divide a string, limitando o tamanho do array em 2
        $timeAndCommand = explode(" ", $timeGame, 2);

        $resp['params'] = isset($value[2]) ? $value[2] : '';
        $resp['time'] = $timeAndCommand[0];
        $resp['wordReserved'] = $timeAndCommand[1];

        $this->analisarLog($resp);

      }
      // Fecha o arquivo aberto
      fclose($log);

    }

    public function analisarLog($resp){

      var_dump($resp['wordReserved']);
      //Compara as palavras reservadas do log
      switch ($resp['wordReserved']) {
          case 'InitGame':
              $this->kills = array();
              $this->countGame++;
              $this->game->setId($this->countGame);
              break;
          case 'ClientUserinfoChanged':
              $player = explode('\t\\', $resp['params'], 2);
              $player = explode(' n\\', $player[0], 2);
              if (!in_array($player[1], $this->game->getPlayers())) {
                //set nome do jogador
                $this->game->setPlayers($player[1]);
              }
              break;
          case 'Kill':
              //add 1 kill
              $this->game->addKill();

              $result = explode(":", $resp['params'], 2);
              $result = explode("killed", $result[1]);
              $p_killer = trim($result[0]);
              $result = explode(" by ", trim($result[1]));
              $p_killed = trim($result[0]);
              $mod = trim($result[1]);

              if ($p_killer == "<world>") {
                  //Se morreu pelo <world>, remove 1 kill.
                   $this->kills[$p_killed] = (isset($this->kills[$p_killed]) ? $this->kills[$p_killed] : 0) - 1;
               } else if ($p_killer == $p_killed) {
                   //se ele se matou, remove 1 kill
                   $this->kills[$p_killer] = (isset($this->kills[$p_killer]) ? $this->kills[$p_killer] : 0) - 1;
               } else {
                   //se ele matou um oponente, adiciona 1 kill
                   $this->kills[$p_killer] = (isset($this->kills[$p_killer]) ? $this->kills[$p_killer] : 0) + 1;
               }
              break;
          case '------------------------------------------------------------':
          case 'ShutdownGame':
              if (isset($this->game)) {
                //set kills
                $this->game->setKills($this->kills);
              }
              break;
          default:
              break;
      }

    }


}
