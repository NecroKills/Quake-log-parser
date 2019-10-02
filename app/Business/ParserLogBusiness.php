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
    public function analisador($req)
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

        //compare the log command
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
                  //set name player
                  $this->game->setPlayers($player[1]);
                }
                break;            
            default:
                break;
        }

      }
      // Fecha o arquivo aberto
      fclose($log);

    }


}
