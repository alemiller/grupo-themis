<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author luisriquelme
 */
class Product {

    //put your code here
    
    var $CI;
    
    function Product() {

        $this->CI = & get_instance();
        $this->CI->load->model('product_model', '', TRUE);
    }
    
    public function available_for_free( $token , $query ) {

        $products = $this->get_products( $token , $query);
        $data = array();
        foreach ( $products->content->entries as $product ){

            if( $product->isSubscription == null &&  $product->title != 'Monthly Recurrent Billing' ){

                $data['tickets'][] = $product;
            }
            else{
                $data['subscriptions'][] = $product;
            }
        }

        return $data;
    }

    public function get_products( $token , $query ) {

        return $this->CI->product_model->get_products( $token , $query );
    }

}
