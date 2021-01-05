@extends('layouts.research')

@section('content')
<div class="form-header">
  <div class="title">
    <h1>Pesquisa Seguro Auto</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div class="area-form">
      <form id="step-two" data-form-register>
        {{ csrf_field() }}
        <div class="section-title">
          <h3>Encontramos ofertas especiais para você com 
              base em seu perfil! Informe os dados abaixo 
              para podermos te enviar as ofertas exclusivas de seguro:
          </h3>
          <hr>
        </div>
        <div class="conditional-inputs">

          <input type="hidden" name="store_url" value="{{ env('STORE_URL') }}" data-store-url>
          
          <div class="form-group">
            <div class="alert alert-danger sr-only" data-form-register-alert>
              Você deve informar um número de celular e um CPF válido.
            </div>
            <div class="alert alert-success sr-only" data-form-register-alert-success>
              Pesquisa concluída! Redirecionando para Store...
            </div>
          </div>

          <div class="form-group">
            <label for="mobile_phone">
              Celular:
            </label>
            <input
              id="mobile_phone"
              class="form-control"
              name="mobile_phone"
              placeholder="Ex: (11) 99123-4567"
              type="text"
              data-insurance-mobile
            >
          </div>

          <div class="form-group">
            <label for="phone">
              Telefone de contato:
            </label>
            <input
              id="phone"
              class="form-control"
              name="phone"
              placeholder="Ex: (11) 3456-7890"
              type="text"
              data-insurance-phone
            >
          </div>    

          <div class="form-group">
            <label for="cpf">
              CPF:
            </label>
            <input
              id="cpf"
              class="form-control"
              name="cpf"
              placeholder="Ex: 123.456.789-10"
              type="text"
              data-insurance-cpf
            >
          </div>                 

          <div class="form-group">
            <div class="alert alert-danger sr-only" data-form-register-alert>
              Você deve informar um número de celular e um CPF válido.
            </div>
            <div class="alert alert-success sr-only" data-form-register-alert-success>
              Pesquisa concluída! Redirecionando para Store...
            </div>            
          </div>                
        </div> 
        <button class="btn-submit" type="submit" data-btn-submit>Enviar</button>             
      </form>
    </div>
  </div>
</div>

<script src="{{ asset('assets/seguro-auto/js/step-three.js') }}" type="text/javascript"></script>

@endsection