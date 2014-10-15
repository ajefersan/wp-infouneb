$(document).ready(function(){

	// validar campos com jValidation

	$("#publico_inscricao").validate({
		errorElement : 'p',
		rules: {
			email: {
				required: true,
				email: true
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
			}
		}
	});

	$('form#maratona').validate({
		errorElement : 'p',
		rules: {
			lider: {
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
    	$('html,body').scrollTo( 0, 2200);
    });

    $('#nascimento').mask("99/99/9999");
    $('#telefone, #celular').mask("(99) 9999-9999");
    $('#cpf, .maskcpf').mask("999.999.999-99");
     
     $('.eventos input[type="checkbox"]').change(function()
     {
        if(this.checked)
        {
        	$('.eventos input[type="checkbox"].' + $(this).attr('class')).not(":checked").hide();
        }
        else
        {
            $('.eventos input[type="checkbox"].' + $(this).attr('class')).not(":checked").show();
        }
    });

});
$.programacao = function(){
	var tabs = 'ul#prog_nav';
	var contents = 'ul.novaprogramacao';

	$(contents).hide();

	$(contents + '.palestras').show();

	$(tabs + ' li a').click(function(){
		$(tabs + ' li a').removeClass('active');
		$(this).addClass('active');

		$(contents).hide();

		$(contents +  '.' + $(this).attr('id')).show();

		return false;
	});
}