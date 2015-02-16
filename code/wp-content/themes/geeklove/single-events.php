<?php get_header(); ?>

<div class="container-wrap">

    <div class="blog-cover">
        <?php if( '' != $event_cover = get_post_meta(get_the_ID(), '_stag_event_cover', true) ) : ?>
            <img src="<?php echo $event_cover; ?>" alt="">
        <?php endif; ?>

        <div class="center blog-title-wrap">
            <div class="blog-title-inner-wrap">
                <h2 class="section-title"><?php the_title(); ?></h2>
                <?php if( '' != $subtitle = get_post_meta(get_the_ID(), '_stag_event_subtitle', true) ) echo '<h4 class="sub-title">'. $subtitle .'</h4>'; ?>
            </div>
        </div>
    </div>

        <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div class="all-posts">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php if ( '' != $map_url = get_post_meta(get_the_ID(), '_stag_event_map_url', true) ) : ?>
                    <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $map_url; ?>&amp;output=embed"></iframe>
                    <?php endif; ?>

                    <!-- BEGIN .entry-content -->
                    <div class="entry-content">
                        <div class="post-metas pull-right">
                            <?php if ( '' != $event_location = get_post_meta(get_the_ID(), '_stag_event_location', true) ) :  ?>
                            <div class="meta-data">
                                <h3 data-icon="&#xe00a;"><?php _e( 'Location:', 'stag' ); ?></h3>
                                <p><?php echo nl2br($event_location); ?></p>
                            </div>
                            <?php endif; ?>

                            <?php if ( '' != $event_date = get_post_meta(get_the_ID(), '_stag_event_date', true) ) :  ?>
                            <div class="meta-data">
                                <h3 data-icon="&#xe00d;"><?php _e( 'Date:', 'stag' ); ?></h3>
                                <p><?php echo date_i18n( 'l d F Y', strtotime( trim( $event_date ) ) ); ?> </p>
                            </div>
                            <?php endif; ?>

                            <?php if ( '' != $event_time = get_post_meta(get_the_ID(), '_stag_event_time', true) ) :  ?>
                            <div class="meta-data">
                                <h3 data-icon="&#xe00c;"><?php _e( 'Time:', 'stag' ); ?></h3>
                                <p><?php echo $event_time; ?></p>
                            </div>
                            <?php endif; ?>

                        </div>
                        <?php the_content( __( 'Continue Reading', 'stag' ) ); ?>
                        <!-- END .entry-content -->
                    </div>
                </article>
            </div>
        <?php endwhile; ?>

        <hr class="section-divider">

        <?php if ( '' != $event_link = get_post_meta(get_the_ID(), '_stag_event_link', true) ) : ?>
            <div class="center">
                <a href="<?php echo $event_link; ?>" class="button stag-button large"><?php echo get_post_meta(get_the_ID(), '_stag_event_link_title', true) ?></a>
            </div>
        <?php endif; ?>

        </div>

    <?php endif; ?>
</div>

<?php get_footer() ?>
