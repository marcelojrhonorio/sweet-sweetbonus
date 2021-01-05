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
          <h3>Responda corretamente as perguntas abaixo</h3>
          <hr>
        </div>
        <div class="conditional-inputs">
          <div class="form-group">
            <div class="alert alert-danger sr-only" data-form-register-alert>
              {{-- JavaScript shows validation feedback here --}}
            </div>
          </div>
          <div class="form-group">
            <p class="radio-label">
            <label for="gender"><strong>Você possui veículo?</strong></label><br>
              <input clas="has_vehicle" type="radio" id="nao-vehicle" name="has_vehicle" value="Não">
              <label for="nao-vehicle">Não</label>
              <input class="has_vehicle" type="radio" id="sim-vehicle" name="has_vehicle" value="Sim">
              <label for="sim-vehicle">Sim</label>
            </p>          
          </div>         
          <div class="form-group">
            <div class="alert alert-danger sr-only" data-form-register-alert>
              {{-- JavaScript shows validation feedback here --}}
            </div>
          </div>
        </div>
        <button class="btn-submit" type="submit">Enviar</button>
      </form>
    </div>
  </div>
</div>

<script src="{{ asset('assets/seguro-auto/js/step-one.js') }}" type="text/javascript"></script>

@endsection