<?php
/*
Plugin Name: Inscrições
Plugin URI: https://github.com/diegoscosta/wp-infouneb
Description: 
Version: 1.0
Author: Diego Costa
*/

require_once "Functions.php";

class Inscricoes
{
	public 	$menus;

	public function __construct() {
		$this->menus = array("inscricao" => array("Inscrições", "infouneb"), "blis" => array("Eventos", "infouneb/eventos"));

		add_action('admin_menu', array($this, 'menu'));
		add_action('init', array($this, 'scripts'));

		$this->instalar();
	}
		
	public function menu() {

		add_menu_page('', 'InfoUNEB', 'manage_options', 'infouneb', array($this, 'pagina_inscricao'), 'dashicons-nametag', 35);

		foreach($this->menus as $key => $value) {
			add_submenu_page('infouneb', $value[0], $value[0], 'manage_options', $value[1], array($this, 'pagina_' . $key) );
		}
		
	}

	public function tema($file, $params = array()){
		extract($params);
		require_once "templates/admin/{$file}";
	}

	public function pagina_inscricao() {
		global $wpdb;
		$params['inscritos'] = $wpdb->get_results("SELECT * FROM `infouneb_usuarios`");
		$this->tema('inscricao_list.html', $params);
	}

	public function pagina_blis() {
		global $wpdb;

		if(isset($_GET['apagar']))	{
			if(!$bli_id = (int) $_GET['apagar']) die();

			$wpdb->delete( 'infouneb_blis', array( 'Id' => $bli_id ), array( '%d' ) );
		}

		$lista['blis'] = $wpdb->get_results("SELECT b.`Id`, b.`Titulo`, b.`Tipo`, (SELECT count(i.`Bli`) FROM `infouneb_inscricoes` AS i WHERE i.`Bli` = b.`Id`) AS Contador FROM `infouneb_blis` AS b");
		$this->tema('blis_list.html', $lista);

		if(isset($_POST['submit_bli'])) {
			extract($_POST);

			$DataHora = $bli_data_ano . '-' . $bli_data_mes . '-' . $bli_data_dia . ' ' . $bli_hora_hora . ':' . $bli_hora_minuto . ':00';
			$dados = array('Titulo' => $bli_titulo, 'Tipo' => $bli_tipo, 'Data' => $DataHora, 'Descricao' => $bli_description, 'Vagas' => $bli_vagas, 'Valor' => $bli_valor);
			

			if(empty($bli_titulo) && empty($bli_vagas) && empty($bli_valor)) {
				echo "<script> alert('Você deixou campos em branco.'); </script>";
			}
			else {
				$wpdb->insert('infouneb_blis', $dados);
			}

			if(isset($wpdb->insert_id)) {
				echo '<script>location.reload();</script>';
			}
		}

		$this->tema('blis_add.html');
	}

	public function imprimir() {
		global $wpdb;

		if(isset($_GET['u'])) {
			if(!$usuario_id = (int) $_GET['u']) die();

			$params['inscrito']	= $wpdb->get_row("SELECT u.* FROM `infouneb_usuarios` AS u WHERE u.`Id` = {$usuario_id}", 'ARRAY_A');
			$params['blis']		= $wpdb->get_results("SELECT i.`Bli`, b.`Titulo`, b.`Data`, b.`Tipo` FROM `infouneb_inscricoes` AS i INNER JOIN `infouneb_blis` AS b ON b.`Id` = i.`Bli` WHERE i.`Usuario` = {$usuario_id}");

			$this->tema('inscricao_print.html', $params);
		}
		if(isset($_GET['b'])){
			if(!$bli_id = (int) $_GET['b']) die();

			$params['bli'] 			= $wpdb->get_row("SELECT b.*, (SELECT count(i.`Bli`) FROM `infouneb_inscricoes` AS i WHERE i.`Bli` = b.`Id`) AS Contador FROM `infouneb_blis` AS b WHERE b.`Id` = {$bli_id}", 'ARRAY_A');
			$params['inscritos']	= $wpdb->get_results("SELECT i.*, u.`Nome`, u.`CPF`, u.`Status` FROM infouneb_inscricoes AS i INNER JOIN infouneb_usuarios AS u ON u.`Id` = i.`Usuario` WHERE i.`Bli` = {$bli_id}");

			$this->tema('blis_print.html', $params);
		}
	}

	public function scripts() {
		$scripts = array('validate' => 'jquery.validate.min.js',
						 'messages' => 'messages_pt_BR.js',
						 'main' => 'main.js');
		
		wp_enqueue_script('jquery');

		foreach($scripts as $key => $src) {
	    	wp_register_script( $key,  plugins_url() . '/infouneb/templates/js/' . $src);
	    	wp_enqueue_script( $key );
	    }
	}

	public function instalar(){
		global $wpdb;

		if($wpdb->query("SHOW TABLES LIKE 'infouneb_usuarios'")){
			$sqlfile = file_get_contents(plugin_dir_path( __FILE__ ) . 'tabelas.sql');
		}
	}

}
$Inscricoes = new Inscricoes();