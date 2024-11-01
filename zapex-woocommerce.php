<?php
/*
Plugin Name:          Transportadora ZAPEX for WooCommerce
Plugin URI:           https://www.reatos.com.br
Description:          Integração Transportadora ZAPEX à sua loja WooCommerce.
Author:               Thalles Brandão
Author URI:           https://www.reatos.com.br
Version:              1.2.2
WC requires at least: 3.8.0
WC tested up to:      5.0.0
License: GPL3+
License URI: https://www.gnu.org/licenses/gpl.txt

@package ZAPEX
*/

defined( 'ABSPATH' ) || exit;

define( 'ZAPEX_WOOCOMMERCE_VERSION', '1.2.2' );
define( 'ZAPEX_WOOCOMMERCE_PLUGIN_FILE', __FILE__ );

include_once dirname( __FILE__ ) . '/includes/class-zapex.php';
