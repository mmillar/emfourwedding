<?php
/*
Template Name: Photo Gallery
*/
?>
<?php get_header(); ?>

<!-- BEGIN .container-wrap -->
<div class="container-wrap">

	<?php get_template_part( 'helper', 'page-cover' ); ?>

	<!-- BEGIN .container -->
	<div class="container">

		<!-- BEGIN #photo-gallery -->
		<div id="photo-gallery">

			<!-- BEGIN #filters -->
			<ul id="filters">
				<li><a href="#" data-filter="*" class="active button"><?php _e( 'All Photos', 'stag' ); ?></a></li>
				<?php

				$c = get_categories( 'taxonomy=photo-type&type=gallery&hide_empty=1' );

				foreach ( $c as $cat ) {
					echo '<li><a class="button" href="#" data-filter=".'. esc_attr( $cat->slug ) .'">'. esc_html( $cat->name ) .'</a></li>';
				}
				?>
				<!-- END #filters -->
			</ul>
			<div id="photo-list" class="clearfix">
				<?php

				$page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args = array(
					'post_type' => 'gallery',
					'posts_per_page' => -1,
				);

				$photos_query = new WP_Query( $args );

				if ( $photos_query->have_posts() ) : while ( $photos_query->have_posts() ): $photos_query->the_post();

				$pics = get_post_meta( get_the_ID(), '_stag_image_ids', true );

				if ( $pics != '' ) {
					$pics = explode( ',', $pics );

					$terms = get_the_terms( get_the_ID(), 'photo-type' );

					if ( $terms && ! is_wp_error( $terms ) ) :
						$links = array();
						foreach ( $terms as $term ) {
							$links[] = $term->slug;
						}
						$tax = join( ' ', $links );
					else :
						$tax = '';
					endif;

					foreach ( array_filter( $pics ) as $pic ) {
						if ( ! $pic || 'false' == $pic ) continue;

						$image = wp_get_attachment_image_src( $pic, 'gallery-thumb' );
						$src   = wp_get_attachment_image_src( $pic, 'full' );

						$caption = stripslashes( @get_post( $pic )->post_excerpt );

						if ( wp_is_mobile() ) {
							echo '<div class="ipad-6 photo '. esc_attr( $tax ) .'"><a href="' . esc_url( $src[0] ) . '"><img src="' . esc_url( $image[0] ) . '" alt=""></a></div>';
						} else {
							echo '<div class="ipad-6 photo '. esc_attr( $tax ) .'"><a href="' . esc_url( $src[0] ) . '" data-lightbox="photos" title="' . esc_attr( $caption ) . '"><img src="' . esc_url( $image[0] ) . '" alt=""></a></div>';
						}
					}
				}
				?>

			<?php endwhile; ?>

			<!-- END #photo-list -->
		</div>

		<!-- END #photo-gallery -->
	</div>

	<hr class="section-divider">

<?php endif; ?>

<?php wp_reset_query(); ?>

<!-- END .container -->
</div>
<!-- END .container-wrap -->
</div>

<?php get_footer(); ?>
