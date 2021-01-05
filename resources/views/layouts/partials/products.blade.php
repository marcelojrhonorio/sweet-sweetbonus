@if('maquiagem' === $page)
<section id="products">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/maquiagem-img-1.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/maquiagem-img-2.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/maquiagem-img-3.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/maquiagem-img-4.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
      </div>
    </div>
</section>

@elseif('bebes' === $page)
<section id="products">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/bebes-img-1.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/bebes-img-2.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/bebes-img-3.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/bebes-img-4.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
      </div>
    </div>
</section>

@elseif('musculacao' === $page)
<section id="products">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/musculacao-img-1.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/musculacao-img-2.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/musculacao-img-3.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/musculacao-img-4.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
      </div>
    </div>
</section>

@elseif('perfumes' === $page)
<section id="products">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/perfumes-img-1.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/perfumes-img-2.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/perfumes-img-3.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
        <div class="col-md-3 col-sm-6 item">
          <img src="{{ asset('images/subpage/perfumes-img-4.png') }}">
          <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
        </div>
      </div>
    </div>
</section>

@elseif('xmove-car' === $page)

@else
<section id="products">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-6 item">
        <img src="{{ asset('images/subpage/products-img-1.png') }}">
        <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
      </div>
      <div class="col-md-3 col-sm-6 item">
        <img src="{{ asset('images/subpage/products-img-2.png') }}">
        <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
      </div>
      <div class="col-md-3 col-sm-6 item">
        <img src="{{ asset('images/subpage/products-img-3.png') }}">
        <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
      </div>
      <div class="col-md-3 col-sm-6 item">
        <img src="{{ asset('images/subpage/products-img-2.png') }}">
        <a href=".form-box" class="scroll" title="Quero agora!"><span>Quero agora!</span></a>
      </div>
    </div>
  </div>
</section>

@endif