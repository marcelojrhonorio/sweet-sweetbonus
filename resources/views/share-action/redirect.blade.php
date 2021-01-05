@extends('layouts.research-redirect')

@section('content')

<input type="hidden" id="destination" name="destination" value="{{ Session::get('redirect') }}" data-redirect-address>

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
          <h3 class="want-titulo"><strong>
            Parabéns! <br></strong></h3>
            <h4>
            Você foi convidado para participar das ações do portal SweetBonus.<br>
            Junte pontos e troque por produtos que você receberá grátis em casa!           
            </h4>
          <br>
          <img src="{{ asset('assets/home/imgs/main-products.png') }}" class="img-responsive" alt="">
      </div>
    </div>
  </div>
</div>

@endsection