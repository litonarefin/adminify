<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'ADMINIFY_Field_backup' ) ) {
  class ADMINIFY_Field_backup extends ADMINIFY_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $unique = $this->unique;
      $nonce  = wp_create_nonce( 'adminify_backup_nonce' );
      $export = add_query_arg( array( 'action' => 'adminify-export', 'unique' => $unique, 'nonce' => $nonce ), admin_url( 'admin-ajax.php' ) );

      echo $this->field_before();

      echo '<textarea name="adminify_import_data" class="adminify-import-data"></textarea>';
      echo '<button type="submit" class="button button-primary adminify-confirm adminify-import" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Import', 'adminify' ) .'</button>';
      echo '<hr />';
      echo '<textarea readonly="readonly" class="adminify-export-data">'. esc_attr( json_encode( get_option( $unique ) ) ) .'</textarea>';
      echo '<a href="'. esc_url( $export ) .'" class="button button-primary adminify-export" target="_blank">'. esc_html__( 'Export & Download', 'adminify' ) .'</a>';
      echo '<hr />';
      echo '<button type="submit" name="adminify_transient[reset]" value="reset" class="button adminify-warning-primary adminify-confirm adminify-reset" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Reset', 'adminify' ) .'</button>';

      echo $this->field_after();

    }

  }
}
