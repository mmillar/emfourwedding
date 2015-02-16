<?php
/**
 * Wedding Intro widget.
 */
class Stag_Wedding_Intro extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_wedding_intro';
		$this->widget_cssclass    = 'wedding-intro';
		$this->widget_description = __( 'Display wedding intro on homepage.', 'stag' );
		$this->widget_name        = __( 'Section: Wedding Intro', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Are Getting Married!', 'stag' ),
				'label' => __( 'Title:', 'stag' ),
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

		echo $before_widget;

		?>

		<!-- BEGIN #intro -->
		<section id="intro">
		    <?php

		    $slide_imgs = stag_get_option('wedding_slideshow');

		    $class = '';

		    // Break the values and wrap them in double quotes to make it work with backstretch
		    if($slide_imgs != ''){
		        $paths = array();
		        foreach(explode(',', $slide_imgs) as $src){
		            $paths[] = '"'.$src.'"';
		        }
		        $path = implode(',', $paths);
		    ?>
		    <script>
		    jQuery(document).ready(function($){
		        $('#intro .wedding-couple-wrap').backstretch([<?php echo $path; ?>], {duration: <?php echo stag_get_option('wedding_slideshow_duration') ?>, fade: <?php echo stag_get_option('wedding_fade_duration') ?>});
		    });
		    </script>

		    <?php
		    }else{
		        $class = " no-cover";
		    }

		    ?>
		    <div class="wedding-couple-wrap<?php echo $class; ?>">

		        <div class="wedding-couple-info">

		            <div class="person-info">
		                <div class="info-header clearfix">
		                    <?php

		                    $br_first_name = stripslashes(stag_get_option('wedding_bride_first_name'));
		                    $br_last_name  = stripslashes(stag_get_option('wedding_bride_last_name'));
		                    $br_avatar     = esc_url(stag_get_option('wedding_bride_avatar'));
		                    $br_bio        = stripslashes(stag_get_option('wedding_bride_bio'));

		                    if($br_avatar != '')        echo "<img src='{$br_avatar}' class='person-avatar' alt='{$br_first_name}'>";
		                    if($br_first_name != '')    echo "<h2>{$br_first_name}</h2>";
		                    if($br_last_name != '')     echo "<p>{$br_last_name}</p>";

		                    ?>
		                </div>
		                <?php if($br_bio != '') echo "<p class='person-bio'>{$br_bio}</p>"; ?>
		            </div>

		            <div class="person-info">
		                <div class="info-header clearfix">
		                    <?php

		                    $brg_first_name = stripslashes(stag_get_option('wedding_bridegroom_first_name'));
		                    $brg_last_name  = stripslashes(stag_get_option('wedding_bridegroom_last_name'));
		                    $brg_avatar     = esc_url(stag_get_option('wedding_bridegroom_avatar'));
		                    $brg_bio        = stripslashes(stag_get_option('wedding_bridegroom_bio'));

		                    if($brg_avatar != '')           echo "<img src='{$brg_avatar}' class='person-avatar' alt='{$brg_first_name}'>";
		                    if($brg_first_name  != '')      echo "<h2>{$brg_first_name}</h2>";
		                    if($brg_last_name   != '')      echo "<p>{$brg_last_name}</p>";

		                    ?>
		                </div>
		                <?php if($brg_bio != '') echo "<p class='person-bio'>{$brg_bio}</p>"; ?>
		            </div>

		        </div>

		        <!-- END .wedding-couple-wrap -->
		    </div>

		    <h2 class="news"><?php echo $title; ?></h2>
		    <h3 class='accent-color'><?php echo stag_full_wedding_date(); ?></h3>

		    <!-- END #intro -->
		</section>

		<?php

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
