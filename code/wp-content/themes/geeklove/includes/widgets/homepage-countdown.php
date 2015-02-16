<?php
/**
 * Countdown widget.
 */
class Stag_Wedding_Countdown extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_wedding_countdown';
		$this->widget_cssclass    = 'wedding-countdown';
		$this->widget_description = __( 'Display wedding countdown.', 'stag' );
		$this->widget_name        = __( 'Section: Wedding Countdown', 'stag' );
		$this->settings           = array(
			'desc' => array(
				'type'  => 'description',
				'std'   => __( 'Yay! No options to set!', 'stag' )
			)
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

		echo $before_widget;
		?>

		<section class="inner-block" id="countdown">
			<!-- BEGIN #countdown -->
			<div id="the_countdown"></div>

			<?php
			$timezone = get_option('gmt_offset');

			if ( !startsWith( $timezone, '-' ) ) {
				$timezone = '+'.$timezone;
			}

			$time = str_replace( ':', ',', stag_get_option('wedding_time') );

			?>
			<script>
				jQuery(document).ready(function($){
					$('#the_countdown').countdown({
						until: new Date(<?php echo stag_wedding_date('Y') ?>, <?php echo stag_wedding_date('m') ?> - 1, <?php echo stag_wedding_date('d') ?>, <?php echo $time; ?>),
						timezone: <?php echo $timezone ?>
					});
				});
			</script>
		</section><!-- #countdown -->

		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );

	}
}
