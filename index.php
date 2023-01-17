<?php


/**
 * Plugin Name:       Contact Woocommerece Tanvirsss
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 */


add_action('admin_menu','myThemeOption');
if(!function_exists('myThemeOption')){
    function myThemeOption(){


        add_menu_page(
            __( 'Custom Menu Title', 'textdomain' ),
            'Tanvir menu',
            'manage_options',
            'myplugin/myplugin-admin.php',
            'custom_plugin_func',
            'dashicons-share-alt',
//            plugins_url( 'myplugin/images/icon.png' ),
            6
        );

    }
}


function custom_plugin_func(){


    function bbloomer_customer_list() {
        $customer_query = new WP_User_Query(
            array(
                'fields' => 'ID',
                'role' => 'customer',
            )
        );
        return $customer_query->get_results();
    }


    foreach ( bbloomer_customer_list() as $customer_id ) {
        $customer = new WC_Customer( $customer_id );

//         echo $customer->email ;

        $billing_email = $skip_duplicate = array();
        $customer_orders = get_posts( array(
            'post_type'   => 'shop_order',
                'post_status' =>'wc-processing', // change accordingly
            'posts_per_page' => '3'
        ) );


        foreach( $customer_orders as $order){

            $order_id = $order->ID;

            if($order_id){

                $order = wc_get_order( $order_id );
                $bemail  = $order->get_billing_email();

                if(!in_array($bemail, $skip_duplicate)){
                    $billing_email[] = $bemail;
                    array_push($skip_duplicate,$bemail);
                }

            }
        }

        echo "<pre>";print_r($billing_email);


    }


    ?>


    <h1>The input element</h1>

    <form action="/action_page.php">
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname"><br><br>
        <label for="lname">Last name:</label>
        <input type="text" id="lname" name="lname"><br><br>

        <select id="cars">
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="opel">Opel</option>
            <option value="audi">Audi</option>
        </select>


        <input type="submit" value="Submit">
    </form>

    <?php
}


?>























