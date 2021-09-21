<?php

    if(!class_exists('Contact_List_Shortcode')){

        class Contact_List_Shortcode{

            public function __construct(){

                
                add_shortcode('contact-list', array($this, 'add_shortcode'));

            }

            public function add_shortcode(){

                //ob_start();
                require(CONTACT_LIST_PATH . 'views/contact-list_shortcode.php');
               /*  wp_enqueue_style('bootstrap_css');
                wp_enqueue_style('style');
                wp_enqueue_script('script');
                wp_enqueue_script('bootstrap_js'); */
                //return ob_get_clean();

            }

        }

    }