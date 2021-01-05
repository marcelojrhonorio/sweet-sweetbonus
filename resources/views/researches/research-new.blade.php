@extends('layouts.research')

@section('content')

<div class="form-header" style="background-color:#e1e66b">
  <div class="title title-research">
    <h1 style="color:#475a4e">
    @if(isset($research->title))
      {{ $research->title }}
    @endif
    </h1>
  </div>
</div>

<section id="slider" class="internal-section">
    <div class="container">
      <div class="section-header" id="section-header">
        <div class="progress-bar-research">
            <div class="progress">
              <div class="progress-wrapper">            
                <div class="progress-bar-wrapper">
                  <div class="progress-bar" 
                    aria-valuemin="0" 
                    aria-valuemax="100" 
                    data-research-progress
                  >
                    <div class="progress-value"></div>
                  </div>            
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</section>

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
            <form id="survey" method="post" data-smk-form>
                <input name="_token" type="hidden" value="{{ csrf_token() }}">     
                <div class="section-title" style="margin-top:-2%;color:#475a4e">
                    <h3>
                      <b> 
                        @if(isset($research->subtitle))
                          {{ $research->subtitle }} 
                        @endif
                      </b>
                    </h3>
                    <hr style="width:inherit;">
                </div>                

                {{-- Loader --}}
                <div class="text-center">
                  <div class="spinner-grow text-danger" style="width:6rem;height:6rem;background-color:#bc6ba3" role="status" data-research-loader>                  
                  </div>
                </div>

                {{-- Render current question here --}}
                <div class="current-question" data-research-current-question></div>

                {{-- Form alert feedback --}}
                <div class="alert-research alert-danger alert-dismissible sr-only" data-alert-danger>
                    Por favor, selecione uma opção.
                </div>

                <div class="">                    
                    <i class="fa fa-arrow-circle-right next-question sr-only" style="color: #bc6ba3" data-btn-next></i>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<input name="total_questions" type="hidden" value="" total-questions>     

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/researches/js/sponsored.js') }}" type="text/javascript"></script>

{{-- Block F5 Key --}}
  <script type="text/javascript">
    $(document).ready(function() {
      $(window).keydown(function(event){
        if(event.keyCode == 116) {
          event.preventDefault();
          return false;
        }
      });
    });
  </script>

@endsection
