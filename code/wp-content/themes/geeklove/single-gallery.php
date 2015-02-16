<?php
/**
 * Single page template for Gallery.
 *
 * @package StagFramework
 * @subpackage GeekLove
 *
 * @since GeekLove 2.0
 */
get_header() ?>

	<div class="container-wrap">

		<?php get_template_part( 'helper', 'page-cover' ); ?>

		<div class="container">
			<div id="photo-gallery">
				<div class="clearfix" id="photo-list">

				<?php
				$photos_ids = get_post_meta( get_the_ID(), '_stag_image_ids', true );

				if ( $photos_ids ) :
					$photos_ids = array_filter( explode( ',', $photos_ids ) );

					if ( is_array( $photos_ids ) ) :
						foreach ( $photos_ids as $photo_id ) :
							if ( ! $photo_id ) continue;

							$image   = wp_get_attachment_image_src( $photo_id, 'gallery-thumb' );
							$src     = wp_get_attachment_image_src( $photo_id, 'full' );
							$caption = stripslashes( @get_post( $photo_id )->post_excerpt );

							if ( wp_is_mobile() ) {
								echo '<div class="ipad-6 photo"><a href="' . esc_url( $src[0] ) . '"><img src="' . esc_url( $image[0] ) . '" alt=""></a></div>';
							} else {
								echo '<div class="ipad-6 photo"><a href="' . esc_url( $src[0] ) . '" data-lightbox="photos" title="' . esc_attr( $caption ) . '"><img src="' . esc_url( $image[0] ) . '" alt=""></a></div>';
							}
						endforeach;
					endif;
				endif;
				?>

				</div><!-- #photo-list -->
			</div><!-- #photo-gallery -->
		</div><!-- .container -->
	</div><!-- .container-wrap -->

<?php get_footer(); ?>
