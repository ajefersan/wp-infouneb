<?php

	function evento_tipo($tipo)
	{
		$eventos = array('Palestra', 'Minicurso', 'Laboratório', '');
		return $eventos[$tipo];
	}

	function grupo_data($grupo)
	{
		$grupos = array('Segunda e Terça', 'Quarta e Quinta');
		return $grupos[$grupo];
	}

	function inscrito_titulo($int)
	{
		$titulos = array("Graduação", "Pós-Graduação", "Mestrado", "Doutorado", "PhD", "Autodidata");
		return $titulos[$int];
	}

	function getUserName($cpf)
	{
		global $wpdb;
		return $wpdb->get_var( "SELECT `Nome` FROM `infouneb_usuarios` WHERE `CPF` = '$cpf'");
	}

	function getStatus($status)
	{
		switch ($status)
		{
			case -1:
				return "Aguardando Pagamento";
				break;
			case 0:
				return "Aguardando e-mail de confirmação";
				break;
			case 1:
				return "Pagamento Realizado";
				break;
		}
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
	 * Função para formatar números.
	 * http://blog.clares.com.br/php-mascara-cnpj-cpf-data-e-qualquer-outra-coisa/
	 */
	
	function mask($val, $mask)
	{
		$maskared = '';
	 	$k = 0;

	 	for($i = 0; $i<=strlen($mask)-1; $i++)
	 	{
	 		if($mask[$i] == '#')
	 		{
	 			if(isset($val[$k]))
	 				$maskared .= $val[$k++];
	 		}
	 		else
	 		{
	 			if(isset($mask[$i]))
	 				$maskared .= $mask[$i];
	 		}
	 	}
	 	return $maskared;
	}