@extends('layouts.app')

@section('style')
@endsection

@section('content')

<div class="featured-box">
    <div class="wrapper">
        <div class="time-line">
				<span class="time-step">
					<span class="time-title">Faça o seu cadastro no Cristal.club</span>
					<span class="time-ball">Início</span>
				</span>
            <span class="time-step">
					<span class="time-title">Responda às perguntas de patrocinadores</span>
					<span class="time-ball"></span>
				</span>
            <span class="time-step">
					<span class="time-title">Responda sobre seus hábitos</span>
					<span class="time-ball"></span>
				</span>
            <span class="time-step">
					<span class="time-title">Faça download gratuito</span>
					<span class="time-ball"><img src="assets/images/icon_flag.png" alt=""></span>
				</span>
        </div>
        <div class="form-box" id="cadastro">
            <form accept-charset="utf-8" method="post" action="{{ route('sweet.api.create') }}">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                <input type="hidden" name="domain" id="domain" value="{{ env('APP_STORAGE') }}"  />
                <input type="hidden" name="source" id="source" value="" />
                <input type="hidden" name="medium" id="medium"  value="" />
                <input type="hidden" name="campaign" id="campaign"  value="" />
                <input type="hidden" name="term" id="term" value="" />
                <input type="hidden" name="content" id="content"  value="" />

                <div class="step-1">
                    <h2>PREENCHA SEUS DADOS PARA RECEBER O SEU <br />E-BOOK</h2>
                    <label id="fullname-label">Nome Completo
                        <input type="text" name="fullname" id="fullname" value="" class="input-text" required data-toggle="tooltip" title="Campo obrigatório">
                    </label>
                    <label id="email-label">E-mail
                        <input type="email" name="email" id="email" value="" class="input-text" required data-toggle="tooltip" title="Campo obrigatório" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    </label>
                    <label>Telefone Celular
                        <input type="text" name="phone_number" id="phone_number" value="" maxlength="14" class="input-text" placeholder="(__)_____-____" required data-toggle="tooltip" title="Campo obrigatório">
                    </label>
                    <button type="button" class="bt large block show-step-2" data-loading-text="Aguarde...">Continuar!</button>
                </div>
                <div class="step-2">
                    <h2>Passo 2</h2>
                    <label>Data de Nascimento
                        <input type="text" name="birthdate" id="birthdate" value="" maxlength="10" class="input-text" placeholder="dd/mm/aaaa" required data-toggle="tooltip" title="Campo obrigatório">
                    </label>
                    <label>Estado
                        <select id="state" class="input-text" required data-toggle="tooltip"></select>
                    </label>
                    <label>Cidade Natal
                        <select id="hometown" name="hometown" class="input-text"  required data-toggle="tooltip" title="Campo obrigatório"></select>
                    </label>
                    <button  type="button" class="bt large block" name="create" id="create">Enviar!</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="wrapper">
    <p>Uma noite tranquila de sono é o que todos precisamos para renovar as energias do corpo e da mente.
        Algumas vezes, sonhos perturbadores podem nos tirar a paz por dias... Nessas horas bate a angústia, e
        então é importante tentar compreender o que esse sonho representa. Será uma mensagem do subconsciente?
        Será uma tentativa de contato de planos espirituais elevados?</p>
        <p>Talvez somente o reflexo do estresse e do
            cansaço diários? Esse livro traz os principais significados de Sonhos buscados no <strong>Astrocentro</strong>, o
        maior portal de consultas esotéricas do Brasil.</p>

    <div class="icons-section" id="oportunidades">
        <div class="row" >
            <div class="col-4 icons-item"><img src="assets/images/icon_cap.png" alt="">Escolas de idiomas</div>
            <div class="col-4 icons-item"><img src="assets/images/icon_phone.png" alt="">Serviços de telefonia móvel
            </div>
            <div class="col-4 icons-item"><img src="assets/images/icon_laptop.png" alt="">Serviços de internet</div>
            <div class="col-4 icons-item"><img src="assets/images/icon_bowl.png" alt="">Cosméticos naturais</div>
            <div class="col-4 icons-item"><img src="assets/images/icon_heart.png" alt="">Sites de relacionamentos</div>
            <div class="col-4 icons-item"><img src="assets/images/icon_box.png" alt="">E muito mais...</div>
        </div>
        <a href="#cadastro" class="scrollAnchor"><span class="bt">Participar</span></a>
    </div>
</div>


<div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
    <div>
        <h2 id="modal1Title">Login</h2>
        <p id="modal1Desc">
            <form>
            <input type="email" name="email-login" id="email-login" class="input-text" required="" placeholder="Digite seu e-mail" />

            </form>
        </p>
    </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancelar</button>
    <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>

@endsection

@section('script')

<script type="text/javascript" charset="utf-8">


    (function ($) {


        $("#hometown").html('<option value="">Selecione o estado</option>');
        $.getJSON('assets/js/library/cidades-estados/estados_cidades.json', function (data) {

            var
                items = [],
                options = '<option value="">Escolha um estado</option>';

            $.each(data, function (key, val) {
                options += '<option value="' + val.sigla + '">' + val.nome + '</option>';
            });
            $("#state").html(options);

            $("#hometown").html('<option value="">Selecione o estado</option>');


            $("#state").change(function () {

                var
                    optionsCities = '',
                    str = '';

                $("#state option:selected").each(function () {
                    str += $(this).text();
                });

                $.each(data, function (key, val) {
                    if (val.nome == str) {
                        $.each(val.cidades, function (key_city, val_city) {
                            optionsCities += '<option value="' + val_city + '">' + val_city + '</option>';
                        });
                    }
                });

                $("#hometown").html(optionsCities);

            });
        });

        $('.scrollAnchor').click(function() {
            $('html, body').animate({
                scrollTop: $( $.attr(this, 'href') ).offset().top
            }, 500);
            return false;
        });

    })(jQuery);

</script>
@endsection
