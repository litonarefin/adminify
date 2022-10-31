<?php
// Google Fonts
$font_url = '';
if ( isset( $this->options['login_google_font'] ) ) {
	$font_family     = isset( $this->options['login_google_font']['font-family'] ) ? $this->options['login_google_font']['font-family'] : '';
	$font_weight     = isset( $this->options['login_google_font']['font-weight'] ) ? $this->options['login_google_font']['font-weight'] : '';
	$text_align      = isset( $this->options['login_google_font']['text-align'] ) ? $this->options['login_google_font']['text-align'] : '';
	$text_transform  = isset( $this->options['login_google_font']['text-transform'] ) ? $this->options['login_google_font']['text-transform'] : '';
	$text_decoration = isset( $this->options['login_google_font']['text-decoration'] ) ? $this->options['login_google_font']['text-decoration'] : '';
	$font_size       = isset( $this->options['login_google_font']['font-size'] ) ? $this->options['login_google_font']['font-size'] : '';
	$line_height     = isset( $this->options['login_google_font']['line-height'] ) ? $this->options['login_google_font']['line-height'] : '';
	$letter_spacing  = isset( $this->options['login_google_font']['letter-spacing'] ) ? $this->options['login_google_font']['letter-spacing'] : '';
	$word_spacing    = isset( $this->options['login_google_font']['word-spacing'] ) ? $this->options['login_google_font']['word-spacing'] : '';
	$font_color      = isset( $this->options['login_google_font']['color'] ) ? $this->options['login_google_font']['color'] : '';
	$font_unit       = isset( $this->options['login_google_font']['unit'] ) ? $this->options['login_google_font']['unit'] : '';

	$jltwp_adminify_query_args = [
		'family' => urlencode( $font_family ),
		// 'subset' => urlencode($font_style_subset),
	];
	$font_url                 = add_query_arg( $jltwp_adminify_query_args, '//fonts.googleapis.com/css' );
	$jltwp_adminify_fonts_url = esc_url_raw( $font_url );
	?>
	<link href="<?php echo esc_url( $jltwp_adminify_fonts_url ); ?>" rel='stylesheet'>
	<style type="text/css">
		<?php
		if ( $font_family ) {
			?>
			body {
			font-family: <?php echo '"' . $font_family . '"'; ?> !important;
		}

		<?php } ?>.login input[type="submit"],
		.login form .input,
		.login input[type="text"] {
			<?php
			if ( $font_family ) {
				?>
				font-family: <?php echo '"' . $font_family . '"'; ?> !important;
			<?php } ?>
					<?php
					if ( $font_weight ) {
						?>
				font-weight: <?php echo esc_attr( $font_weight ); ?> !important;
					<?php } ?>
					<?php
					if ( $text_align ) {
						?>
				text-align: <?php echo esc_attr( $text_align ); ?> !important;
					<?php } ?>
					<?php
					if ( $text_transform ) {
						?>
				text-transform: <?php echo esc_attr( $text_transform ); ?>
			!important;
					<?php } ?>
					<?php
					if ( $text_decoration ) {
						?>
				text-decoration: <?php echo esc_attr( $text_decoration ); ?>
			!important;
					<?php } ?>
					<?php
					if ( $font_size ) {
						?>
				font-size: <?php echo esc_attr( $font_size . $font_unit ); ?> !important;
					<?php } ?>
					<?php
					if ( $line_height ) {
						?>
				line-height: <?php echo esc_attr( $line_height . $font_unit ); ?>
			!important;
					<?php } ?>
					<?php
					if ( $letter_spacing ) {
						?>
				letter-spacing:
						<?php echo esc_attr( $letter_spacing . $font_unit ); ?> !important;
					<?php } ?>
					<?php
					if ( $word_spacing ) {
						?>
				word-spacing: <?php echo esc_attr( $word_spacing . $font_unit ); ?>
			!important;
					<?php } ?>
					<?php
					if ( $font_color ) {
						?>
				color: <?php echo esc_attr( $font_color ); ?> !important;
					<?php } ?>
		}
	</style>
	<?php
}
?>


<?php
if ( ! empty( $this->options['jltwp_adminify_customizer_custom_css'] ) ) :
	$stat_tag     = '/<style>/m';
	$end_tag      = '#</style>#m';
	$result_start = preg_match( $stat_tag, $this->options['jltwp_adminify_customizer_custom_css'] );
	$result_end   = preg_match( $end_tag, $this->options['jltwp_adminify_customizer_custom_css'] );
	echo ( ! $result_start && ! $result_end ) ? '<style>' : '';
	echo "\n{$this->options['jltwp_adminify_customizer_custom_css']}\n";
	echo ( ! $result_start && ! $result_end ) ? '</style>' : '';
endif;
?>

<?php if ( ! empty( $this->options['jltwp_adminify_customizer_custom_js'] ) ) :
	$stat_tag     = '/<script>/m';
	$end_tag      = '#</script>#m';
	$result_start = preg_match( $stat_tag, $this->options['jltwp_adminify_customizer_custom_js'] );
	$result_end   = preg_match( $end_tag, $this->options['jltwp_adminify_customizer_custom_js'] );
	echo ( ! $result_start && ! $result_end ) ? '<script>' : '';
	echo "\n{$this->options['jltwp_adminify_customizer_custom_js']}\n";
	echo ( ! $result_start && ! $result_end ) ? '</script>' : '';
endif; ?>
