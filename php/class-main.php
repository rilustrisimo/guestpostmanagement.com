<?php
/**
 * * Main Class. Classes and functions for Labyog.
 *
 * @author    eyorsogood.com, Rouie Ilustrisimo
 * @package   Eyorsogood
 * @version   1.0.0
 */

/**
 * No direct access to this file.
 *
 * @since 1.0.0
 */
defined( 'ABSPATH' ) || die();

/**
 * Class Labyog
 */
class Theme {
    protected $user;
    protected $post_types = array(
        /**
         * added classes here
         */
        
        array(
            'post_type'		=> 'orderfields',
            'singular_name' => 'Order Field',
            'plural_name'	=> 'Order Fields',
            'menu_icon' 	=> 'dashicons-universal-access',
            'supports'		=> array( 'title', 'thumbnail')
        )
        
    );
    

    function __autoload() {
        $classes = array();

        foreach($classes as $value){
            require_once PARENT_DIR . '/php/class-'. $value .'.php';
        }
    }

	/**
	 * Constructor runs when this class instantiates.
	 *
	 * @param array $config Data via config file.
	 */
	public function __construct( array $config = array() ) {
        $this->__autoload();
        $this->initSession();
        $this->initActions();
        $this->initFilters();
        $this->user = wp_get_current_user();
    }

    protected function initActions() {
        /**
         * 
         * function should be public when adding to an action hook.
         */

        add_action('acf/save_post', array($this, 'my_save_post'));

        add_action( 'init', array($this, 'createPostTypes')); 
        add_action( 'woocommerce_cart_calculate_fees', array($this, 'prefix_add_discount_line'));
        add_action( 'woocommerce_thankyou', array($this,'woocommerce_thankyou_function'));
        
    }

    protected function initFilters() {
        /**
         * Place filters here
         */

    }

    public function woocommerce_thankyou_function( $order_id ) {
        $ofields = $_SESSION['oid'];
        $getfields = get_fields($ofields);

        $value = array(
            'no_of_articles' => $getfields['general_settings']['no_of_articles'],
            'images_per_article' => $getfields['general_settings']['images_per_article'],
            'additional_authoritymasking_links_per_article_2_authority_links' => $getfields['general_settings']['additional_authoritymasking_links_per_article_2_authority_links'],
            'niche' => $getfields['general_settings']['niche'],
            'link_type' => $getfields['general_settings']['link_type'],
            'money_keywords_anchor_text__anchor_url' => $getfields['general_settings']['money_keywords_anchor_text__anchor_url']
        );

        update_field( 'general_settings', $value, $order_id );

        $value = array(
            'rsos' => $getfields['article-level_rsos']['rsos']
        );

        update_field( 'article-level_rsos', $value, $order_id );

        $value = array(
            'additional_requests' => $getfields['additional_information']['additional_requests'],
            'client_name_for_accounting_purposes' => $getfields['additional_information']['client_name_for_accounting_purposes']
        );

        update_field( 'additional_information', $value, $order_id );
    }

    public function prefix_add_discount_line( $cart ) {
        if(isset($_SESSION['oid'])):
            //var_dump($cart);
            $fields = get_fields($_SESSION['oid']);
            $product = wc_get_product($fields['package_id']);
            $prodprice = $product->get_price();

            $noa = $fields['general_settings']['no_of_articles'];
            $wpa = $fields['general_settings']['words_per_article'];

            $new_qty = (int)$noa;

            foreach( $cart->cart_contents as $cart_item_key => $cart_item ) {
                $product_id = $cart_item['data']->get_id();
                // Check for specific product IDs and change quantity
                if( $cart_item['quantity'] != $new_qty ){
                    $cart->set_quantity( $cart_item_key, $new_qty ); // Change quantity
                }
            }

            $rate = array(
                '1100'  =>  2.5,
                '1200'  =>  5,
                '1300'  =>  7.5,
                '1400'  =>  10,
                '1500'  =>  12.5,
                '1600'  =>  15,
                '1700'  =>  17.5,
                '1800'  =>  20,
                '1900'  =>  22.5,
                '2000'  =>  25
            );

            if((int)$wpa >= 1100):
                $ratewords = $rate[$wpa] * (int)$noa;
            else:
                $ratewords = 0;
            endif;

            if($ratewords):
                $cart->add_fee( __( 'Words per Article ('.$wpa.')', 'yourtext-domain' ) , $ratewords);
            endif;

            $cart->set_total(0.00);

        endif;    
    }

    public function createQuery($posttype, $meta_query = array(), $numberposts = -1, $orderby = 'date', $order = 'DESC') {
        $args = array(
            'orderby'			=> $orderby,
            'order'				=> $order,
            'numberposts'	=> $numberposts,
            'post_type'		=> $posttype,
            'meta_query'    => array($meta_query),
            'posts_per_page' => $numberposts
        );

        $the_query = new WP_Query( $args );

        return $the_query;
    }

    public function createPostQuery($postType, $postPerPage, $pagination = false, $meta_query = array()) {
        $rows = array();
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $args = array(
            'post_type' => $postType,
            'post_status' => array('publish'),
            'posts_per_page' => $postPerPage,
            'paged' => $paged,
            'orderby'			=> 'date',
            'order'				=> 'DESC',
            'meta_query'        => $meta_query
        );

        $pagi = '';
    
        $the_query = new WP_Query( $args );
        // The Loop
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $fields = get_fields(get_the_ID());
    
                $rows[get_the_ID()] = $fields;
            } // end while
        } // endif
    
        if($pagination){
            $pagi = '<div class="pagination">'.paginate_links( array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $the_query->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'type'         => 'plain',
                'end_size'     => 2,
                'mid_size'     => 1,
                'prev_next'    => true,
                'prev_text'    => sprintf( '<i></i> %1$s', __( '<i class="fas fa-angle-double-left"></i>', 'text-domain' ) ),
                'next_text'    => sprintf( '%1$s <i></i>', __( '<i class="fas fa-angle-double-right"></i>', 'text-domain' ) ),
                'add_args'     => false,
                'add_fragment' => '',
            ) ).'</div>';
        }
    
        // Reset Post Data
        wp_reset_postdata();
    
        return array($rows, $pagi);
    }

    public function initAcfScripts(){
        return acf_form_head();
    }

    public function createAcfForm($fieldGroupId, $postType, $button = 'Submit', $redirect = null){
        return 	acf_form(array(
            'post_id'		=> 'new_post',
            'post_title'	=> false,
            'post_content'	=> false,
            'field_groups'	=> array($fieldGroupId),
            'submit_value'	=> $button,
            'new_post'		=> array(
                'post_type'		=> $postType,
                'post_status'	=> 'publish'
            ),
            'form' => true,
            'return' => (is_null($redirect))?home_url():home_url('/'.$redirect),
            'updated_message' => __("Account Created", 'acf'),
        ));
    }

    public function updateAcfForm($postid, $fieldGroupId, $button = 'Update', $redirect = null) {
        return acf_form(array(
            'post_id'		=> $postid,
            'post_title'	=> false,
            'post_content'	=> false,
            'field_groups'	=> array($fieldGroupId),
            'submit_value'	=> $button,
            'form' => true,
            'return' => (is_null($redirect))?home_url():home_url('/'.$redirect)
        ));
    }

    public function createPostTypes() {
        /*
        * Added Theme Post Types
        *
        */
        // Uncomment the $a_post_types declaration to register your custom post type
        
        $a_post_types = $this->post_types;

        if( !empty( $a_post_types ) ) {
            foreach( $a_post_types as $a_post_type ) {
                $a_defaults = array(
                    'supports'		=> $a_post_type['supports'],
                    'has_archive'	=> TRUE
                );
    
                $a_post_type = wp_parse_args( $a_post_type, $a_defaults );
    
                if( !empty( $a_post_type['post_type'] ) ) {
    
                    $a_labels = array(
                        'name'				=> $a_post_type['plural_name'],
                        'singular_name'		=> $a_post_type['singular_name'],
                        'menu_name'			=> $a_post_type['plural_name'],
                        'name_admin_bar'		=> $a_post_type['singular_name'],
                        'add_new_item'			=> 'Add New '.$a_post_type['singular_name'],
                        'new_item'			=> 'New '.$a_post_type['singular_name'],
                        'edit_item'			=> 'Edit '.$a_post_type['singular_name'],
                        'view_item'			=> 'View '.$a_post_type['singular_name'],
                        'all_items'			=> 'All '.$a_post_type['plural_name'],
                        'search_items'			=> 'Search '.$a_post_type['plural_name'],
                        'parent_item_colon'		=> 'Parent '.$a_post_type['plural_name'],
                        'not_found'			=> 'No '.$a_post_type['singular_name'].' found',
                        'not_found_in_trash'	=> 'No '.$a_post_type['singular_name'].' found in Trash'
                    );
    
                    $a_args = array(
                        'labels'				=> $a_labels,
                        'show_in_menu'			=> true,
                        'show_ui'				=> true,
                        'rewrite'				=> array( 'slug' => $a_post_type['post_type'] ),
                        'capability_type'		=> 'post',
                        'has_archive'			=> $a_post_type['has_archive'],
                        'supports'				=> $a_post_type['supports'],
                        'publicly_queryable' 	=> true,
                        'public' 				=> true,
                        'query_var' 			=> true,
                        'menu_icon'				=> $a_post_type['menu_icon']
                    );
    
                    register_post_type( $a_post_type['post_type'], $a_args );
                }
            }
        }
    }


    public function my_save_post( $post_id ) {	

        if(isset($_POST['_acf_post_id'])) {
            /**
             * get post details
             */
            $post_values = get_post($post_id);


            /**
             * bail out if not a custom type and admin
             */
            $types = array('orderfields');

            if(!(in_array($post_values->post_type, $types))){
                return;
            }

            $current_user = wp_get_current_user();

            if($_POST['_acf_post_id'] == "new_post"){
                /**
                 * applicant set values
                 */
                if($post_values->post_type == 'orderfields'){
                    /**
                     * update post
                     */

                    

                    $my_post = array(
                        'ID'           => $post_id,
                        'post_title'   => $current_user->display_name.' - '.$post_id
                    );

                    wp_update_post( $my_post );

                    $_SESSION['oid'] = $post_id;
                }

                /**
                 *  Clear POST data
                 */
                unset($_POST);

                /**
                 * notifications
                 */
         
            }
            else if($_POST['_acf_post_id'] == $post_id) {

                //Update post title
                if(isset($_POST['acf']['field_60d42d913ff5b'])){
                    $my_post = array(
                        'ID'           => $post_id,
                        'post_title'   => $current_user->display_name.' - '.$post_id
                    );
    
                    wp_update_post( $my_post );
                }

                /**
                 *  Clear POST data
                 */
                unset($_POST);

                /**
                 * notifications
                 */

            }
        }
    }

    public function initSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return true;
    }
}
