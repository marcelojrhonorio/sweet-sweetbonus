@extends('layouts.research')

@section('content')
<div class="form-header">
  <div class="title">
    <h1>Pesquisa Carreira Pública Informações Cadastrais</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div class="area-form">
      <form id="survey" data-form-register>
      {{ csrf_field() }}
        <div class="section-title">
          <h3>Insira seus dados abaixo para prosseguir</h3>
          <hr>
        </div>
        <div class="conditional-inputs">
          <div class="form-group">
            <div class="alert alert-danger sr-only" data-form-register-alert>
              {{-- JavaScript shows validation feedback here --}}
            </div>
          </div>    
          <div class="form-group">
            <input id="fullname" name="fullname" class="fullname" type="text" placeholder="Nome completo" required data-customer-fullname>
          </div>
          <div class="form-group">
            <input id="email" name="email" class="email" type="email" placeholder="E-mail" required data-customer-email>
          </div>
          <div class="form-group">
            <input id="phone" name="phone" class="phone" type="text" placeholder="Celular" required data-customer-phone>
          </div>          
        </div>
        <button class="btn-submit" type="submit">Enviar</button>
      </form>
    </div>
  </div>
</div>
@endsection


@section('customjs')
  <script src="{{ asset('assets/alfacon/js/alfacon-info.js') }}" type="text/javascript"></script>
@endsection
