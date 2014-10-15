<?php
	ini_set('display_errors',1);
	ini_set('display_startup_erros',1);
	error_reporting(E_ALL);

	//phpinfo();
	require_once('Conexao.php');
	require_once('Functions.php');
	require_once('D:\www\infouneb\wp-blog-header.php');

	$Conexao = new InscricoesConexao();

	$CPF = (isset($_GET['cpf'])) ? $_GET['cpf'] : false;

	global $wpdb;

	if($wpdb)
	{
		if(validarCPF($CPF))
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
					$erro = "Sua conta já foi paga";
				}
				elseif($InsIntervalo > 3)
				{
					$erro = "Seu prazo de pagamento de 3 dias expiraram! Entre em contato com a organização para verificar a possibilidade de reativação de sua inscrição.";
				}
				else
				{
					$tem_blis = $wpdb->get_results("SELECT `Bli` FROM `{$Conexao->tinscricoes}` WHERE `Usuario` = '{$inscrito->Id}'");

					foreach ($tem_blis as $key) {
						$grupo = $wpdb->get_var( "SELECT `Grupo` FROM `{$Conexao->teventos}` WHERE `Id` = '{$key->Bli}'");
						$valorPgto += ($grupo == 2) ? 30 : 15;
					}
					InfoUNEBPagseguro($valorPgto, $inscrito->Id, $inscrito->Nome, $inscrito->CPF, $inscrito->Email, '_self');
					echo '<script type="text/javascript"> document.forms["pagseguro"].submit(); </script>';
				}
			}
			else
			{
				$erro = "Conta inválida ou link quebrado.";
			}
		}
	}

	if($erro)
	{
		echo $erro;
	}