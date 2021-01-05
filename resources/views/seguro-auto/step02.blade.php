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
      <form id="step-one" data-form-register>
        {{ csrf_field() }}
        <div class="section-title">
          <h3>Preencha corretamente as perguntas abaixo</h3>
          <hr>
        </div>
        <div class="conditional-inputs">
          <div class="form-group">
            <div class="alert alert-danger sr-only" data-form-register-alert>
              {{-- JavaScript shows validation feedback here --}}
            </div>
          </div>

          <input type="hidden" value="{{ env('APP_SWEET_API') }}" data-sweet-api-url>
          <input type="hidden" value="{{ Session::get('id') }}" data-customer-id>

          <div class="form-group" data-wrap-brand>
            <label for="brand">
              Marca do veículo
            </label>
            <select id="brand" name="brand" data-insurance-brand>               
            </select>
          </div>

          <div class="form-group" data-wrap-model>
            <label for="model">
              Modelo
            </label>
            <select id="model" name="model" data-insurance-model>
            </select>
          </div>

          <div class="form-group" data-wrap-year>
            <label for="year">
              Ano
            </label>
            <select id="year" name="year" data-insurance-year>
            </select>
          </div>
          
          <div class="form-group" data-wrap-has-insurance>
            <p class="radio-label">
            <label for="gender"><strong>Você possui seguro veículo?</strong></label><br>
              <input class="has_insurance" type="radio" id="sim-insurance" name="has_insurance" value="Sim">
              <label for="sim-insurance">Sim</label>
              <input clas="has_insurance" type="radio" id="nao-insurance" name="has_insurance" value="Não">
              <label for="nao-insurance">Não</label>
            </p>          
          </div>

          <div class="form-group" data-wrap-insurer>
            <label for="insurer">
              Qual seguradora?
            </label>
            <select id="insurer" name="insurer" data-insurance-insurer>
            </select>
          </div>

          <div class="form-group" data-wrap-date-insurance>
            <label>Período de Renovação</label>
            <div class="row">
              <div class="col-sm-4">
                <label for="date_insurance">
                  Mês
                </label>
                <select id="date_insurance_year" name="date_insurance_year" data-date-insurance-month>
                </select>
              </div>
              <div class="col-sm-8">
                <label for="date_insurance">
                  Ano
                </label>
                <select id="date_insurance_year" name="date_insurance_year" data-date-insurance-year>
                </select>
              </div>
            </div>
          </div>     

          <div class="form-group">
            <div class="alert alert-danger sr-only" data-form-register-alert>
              {{-- JavaScript shows validation feedback here --}}
            </div>
          </div>

        </div>
        <button class="btn-submit" type="submit" data-btn-submit>Enviar</button>
      </form>
    </div>
  </div>
</div>

<script src="{{ asset('assets/seguro-auto/js/step-two.js') }}" type="text/javascript"></script>

@endsection