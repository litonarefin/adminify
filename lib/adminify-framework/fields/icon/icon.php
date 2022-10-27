<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: icon
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'ADMINIFY_Field_icon' ) ) {
  class ADMINIFY_Field_icon extends ADMINIFY_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'button_title' => esc_html__( 'Add Icon', 'adminify' ),
        'remove_title' => esc_html__( 'Remove Icon', 'adminify' ),
      ) );

      echo $this->field_before();

      $nonce  = wp_create_nonce( 'adminify_icon_nonce' );
      $hidden = ( empty( $this->value ) ) ? ' hidden' : '';

      echo '<div class="adminify-icon-select">';
      echo '<span class="adminify-icon-preview'. esc_attr( $hidden ) .'"><i class="'. esc_attr( $this->value ) .'"></i></span>';
      echo '<a href="#" class="button button-primary adminify-icon-add" data-nonce="'. esc_attr( $nonce ) .'">'. $args['button_title'] .'</a>';
      echo '<a href="#" class="button adminify-warning-primary adminify-icon-remove'. esc_attr( $hidden ) .'">'. $args['remove_title'] .'</a>';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'" class="adminify-icon-value"'. $this->field_attributes() .' />';
      echo '</div>';

      echo $this->field_after();

    }

    public function enqueue() {
      add_action( 'admin_footer', array( 'ADMINIFY_Field_icon', 'add_footer_modal_icon' ) );
      add_action( 'customize_controls_print_footer_scripts', array( 'ADMINIFY_Field_icon', 'add_footer_modal_icon' ) );
    }

    public static function add_footer_modal_icon() {
    ?>
      <div id="adminify-modal-icon" class="adminify-modal adminify-modal-icon hidden">
        <div class="adminify-modal-table">
          <div class="adminify-modal-table-cell">
            <div class="adminify-modal-overlay"></div>
            <div class="adminify-modal-inner">
              <div class="adminify-modal-title">
                <?php esc_html_e( 'Add Icon', 'adminify' ); ?>
                <div class="adminify-modal-close adminify-icon-close"></div>
              </div>
              <div class="adminify-modal-header">
                <input type="text" placeholder="<?php esc_html_e( 'Search...', 'adminify' ); ?>" class="adminify-icon-search" />
              </div>
              <div class="adminify-modal-content">
                <div class="adminify-modal-loading"><div class="adminify-loading"></div></div>
                <div class="adminify-modal-load"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
    }

  }
}
