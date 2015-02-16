<?php if( has_post_thumbnail() ) : ?>
	<div class="post-thumb">
		<?php the_post_thumbnail('full'); ?>
	</div>
<?php endif; ?>

<div class="entry-meta entry-header grids">
    <span class="grid-3 author">
    	<i class="icon icon-author"></i>
    	<span><?php _e( 'Posted By', 'stag' ) ?></span>
    	<?php the_author_posts_link(); ?>
	</span>

    <span class="grid-3 category">
    	<i class="icon icon-categories"></i>
    	<span><?php _e( 'In Category', 'stag' ) ?></span>
    	<?php the_category(', '); ?>
	</span>

    <span class="grid-3 date">
    	<i class="icon icon-date"></i>
    	<span><?php the_time('M d Y'); ?></span>
	</span>

	<span class="grid-3 comments">
    	<i class="icon icon-comments"></i>
    	<?php printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'stag' ), number_format_i18n( get_comments_number() ) ); ?>
	</span>
</div>

<?php if ( !is_singular() ) : ?>
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'stag'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
<?php else: ?>
	<h2 class="entry-title accent-color"><?php the_title(); ?></h2>
<?php endif; ?>

<div class="entry-content">
  <?php
    if ( is_singular() ) {
    	the_content();
    	wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'stag').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
    } else {
        the_excerpt();
    }
  ?>
</div>
