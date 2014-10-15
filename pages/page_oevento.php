<div id="oevento" class="pagina_azul">
	<div class="topo">
		<div class="botaoInscricao">Faça Sua Inscrição</div>
	</div>
	<div class="content">
			<div class="wrapper">

				<div class="introducao">
					<div class="historia">

						<?php
			 			$the_query = new WP_Query( 'page_id=4' );

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
					<div class="clear"></div>

					<div class="headline">
					Para mais informações acesse a grade do evento. Preparamos as melhores palestras e atividades para contribuir com a sua formação. Garanta logo sua vaga!
					</div>

					<div class="clear"></div>
				</div>
			</div>
		</div>
</div>