<?php
/**
 * Homepage Tweets Widget.
 */
class Stag_Wedding_Tweets extends Stag_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id          = 'stag_wedding_tweets';
		$this->widget_cssclass    = 'wedding-couple-tweets';
		$this->widget_description = __( 'Display back to back tweets from bridegroom and bride.', 'stag' );
		$this->widget_name        = __( 'Section: Wedding Couple Tweets', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Tweets Back to Back', 'stag' ),
				'label' => __( 'Title:', 'stag' ),
			),
			'subtitle' => array(
				'type'  => 'text',
				'std'   => null,
				'label' => __( 'Sub Title:', 'stag' ),
			),
			'widget_desc' => array(
				'type'  => 'description',
				'std'   => sprintf( __( 'This widget will use avatar and first name of bride and bridegroom set under Theme Options > <a href="%s" target="_blank">Wedding Settings</a>.', 'stag' ), admin_url('admin.php?page=stagframework#wedding-settings') )
			),
			'brg_twitter' => array(
				'type'  => 'text',
				'std'   => null,
				'label' => __( 'Bridegroom Twitter Username:', 'stag' ),
			),
			'br_twitter' => array(
				'type'  => 'text',
				'std'   => null,
				'label' => __( 'Bride Twitter Username:', 'stag' ),
			),
			'cache_time' => array(
				'type'  => 'number',
				'std'   => '2',
				'min'   => '1',
				'label' => __( 'Cache tweets in every following hours:', 'stag' ),
			),
			'postcount' => array(
				'type'  => 'number',
				'std'   => '3',
				'min'   => '1',
				'max'   => '10',
				'step'  => '1',
				'label' => __( 'Number of tweets (max 10):', 'stag' ),
			),
			'desc' => array(
				'type' => 'description',
				'std'  => sprintf( __( 'Details like Consumer key and secret can be set under <a href="%s" target="_blank">StagTools Settings</a>', 'stag' ), admin_url('options-general.php?page=stagtools') )
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

		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$subtitle    = $instance['subtitle'];
		$brg_twitter = $instance['brg_twitter'];
		$br_twitter  = $instance['br_twitter'];
		$cache_time  = $instance['cache_time'];
		$postcount   = $instance['postcount'];

		echo $before_widget;

		?>

		<!-- BEGIN #tweets -->
		<section id="tweets" class="section-block">

		    <div class="inner-block">
		        <h2 class="section-title"><?php echo $title; ?></h2>
		        <?php if($subtitle != '') echo "<h4 class='sub-title'>$subtitle</h4>"; ?>

		        <div class="grids">


		          <?php
		            $stag_options = get_option( 'stag_options' );

		            if( empty($stag_options['consumer_key']) || empty($stag_options['consumer_secret']) || empty($stag_options['access_key']) || empty($stag_options['access_secret']) ) {
		              echo '<strong>' . __( 'Please fill all widget settings.', 'stag' ) . '</strong>' . $after_widget;
		              return;
		            }

		            $tw_helper = new StagTWHelper();

		            $last_cache = get_option('twitter_widget_last_cache_time');
		            $diff = time() - $last_cache;
		            $crt = $instance['cache_time'] * 3600;

		            if( $diff >= $crt || empty($last_cache) ){
		              $connection = $tw_helper->getConnectionWithAccessToken( $stag_options['consumer_key'], $stag_options['consumer_secret'], $stag_options['access_key'], $stag_options['access_secret'] );

		              $brg_tweets = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $instance['brg_twitter'] . "&count=". $instance['postcount'] ) or die( __( "Couldn't retrieve tweets! Wrong username!", "stag" ) );
		              $br_tweets  = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $instance['br_twitter'] . "&count=". $instance['postcount'] ) or die( __( "Couldn't retrieve tweets! Wrong username!", "stag" ) );

		              if(!empty($brg_tweets->errors) && !empty($br_tweets->errors) ){
		                if($brg_tweets->errors[0]->message == 'Invalid or expired token'){
		                  echo '<strong>'.$brg_tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!' . $after_widget;
		                }else{
		                  echo '<strong>'.$brg_tweets->errors[0]->message.'</strong>' . $after_widget;
		                }
		                return;
		              }

		              for($i = 0;$i <= count($brg_tweets); $i++){
		                if(!empty($brg_tweets[$i])){
		                  $brg_tweets_array[$i]['created_at'] = $brg_tweets[$i]->created_at;
		                  $brg_tweets_array[$i]['text'] = $brg_tweets[$i]->text;
		                  $brg_tweets_array[$i]['status_id'] = $brg_tweets[$i]->id_str;
		                }
		              }

		              for($i = 0;$i <= count($br_tweets); $i++){
		                if(!empty($br_tweets[$i])){
		                  $br_tweets_array[$i]['created_at'] = $br_tweets[$i]->created_at;
		                  $br_tweets_array[$i]['text'] = $br_tweets[$i]->text;
		                  $br_tweets_array[$i]['status_id'] = $br_tweets[$i]->id_str;
		                }
		              }

		              update_option('twitter_widget_brg_tweets', serialize($brg_tweets_array));
		              update_option('twitter_widget_br_tweets', serialize($br_tweets_array));
		              update_option('twitter_widget_last_cache_time', time());

		            }

		            $brg_widget_tweets = maybe_unserialize(get_option('twitter_widget_brg_tweets'));
		            $br_widget_tweets = maybe_unserialize(get_option('twitter_widget_br_tweets'));

		              ?>

		              <div class="grid-6 tweets">
		                <div class="tweet-header">
		                  <?php if(stag_get_option('wedding_bride_avatar') != ''): ?>
		                    <img src="<?php echo stag_get_option('wedding_bride_avatar'); ?>" alt="" class="avatar-tw">
		                  <?php endif; ?>

		                  <h4><?php echo stag_get_option('wedding_bride_first_name'); ?></h4><span><a href="//twitter.com/<?php echo $br_twitter; ?>">@<?php echo $br_twitter; ?></a></span>
		                </div>

		                <?php
		                  if( !empty($br_widget_tweets) ){
		                    echo '<ul>';
		                    $count = 1;
		                    $protocol = is_ssl() ? 'https:' : 'http:';
		                    foreach( $br_widget_tweets as $tweet ){
		                      echo '<li><span>'. $tw_helper->twitter_widget_convert_links($tweet['text']) .'</span><div class="time"><a href="'.$protocol.'//twitter.com/'.$instance['br_twitter'].'/statuses/'.$tweet['status_id'].'" target="_blank">'.$tw_helper->twitter_widget_relative_time($tweet['created_at']).'</a></div></li>';
		                      if( $count == $instance['postcount']){ break; }
		                      $count++;
		                    }
		                    echo '</ul>';
		                  }
		                ?>

		                <div class="follow">
		                  <a href="//twitter.com/<?php echo $br_twitter; ?>" class="button">Follow</a>
		                </div>
		              </div>

		              <div class="grid-6 tweets">
		                <div class="tweet-header">
		                  <?php if(stag_get_option('wedding_bridegroom_avatar') != ''): ?>
		                    <img src="<?php echo stag_get_option('wedding_bridegroom_avatar'); ?>" alt="" class="avatar-tw">
		                  <?php endif; ?>

		                  <h4><?php echo stag_get_option('wedding_bridegroom_first_name'); ?></h4><span><a href="//twitter.com/<?php echo $brg_twitter; ?>">@<?php echo $brg_twitter; ?></a></span>
		                </div>

		                <?php
		                  if( !empty($brg_widget_tweets) ){
		                    echo '<ul>';
		                    $count = 1;
		                    $protocol = is_ssl() ? 'https:' : 'http:';
		                    foreach( $brg_widget_tweets as $tweet ){
		                      echo '<li><span>'. $tw_helper->twitter_widget_convert_links($tweet['text']) .'</span><div class="time"><a href="'.$protocol.'//twitter.com/'.$instance['brg_twitter'].'/statuses/'.$tweet['status_id'].'" target="_blank">'.$tw_helper->twitter_widget_relative_time($tweet['created_at']).'</a></div></li>';
		                      if( $count == $instance['postcount']){ break; }
		                      $count++;
		                    }
		                    echo '</ul>';
		                  }
		                ?>

		                <div class="follow">
		                  <a href="//twitter.com/<?php echo $brg_twitter; ?>" class="button">Follow</a>
		                </div>

		              </div>

		        </div>
		        <!-- END .inner-block -->
		    </div>
		    <!-- END #tweets -->
		</section>

		<?php

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
