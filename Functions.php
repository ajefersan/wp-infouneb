<?php

	/*
	 * Função para formatar números em geral
	 * @link http://blog.clares.com.br/php-mascara-cnpj-cpf-data-e-qualquer-outra-coisa/
	 */

	function mf($string, $mask) {
 		$maskared = '';
 		$k = 0;
 		
 		for($i = 0; $i <= strlen($mask)-1; $i++) {
 			if($mask[$i] == '#') {
 				if(isset($string[$k])) $maskared .= $string[$k++];
 			}
 			else {
 				if(isset($mask[$i])) $maskared .= $mask[$i];
 			}
 		}
 		return $maskared;
	}

	/*
	 * Função que retorna o tipo do evento de acordo com a entrada no banco de dados.
	 */

	function evento_tipo($tipo) {
		return ($tipo == 1) ? 'Minicurso' : 'Laboratório';
	}

	function inscrito_titulo($int){
		$titulos = array("Graduação", "Pós-Graduação", "Mestrado", "Doutorado", "PhD", "Autodidata");
		return $titulos[$int];
	}

	/*
	 * Função que retorna o link da página de relatório
	 */

	function print_url() {
		return plugins_url() . '/Inscricoes/Print.php';
	}

	/*
	 * Função para formatar datas
	 */

	function data($string, $formato = 'd/m/Y') {
		return date($formato, strtotime($string));
	}


	/* 
	 * Função para validar CPF.
	 * @link http://www.geradorcpf.com/script-validar-cpf-php.htm
	 * @date 2014-06-20
	 */

	function validarCPF($cpf = null) {

	    if(empty($cpf)) { return false; }
	 
	    $cpf = ereg_replace('[^0-9]', '', $cpf);
	    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	     
	    if (strlen($cpf) != 11) { return false; }

	    else if ($cpf == '00000000000' || 
	        $cpf == '11111111111' || 
	        $cpf == '22222222222' || 
	        $cpf == '33333333333' || 
	        $cpf == '44444444444' || 
	        $cpf == '55555555555' || 
	        $cpf == '66666666666' || 
	        $cpf == '77777777777' || 
	        $cpf == '88888888888' || 
	        $cpf == '99999999999') {
	        return false;

	     } else {   
	         
	        for ($t = 9; $t < 11; $t++) {
	             
	            for ($d = 0, $c = 0; $c < $t; $c++) {
	                $d += $cpf{$c} * (($t + 1) - $c);
	            }
	            $d = ((10 * $d) % 11) % 10;
	            if ($cpf{$c} != $d) {
	                return false;
	            }
	        }
	 
	        return true;
	    }
	}


	/*
 	 * Função para gerar senhas aleatórias
 	 */

	function gerarSenha(){
		$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$tamanho = strlen($caracteres);

		for($i = 0; $i < 6; $i++){
			$rand = mt_rand(1, $tamanho);
			$retorno .= $caracteres[$rand-1];
		}
		return $retorno;
	}

	/*
 	 * Shortcodes para carregar as páginas.
 	 */

	function infouneb_shortcode_form_inscricao(){
		if(isset($_POST['infouneb'])){
			extract($_POST);

			if(empty($tos)){
				$msg = 'Você deve aceitar os termos de inscrição.';
			}
			elseif(empty($email)){
				$msg = 'Você deve informar seu e-mail.';
			}
			elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$msg = 'Você deve informar um e-mail válido.';
			}
			elseif(empty($senha)) {
				$msg = 'Você deve informar sua senha.';
			}
			elseif(strlen($senha) <= 5){
				$msg = 'Sua senha deve ter mais de 5 caracteres.';
			}
			elseif($senha != $confirme_senha){
				$msg = 'A confirmação de sua senha falhou. Por favor, forneça os mesmos válores para os campos de senha.';
			}
			elseif(empty($nome)){
				$msg = 'Você deve informar seu nome.';
			}
			elseif(empty($cpf)){
				$msg = 'Você deve informar seu CPF.';
			}
			elseif(!validarCPF($cpf)){
				$msg = 'Você deve informar um CPF válido.';
			}
			elseif(empty($telefone)){
				$msg = 'Você deve informar seu telefone.';
			}
			if(isset($msg)){

				echo '<div class="sysmsg erro">'. $msg .'</div>';

			} else{
				global $wpdb;

				// cadastra usuário

				$senha_hash = $senha; // escolher uma função de crypt

				$usuario_dados =  array('Email' => $email, 'Senha' => $senha_hash, 'Nome' => $nome, 'CPF' => $cpf, 'Nascimento' => $nascimento_ano . '-' . $nascimento_mes . '-' . $nascimento_dia, 'Telefone' => $telefone, 'Celular' => ((isset($celular)) ? $celular : null), 'Status' => 0, 'Sexo' => $sexo, 'Profissional' => $profissional, 'Titulo' => $titulo, 'Area' => $area);

				$cadUsuario = $wpdb->insert('infouneb_usuarios', $usuario_dados);

				if($cadUsuario){
					// cadastra as bli
					echo 'cadastro ok';
				}
				else{
					echo '<div class="sysmsg erro">Não conseguimos realizar seu cadastro. Entre em contato com a organização do evento.</div>';
				}
			}
		}
		require_once "templates/public/inscricao.html";
	}

	add_shortcode('infouneb_form_inscricao','infouneb_shortcode_form_inscricao');

	function infouneb_shortcode_form_acesso() {
		if(isset($_POST['infouneb'])){
			extract($_POST);

			if(empty($email)){
				$msg = 'Você deve informar seu e-mail.';
			}
			elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$msg = 'Você deve informar um e-mail válido.';
			}
			elseif(empty($senha)) {
				$msg = 'Você deve informar sua senha.';
			}

			if(isset($msg)){
				echo '<div class="sysmsg erro">'. $msg .'</div>';
			} else{
				global $wpdb;
				
				// verifica se o usuário está cadastrado
				$cadastro = $wpdb->get_var("SELECT `CPF` FROM `infouneb_usuarios` WHERE `Email` = '{$email}' AND `Senha` = '{$senha}'");

				if($cadastro){

					/*
					 * Escolher como passar a informação do usuário para o formulário de edição.
					 */
				}
				else{
					echo '<div class="sysmsg erro">E-mail ou senha inválida.</div>';
				}
			}
		}
		require_once "templates/public/acesso.html";
	}

	add_shortcode('infouneb_form_acesso', 'infouneb_shortcode_form_acesso');

	function infouneb_shortcode_form_senha() {
		if(isset($_POST['infouneb'])){
			extract($_POST);

			if(empty($email)){
				$msg = 'Você deve informar seu e-mail.';
			}
			elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$msg = 'Você deve informar um e-mail válido.';
			}

			if(isset($msg)){
				echo '<div class="sysmsg erro">'. $msg .'</div>';
			} else{

				global $wpdb;

				// verifica se o usuário está cadastrado
				$cadastro = $wpdb->get_var("SELECT COUNT(*) FROM `infouneb_usuarios` WHERE `Email` = '{$email}'");

				if($cadastro){

					// gera uma nova senha
					$nova_senha = gerarSenha();

					// atualiza o cadastro com a nova senha
					$atualizar = $wpdb->update('infouneb_usuarios', array('Senha' => $nova_senha), array('Email' => $email), '%s', '%s');

					if($atualizar){

						$assunto	= 'Senha InfoUNEB';
						$mensagem	= 'Olá, sua nova senha é: ' . $nova_senha;
						$headers	= 'From: InfoUNEB <organizacao_infouneb@uneb.br>';

						// envia e-mail com a nova senha
						if(wp_mail($email, $assunto, $mensagem, $headers)){
							echo '<div class="sysmsg ok">Uma nova senha foi gerada e enviada para seu e-mail.</div>';
						}
					}
					else{
						echo '<div class="sysmsg erro">Não conseguimos gerar uma nova senha. Entre em contato com a organização do evento.</div>';
					}
				}
				else{
					echo '<div class="sysmsg erro">Não foi encontrado nenhum usuário cadastrado com esse e-mail.</div>';
				}
			}
		}
		require_once "templates/public/senha.html";
	}

	add_shortcode('infouneb_form_senha', 'infouneb_shortcode_form_senha');