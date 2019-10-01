<?php

namespace App\Business;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Class ParserLogBusiness
 *
 * @package App\Business
 */
class ParserLogBusiness
{
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
        
      }
      fclose($file);
    }


}
