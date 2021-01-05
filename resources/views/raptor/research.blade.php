@extends('layouts.research')

@section('content')
<div class="form-header">
  <div class="title">
    <h1>Pesquisa sobre renda dos Brasileiros</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div class="area-form">
      <form id="survey" data-form-register>
      {{ csrf_field() }}
        <div class="section-title">
          <h3>Responda corretamente abaixo para prosseguir</h3>
          <hr>
        </div>
        <div class="conditional-inputs">
          <div class="form-group">
            <div class="alert alert-danger sr-only" data-form-register-alert>
              {{-- JavaScript shows validation feedback here --}}
            </div>
          </div>

          {{-- Input Hidden --}}
          <input type="hidden" value="{{ $customerId }}" data-form-customer-id>

          <div class="form-group">
            <h4>Você é aposentado ou pensionista do INSS?</h4>
            <p required="required" class="radio-label">
                <input type="radio" id="option-s" name="question-1" value="1" required>
                <label for="option-s">Sim</label>
            </p>
            <p required="required" class="radio-label">
                <input type="radio" id="option-n" name="question-1" value="2" required>
                <label for="option-n">Não</label>
            </p>
            <!-- <p required="required" class="radio-label">
                <input type="radio" id="option-u" name="question-1" value="3" required>
                <label for="option-u">Prefiro não dizer</label>
            </p>             -->
          </div>

          {{-- 
          <div class="form-group">
            <h4>Qual sua idade?</h4>
            <input id="age" name="age" class="age" type="number" placeholder="Ex.: 15" data-raptor-age>
          </div>          

          <div class="form-group">
            <h4>Informe sua renda</h4>
            <p required="required" class="radio-label">
                <input type="radio" id="option-1" name="question-2" value="1" required>
                <label for="option-1">Até R$500,00</label>
            </p>
            <p required="required" class="radio-label">
                <input type="radio" id="option-2" name="question-2" value="2" required>
                <label for="option-2">De R$ 500,00 a R$1.000,00</label>
            </p>
            <p required="required" class="radio-label">
                <input type="radio" id="option-3" name="question-2" value="3" required>
                <label for="option-3">De R$ 1.000.01 a R$ 1.500,00</label>
            </p>
            <p required="required" class="radio-label">
                <input type="radio" id="option-4" name="question-2" value="4" required>
                <label for="option-4">De R$ 1.500,01 a R$ 2.500,00</label>
            </p>   
            <p required="required" class="radio-label">
                <input type="radio" id="option-5" name="question-2" value="5" required>
                <label for="option-5">De 2.500,01 a R$ 4.000,00</label>
            </p>
            <p required="required" class="radio-label">
                <input type="radio" id="option-6" name="question-2" value="6" required>
                <label for="option-6">De R$4.000,01 a R$7.000,00</label>
            </p>
            <p required="required" class="radio-label">
                <input type="radio" id="option-7" name="question-2" value="7" required>
                <label for="option-7">De R$7.000,01 a R$10.000,00</label>
            </p>
            <p required="required" class="radio-label">
                <input type="radio" id="option-8" name="question-2" value="8" required>
                <label for="option-8">Acima de R$10.000,01</label>
            </p>
          </div>          
          --}}
   
        </div>
        <button class="btn-submit" type="submit" data-btn-submit>Enviar</button>
      </form>
    </div>
  </div>
</div>
@endsection


@section('customjs')
  <script src="{{ asset('assets/raptor/js/info.js') }}" type="text/javascript"></script>
@endsection
