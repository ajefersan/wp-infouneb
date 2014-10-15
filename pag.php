<?php

	require_once('wp-blog-header.php');
	require_once( get_template_directory() . '/plugin/Inscricoes.php');

	global $wpdb;

	$Conexao = new InscricoesConexao();
	$CPF = (isset($_GET['usuario'])) ? $_GET['usuario'] : 0;
	$Equipe = (isset($_GET['equipe'])) ? $_GET['equipe'] : 0;

	if(!$wpdb) die('Erro ao carregar página');

	if(validarCPF($CPF) || validarCPF($Equipe))
	{

		if($CPF != 0)
		{
			$CPF = mask($CPF,'###.###.###-##');
			$inscrito = $wpdb->get_row("SELECT * FROM `{$Conexao->tusuarios}` AS u WHERE u.`CPF` = '{$CPF}'");

			if($inscrito != null)
			{
				$valorPgto = 10;
				$insData = new DateTime($inscrito->InscricaoData);
				$insAgora = new DateTime('now');
				$InsIntervalo =  round(($insAgora->format('U') - $insData->format('U')) / (60*60*24));

				if($inscrito->Status == 1)
				{
					$erro = "Sua inscrição já foi paga";
				}
				elseif($InsIntervalo > 3)
				{
					$erro = "Seu prazo de pagamento de 3 dias expiraram! Entre em contato com a organização para verificar a possibilidade de reativação de sua inscrição.";
				}
				else
				{
					$tem_blis = $wpdb->get_results("SELECT `Bli` FROM `{$Conexao->tinscricoes}` WHERE `Usuario` = '{$inscrito->Id}'");

					foreach ($tem_blis as $key)
					{
						$valorPgto += $wpdb->get_var( "SELECT `Valor` FROM `{$Conexao->teventos}` WHERE `Id` = '{$key->Bli}'");
					}

					InfoUNEBPagseguro($valorPgto, $inscrito->Id, $inscrito->Nome, $inscrito->CPF, $inscrito->Email, '_self');
				}
			}
			else
			{
				$erro = "Inscrição inválida ou link quebrado.";
			}
		}
		else if($Equipe != 0)
		{
			$Equipe = mask($Equipe,'###.###.###-##');

			$inscrito = $wpdb->get_row("SELECT * FROM `{$Conexao->tmaratona}` AS u WHERE u.`Lider` = '{$Equipe}'");

			if($inscrito != null)
			{
				$valorPgto = 30;

				if($inscrito->Status == 1)
				{
					$erro = "Sua inscrição já foi paga";
				}
				else
				{
					InfoUNEBPagseguro($valorPgto, $inscrito->Id, 'Equipe ' . $inscrito->Titulo, $inscrito->Lider, '', '_self', 'Inscrição na Maratona de Programação da InfoUNEB 2014');
				}
			}
			else
			{
				$erro = "Inscrição inválida ou link quebrado.";
			}
		}
	}

	else
	{
		$erro = "Inscrição inválida ou link quebrado.";
	}
	
	echo (!$erro) ? '<script type="text/javascript"> document.forms["pagseguro"].submit(); </script>' : $erro;