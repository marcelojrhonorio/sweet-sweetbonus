@extends('layouts.research-redirect')

@section('content')

<input type="hidden" id="destination" name="destination" value="{{ Session::get('redirect') }}" data-redirect-address>

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
          <h3 class="want-titulo"><strong>
            Vamos ajudar a salvar nossos oceanos! ❤ <br></strong></h3>
            <h4>
            Assine a petição para pressionar os governantes 
            para que eles criem o Tratado Global dos Oceanos. <br>
            Esse é o primeiro passo para protegermos 30% dos 
            oceanos e garantir o futuro seguro para essas águas!           
            </h4>
          <br>
          <img src="{{ asset('assets/greenpeace-oceanos/imgs/greenpeace-oceanos_4.jpeg')}}" class="img-responsive" alt="">
      </div>
    </div>
  </div>
</div>

@endsection