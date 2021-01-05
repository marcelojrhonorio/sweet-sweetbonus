$(document).ready(function(){
	$('#estado').change(function(){
        $('#opcoes').html('Carregando...');
        data = $(this).val();
        $('.opcoes_cidades').remove();
        $.ajax({
            type: "POST",
            url: "cidades.php",
            data: {estado: data},
            cache: false,
            success: function(response)
            {
                $('#opcoes').after(response);
                $('#opcoes').html('Selecione uma cidade');
            }
        });
    });

    $(".data_nascimento").mask("99/99/9999");
    $("#CPF").mask("999.999.999-99");
    $(".cep").mask("99999-999");
	$("#telefone").mask('(99) 9999-9999');
	$("#celular").mask('(99) 99999-9999');

  $('#estado').change(function() {
    var $select_cidades, estado;
    $select_cidades = $('#cidade');
    $select_cidades.attr('disabled', true);
    estado = $(this).val();
    $.getJSON('get_cidades.php', {
      estado: estado
    }, function(data) {
      $select_cidades.html(new Option('Selecione uma cidade', ''));
      $.each(data, function(k, v) {
        $select_cidades.append(new Option(v, k));
      });
    }).done(function() {
      $select_cidades.attr('disabled', false);
    });

  });
});

function check(objForm)	{
	telMatch = ['0000-0000', '1111-1111', '2222-2222', '3333-3333', '4444-4444', '5555-5555', '6666-6666', '7777-7777', '8888-8888', '9999-9999','0000-00000', '1111-11111', '2222-22222', '3333-33333', '4444-44444', '5555-55555', '6666-66666', '7777-77777', '8888-88888', '9999-99999'];
	telFixoMatch = ['0', '1', '6', '7', '8', '9'];
	telMovelMatch = ['0', '1', '2', '3', '4'];

	cel = $("#celular").val();
	subcel = cel.substr(1,2);
	total = $("#celular").val().length;

	for(var i=0; i < telMatch.length; ++i){
		if($("#telefone").val().substr(5) == telMatch[i] || $("#telefone").val().substr(5,1) == telFixoMatch[i] || $("#telefone").val().substr(1,1) == "0"){
			alert('Telefone fixo invÃ¡lido!');
			$("#telefone").focus();
			return false;
		}
	}


	for(var i=0; i < telMovelMatch.length; ++i){
		if($("#celular").val().substr(5) == telMatch[i] || $("#celular").val().substr(5,1) == telMovelMatch[i] || $("#celular").val().substr(1,1) == "0"){
				alert('Telefone mÃ³vel invÃ¡lido!');
				$("#celular").focus();
				return false;
			}
	}

	if( !validateFormTemplate( objForm, null, true ) )
		return false;
		
		$("#btn_submit").hide();
}