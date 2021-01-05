@extends('layouts.campaigns')

@section('content')
  <header>
    <div class="container">
      <img class="logo" src="https://sweetbonus.com.br/images/subpage/main-logo.png">
    </div>
  </header>
  <section id="slider" class="internal-section">
    <div class="container">
      <div class="section-header" id="section-header">
        <h1 class="main-title">
          A SweetBonus escolhe pessoas reais para testarem amostras, 
          por isso responda com atenção as perguntas abaixo.
        </h1>
      </div>
      <div class="progress">
        <div class="progress-wrapper">
          <div class="balloons">
            <div class="campaigns-step" style="margin-left: calc(0% - 15px);">
              <div class="balloon-item" style="background-color: #f4ae30" data-balloon-percent0>
                0%<i class="fa fa-play" style="color: #f4ae30;" aria-hidden="true" data-balloon-percent0-icon></i>
              </div>
            </div>
            <div class="campaigns-step" style="margin-left: calc(25% - 15px);">
              <div class="balloon-item" data-balloon-percent25>
                25%<i class="fa fa-play" style="color: #bc6ba3;" aria-hidden="true" data-balloon-percent25-icon></i>
              </div>
            </div>
            <div class="campaigns-step" style="margin-left: calc(50% - 15px);">
              <div class="balloon-item" data-balloon-percent50>
                50%<i class="fa fa-play" style="color: #bc6ba3;" aria-hidden="true" data-balloon-percent50-icon></i>
              </div>
            </div>
            <div class="campaigns-step" style="margin-left: calc(75% - 15px);">
              <div class="balloon-item" data-balloon-percent75>
                75%<i class="fa fa-play" style="color: #bc6ba3;" aria-hidden="true" data-balloon-percent75-icon></i>
              </div>
            </div>
            <div class="campaigns-step" style="margin-left: calc(100% - 15px);">
              <div class="balloon-item" data-balloon-percent100>
                100%<i class="fa fa-play" style="color: #bc6ba3;" aria-hidden="true" data-balloon-percent100-icon></i>
              </div>                           
            </div>
          </div>
          <div class="progress-bar-wrapper">
            <div class="progress-bar" 
              aria-valuemin="0" 
              aria-valuemax="100" 
              data-campaign-progress
            >
              <div class="progress-value"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="slider-content" data-campaign-wrap>
        <div class="option active">
          <div class="media">
            <input type="hidden" value={{ env('APP_STORAGE') }} data-storage-url>
            <img class="img-responsive" width="500" height="260" data-image-path>
          </div>
          <div class="content questions">

            {{-- Render title --}}
            <h3 data-campaign-title></h3>

            {{-- Campaign ID --}}
            <input type="hidden" data-campaign-id value="">
            
            {{-- Render Questions Here --}}
            <p data-campaign-question></p>
            
            <div class="description question">
              
              {{-- Render Answers Here --}}
              <div data-campaign-answers></div>
              
            </div>
            <div class="actions">
              <button type="button" class="btn btn-yellow" data-btn-answer>
                <img class="sr-only" src="{{ asset('assets/images/ajaxSpinner.gif') }}" 
                  style="width: 20px; opacity: 0.7;" data-ajax-spinner>
                <span data-span-btn>Continuar</span>
                <i class="fas fa-angle-right pull-right" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
  {{-- Google Code for Conversao_sweet Conversion Page --}}
  <script>
    /* <![CDATA[ */
    var google_conversion_id = 815359827;
    var google_conversion_label = "HCO1CIqCuH8Q087lhAM";
    var google_remarketing_only = false;
    /* ]]> */
  </script>
  <script src="//www.googleadservices.com/pagead/conversion.js"></script>
  <noscript>
    <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/815359827/?label=HCO1CIqCuH8Q087lhAM&amp;guid=ON&amp;script=0">
    </div>
  </noscript>

  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/app/campaigns.js') }}"></script>

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