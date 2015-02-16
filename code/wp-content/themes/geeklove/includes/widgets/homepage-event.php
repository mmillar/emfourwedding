<?php
/**
 * Event widget.
 */
class Stag_Wedding_Event extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_wedding_event';
		$this->widget_cssclass    = 'wedding-event';
		$this->widget_description = __( 'Display wedding event details on homepage.', 'stag' );
		$this->widget_name        = __( 'Section: Wedding Event', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'The Wedding Event', 'stag' ),
				'label' => __( 'Title:', 'stag' ),
			),
			'welcomeText' => array(
				'type'  => 'textarea',
				'rows'  => '4',
				'std'   => null,
				'label' => __( 'Welcome Text:', 'stag' ),
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

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$welcomeText = $instance['welcomeText'];

		echo $before_widget;

		?>

		<!-- BEGIN #event -->
		<section id="event" class="section-block">

			<div class="inner-block">
				<h2 class="section-title"><?php echo $title; ?></h2>
				<h4 class="sub-title"><?php if(function_exists('stag_wedding_date')) echo stag_full_wedding_date(); ?></h4>

				<?php if($welcomeText != '') echo "<p class='welcome-text'>$welcomeText</p>"; ?>

				<div class="all-events grids">
					<?php

					$query = new WP_Query('post_type=events&posts_per_page=6');

					if ( $query->have_posts() ) :
						while( $query->have_posts() ): $query->the_post();
					?>

					<div class="event grid-6">
						<?php if( '' != $event_featured_image = get_post_meta(get_the_ID(), '_stag_event_featured_image', true) ): ?>
							<img class="wedding-cover" src="<?php echo $event_featured_image; ?>" alt="<?php the_title(); ?>">
						<?php endif; ?>

						<div class="event-details accent-background">
							<h3><?php echo the_title(); ?></h3>

							<div class="event-time">
								<?php if( '' != $event_date = get_post_meta(get_the_ID(), '_stag_event_date', true) ) : ?>
									<span class="the-block">
										<i class="icon icon-event_date"></i>
										<span><?php echo stag_full_date( $event_date ); ?></span>
									</span>
								<?php endif; ?>

								<?php if( '' != $event_time = get_post_meta(get_the_ID(), '_stag_event_time', true) ) : ?>
									<span class="the-block">
										<i class="icon icon-event_time"></i>
										<span><?php echo $event_time; ?></span>
									</span>
								<?php endif; ?>
							</div>
						</div>

						<a class="button" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( __('Permanent Link to %s', 'stag'), get_the_title() ); ?>"><?php _e( 'Learn More', 'stag' ); ?></a>
					</div>

					<?php
					endwhile;
					endif;

					wp_reset_postdata();

					?>
				</div>

				<!-- END .inner-block -->
			</div>

			<!-- END #event -->
		</section>

		<?php

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
