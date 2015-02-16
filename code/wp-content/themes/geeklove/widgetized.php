<?php
/**
 * Template Name: Widgetized
 *
 * @package StagFramework
 * @subpackage GeekLove
 * @since 1.2.8
 */

get_header(); ?>

<div class="homepage-sections">
	<?php

	while( have_posts() ): the_post();
		the_content();
	endwhile;

	?>
</div>

<?php get_footer(); ?>
