    <?php if ( is_active_sidebar('sidebar-footer') ) : ?>
	<div class="footer-outer">
		<footer class="footer grids" role="contentinfo">
			<?php dynamic_sidebar('sidebar-footer'); ?>
		</footer>
	</div>
    <?php endif; ?>

    <?php if( '' != $footer_text = stag_get_option('blog_footer') ) : ?>
	<div class="footer-copyright-wrap">
		<footer class="footer-copyright">
			<?php do_action('icl_language_selector'); ?>
			<?php echo stripslashes( $footer_text ); ?>
		</footer>
	</div>
    <?php endif; ?>

    <?php wp_footer(); ?>
</body>
</html>
