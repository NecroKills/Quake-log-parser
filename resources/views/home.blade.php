@extends('layout.site')

@section('titulo', 'Cursos')

@section('conteudo')

<div class="container">
  <div class="row">
    <div class="col s6 offset-s3 valign">
      <div class="card center">
        <div class="card-center">
          <h4 class="center">Quake Log Parser</h4>
        </div>
        <div class="card-action">
          <form action="#">
            <div class="file-field input-field">
              <div class="btn">
                <span>Select File</span>
                <input type="file" multiple>
              </div>
              <div class="file-path-wrapper">
              <input class="file-path validate" type="text" placeholder="Selecione o arquivo de log do game">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
