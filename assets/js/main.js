$(document).ready(function(){

	// validar campos com jValidation

	$("#publico_inscricao").validate({
		errorElement : 'p',
		rules: {
			email: {
				required: true,
				email: true
			},
			senha: {
				required: true,
				minlength: 6
			},
			confirme_senha:{
				required: true,
				equalTo: "#senha"
			},
			nome:{
				required: true,
				minlength: 10
			},
			cpf:{
				required: true
			},
			telefone: {
				required: true
			},
			nascimento:{
				required: true
			},
			tos: {
				required: true
			}
		}
	});

	$.programacao();

	$( '#header' ).parallax("50%", 1);

	$("#navigation nav ul ul a").click(function(evn){
        evn.preventDefault();
         $('html,body').scrollTo(this.hash, this.hash); 
    });

    $('.botaoInscricao').click(function(evn){
    	evn.preventDefault();
    	$('html,body').scrollTo( 0, 2050);
    });

    $('#nascimento').mask("99/99/9999");
    $('#telefone, #celular').mask("(99) 9999-9999");
    $('#cpf').mask("999.999.999-99");

});
$.programacao = function(){
	var tabs = 'ul#prog_nav';
	var contents = 'ul.programacao';

	$(contents).hide();

	$(contents + '.segunda').show();

	$(tabs + ' li a').click(function(){
		$(tabs + ' li a').removeClass('active');
		$(this).addClass('active');

		$(contents).hide();

		$(contents +  '.' + $(this).attr('id')).show();

		return false;
	});
}