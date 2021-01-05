@extends('layouts.research')

@section('content')

<div class="form-header">
  <div class="title">
    <h1>
      {{ $research->title }}
    </h1>
  </div>
</div>

  <div class="msg-alert-research">
    <div class="alert alert-danger sr-only" data-form-register-alert>
      {{-- JavaScript shows validation feedback here --}}
    </div>
  </div>  
  <div class="msg-success-research">
    <div class="alert alert-success sr-only" data-form-alert-success>
      {{-- JavaScript shows validation feedback here --}}
    </div>
  </div>  

<div class="form">
  <div class="form-wrapper">
    <div id="app">        
        <div class="area-form">
            <form id="survey" method="post" action="/research/{{$research->final_url}}/research" data-smk-form>
            <input name="_token" type="hidden" value="{{ csrf_token() }}">      
            <input type="hidden" value="{{$questionsOneAnswer}}" data-questions-one-answer>      
            <input type="hidden" value="{{$questionsMoreAnswer}}" data-questions-more-answer>      
            <div class="section-title">
                <h3> {{ $research->subtitle }} </h3>
                <hr>
            </div>
            @foreach($questions as $question)
                <div class="conditional-inputs" id="{{ $question->id }}">
                    <input type="hidden" id="research" name="research" value="research-{{$research->id}}">
                    <input name="customers_id" id="customers_id" name="customers_id" type="hidden" value="customers-{{ $customers_id }}">
                    <div class="form-group">
                    <h4>{{ $question->description }} *</h4>
                    @if($question->extra_information)
                      <p class="extra-information">{{$question->extra_information}}</p>
                    @endif
                    @foreach($question_options as $question_option)
                      @if($question_option[0]->questions_id == $question->id)
                        @foreach($question_option as $ques_opt)
                          @foreach($options as $option)
                            @if($option->id == $ques_opt->options_id)
                              @php 
                                $flag = '';
                              @endphp
                              <p class="radio-label" required>
                                {{-- Verificação de questions com Middle Page --}}
                                @foreach($researchMiddlePages as $researchMiddlePage) 
                                  @if($researchMiddlePage->questions_id == $question->id)
                                    @foreach($middlePages as $middlePage)
                                      @if($middlePage->id == $researchMiddlePage->middle_pages_id)
                                        @if($option->id == $researchMiddlePage->options_id)
                                          @php 
                                            $flag = $option->id;
                                          @endphp
                                          @if($question->one_answer)
                                            <input type="radio" id="option-{{$option->id}}" name="question-{{$question->id}}" value="{{$option->id}}middle{{$middlePage->id}}" required>
                                            <label for="option-{{$option->id}}"> {{$option->description}} </label>
                                          @else 
                                            <input type="checkbox" id="option-{{$option->id}}" name="question-{{$question->id}}[]" value="{{$option->id}}middle{{$middlePage->id}}">
                                            <label for="option-{{$option->id}}"> {{$option->description}} </label>
                                          @endif  
                                        @endif  
                                      @endif
                                    @endforeach
                                  @endif
                                @endforeach

                                {{-- Tratamento para não duplicar as options --}}
                                @if($flag != $option->id)
                                  @if($question->one_answer)
                                    <input type="radio" id="option-{{$option->id}}" name="question-{{$question->id}}" value="option-{{$option->id}}" required>
                                    <label for="option-{{$option->id}}"> {{$option->description}} </label>
                                  @else 
                                    <input type="checkbox" id="option-{{$option->id}}" name="question-{{$question->id}}[]" value="option-{{$option->id}}">
                                    <label for="option-{{$option->id}}"> {{$option->description}} </label>
                                  @endif  
                                @endif         
                              </p>  
                            @endif                          
                          @endforeach
                        @endforeach
                      @endif
                    @endforeach             
                    <p class="radio-label error"></p>
                    </div>
                </div>   
            @endforeach           

            <button class="btn-submit" type="submit" btn-submit-research>Enviar</button>
            </form>
            <div class="msg-alert-research2">
              <div class="alert alert-danger sr-only" data-form-register-alert>
                {{-- JavaScript shows validation feedback here --}}
              </div>
            </div> 
            <div class="msg-success-research2">
              <div class="alert alert-success sr-only" data-form-alert-success>
                {{-- JavaScript shows validation feedback here --}}
              </div>
            </div>   
        </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/researches/js/sponsored.js') }}" type="text/javascript"></script>

@endsection