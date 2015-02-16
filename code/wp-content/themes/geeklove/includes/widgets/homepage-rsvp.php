<?php
/**
 * Wedding RSVP Widget.
 */
class Stag_Wedding_Rsvp extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_wedding_rsvp';
		$this->widget_cssclass    = 'wedding-rsvp';
		$this->widget_description = __( 'Display RSVP form.', 'stag' );
		$this->widget_name        = __( 'Section: RSVP Form', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Are you attending? RSVP here!', 'stag' ),
				'label' => __( 'Title:', 'stag' ),
			),
			'subtitle' => array(
				'type'  => 'text',
				'std'   => __( 'Please select the options below and click the button in order to RSVP!', 'stag' ),
				'label' => __( 'Sub Title:', 'stag' ),
			),
			'guests' => array(
				'type'  => 'number',
				'label' => __( 'Max number of Guests:', 'stag' ),
				'std'   => '5',
				'min'   => '1',
				'max'   => '20',
				'step'  => '1',
			),
			'rsvp_label' => array(
				'type'  => 'text',
				'std'   => __( 'I Am Attending', 'stag' ),
				'label' => __( 'RSVP Button Label:', 'stag' ),
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

		$title      = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$subtitle   = $instance['subtitle'];
		$guests     = $instance['guests'];
		$rsvp_label = $instance['rsvp_label'];

		echo $before_widget;

		?>

		<!-- BEGIN #rsvp -->
		<section id="rsvp" class="section-block">

			<div class="inner-block">
				<h2 class="section-title"><?php echo $title; ?></h2>
				<?php if($subtitle != '') echo "<h4 class='sub-title'>$subtitle</h4>"; ?>

				<form class="grids" id="rsvp-form" method="post" action="<?php the_permalink(); ?>">
					<div class="grid-4">
						<label for="attendee_name"><?php _e('Your Name', 'stag'); ?></label>
						<input type="text" id="attendee_name" name="attendee_name" required>
					</div>

					<div class="grid-4">
						<label for="attendee_count"><?php _e('Number of Guests', 'stag') ?></label>
						<select id="attendee_count" name="attendee_number" class="custom-dropdown">
							<?php
							$max_guests = (int) ( ( isset( $guests ) && ! empty( $guests ) ) ? $guests : 5 );

							for ($i = 1; $i < $max_guests + 1 ; $i++) {
								echo "<option value='$i'>$i</option>";
							}

							?>
						</select>
					</div>

					<?php $all_events = stag_all_wedding_events(); ?>

					<?php if ( ! empty( $all_events ) ) : ?>
					<div class="grid-4">
						<label for="attendee_event"><?php _e( 'You will attend&hellip;', 'stag' ) ?></label>
						<select id="attendee_event" name="attendee_event" class="custom-dropdown">

							<?php if ( count($all_events) > 1 ) : ?>
							<option value="all-events"><?php _e( 'All Events', 'stag' ); ?></option>
							<?php endif; ?>

							<?php foreach ( $all_events as $title ) : ?>
							<option value="<?php echo esc_attr( stag_to_slug( $title ) ); ?>"><?php echo esc_html($title); ?></option>
							<?php endforeach; ?>

							<option value="no-events"><?php _e( 'Not attending', 'stag' ); ?></option>

						</select>
					</div>
					<?php endif; ?>

					<div class="submit grid-12">
						<?php $label = ( isset( $rsvp_label ) && !empty($rsvp_label) ) ? $rsvp_label : __( 'I Am Attending' ); ?>
						<input type="submit" value="<?php echo esc_attr( $label ); ?>" name="submit_rsvp" />
						<input type="hidden" name="action" value="post" />
						<?php wp_nonce_field( 'new-post' ); ?>
					</div>

				</form>

				<!-- END .inner-block -->

			</div>

			<!-- END #rsvp -->
		</section>

		<?php

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
