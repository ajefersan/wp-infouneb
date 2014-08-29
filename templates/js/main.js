jQuery(document).ready(function(){
	jQuery("#addbli").validate({
		rules: {
			bli_titulo : {
				required: true,
			},
			bli_valor : {
				required: true,
				number: true,
			},
			bli_vagas: {
				required: true,
				number: true,
			},
			bli_description: {
				required: true,
			}
		}
	});
	jQuery("#publico_inscricao").validate({
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
				required: true,
				number: true,
				minlength: 11,
				maxlength: 11
			},
			telefone: {
				required: true,
				number: true
			},
			celular: {
				number: true
			},
			tos: {
				required: true
			},
			area: {
				required: true
			}
		}
	});
});