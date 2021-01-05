@extends('layouts.research-redirect')

@section('content')

<input type="hidden" id="destination" name="destination" value="{{ env('STORE_URL')}} " data-redirect-address>

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
          <h3 class="want-titulo"><strong>
            Você não tem perfil para esta pesquisa! <br>
            Redirecionando para a Store...</strong></h3>
      </div>
    </div>
  </div>
</div>

@endsection