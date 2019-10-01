<?php

namespace App\Http\Controllers;

use App\Business\ParserLogBusiness;
use Illuminate\Http\Request;
use Exception;

class ParserController extends Controller
{
  /**
   * @var ParserLogBusiness
   */
  private $parserLogBusiness;

  /**
   * ParserController constructor.
   *
   * @param ParserLogBusiness $parserLogBusiness
   */
  public function __construct(ParserLogBusiness $parserLogBusiness)
  {
      $this->parserLogBusiness = $parserLogBusiness;
  }

  /**
   * [selecionar description]
   * @param  Request $req [description]
   * @return [type]       [description]
   */
    public function selecionar(Request $req){
      $req->all();
      $registro = $this->parserLogBusiness->analisador($req);
    }
}
