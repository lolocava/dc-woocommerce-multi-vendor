<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @class 		WCMp Vendor Order Class
 *
 * @version		3.4.0
 * @package		WCMp
 * @author 		WC Marketplace
 */
class WCMp_Vendor_Order {
    
    public $id;
    public $vendor_id;
    public $order;
    
    /**
     * Get the order if ID is passed, otherwise the order is new and empty.
     *
     * @param  int|object|WCMp_Order $order Order to read.
     */
    public function __construct( $order = 0 ) {

        if ( is_numeric( $order ) && $order > 0 ) {
            $this->id   = absint( $order );
        } elseif ( $order instanceof WC_Order ) {
            $this->id = absint( $order->id );
        }else{
            $this->id = 0;
        }
        $this->vendor_id = get_post_meta($this->id, '_vendor_id', true);
        
        $this->order = wc_get_order( $this->id );
    }
    
    public function get_prop( $prop ) {
        return get_post_meta($this->id, $prop, true);
    }
    
    /**
     * Get order vendor.
     *
     * @since 3.4.0
     * @return object/false Vendor
     */
    public function get_vendor() {
        return is_user_wcmp_vendor($this->vendor_id) ? get_wcmp_vendor($this->vendor_id) : false;
    }
    
    /**
     * Get vendor commission total.
     *
     * @since 3.4.0
     */
    public function get_commission_total($context = 'view') {
        $commission_id = $this->get_prop('_commission_id');
        return WCMp_Commission::commission_totals($commission_id, $context);
    }
    
    /**
     * Get vendor commission amount.
     *
     * @since 3.4.0
     */
    public function get_commission($context = 'view') {
        $commission_id = $this->get_prop('_commission_id');
        return WCMp_Commission::commission_amount_totals($commission_id, $context);
    }
    
    /**
     * Get formatted commission total.
     *
     * @since 3.4.0
     */
    public function get_formatted_commission_total($context = 'view') {
        $commission_id = $this->get_prop('_commission_id');
        $commission_amount = get_post_meta( $commission_id, '_commission_amount', true );
        if($commission_amount != WCMp_Commission::commission_amount_totals($commission_id, 'edit')){
            return '<del>' . wc_price($commission_amount, array('currency' => $this->order->get_currency())) . '</del> <ins>' . WCMp_Commission::commission_amount_totals($commission_id, $context).'</ins>'; 
        }else{
            return WCMp_Commission::commission_amount_totals($commission_id, $context);
        }
    }
    
    /**
     * Get commission refunded amount.
     *
     * @since 3.4.0
     */
    public function get_commission_refunded_amount($context = 'view') {
        $commission_id = $this->get_prop('_commission_id');
        return WCMp_Commission::commission_refunded_totals($commission_id, $context);
    }
    
    /**
     * Get vendor shipping amount.
     *
     * @since 3.4.0
     */
    public function get_shipping($context = 'view') {
        $commission_id = $this->get_prop('_commission_id');
        return WCMp_Commission::commission_shipping_totals($commission_id, $context);
    }
    
    /**
     * Get vendor tax amount.
     *
     * @since 3.4.0
     */
    public function get_tax($context = 'view') {
        $commission_id = $this->get_prop('_commission_id');
        return WCMp_Commission::commission_tax_totals($commission_id, $context);
    }
    
    /**
     * Get vendor order.
     *
     * @since 3.4.0
     * @return object/false Vendor order
     */
    public function get_order() {
        return $this->order ? $this->order : false;
    }
    
}


