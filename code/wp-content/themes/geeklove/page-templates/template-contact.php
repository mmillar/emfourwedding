<?php
/**
 * Template Name: Contact Form
 */

$nameError = __( 'Please enter your name.', 'stag' );
$emailError = __( 'Please enter your email address.', 'stag' );
$emailInvalidError = __( 'You entered an invalid email address.', 'stag' );
$commentError = __( 'Please enter a message.', 'stag' );

$errorMessages = array();

if ( isset( $_POST['submit_message'] ) ) {
    if( trim( $_POST['contact_name'] ) === '' ) {
        $errorMessages['nameError'] = $nameError;
        $hasError = true;
    } else {
        $name = trim( $_POST['contact_name'] );
    }

    if( trim($_POST['contact_email'] ) === '' ) {
        $errorMessages['emailError'] = $emailError;
        $hasError = true;
    } elseif ( ! is_email( $_POST['contact_email'] ) ) {
        $errorMessages['emailInvalidError'] = $emailInvalidError;
        $hasError = true;
    } else {
        $email = trim($_POST['contact_email']);
    }

    if( trim($_POST['contact_message'] ) === '' ) {
        $errorMessages['commentError'] = $commentError;
        $hasError = true;
    } else {
        $comments = stripslashes(trim($_POST['contact_message']));
    }

    if( !isset( $hasError ) ) {
        $emailTo = stag_get_option('general_contact_email');
        if ( !isset($emailTo) || ($emailTo == '') ) {
            $emailTo = get_option('admin_email');
        }

        $subject = '[Contact Form] From '.$name;

        $body = "Name: $name \n\nEmail: $email \n\nMessage: $comments \n\n";
        $body .= "--\n";
        $body .= "This mail is sent via contact form on ". get_bloginfo('name') ."\n";
        $body .= home_url();

        $headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;

        wp_mail($emailTo, $subject, $body, $headers);
        $emailSent = true;
    }
}

get_header(); ?>

<div class="container-wrap">

	<?php get_template_part( 'helper', 'page-cover' ); ?>

	<section id="event" class="section-block contact">

		<div class="inner-block">

			<form class="contact-form" action="<?php the_permalink(); ?>" method="post">
				<div class="grids">
					<div class="grid-4">
						<label for="contact_name"><?php _e('Your Name', 'stag'); ?>*</label>
						<input type="text" id="contact_name" name="contact_name" >
						<?php if(isset($errorMessages['nameError'])) { ?>
			                <span class="error"><?php echo $errorMessages['nameError']; ?></span>
			            <?php } ?>
					</div>

					<div class="grid-4">
						<label for="contact_email"><?php _e('Your Email', 'stag'); ?>*</label>
						<input type="email" id="contact_email" name="contact_email" >
						<?php if(isset($errorMessages['emailError'])) { ?>
			                <span class="error"><?php echo $errorMessages['emailError']; ?></span>
			            <?php } ?>
			            <?php if(isset($errorMessages['emailInvalidError'])) { ?>
			                <span class="error"><?php echo $errorMessages['emailInvalidError']; ?></span>
			            <?php } ?>
					</div>
					<div class="grid-4">
						<label for="contact_phone"><?php _e( 'Your Phone', 'stag' ); ?></label>
						<input type="text" id="contact_phone" name="contact_phone">
					</div>
				</div>

				<div class="grids textarea-wrap">
					<div class="grid-12">
						<label for="contact_message"><?php _e( 'Your Message', 'stag' ) ?>*</label>
						<textarea name="contact_message" id="contact_message" cols="30" rows="10" ></textarea>
						<?php if(isset($errorMessages['commentError'])) { ?>
				            <span class="error"><?php echo $errorMessages['commentError']; ?></span>
				        <?php } ?>
					</div>
				</div>

				<?php if(isset($emailSent) && $emailSent == true): ?>
					<div class="thanks">
						<p><?php _e('Thanks, your message was sent successfully.', 'stag') ?></p>
					</div>
				<?php endif; ?>

				<div class="submit">
					<input type="submit" class="" value="<?php _e( 'Send Message', 'stag' ) ?>" name="submit_message">
				</div>
			</form>

			<!-- END .inner-block -->
		</div>

		<!-- END #event -->
	</section>

	<!-- BEGIN .container -->
	<div class="container">

		<?php if( have_posts() ) : ?>
			<?php while( have_posts() ) : the_post(); ?>

			<div class="entry-content center contact-page">
				<?php if( '' != $secondary_title = get_post_meta( get_the_ID(), '_stag_contact_secondary_title', true ) ) : ?>
					<h1 class="section-title"><?php echo $secondary_title; ?></h1>
				<?php endif; ?>

				<?php the_content(); ?>

				<?php if( get_post_meta( get_the_ID(), '_stag_contact_number', true ) != '' || get_post_meta( get_the_ID(), '_stag_contact_email', true ) != '' ) : ?>
					<div class="contact-details">
						<span class="contact-number"><i class="icon icon-phone"></i> <?php echo get_post_meta(get_the_ID(), '_stag_contact_number', true); ?></span>
						<span class="contact-email"><i class="icon icon-mail"></i> <a href="mailto:<?php echo get_post_meta(get_the_ID(), '_stag_contact_email', true); ?>"><?php echo get_post_meta(get_the_ID(), '_stag_contact_email', true); ?></a></span>
					</div>
				<?php endif; ?>
			</div><!-- .contact-page -->

		<?php endwhile; ?>
	<?php endif; ?>

	<!-- END .container -->
</div>

</div>

<?php get_footer(); ?>
