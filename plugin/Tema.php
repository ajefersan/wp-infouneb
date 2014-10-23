<?php

	$Conexao = new InscricoesConexao();

	function InfoUNEBProgramacao($tipo)
	{
		global $wpdb, $Conexao;

		if($tipo == 'palestras')
		{
			return $wpdb->get_results("SELECT * FROM `{$Conexao->tpalestras}`");
		}
		if($tipo == 'minicursos')
		{
			return $wpdb->get_results("SELECT * FROM `{$Conexao->teventos}` WHERE `Tipo` = '1' ORDER BY `Grupo` DESC");
		}
		if($tipo == 'laboratorios')
		{
			return $wpdb->get_results("SELECT * FROM `{$Conexao->teventos}` WHERE `Tipo` = '2' ORDER BY `Grupo` DESC");
		}
	}

	function InfoUNEBEventos()
	{
		global $wpdb, $Conexao;

		$blis = $wpdb->get_results("SELECT *, (SELECT count(i.`Bli`) FROM `{$Conexao->tinscricoes}` AS i WHERE i.`Bli` = b.`Id`) AS Contador FROM `{$Conexao->teventos}` AS b");

		foreach($blis as $key => $value)
		{
			echo '<li class="hora'.$value->Grupo.'">';

			if($value->Contador < $value->Vagas)
			{
				echo '<input type="checkbox" name="ehora'.$value->Grupo.'" value="'. $value->Id .'" class="ehora'.$value->Grupo.'"> [R$ '.$value->Valor.',00 ] ';
			}
			else
			{
				echo '[Vagas Esgotadas] ';
			}
			echo evento_tipo($value->Tipo) .' '. $value->Titulo .' <em>'. grupo_data($value->Grupo) .'</em></li>';
		}
	}


	function InfoUNEBInscricao()
	{
		global $wpdb, $Conexao;

		if(isset($_POST['infouneb']))
		{
			extract($_POST);

			if(empty($email))
			{
				$msg = 'Você deve informar seu e-mail.';
			}
			elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$msg = 'Você deve informar um e-mail válido.';
			}
			elseif(empty($nome))
			{
				$msg = 'Você deve informar seu nome.';
			}
			elseif(empty($cpf))
			{
				$msg = 'Você deve informar seu CPF.';
				$cpf = str_replace(array('.','-'), '', $cpf);
			}
			elseif(!validarCPF($cpf))
			{
				$msg = 'Você deve informar um CPF válido.';
			}
			elseif(empty($telefone))
			{
				$msg = 'Você deve informar seu telefone.';
			}
			if(isset($msg))
			{

				echo '<div class="sysmsg erro">'. $msg .'</div>';

			} 
			else
			{
				
				if(!$wpdb->get_var( "SELECT COUNT(*) FROM `{$Conexao->tusuarios}` WHERE `CPF` = '$cpf'"))
				{
					$usuario_dados =  array('Email' => $email, 'Nome' => $nome, 'CPF' => $cpf, 'Nascimento' => $nascimento, 'Telefone' => $telefone, 'Celular' => ((isset($celular)) ? $celular : null), 'Status' => 0, 'Sexo' => $sexo, 'Profissional' => $profissional, 'Titulo' => $titulo, 'Area' => $area, 'InscricaoData' => date("Y-m-d H:i:s"));
					$cadUsuario = $wpdb->insert($Conexao->tusuarios, $usuario_dados);
					$cadErroMensagem = 'Não conseguimos realizar seu cadastro. Entre em contato com a organização do evento.';
					$valorPgto = 10;
					$tipoCadastro = 'Inscrição na InfoUneb 2014';
				}
				else
				{
					$cadUsuario = 0;
					$cadErroMensagem = 'Já existe uma conta cadastrada com esse CPF. <br>Se deseja alterar seus dados entre em contato com a organização do evento.';
				}

				if($cadUsuario)
				{

					$cadUsuario = $wpdb->insert_id;

					if(isset($ehora0))
					{
						$verContador = $wpdb->get_var("SELECT count(i.`Bli`) FROM `{$Conexao->tinscricoes}` AS i WHERE i.`Bli` = '{$ehora0}'");
						$verVagas = $wpdb->get_var("SELECT `Vagas` FROM `{$Conexao->teventos}` AS i WHERE i.`Id` = '{$ehora0}'");
						$verNome = $wpdb->get_var("SELECT `Titulo` FROM `{$Conexao->teventos}` AS i WHERE i.`Id` = '{$ehora0}'");

						if($verContador < $verVagas)
						{
							$cadBli[] = $wpdb->insert($Conexao->tinscricoes, array('Bli' => $ehora0, 'Usuario' => $cadUsuario));
							$valorPgto += 15;
							$tipoCadastro .= ' + ' . $verNome;
						}
						else
						{
							$bliErro[] = "Não existem mais vagas para " . $verNome; 
						}
						
					}

					if(isset($ehora1))
					{
						$verContador = $wpdb->get_var("SELECT count(i.`Bli`) FROM `{$Conexao->tinscricoes}` AS i WHERE i.`Bli` = '{$ehora1}'");
						$verVagas = $wpdb->get_var("SELECT `Vagas` FROM `{$Conexao->teventos}` AS i WHERE i.`Id` = '{$ehora1}'");
						$verNome = $wpdb->get_var("SELECT `Titulo` FROM `{$Conexao->teventos}` AS i WHERE i.`Id` = '{$ehora1}'");

						if($verContador < $verVagas)
						{
							$cadBli[] = $wpdb->insert($Conexao->tinscricoes, array('Bli' => $ehora1, 'Usuario' => $cadUsuario));
							$valorPgto += 15;
							$tipoCadastro .= ' + ' . $verNome;
						}
						else
						{
							$bliErro[] = "Não existem mais vagas para " . $verNome; 
						}
					}

					
					if($bliErro)
					{
						foreach ($bliErro as $key => $value) {
							echo '<div class="sysmsg erro">'. $value .'</div>';
						}
					}

					/*$headers[] = 'From: Organização InfoUNEB 2014 <EMAIL INFO UNEB>';

					$mensagem = '';  // mensagem que será enviada por e-mail

					if(!wp_mail( $email, 'Confirmação de Inscrição na InfoUNEB 2014', $mensagem, $headers ))
					{
							echo '<div class="sysmsg erro">Não foi possível enviar o e-mail de confirmação.</div>';
					}*/

					echo '<div class="inscricao_concluida"><strong>Inscrição foi efetuada com sucesso!</strong> <br />
							Realize o pagamento para que ele seja confirmado.<br>
							Sua vaga só será reservada durante 3 dias.'; // mensagem que será exibida na tela do site

					InfoUNEBPagseguro($valorPgto, $cadUsuario, $nome, $cpf, $email, 'pagseguro', $tipoCadastro);

					echo '</div>';

					echo '<style type="text/css"> #publico_inscricao{ display:none !important; } </style>';
					
				}
				else
				{
					echo '<div class="sysmsg erro">'. $cadErroMensagem .'</div>';
				}
			}
		}
	}


	function InfoUNEBPagseguro($valor, $userid, $nome, $cpf, $email, $target, $texto = 'Inscrição na InfoUneb 2014')
	{
		echo '<!-- Declaração do formulário -->  
		<form method="post" name="pagseguro" target="'.$target.'"  
		action="https://pagseguro.uol.com.br/v2/checkout/payment.html">  
		          
		        <!-- Campos obrigatórios -->  
		        <input name="receiverEmail" type="hidden" value="flsapucaia@gmail.com">  
		        <input name="currency" type="hidden" value="BRL">  
		  
		        <!-- Itens do pagamento (ao menos um item é obrigatório) -->  
		        <input name="itemId1" type="hidden" value="0001">  
		        <input name="itemDescription1" type="hidden" value="'.$texto.'">  
		        <input name="itemAmount1" type="hidden" value="'.$valor.'.00">  
		        <input name="itemQuantity1" type="hidden" value="1">  
		        <input name="itemWeight1" type="hidden" value="0">  
		        <input name="item_frete_1" type="hidden" value="0">
		  		<input type="hidden" value="0" name="tipo_frete"/>

		        <!-- Código de referência do pagamento no seu sistema (opcional) -->  
		        <input name="reference" type="hidden" value="ID '.$userid.' - CPF '.$cpf.'">   
		  
		        <!-- Dados do comprador (opcionais) -->  
		        <input name="senderName" type="hidden" value="'.$nome.'">  
		        <input name="senderEmail" type="hidden" value="'.$email.'">  
		  
		        <!-- submit do form (obrigatório) -->  
		        <input alt="Pague com PagSeguro" name="submit"  type="image"  
		src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif"/>  
		          
		</form>  ';
	}

	function InfoUNEBMaratona()
	{
		global $wpdb, $Conexao;

		if(isset($_POST['maratona']))
		{
			echo '<style>
			ul#prog_nav {display:none !important;}
			ul.minicursos, ul.palestras, ul.laboratorios{display:none !important; }
			ul.maratona{margin-top:20px !important; display:block !important; }
			</style>';

			extract($_POST);

			if(empty($membro[0]))
			{
				$erro = 'O campo do primeiro membro deve ser informado com o seu CPF.';
			}

			$membro = array_filter($membro);

			foreach($membro as $cpf)
			{
				// verifica se os cpfs são válidos

				if(!validarCPF($cpf)){
					$erro = 'Você deve informar um CPF válido.';
					break;
				}

				// verifica se os membros estão previamente cadastrados cadastrados

				$status = $wpdb->get_var( "SELECT `Id` FROM `{$Conexao->tusuarios}` WHERE `CPF` = '{$cpf}' AND `Status` = '1'");

				if($status == null)
				{
					$erro = 'O CPF ' . $cpf . ' não está inscrito no InfoUNEB 2014.';
					break;
				}

				// verifica se os membros já não estão cadastrados em outras equipes

				$equipes = $wpdb->get_var( "SELECT `Id` FROM `{$Conexao->tmaratona}` WHERE `Lider` = '{$cpf}' OR `Membro1` = '{$cpf}' OR `Membro2` = '{$cpf}' OR `MembroReserva` = '{$cpf}'");

				if($equipes != null)
				{
					$erro = 'O CPF ' . $cpf . ' já está cadastrado em outra equipe da maratona.';
					break;
				}
						
			}

			if(!$erro)
			{
				// verificações no banco de dados
				$dados = array('Titulo' => ((!empty($equipe)) ? $equipe : null), 'Lider' => $membro[0],
						'Membro1' => ((isset($membro[1])) ? $membro[1] : null), 
						'Membro2' =>((isset($membro[2])) ? $membro[2] : null), 
						'MembroReserva' => ((isset($membro[3])) ? $membro[3] : null),
						'Status' => 0
					);

				$wpdb->insert($Conexao->tmaratona, $dados);

				echo '<strong>Inscrição foi efetuada com sucesso!</strong> <br />
							Realize o pagamento para que ele seja confirmado.<br>
							Sua vaga só será reservada durante 3 dias.'; // mensagem que será exibida na tela do site

				InfoUNEBPagseguro(30, $wpdb->insert_id, '', 'Equipe #'.$wpdb->insert_id, '', 'pagseguro', 'Maratona de Programação InfoUNeb 2014');
				echo '<style type="text/css"> .maratonabox #maratonaform{ display:none !important; } </style>';
			}
			else
			{
				echo '<div class="marerro">'.$erro.'</div>';
			}
		}
	}