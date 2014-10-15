<div id="programacao" class="pagina">
			<div class="topo"></div>

			<div class="wrapper">
				<h2 class="p_titulo">programação</h2>

				<ul id="prog_nav">
					<li><a href="" id="palestras" class="active">Palestras</a></li>
					<li><a href="" id="minicursos">Minicursos</a></li>
					<li><a href="" id="laboratorios">Laboratórios</a></li>
					<li><a href="" id="maratona">maratona</a></li>
				</ul>
				<div class="clear"></div>

			<ul class="palestras novaprogramacao">

			<?php foreach(InfoUNEBProgramacao('palestras') as $key => $value): ?>
				<li>
					<h2><?php echo $value->Titulo; ?></h2>				
					<h3><?php echo $value->Ministrante; ?></h3>
					<h4><?php echo date('d', strtotime($value->Data)); ?> de novembro</h4>
					<h4><?php echo date('H:i', strtotime($value->HoraInicio)); ?> - <?php echo date('H:i', strtotime($value->HoraFim)); ?></h4>
					<?php echo ($value->Obs) ? '<h5>'. $value->Obs .'</h5>' : ''; ?>
				</li>
			<?php endforeach; ?>

			<div class="clear"></div>
		</ul>

		<ul class="minicursos novaprogramacao">
		<?php foreach(InfoUNEBProgramacao('minicursos') as $key => $value): ?>
			<li>
				<h2><?php echo $value->Titulo; ?></h2>
				<h3><?php echo $value->Ministrante; ?></h3>
				<h4><?php echo ($value->Grupo) ? '24 e 25 de novembro' : '26 e 27 de novembro'; ?></h4>
				<h4>14:00 - 18:20</h4>
			</li>
		<?php endforeach; ?>
			<div class="clear"></div>
		</ul>

		<ul class="laboratorios novaprogramacao">
		<?php foreach(InfoUNEBProgramacao('laboratorios') as $key => $value): ?>
			<li>
				<h2><?php echo $value->Titulo; ?></h2>
				<h3><?php echo $value->Ministrante; ?></h3>
				<h4><?php echo ($value->Grupo) ? '24 e 25 de novembro' : '26 e 27 de novembro'; ?></h4>
				<h4>14:00 - 18:20</h4>
			</li>
		<?php endforeach; ?>
			<div class="clear"></div>
		</ul>

		<ul class="maratona novaprogramacao">
			
			 	<div class="informacoes">
			 	1. A maratona de programação será na manha do dia 28 de novembro.<br><br>
				2. Serão no máximo 12 times.<br><br>
				3. A inscrição deverá ser realizada através do formulário específico da maratona pelo líder  do time, informando os demais componentes. <br><br>
				4. Cada time terá no máximo 3 alunos.<br><br>
				5. A maratona terá duração de 3 horas com início as 9:00 e término as 12:00h. Sendo o WarmUp das 8:00h às 9:00h.<br><br>
				6. As linguagens permitidas serão C, C++, Java, Pascal, PHP, caso o time precise de uma outra, avisar com antecedência e veremos viabilidade de colocá-la. <br><br>
				7. Para a implementação os times terão à sua disposição um computador e todo o material ESCRITO que desejarem.<br><br>
				8. Entretanto, não poderão fazer uso de material armazenado em meio digital ou ter acesso à Internet durante a competição.<br><br>
				9. O time vencedor é aquele que resolve a maior quantidade dentro do período.<br><br>
				10. O cadastro na Maratona só será possível após a confirmação do pagamento da inscrição no evento. Todos os membros precisam estar inscritos.<br><br>

				</div>
				<div class="maratonabox" id="pgmaratona" style="display:none;">
					<h1>Participe da Maratona</h1>
					<?php InfoUNEBMaratona(); ?>
				
					<form action="index.php#pgmaratona" id="maratonaform" method="post">
						<label for="equipe">
							<span>Nome da Equipe (Opcional)</span>
							<input type="text" name="equipe" id="equipe">
						</label>

						<label for="lider">
							<span>1# Membro</span>
							<input type="text" name="membro[]" id="lider" class="maskcpf">
						</label>

						<label for="membro1">
							<span>#2 Membro (Opcional)</span>
							<input type="text" name="membro[]" id="membro1" class="maskcpf">
						</label>

						<label for="membro2">
							<span>#3 Membro (Opcional)</span>
							<input type="text" name="membro[]" id="membro2" class="maskcpf">
						</label>

						<label for="reserva">
							<span>Membro Reserva (Opcional)</span>
							<input type="text" name="membro[]" id="reserva" class="maskcpf">
						</label>

						<input type="submit" name="maratona" value="Cadastrar">

					</form>
				</div>

		<div class="clear"></div>

	</div>
</div>
