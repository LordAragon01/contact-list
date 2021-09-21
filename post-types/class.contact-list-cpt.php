<?php

if(!class_exists('Contact_List_Post_type')){


    class Contact_List_Post_type{

        public function __construct(){
        
            add_action( 'init', array( $this, 'create_post_type' ) );
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_post'));

            add_filter('manage_contact-list_posts_columns', array($this, 'contact_list_cpt_columns'));
            add_action('manage_contact-list_posts_custom_column', array($this, 'contact_list_custom_column'), 10, 2);
            add_filter('manage_edit-contact-list_sortable_columns', array($this, 'contact_list_sortable_columns'));

        }

        public function create_post_type(){
            register_post_type(
                'contact-list',
                array(
                    'label' => esc_html__( 'Contact List', 'contact-list' ),
                    'description'   => esc_html__( 'Contact List', 'contact-list' ),
                    'labels' => array(
                        'name'  => esc_html__( 'Contact List', 'contact-list' ),
                        'singular_name' => esc_html__( 'Contact List', 'contact-list' ),
                    ),
                    'public'    => true,
                    'supports'  => array( 'title', 'editor', 'thumbnail' ),
                    'hierarchical'  => false,
                    'show_ui'   => true,
                    'show_in_menu'  => true,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export'    => true,
                    'has_archive'   => true,
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'show_in_rest'  => true,
                    'menu_icon' => 'dashicons-list-view',
                )
            );
        }

        public function add_meta_boxes(){

            add_meta_box(
                'contact_list_meta_box',
                esc_html__('Contact List Options', 'contact-list'),
                array($this, 'add_inner_meta_boxes'),
                'contact-list', 
                'normal', 
                'high'
            );

        }

        public function add_inner_meta_boxes($post){

           
            require_once( CONTACT_LIST_PATH . 'views/contact-list_metabox.php');
        

        }

        public function contact_list_cpt_columns($columns){

            $columns['contact_list_name'] = esc_html__('Name', 'contact-list');
            $columns['contact_list_email'] = esc_html__('Email', 'contact-list');
            $columns['contact_list_number'] = esc_html__('Number', 'contact-list');

            return $columns;
        }

        public function contact_list_custom_column($column, $post_id){

            switch($column){

                case 'contact_list_name':
                    echo esc_html(get_post_meta($post_id, 'contact_list_name', true));                    
                break;    

                case 'contact_list_email':
                    echo esc_html(get_post_meta($post_id, 'contact_list_email', true));                    
                break; 

                case 'contact_list_number':
                    echo esc_html(get_post_meta($post_id, 'contact_list_number', true));                    
                break; 

            }

        }

        public function contact_list_sortable_columns($columns){

            $columns['contact_list_name'] = 'contact_list_name';
            return $columns;
        }


        public function save_post($post_id){

            //Verify Nonce
            if(isset($_POST['contact_list_nonce'])){

                if(!wp_verify_nonce($_POST['contact_list_nonce'], 'contact_list_nonce')){

                    return;
                }
                
            }

            //Auto-save verification from Wordpress
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){

                return;

            }

            //Checks if the saved data is according to the post type

            if(isset($_POST['post_type']) && $_POST['post_type'] === 'contact-list'){

                //Verificar se o usuário tem permissão para editar o Post ou Página
                if(!current_user_can('edit_page', $post_id)){

                    return;

                }elseif(!current_user_can('edit_post', $post_id)){

                    return;

                }

            }

            if(isset($_POST['action']) && $_POST['action'] == 'editpost'){

                $old_name = get_post_meta($post_id, 'contact_list_name', true);
                $new_name = $_POST['contact_list_name'];
                $old_email = get_post_meta($post_id, 'contact_list_email', true);
                $new_email = $_POST['contact_list_email'];
                $old_code = get_post_meta($post_id, 'contact_list_code_number', true);
                $new_code = $_POST['contact_list_code_number'];
                $old_number = get_post_meta($post_id, 'contact_list_number', true);
                $new_number = $_POST['contact_list_number'];
            
                $name_len = strlen($new_name);
                $number_len = strlen($new_number);

                if($name_len < 5){

                    update_post_meta($post_id, 'contact_list_name', esc_html__('Add a name with more than 5 characters', 'contact-list'));

                }else{

                    update_post_meta($post_id, 'contact_list_name', sanitize_text_field($new_name), $old_name);

                }

                if(is_email($new_email) === false){

                    update_post_meta($post_id, 'contact_list_email', esc_html__('Add a valid email address', 'contact-list'));

                }else{

                    update_post_meta($post_id, 'contact_list_email', sanitize_email($new_email), $old_email);

                }
                
                if(empty($new_code)){

                    update_post_meta($post_id, 'contact_list_code_number', esc_html__('Add a Country Code', 'contact-list'));

                }else{

                    update_post_meta($post_id, 'contact_list_code_number', sanitize_text_field($new_code), $old_code);

                }

                if(empty($new_number)){

                    update_post_meta($post_id, 'contact_list_number', esc_html__('Add only numbers with a total of 9 characters', 'contact-list'));

                }else{

                    update_post_meta($post_id, 'contact_list_number', sanitize_text_field($new_number), $old_number);

                }

                

            }


        }    


    }


}