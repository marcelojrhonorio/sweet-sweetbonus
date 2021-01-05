@if('xmove-car' === $page)
  <section id="steps" class="steps-xmove">
@else 
  <section id="steps">
@endif
    <div class="container">
      <div class="row">
        <div class="col-12">
          @if('xmove-car' === $page)
            <h3>Veja como é rápido alugar o seu carro</h3>
          @else 
            <h3>Como Participar</h3>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-md item item-1">
        @if('xmove-car' === $page)
          <img src="{{ asset('images/subpage/xmove-car/steps-icon-1_blue.png') }}">
        @else 
          <img src="{{ asset('images/subpage/steps-icon-1.png') }}">
        @endif
          <p>Preencha o<br>formulário</p>
        </div>
        <div class="col-md item item-2">
        @if('xmove-car' === $page)
          <img src="{{ asset('images/subpage/xmove-car/steps-icon-2_blue.png') }}">
        @else 
          <img src="{{ asset('images/subpage/steps-icon-2.png') }}">
        @endif
          @if('xmove-car' === $page)
            <p>Entramos em<br>contato</p>
          @else 
            <p>Responda as<br>perguntas</p>
          @endif
        </div>
        <div class="col-md item item-3">
        @if('xmove-car' === $page)
          <img src="{{ asset('images/subpage/xmove-car/steps-icon-3_blue.png') }}">
        @else 
          <img src="{{ asset('images/subpage/steps-icon-3.png') }}">
        @endif
          <p>Aguarde</p>
        </div>
      </div>
    </div>
</section>