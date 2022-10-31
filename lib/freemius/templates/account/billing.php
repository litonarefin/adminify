<?php 

namespace MultiStep_Checkout;

/**
 * The Assets Handler Class
 */
class Assets {
	
	function __construct() {

		$this->define_constants();
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] , 99 );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_assets' ] , 99 );
		add_action('wp_head',[ $this, 'custom_css'],99);

	}
	
	public function define_constants(){
        define( 'MSC_FILE', __FILE__ );
        define( 'MSC_PATH', __DIR__ );
        define( 'MSC_URL', plugins_url( '', MSC_FILE ) );
        define( 'MSC_ASSETS', MSC_URL . '/assets' );
	}

	public function custom_css(){

		$color   = get_option('btn_text_color','#333');
		$bgColor = get_option('btn_bg_color','#fdd922');
		?>
		<style>
			.one-page-checkout .active .step-title{
				border-color: <?php echo esc_attr($bgColor ? $bgColor : '#fdd922' ); ?>;
			}
			.one-page-checkout .active .step-title .number{
				background-color: <?php echo esc_attr($bgColor ? $bgColor : '#fdd922' ); ?>;
				color: <?php echo esc_attr($color ? $color : '#333' ); ?> !important;
			}
			.one-page-checkout button{
				background-color: <?php echo esc_attr($bgColor ? $bgColor : '#fdd922' ); ?> !important;
				color: <?php echo esc_attr($color ? $color : '#333' ); ?> !important;
			}
		</style>		
		<?php
	}

	public function get_scripts() {
		return [
			'multistep-checkout-scripts' => [
				'src'     => MSC_ASSETS . '/js/frontend.js',
				'version' => filemtime( MSC_PATH . '/assets/js/frontend.js' ), 
				'deps' => ['jquery'], 
			] 
		];
	}

	public function get_styles() {
		return [ 
			'multistep-checkout-style' => [
				'src'     => MSC_ASSETS . '/css/frontend.css',
				'version' => filemtime( MSC_PATH . '/assets/css/frontend.css' ),
			] 
		];
	}

	public function enqueue_assets() {
		// scripts.
		$scripts = $this->get_scripts();
		foreach ($scripts as $handler => $script) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : false;	// dependencis	
			$load = isset( $script['load'] ) ? $script['load'] : true;	// load on header or footer
			wp_register_script( $handler, $script['src'], $deps, $script['version'], $load );
		}
 
		// styles
		$styles = $this->get_styles();
		foreach ($styles as $handler => $style) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;	// dependencis	 
			wp_register_style( $handler, $style['src'], $deps, $style['version'] );
		}
 
		wp_enqueue_style( 'multistep-checkout-style' ); 
		wp_enqueue_script( 'multistep-checkout-scripts' );
  
	}

	public function admin_enqueue_assets(){ 
        wp_enqueue_script('jquery');
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' ); 
	}
}