<?php
/**
 * Event widget.
 */
class Stag_Wedding_Divider extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_wedding_divider';
		$this->widget_cssclass    = 'wedding-divider';
		$this->widget_description = __( 'Separate homepage sections with this horizontal divider.', 'stag' );
		$this->widget_name        = __( 'Section: Section Divider', 'stag' );
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

		<!-- BEGIN .section-divider -->
		<hr class="section-divider"Meth>
		<!-- END .section-divider -->

		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );

	}
}
