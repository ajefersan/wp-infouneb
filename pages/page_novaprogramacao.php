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
			 		<?php
			 			$the_query = new WP_Query( 'page_id=79' );

					// The Loop
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							the_content();
						}
					} 
					/* Restore original Post Data */
					wp_reset_postdata();
					?>
				</div>
				<div class="maratonabox" id="pgmaratona">
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
