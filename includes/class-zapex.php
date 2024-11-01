<?php

/**
 * Zapex
 *
 * @package Zapex/Classes
 * @since   1.2.1
 * @version 1.2.1
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugins main class.
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    function zapex_delivery_init() {
        if ( ! class_exists( 'WC_Zapex_Delivery_Method' ) ) {
            class WC_Zapex_Delivery_Method extends WC_Shipping_Method {

                public function __construct($instance_id = 0)
                {
                  $this->id = 'zapex_delivery';
                  $this->instance_id = absint($instance_id);
                  $this->method_title = __('Zapex Transportadora', 'zapex');
                  $this->method_description = __('Um método de envio personalizado configurável para Transportadora Zapex', 'zapex');
                  $this->supports = array(
                    'shipping-zones',
                    'instance-settings',
                    'instance-settings-modal',
                  );
                  
                  $this->token = !empty($this->settings['token']) ? $this->settings['token'] : '';
                  $this->enabled = isset($this->settings['enabled']) ? $this->settings['enabled'] : 'yes';
                  $this->cep = isset($this->settings['cep']) ? $this->settings['cep'] : '';
                  $this->dias_adicionais = isset($this->settings['dias_adicionais']) ? $this->settings['dias_adicionais'] : '';
                
                  $this->init();
        
                }
        
                function init()
                {
                  $this->init_form_fields();
                  $this->init_settings();
        
                  $this->enabled = $this->get_option( 'enabled' );
                  $this->title = 'Zapex Transportadora'; 
        
                  add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
                }
        
                function init_form_fields()
                {
                  $this->instance_form_fields = array(
        
                    'enabled' => array(
                      'title'       => __( 'Habilitar', 'zapex' ),
                      'type'        => 'checkbox',
                      'description' => __( 'Habilite este método de envio.', 'zapex' ),
                      'default'     => 'yes'
                  ),
        
                  'token' => array(
                      'title'       => __( 'Token', 'zapex' ),
                      'type'        => 'text',
                      'description' => __( 'Token fornecido pela ZAPEX', 'zapex' ),
                      'default'     => __( '', 'zapex' )
                  ),
        
                  'cep' => array(
                      'title'       => __( 'CEP', 'zapex' ),
                      'type'        => 'number',
                      'description' => __( 'Informe o CEP de onde os produtos serão enviados', 'zapex' ),
                      'default'     => ''
                  ),
        
                  'dias_adicionais' => array(
                      'title'       => __( 'Dias adicionais', 'zapex' ),
                      'type'        => 'number',
                      'description' => __( 'Informe dias adicionas que serão somados ao FRETE', 'zapex' ),
                      'default'     => ''
                  ),
        
                  );
                }
        
                public function calculate_shipping( $package = array() )
                {
        
                  $instance_settings =  $this->instance_settings;
                  $total = $this->get_total_volumes($package);
                  $weight = $this->get_order_total_weight($package);
                  $postcode = $package['destination']['postcode'];
                  $contents_cost = $package['contents_cost'];
        
                  if($instance_settings['token'] AND $instance_settings['cep'] AND $instance_settings['enabled'] === 'yes' AND $postcode && $contents_cost && $total && $weight){
        
                      $uri        = "http://api.zapex.com.br/cotacaofrete/{$instance_settings['token']}/{$instance_settings['cep']}/{$postcode}/{$total}/{$weight}/{$contents_cost}";
                      $response   = $this->request_to_api( $uri, array(
                                        'timeout' => 60,
                                        'redirection' => 5,
                                        'blocking' => true,
                                        'sslverify' => false,
                                        'headers' => array(
                                          'Content-Type' => 'application/json'
                                        )
                                    ));
        
                      if ($response !== NULL) {  
                          foreach ($response->oObj as $value){
        
                              if($instance_settings['dias_adicionais']){
                                  $entrega = $value->PrazoEntrega + $instance_settings['dias_adicionais'];
                              }else{
                                  $entrega = $value->PrazoEntrega;
                              }
        
                              $rate = apply_filters( 'woocommerce_zapex_' . $this->id . '_rate', array(
                                'id'    => $this->id . $this->instance_id,
                                'label' => $value->Descricao . ' (Entrega em ' . $entrega . ' dias úteis)',
                                'cost' => $value->Valor
                              ), $this->instance_id, $package );
        
                              $this->add_rate($rate);
                          }
                      }  
                  }else{
                      return;
                  }
                }
        
                private function request_to_api( $uri, $args )
                {
                    $response = wp_remote_post( $uri, $args );
                    if ( is_wp_error( $response ) || '200' != wp_remote_retrieve_response_code( $response )) {
                        return;
                    }
                    $body = json_decode( wp_remote_retrieve_body( $response ) );
                    if ( empty( $body ) )
                        return;
                    return $body;
                }
        
                private function get_total_volumes( $package ) {
                    $total = 0;
        
                    foreach ( $package['contents'] as $item_id => $values ) {
                        $total += (int) $values['quantity'];
                    }
        
                    return $total;
                }
        
                private function get_order_total_weight( $package ) {
        
                    $total = 0;
        
                    foreach ( $package['contents'] as $item_id => $values )
                    {
                        $_product = $values['data'];
                        $_product_weight = (float) $_product->get_weight();
                        $total += $_product_weight * $values['quantity'];
                    }
        
                    $total = wc_get_weight( $total, 'kg' );
        
                    return $total;
                }
        


            }
        }
    }

    add_action( 'woocommerce_shipping_init', 'zapex_delivery_init' );

    function zapex_delivery_shipping_method( $methods ) {
        $methods['zapex_delivery'] = 'WC_Zapex_Delivery_Method';

        return $methods;
    }

    add_filter( 'woocommerce_shipping_methods', 'zapex_delivery_shipping_method' );
}