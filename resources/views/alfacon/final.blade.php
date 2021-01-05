@extends('layouts.research-redirect')

@section('content')

{{-- <input type="hidden" id="destination" name="destination" value="{{ Session::get('redirect') }}" data-redirect-address>--}}

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
          <h3 class="want-titulo">
            <strong>
                OBRIGADO! <br>
            </strong>
          </h3>
          <h4>
            Sua resposta foi registrada com sucesso. Agradecemos a participação.          
          </h4>
          <br>
          {{-- <img src="{{ asset('assets/endividamento/imgs/juros.jpg')}}" class="img-responsive" alt="">--}}
      </div>
    </div>
  </div>
</div>

@endsection