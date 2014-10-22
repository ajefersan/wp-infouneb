<?php
/*
Plugin Name: Inscrições
Plugin URI: https://github.com/diegoscosta/wp-infouneb
Description: 
Version: 1.0
Author: Diego Costa
*/

require_once "Conexao.php";
require_once "Functions.php";
require_once "Tema.php";

class Inscricoes extends InscricoesConexao
{
	public $menus;

	public function __construct() 
	{
		parent::__construct();

		$this->menus = array("inscricao" => array("Inscrições", "infouneb"), 
							 "palestras" => array("Palestras", 'infouneb/palestras'), 
							 "blis" => array("Eventos", "infouneb/eventos"), 
							 "maratona" => array("Maratona", "infouneb/maratona"));

		add_action('admin_menu', array($this, 'menu'));
		add_action('init', array($this, 'scripts'));
	}
		
	public function menu()
	{

		add_menu_page('', 'InfoUNEB', 'manage_options', 'infouneb', array($this, 'pagina_inscricao'), 'dashicons-nametag', 35);

		foreach($this->menus as $key => $value)
		{
			add_submenu_page('infouneb', $value[0], $value[0], 'manage_options', $value[1], array($this, 'pagina_' . $key) );
		}
		
	}

	public function tema($file, $params = array())
	{
		extract($params);
		require_once "templates/{$file}";
	}

	public function pagina_inscricao() 
	{
		global $wpdb;

		if(isset($_GET['status']))
		{
			if(!$user_id = (int) $_GET['user']) die();

			$wpdb->update($this->tusuarios, array('Status' => (int) $_GET['status']), array('Id' => $user_id)); 
			//$wpdb->update($this->tinscricoes, array('Status' =>  (int) $_GET['status']),array('Usuario' => $user_id));
		}

		if(isset($_GET['u'])) 
		{
			if(!$usuario_id = (int) $_GET['u']) die();

			$imprimir['usuario'] 	= $usuario_id;
			$imprimir['inscrito']	= $wpdb->get_row("SELECT u.* FROM `{$this->tusuarios}` AS u WHERE u.`Id` = {$usuario_id}", 'ARRAY_A');
			$imprimir['blis']		= $wpdb->get_results("SELECT i.`Bli`, b.`Titulo`, b.`Tipo` FROM `{$this->tinscricoes}` AS i INNER JOIN `{$this->teventos}` AS b ON b.`Id` = i.`Bli` WHERE i.`Usuario` = {$usuario_id}");

			$this->tema('imprimir.html', $imprimir);
		}

		$inscricoes['novas'] = $wpdb->get_results("SELECT * FROM `{$this->tusuarios}` WHERE `Status` = '0'");
		$inscricoes['pendentes'] = $wpdb->get_results("SELECT * FROM `{$this->tusuarios}` WHERE `Status` = '-1'");
		$inscricoes['confirmados'] = $wpdb->get_results("SELECT * FROM `{$this->tusuarios}` WHERE `Status` = '1'");
		$inscricoes['contador'] = count($wpdb->get_results("SELECT Id FROM `{$this->tusuarios}`"));

		$this->tema('inscricoes.html', $inscricoes);
		
	}

	public function pagina_palestras()
	{
		global $wpdb;

		if(isset($_GET['apagar']))
		{
			if(!$palestra_id = (int) $_GET['apagar']) die();

			$wpdb->delete($this->tpalestras, array( 'Id' => $palestra_id ), array( '%d' ) );
		}

		if(isset($_POST['submit_palestra']))
		{
			extract($_POST);

			if(empty($palestra_titulo))
			{
				$erro = 'Você deixou o titulo da palestra em branco.';
			}
			elseif(empty($palestra_ministrante))
			{
				$erro = 'Você deixou o nome do ministrante em branco.';
			} 
			elseif(empty($palestra_data))
			{
				$erro = 'Você deixou a data da palestra em branco.';
			}
			elseif(empty($palestra_horainicio) || empty($palestra_horafim))
			{
				$erro = 'Você deixou o horário da palestra em branco';
			}
			
			if(!$erro)
			{
				$dados = array('Titulo' => $palestra_titulo, 
							   'Ministrante' => $palestra_ministrante,
							   'Data' => date('Y-m-d', strtotime(str_replace('/', '-', $palestra_data))),
							   'HoraInicio' => $palestra_horainicio.':00',
							   'HoraFim' => $palestra_horafim.':00',
							   'Obs' => $palestra_obs);

				$wpdb->insert($this->tpalestras, $dados);
			}
			else
			{
				$palestras['erro'] = $erro;
			}

			if($wpdb->insert_id) $_POST = array();

		}

		$palestras['lista'] = $wpdb->get_results("SELECT * FROM `{$this->tpalestras}`");
		$palestras['contador'] = count($palestras['lista']);

		$this->tema('palestras.html', $palestras);
	}

	public function pagina_blis()
	{
		global $wpdb;

		if(isset($_GET['apagar']))
		{
			if(!$evento_id = (int) $_GET['apagar']) die();

			$wpdb->delete( $this->teventos, array( 'Id' => $evento_id ), array( '%d' ) );
		}

		if(isset($_GET['e']))
		{
			if(!$evento_id = (int) $_GET['e']) die();

			$evento['evento'] 		= $evento_id;
			$evento['bli'] 			= $wpdb->get_row("SELECT b.*, (SELECT count(i.`Bli`) FROM `{$this->tinscricoes}` AS i WHERE i.`Bli` = b.`Id`) AS Contador FROM `{$this->teventos}` AS b WHERE b.`Id` = {$evento_id}", 'ARRAY_A');
			$evento['inscritos']	= $wpdb->get_results("SELECT i.*, u.`Nome`, u.`CPF`, u.`Status` FROM `{$this->tinscricoes}` AS i INNER JOIN `{$this->tusuarios}` AS u ON u.`Id` = i.`Usuario` WHERE i.`Bli` = {$evento_id}");

			$this->tema('imprimir.html', $evento);
		}

		if(isset($_POST['submit_bli']))
		{
			extract($_POST);
			
			if(empty($bli_titulo))
			{
				$erro = 'Você deixou o campo titulo em branco.';
			}
			elseif(empty($bli_ministrante))
			{
				$erro = 'Você deixou o nome do ministrante em branco.'; 
			}
			elseif(empty($bli_vagas))
			{
				$erro = 'Você deve informar um número de vagas';
			}
			elseif(empty($bli_valor))
			{
				$erro = 'Você deve informar um valor. Se for gratuito informe 0.';
			}

			if(!$erro)
			{
				$dados = array('Titulo' => $bli_titulo,
							   'Ministrante' => $bli_ministrante, 
							   'Tipo' => $bli_tipo, 
							   'Grupo' => $bli_grupo, 
							   'Vagas' => $bli_vagas, 
							   'Valor' => $bli_valor);

				$wpdb->insert($this->teventos, $dados);
			}
			else
			{
				$evento['erro'] = $erro;
			}

			if($wpdb->insert_id) $_POST = array();
		}

		$evento['blis'] = $wpdb->get_results("SELECT b.`Id`, b.`Titulo`, b.`Tipo`, (SELECT count(i.`Bli`) FROM `{$this->tinscricoes}` AS i WHERE i.`Bli` = b.`Id`) AS Contador FROM `{$this->teventos}` AS b");

		$this->tema('eventos.html', $evento);
	}

	public function pagina_maratona()
	{
		global $wpdb;

		if(isset($_GET['status']))
		{
			if(!$equipe_id = (int) $_GET['equipe']) die();

			$wpdb->update($this->tmaratona, array('Status' => (int) $_GET['status']), array('Id' => $equipe_id)); 
		}

		if(isset($_GET['m']))
		{
			if(!$maratona_id = (int) $_GET['m']) die();

			$maratona['maratona']	= $maratona_id;
			$maratona['equipe']		= $wpdb->get_row("SELECT * FROM `{$this->tmaratona}` WHERE `Id` = {$maratona_id}", 'ARRAY_A');

			$this->tema('imprimir.html', $maratona);
		}

		$maratona['lista'] = $wpdb->get_results("SELECT * FROM `{$this->tmaratona}`");
		$maratona['contador'] = count($maratona['lista']);

		$this->tema('maratona.html', $maratona);
	}

	public function scripts()
	{
	    wp_register_script( 'maskedinput',  get_bloginfo('template_url') . '/plugin/templates/js/jquery.maskedinput.min.js');
	    wp_enqueue_script( 'maskedinput' );

	    wp_register_script( 'infouneb',  get_bloginfo('template_url') . '/plugin/templates/js/main.js');
	    wp_enqueue_script( 'infouneb' );
	}

}
$Inscricoes = new Inscricoes();