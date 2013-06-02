<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php _e('Insta WP Settings', 'insta-wp-locale'); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'instawp_options' ); ?>
			<?php do_settings_sections( 'instawp-options' ); ?>
			<p class="submit">
            	<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
            	<input id="reset" type="submit" class="button-secondary" value="<?php _e('Reset'); ?>" />
            </p>
		</form>
		<?php do_action('instawp_after_form'); ?>
</div>