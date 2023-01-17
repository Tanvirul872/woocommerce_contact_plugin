<?php


/**
 * Plugin Name:       Contact Woocommerece Tanvirsss
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 */


function add_theme_scripts() {
    wp_enqueue_style( 'style', PLUGINS_URL.'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css','',1 );

//    wp_enqueue_style( 'slider', get_template_directory_uri() . '/css/slider.css', array(), '1.1', 'all' );

}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );



function ti_custom_javascript() {
    ?>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        //(function ($) {
        //    $('#enquiry').submit(function (event) {
        //        event.preventDefault();
        //
        //        alert('jeeeeeee') ;
        //
        //
        //        var endpoint = '<?php //echo admin_url('admin-ajax.php'); ?>//';
        //        // var form = $('#enquiry').serialize();
        //        var form = $("#enquiry").find("input[name!='g-recaptcha-response'],textarea[name='Enquiry']").serialize();
        //        var formdata = new FormData;
        //
        //
        //
        //        formdata.append('action', 'enquiry');
        //        formdata.append('enquiry', form);
        //
        //        $('#imgenquiry').css('display', 'inline-block');
        //        $('#submit').css('display', 'none');
        //
        //
        //
        //
        //        $.ajax(endpoint, {
        //            type: 'POST',
        //            data: formdata,
        //            processData: false,
        //            contentType: false,
        //            success: function (res) {
        //
        //
        //                $("#myModal").modal('show');
        //
        //
        //                $('#imgenquiry').css('display', 'none');
        //                $('#submit').css('display', 'inline-block');
        //                $('#enquiry').fadeOut(200);
        //                // $('#success_message').text('Thanks for your enquiry').show();
        //                $('#enquiry').trigger('reset');
        //                $('#enquiry').fadeIn(500);
        //
        //            },
        //
        //            error: function (err) {
        //
        //            }
        //        })
        //
        //    })
        //})(jQuery)


        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });


    </script>
    <?php
}
add_action('admin_enqueue_scripts', 'ti_custom_javascript');




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
            'post_status' =>'wc-processing','wc-completed', // change accordingly
//            'posts_per_page' => '3'
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


    <h1> Customer Email </h1>

    <form action="#" id="enquiry">

        <label for="c_mail"> Customer Email :</label>
        <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
            <?php foreach($billing_email as $billing_emails){ ?>
              <option value="<?php echo $billing_emails ; ?>"><?php echo $billing_emails ; ?></option>
            <?php  }  ?>
        </select>


        <input type="submit" value="Submit">
    </form>

    <?php
}


?>























