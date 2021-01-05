@extends('layouts.research-redirect')

@section('content')

<input type="hidden" id="destination" name="destination" value="{{ Session::get('redirect') }}" data-redirect-address>

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
          <h2 class="want-titulo">Você pode concorrer à uma série de prêmios!!!</h2><br>
          <h3>De acordo com suas respostas, você está prestes a concorrer <br><strong>à uma série de prêmios</strong></h3>
          <h3>Veja na página à seguir quais são eles...</strong></h3>
      </div>
    </div>
  </div>
</div>

@endsection