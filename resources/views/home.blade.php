@extends('layout.site')

@section('titulo', 'Quake Log Parser')

@section('conteudo')

<div class="container ">
  <div class="row">
    <div class="col s6 offset-s3 valign">
      <div class="card center #f5f5f5 grey lighten-4">
        <div class="card-center ">
          <h4 class="center">Quake Log Parser</h4>
        </div>
        <div class="card-action">
          <form class="" action="{{route('log.selecionar')}}" method="POST"
                enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="file-field input-field">
              <div class="btn">
                <span>Select File</span>
                <input type="file" name="file" id="file">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text"
                  placeholder="Selecione o arquivo de log do game">
              </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit"
                    name="action">OK
              <i class="material-icons right">send</i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
