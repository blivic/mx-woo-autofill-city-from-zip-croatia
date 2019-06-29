<?php
/*
Plugin Name: MX Autofill city from ZIP
Plugin URI: http://media-x.hr
Description: Autofill "City" field from entered ZIP#
Version: 1.0
Author: Media X
WC requires at least: 2.6
WC tested up to: 3.5.4
Author URI: https://media-x.hr
License: GPLv3
*/


function mx_hr_autofill_city_scripts() {
	if( is_checkout() ) {
		wp_register_script( 'mx_zip_checkout_script', plugins_url('/includes/js/zipcodes.js', __FILE__), array('jquery'));
	    wp_register_script( 'mx_autofill_checkout_script', plugins_url('/includes/js/autofill.js', __FILE__), array('jquery'));
	    wp_enqueue_script( 'mx_zip_checkout_script' );  
        wp_enqueue_script( 'mx_autofill_checkout_script' );
	}
}
add_action( 'wp_enqueue_scripts', 'mx_hr_autofill_city_scripts' );

add_filter( 'woocommerce_default_address_fields', 'mx_edit_default_address_fields', 100, 1 );
function mx_edit_default_address_fields($fields) {

  /* ------ Reorder ------ */
   $fields['country']['priority'] = 40;
   $fields['postcode']['priority'] = 50;
   $fields['city']['priority'] = 60;
   $fields['address_1']['priority'] = 70;
   $fields['address_2']['priority'] = 80;
   /* ------ Unset state (županija) ------  */
   unset( $fields['state'] );
 

   return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'mx_organize_checkout_billing_fields', 20, 1 );
function mx_organize_checkout_billing_fields( $fields ){
       // Move email field under first & last name
	   $fields['billing']['billing_email']['priority'] = 30;
        // Change class
       $fields['billing']['billing_postcode']['class']   = array('form-row-first'); //  50%
       $fields['billing']['billing_city']['class']   = array('form-row-last');  //  50%
    
    return $fields;
}
add_filter( 'woocommerce_get_country_locale', function( $locale ) {
    foreach ( $locale as $country_code => $locale_fields ) {
        foreach ( $locale_fields as $field_key => $field_options ) {
            if ( isset( $field_options['priority'] ) ) {
                unset( $field_options['priority'] );
            }

            $locale[ $country_code ][ $field_key ] = $field_options;
        }
    }

    return $locale;
} );
