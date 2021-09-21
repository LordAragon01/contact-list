<?php
/**
* Plugin Name: Contact List
* Plugin URI: https://www.linkedin.com/in/joene-goncalves/
* Description: The plugin will make it easier for you to manage your contacts. With this plugin you create, edit and add more than one contact per person. 
* Version: 1.0
* Requires at least: 5.6
* Requires PHP: 7.0
* Author: Joene Gonçalves
* Author URI: https://www.linkedin.com/in/joene-goncalves/
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: contact-list
* Domain Path: /languages
*/

if(!defined('ABSPATH')){
    exit;
}

if(!class_exists('Contact_List')){


    class Contact_List{


        public function __construct(){

            $this->define_constants();


            require_once(CONTACT_LIST_PATH . 'post-types/class.contact-list-cpt.php');
            $cpt = new Contact_List_Post_type();

            require_once(CONTACT_LIST_PATH . 'shortcode/class.contact-list_shortcode.php');
            $shortcode = new Contact_List_Shortcode();

            add_action('wp_enqueue_scripts', array($this, 'register_scripts'), 999);
            add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));

        }

        /**
         * Define Constants
         */
       public function define_constants(){

        define('CONTACT_LIST_PATH', plugin_dir_path(__FILE__) );
        define('CONTACT_LIST_URL', plugin_dir_url(__FILE__));
        define('CONTACT_LIST_VERSION', '1.0.0');

       }
       
       /**
        * Activate Plugin and Create Page
        */
        public static function activate(){
            update_option('rewrite_rules', '');

            global $wpdb;

            $page_name = $wpdb->get_row("SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'contact-list'");

            if($page_name === null){

                $current_user = wp_get_current_user();

                $page = array(                  
                    'post_title' => __('Contact List', 'contact-list'),
                    'post_name' => 'contact-list',
                    'post_status' => 'publish',
                    'post_author' => $current_user->ID,
                    'post_type' => 'page',
                    'post_content' => '<!-- wp:shortcode -->[contact-list]<!-- /wp:shortcode -->'
                );
                wp_insert_post($page);

            }

            
        }

        /**
         * Deactivate Plugin
         */
        public static function deactivate(){
            unregister_post_type( 'contact-list' );
            flush_rewrite_rules();
        }

        /**
         * Delete Plugin
         */
        public static function uninstall(){
       /*      delete_option('contact-list');

            $posts = get_posts(
                array(
                    'post_type' => 'contact-list',
                    'number_posts' => -1,
                    'post_status' => 'any'
                )
            );

            foreach($posts as $post){
            
                wp_delete_post($post->ID, true);

            } */


        /*     global $wpdb;

            $wpdb->query(
                "DELETE FROM $wpdb->posts
                WHERE post_type = 'page'
                AND post_name = 'contact-list'
                "
            );
 */
        }

        /**
         * Register Scripts
         */
        public static function register_scripts(){

            wp_register_style('bootstrap_css', CONTACT_LIST_URL . 'assets/css/bootstrap.min.css', array(), '4.4.1', 'all');
            wp_register_style('style', CONTACT_LIST_URL . 'assets/css/style.css', array(), CONTACT_LIST_VERSION, 'all');
            wp_register_script('bootstrap_js', CONTACT_LIST_URL . 'assets/js/bootstrap.min.js', array('jquery'), '4.4.1', true);
            wp_register_script('script', CONTACT_LIST_URL . 'assets/js/script.js', array('jquery'), CONTACT_LIST_VERSION, true);           

        }

        public function register_admin_scripts(){

           
            global $typenow;


            if($typenow == 'contact-list'){

                wp_enqueue_script('contact-list-admin-script', CONTACT_LIST_URL . 'assets/js/script.js');
                wp_enqueue_style('contact-list-admin-style', CONTACT_LIST_URL . 'assets/css/style.css');
                wp_enqueue_style('contact-list-admin-bootstrap', CONTACT_LIST_URL . 'assets/css/bootstrap.min.css');

            }

            

        }


    }

}

if(class_exists('Contact_List')){

    register_activation_hook(__FILE__, array('Contact_List', 'activate'));
    register_deactivation_hook(__FILE__, array('Contact_List', 'deactivate'));
    register_uninstall_hook(__FILE__, array('Contact_List', 'uninstall'));

    $contact_list = new Contact_List();

}