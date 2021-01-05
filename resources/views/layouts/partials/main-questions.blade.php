<section id="main-questions">
    <div class="container">
      <div class="row">       
        @if('xmove-car' === $page)
        <div class="col-md-6 question question-1 first-question-xmove">
          <h3>Por que alugar um carro?</h3>
          <p id="why-xmove">
            Melhor custo benefício do mercado. <br> Sem necessidade de cartão de crédito.
          </p>
        @else
        <div class="col-md-6 question question-1">
          <h3>O que posso ganhar?</h3>
          <p>
            Dependendo de sua quantidade de pontos, você pode trocar por produtos de marcas variadas como: Omo, Nutella, Dove e muito mais!
          </p>
        @endif
        </div>        
        @if('xmove-car' === $page)
        <div id="about-xmove" class="col-md-6 question question-2 second-question-xmove">
          <h3>Sobre a XMove Car</h3>
            <p>
            Somos uma locadora de veículos para aplicativos. Muito mais que uma locadora, venha mudar seu conceito de locação, venha para Xmove Car!
            </p>
          @else
          <div id="about-xmove" class="col-md-6 question question-2">
          <h3>O que é a Sweet?</h3>
            <p>
              A Sweet é uma plataforma em que qualquer pessoa pode realizar tarefas simples na internet, ganhar pontos e trocar por produtos.
            </p>
          @endif          
        </div>

        @if('xmove-car' === $page)
        <div class="container">
          <div class="row steps-xmove">
            <div class="col-12">
              <h3 class="title-vs-xmove">Hatch vs Sedan</h3>
            </div>
          </div>
          <div id="about-xmove" class="col-md-6 question question-2 hatch-question second-question-xmove">
            <h3>Hatch</h3>
              <p>
              Automóveis mais compactos. <br> Motores menos potentes. <br> Mais econômicos.
              </p>
          </div>
          <div class="col-md-6 question question-1 sedan-question-xmove">
            <h3>Sedan</h3>
            <p id="why-xmove">
               Automóveis mais confortáveis. <br> Espaço interno e porta-malas grande. <br>Motores mais potentes.
            </p>
          </div>        
        </div>        
        @endif
      </div>
    </div>
</section>