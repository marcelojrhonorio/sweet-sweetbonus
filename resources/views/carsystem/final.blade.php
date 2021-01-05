@extends('layouts.research-redirect')

@section('content')

<input type="hidden" id="destination" name="destination" value="{{ Session::get('redirect') }}" data-redirect-address>

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
          <h3 class="want-titulo"><strong>
            A maior empresa de Rastreamento Veicular do BRASIL <br>
            Acesse aqui e aproveite!</strong></h3>
          <br>
          <img src="{{ asset('assets/carsystem/imgs/carsystem.jpg')}}" class="img-responsive" alt="">
      </div>
    </div>
  </div>
</div>

@endsection