 <section id="text-about">
   <div class="container">
     <div class="row">
       <div class="col-12 text">
       @if('xmove-car' === $page)
       <div id="carouselExampleIndicators" class="carousel slide" style="padding-top:4%;margin-bottom:-4%;" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/hatch/ford-ka.png') }}" alt="Ford Ka">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-ka"><strong>Ford Ka <br> Hatch </strong></h5>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/hatch/chevrolet-onix.png') }}" alt="Chevrolet Onix">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-onix"><strong>Chevrolet Onix <br> Hatch </strong></h5>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/hatch/fiat-mobi.png') }}" alt="Fiat Mobi">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-mobi"><strong>Fiat Mobi <br> Hatch </strong></h5>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/hatch/renaut-kwid.png') }}" alt="Renault Kwid">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-kwid"><strong>Renault Kwid <br> Hatch </strong></h5>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/hatch/renaut-sandero.png') }}" alt="Renault Sandero">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-sandero"><strong>Renault Sandero <br> Hatch </strong></h5>
            </div>
          </div>

          <div class="carousel-item">
          <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/sedan/ford-ka-sedan.png') }}" alt="Ford Ka">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-sandero"><strong>Ford Ka <br> Sedan </strong></h5>
            </div>            
          </div>
          <div class="carousel-item">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/sedan/chevrolet-prisma.png') }}" alt="Chevrolet Prisma">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-prisma"><strong>Chevrolet Prisma <br> Sedan </strong></h5>
            </div> 
          </div>
          <div class="carousel-item">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/sedan/fiat-grand-siena.png') }}" alt="Fiat Grand Siena">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-siena"><strong>Fiat Grand Siena <br> Sedan </strong></h5>
            </div> 
          </div>
          <div class="carousel-item">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/sedan/renaut-logan.png') }}" alt="Renault Logan">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-logan"><strong>Renault Logan <br> Sedan </strong></h5>
            </div> 
          </div>
          <div class="carousel-item">
            <img class="d-block w-100 cars-xmove" src="{{ asset('images/subpage/xmove-car/sedan/nissan-versa.png') }}" alt="Nissan Versa">
            <div class="carousel-caption d-none d-md-block custom-xmove">
              <h5 class="subtitle-versa"><strong>Nissan Versa <br> Sedan </strong></h5>
            </div> 
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Próximo</span>
        </a>
      </div>




       @else
         <p align="center"><br>Torne-se ainda hoje membro da SweetBonus e receba produtos para testar diretamente na sua casa!! Quer receber amostras das melhores marcas gratuitamente? Funciona da seguinte forma: você se inscreve e responde sobre campanhas e promoções de nossos afiliados e gera pontos, onde você pode procurar produtos que quer testar. A participação é 100% gratuita, inclusive o envio dos brindes gratis pelo correio. Temos produtos grátis de todos os tipos, você poderá receber amostra gratis de produtos nacionais, amostra gratis de produtos importados , temos de tudo um pouco! Então venha fazer parte da SweetBonus agora mesmo!</p>
       @endif
       </div>
     </div>
   </div>
</section>