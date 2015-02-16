<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_wedding_gallery");'));

class stag_wedding_gallery extends WP_Widget{
  function stag_wedding_gallery(){
    $widget_ops = array('classname' => 'wedding-rsvp', 'description' => __('Display Gallery pics from a specific category.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_wedding_gallery');
    $this->WP_Widget('stag_wedding_gallery', __('Section: Wedding Gallery', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
	$title    = apply_filters('widget_title', $instance['title'] );
	$subtitle = $instance['subtitle'];
	$cat      = $instance['cat'];
	$page     = $instance['page'];

    echo $before_widget;

    ?>

    <!-- BEGIN #gallery -->
    <section id="gallery" class="section-block">

        <div class="inner-block">
            <h2 class="section-title"><?php echo $title; ?></h2>
            <?php if($subtitle != '') echo "<h4 class='sub-title'>$subtitle</h4>"; ?>

            <div id="photo-list" class="clearfix">
              <?php

              if($cat){

                $args = array(
                  'post_type' => 'gallery',
                  'tax_query'      => array(
                    array(
                      'taxonomy' => 'photo-type',
                      'field'    => 'slug',
                      'terms'    => $cat
                    )
                  )
                );

                $photos_query = new WP_Query($args);

                if($photos_query->have_posts()): while($photos_query->have_posts()): $photos_query->the_post();

                $pics = get_post_meta(get_the_ID(), '_stag_image_ids', true);
                $pics = explode(",", $pics);

                $terms = get_the_terms( get_the_ID(), 'photo-type' );
                if ( $terms && ! is_wp_error( $terms ) ) :
                  $links = array();
                  foreach ( $terms as $term ){
                      $links[] = $term->slug;
                  }
                  $tax = join( " ", $links );
                else :
                    $tax = '';
                endif;

                foreach($pics as $pic){
                  if( !$pic ) continue;

                  $image = wp_get_attachment_image_src( $pic, 'gallery-thumb' );
                  $src   = wp_get_attachment_image_src( $pic, 'full' );

                  if( wp_is_mobile() ) {
                    echo "<div class='ipad-6 photo {$tax}'><a href='{$src[0]}'><img src='{$image[0]}' alt=''></a></a></a></div>";
                  } else {
                    echo "<div class='ipad-6 photo {$tax}'><a href='{$src[0]}' data-lightbox='photos'><img src='{$image[0]}' alt=''></a></div>";
                  }
                }

                endwhile;

                endif;
                wp_reset_query();

              }

              ?>
            </div>

            <?php

            if($page != -1){
              echo '<div class=center><a href="'.get_page_link($page).'" class="button">'. __( 'Go to Galleries', 'stag' ) .'</a></div>';
            }

            ?>

            <!-- END .inner-block -->

        </div>

        <!-- END #gallery -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
	$instance['title']    = strip_tags($new_instance['title']);
	$instance['subtitle'] = strip_tags($new_instance['subtitle']);
	$instance['cat']      = strip_tags($new_instance['cat']);
	$instance['page']     = strip_tags($new_instance['page']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
		'title'    => __('Featured Photographs', 'stag'),
		'subtitle' => '',
		'cat'      => '',
		'page'     => '-1',
	);

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Category:', 'stag'); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>">
      <?php
      $c = get_categories('taxonomy=photo-type&type=gallery&hide_empty=1');
      foreach($c as $cat){
          ?>
          <option value="<?php echo $cat->slug; ?>" <?php if($instance['cat'] === $cat->slug) echo "selected"; ?>><?php echo $cat->name; ?></option>
          <?php
      }
      ?>
      </select>
      <span class="description"><?php _e('Choose category from which to display photos', 'stag'); ?></span>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Linked Page:', 'stag'); ?></label>

      <select id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>" class="widefat">
        <option value="-1"><?php _e( '-Select Page-', 'stag' ); ?></option>
      <?php

        $args = array(
          'sort_order' => 'ASC',
          'sort_column' => 'post_title',
          );
        $pages = get_pages($args);

        foreach($pages as $paged){ ?>
          <option value="<?php echo $paged->ID; ?>" <?php if($instance['page'] == $paged->ID) echo "selected"; ?>><?php echo $paged->post_title; ?></option>
        <?php }

       ?>
     </select>
     <span class="description"><?php _e( 'This page will be display a link to the photo gallery.', 'stag' ); ?></span>
    </p>

    <?php
  }
}
?>
