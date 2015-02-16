<?php
/**
 * Event widget.
 */
class Stag_Recent_Post extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_recent_post';
		$this->widget_cssclass    = 'stag-recent-post';
		$this->widget_description = __( 'Display a recent post from blog.', 'stag' );
		$this->widget_name        = __( 'Section: Blog', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'From the Blog', 'stag' ),
				'label' => __( 'Title:', 'stag' ),
			),
			'subtitle' => array(
				'type'  => 'text',
				'std'   => __( 'Present ideas, Stories, and latest updates for the Wedding.', 'stag' ),
				'label' => __( 'Sub Title:', 'stag' ),
			),
			'count' => array(
				'type'  => 'number',
				'std'   => '1',
				'min'   => '1',
				'label' => __( 'Post Count:', 'stag' ),
			),
		);

		parent::__construct();
	}

	/**
	 * Widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();

		extract( $args );

		$title    = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$subtitle = $instance['subtitle'];
		$count    = $instance['count'];

		echo $before_widget;
		?>

		<!-- BEGIN #blog -->
		<section id="blog" class="section-block">

			<div class="inner-block">
				<h2 class="section-title"><?php echo $title; ?></h2>
				<?php if($subtitle != ''){
					echo "<h4 class='sub-title'>$subtitle</h4>";
				} ?>
				<div class="all-posts">
					<?php

					$query = new WP_Query( 'post_type=post&posts_per_page='.$count );

					if ( $query->have_posts() ) :
						while( $query->have_posts() ): $query->the_post();
					?>
					<article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>
						<?php if( has_post_thumbnail() ) : ?>
							<div class="post-thumb">
								<?php the_post_thumbnail('full'); ?>
							</div>
						<?php endif; ?>

						<div class="entry-meta entry-header grids">
							<span class="grid-3 author"><i class="icon icon-author"></i><span><?php _e( 'Posted By', 'stag' ) ?> </span><?php the_author_posts_link(); ?></span>
							<span class="grid-3 category"><i class="icon icon-categories"></i><span><?php _e( 'In Category', 'stag' ) ?> </span><?php the_category(', '); ?></span>
							<span class="grid-3 date"><i class="icon icon-date"></i><span><?php the_time('M d Y'); ?></span></span>
							<span class="grid-3 comments"><i class="icon icon-comments"></i><span><?php printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'stag' ), number_format_i18n( get_comments_number() ) ); ?></span></span>
						</div>

						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'stag'), get_the_title()); ?>"><?php the_title(); ?></a></h2>

						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div>
					</article>
					<?php endwhile; ?>

				</div><!-- .all-posts -->

				<div class="center">
					<a href="<?php echo ( get_option( 'show_on_front' ) == 'page' ) ? get_permalink( get_option('page_for_posts' ) ) : home_url(); ?>" class="button accent-background"><?php _e( 'Go to Blog', 'stag' ); ?></a>
				</div>

				<?php endif; ?>
				<?php wp_reset_query(); ?>
				<!-- END .inner-block -->
			</div>

			<!-- END #blog -->
		</section>

		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );

	}
}
