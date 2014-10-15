<?php

	class InscricoesConexao
	{
		public $tprefixo;
		public $tpalestras;
		public $tusuarios;
		public $teventos;
		public $tinscricoes;
		public $tmaratona;

		public function __construct()
		{
			$this->tprefixo = 'infouneb_';
			$this->tpalestras = $this->tprefixo . 'palestras';
			$this->tusuarios = $this->tprefixo . 'usuarios';
			$this->teventos = $this->tprefixo . 'blis';
			$this->tinscricoes = $this->tprefixo . 'inscricoes';
			$this->tmaratona = $this->tprefixo . 'maratona';
		}

	}