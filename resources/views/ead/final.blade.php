@extends('layouts.research-redirect')

@section('content')

<input type="hidden" id="destination" name="destination" value="{{ Session::get('redirect') }}" data-redirect-address>

<div class="sucesso">
  <div class="interno-sucesso">
    <div class="container">
      <div class="col-md-12">
          <h3 class="want-titulo">Chegou o momento de você crescer na sua carreira com 
                <strong>cursos de graduação e pós-graduação online, semipresenciais e presenciais</strong> 
                em uma das melhores instituições de ensino do país.           
          </h3>
          <br>
          <img src="{{ asset('assets/ead/imgs/anhanguera.png')}}" class="img-responsive" alt="">
      </div>
    </div>
  </div>
</div>

@endsection