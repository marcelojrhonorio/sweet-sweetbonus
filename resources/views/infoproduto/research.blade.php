@extends('layouts.research')

@section('content')
<div class="form-header">
  <div class="title">
    <h1>Pesquisa sobre o perfil dos brasileiros</h1>
  </div>
</div>
<div class="form">
  <div class="form-wrapper">
    <div class="area-form">
      <form id="survey" data-form-register>
      {{ csrf_field() }}
        <div class="section-title">
          <h3>Responda corretamente as questões abaixo</h3>
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
          <input type="hidden" value="{{ count($research) }}" data-form-count-questions>
          <input type="hidden" value="{{ env('INFOPRODUTO_INCENTIVE_EMAIL_CODE') }}" data-incentive-email-code>
          <input type="hidden" value="{{ env('STORE_URL') }}" data-store-url>

          @foreach($research as $question)
          <div class="form-group">
            <h4>{{ $question->description }}</h4>
            @foreach($question->research_options as $option)
              <p required="required" class="{{ count($question->research_options) == 1 ? 'sr-only' : 'radio-label'}}">
                <input type="{{ $question->one_answer == '1' ? 'radio' : 'checkbox' }}" 
                 id="option-{{ $option->id }}" 
                 name="question-{{ $question->id }}" 
                 value="{{ $option->id }}"
                 data-opened="{{ '1' ==  $option->opened_answer ? 'true' : 'false' }}"
                 data-question="{{ $question->id }}"
                 data-research-option
                 @if($question->one_answer == '1')
                  required
                 @endif
                 @if(count($question->research_options) == 1)
                  checked
                 @endif
                >
                <label for="option-{{ $option->id }}">{{ $option->description }}</label>
              </p>
              @if('1' === $option->opened_answer)
                <input id="opened-question-{{ $question->id }}" name="opened-question-{{ $question->id }}" class="opened-question-{{ $question->id }} {{ count($question->research_options) == 1 ? 'opened-answer' : 'opened-answer sr-only'}}" type="text" placeholder="Digite a resposta aqui">
              @endif
            @endforeach
          </div>
          @endforeach

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
@endsection


@section('customjs')
  <script src="{{ asset('assets/infoproduto/js/infoproduto.js') }}" type="text/javascript"></script>
@endsection
