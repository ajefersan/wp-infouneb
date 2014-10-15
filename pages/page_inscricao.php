<div id="inscricao" class="pagina_azul footerfix">
	
	<!-- <div class="inscricaoFechada">
			<h3>As inscrições ainda não foram abertas!</h3>
	</div> -->


			<div class="content">
				<div class="pattern">
				<div class="wrapper">

					<div class="info">
						<h2>Inscrição</h2>
						<p>Faça sua inscrição para participar da oitava edição da InfoUNEB <br /> Ao realizar o cadastro você aceita os <a href="">termos de uso</a>.</p>
						<div class="clear"></div>
					</div>

					<?php InfoUNEBInscricao(); ?>

					<div class="formulario">
						<form action="index.php#inscricao" method="post" id="publico_inscricao">

							<fieldset>
								<legend>Dados Pessoais</legend>

								<label for="nome">
									<span>Nome completo</span>
									<input type="text"<?php echo (isset($_POST['nome'])) ? 'value="'.$_POST['nome'].'"' : ''; ?> name="nome" id="nome">
								</label>

								<label for="cpf">
									<span>CPF</span>
									<input type="text"<?php echo (isset($_POST['cpf'])) ? 'value="'.$_POST['cpf'].'"' : ''; ?> name="cpf" id="cpf">
								</label>

								<div class="clear"></div>

								<label for="email">
									<span>E-mail</span>
									<input type="text"<?php echo (isset($_POST['email'])) ? 'value="'.$_POST['email'].'"' : ''; ?> name="email" id="email">
								</label>

								<div class="clear"></div>

								<label for="nascimento">
									<span>Data de Nascimento</span>
									<input type="text"<?php echo (isset($_POST['nascimento'])) ? 'value="'.$_POST['nascimento'].'"' : ''; ?> name="nascimento" id="nascimento">
								</label>

								<label for="sexo">
									<span>Sexo</span>
									<input type="radio" name="sexo" value="0" checked="checked"> Masculino
									<input type="radio" name="sexo" value="1"> Feminino
								</label>
								
								<div class="clear"></div>

								<label for="telefone">
									<span>Telefone</span>
									<input type="text"<?php echo (isset($_POST['telefone'])) ? 'value="'.$_POST['telefone'].'"' : ''; ?> name="telefone" id="telefone">
								</label>

								<label for="celular">
									<span>Celular</span>
									<input type="text"<?php echo (isset($_POST['celular'])) ? 'value="'.$_POST['celular'].'"' : ''; ?> name="celular" id="celular">
								</label>

							</fieldset>

							<fieldset>
								<legend>Dados Profissionais</legend>

								<label for="profissional">
									<span>Dados Profissionais</span>
									<input type="radio" name="profissional" value="0" checked> Estudante
									<input type="radio" name="profissional" value="1"> Profissional
								</label>

								<label for="titulo">
									<span>Titulo</span>
									<select name="titulo" id="titulo">
										<?php
											$titulos = array(0 => "Graduação", 1 => "Pós-Graduação", 2 => "Mestrado", 3 => "Doutorado", 4 => "PhD", 5 => "Autodidata");
											foreach ($titulos as $id => $titulo) {
												echo "<option value=\"{$id}\">{$titulo}</option>";
											}
										?>
									</select>
								</label>

								<label for="area">
									<span>Área de Atuação</span>
									<input type="text"<?php echo (isset($_POST['area'])) ? 'value="'.$_POST['area'].'"' : ''; ?> name="area" id="area">
								</label>
								
								<div class="clear"></div>
							</fieldset>

							<fieldset id="subeventos">
								<div class="eventos">
									<ul>
									<?php InfoUNEBEventos(); ?>
									</ul>
								</div>
								<input type="submit" id="cadastrar" name="infouneb" value="Cadastrar">
							</fieldset>
						</form>

					</div>
					<div class="clear"></div>
				</div>
				</div>
			</div>
		</div>