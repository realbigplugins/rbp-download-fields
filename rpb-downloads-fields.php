<?php
/**
 * Plugin Name: RBP Downloads Fields
 * Description: Adds Additional Metaboxes for EDD's "Downloads" Post Type
 * Version: 0.2.0
 * Author: Eric Defore
 * Author URI: http://realbigmarketing.com
 * Text Domain: rbp-downloads-fields
 */

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

class RBP_Downloads_Fields {
    
    /**
     * @var         RBP_Downloads_Fields $instance The one true RBP_Downloads_Fields
     * @since       0.1.0
     */
    private static $instance;
    
    /**
     * @var         Used for Localization
     * @since       0.1.0
     */
    public static $plugin_id = 'rbp-downloads-fields';

    private function __clone() {}

    private function __wakeup() {}

    /**
     * Get active instance
     *
     * @access      public
     * @since       0.1.0
     * @return      object self::$instance The one true RBP_Downloads_Fields
     */
    public static function get_instance() {

        if ( ! self::$instance ) {
            self::$instance = new RBP_Downloads_Fields();
            self::$instance->hooks();
        }
        
        return self::$instance;

    }
    
    /**
     * Run action and filter hooks
     *
     * @access      private
     * @since       0.1.0
     * @return      void
     */
    private function hooks() {
        
        // Doing this within a Hook so I have access to some other WP functions
        add_action( 'init', array( $this, 'setup_constants' ) );
        
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        
    }
    
    /**
     * Setup plugin constants
     *
     * @access      public
     * @since       0.1.0
     * @return      void
     */
    public function setup_constants() {
		
		// WP Loads things so weird. I really want this function.
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}
        
        $plugin_data = get_plugin_data( __FILE__ );
        
        // Plugin version
        define( 'RBP_Downloads_Fields_VER', $plugin_data['Version'] );
        
        // Plugin path
        define( 'RBP_Downloads_Fields_DIR', plugin_dir_path( __FILE__ ) );
        
        // Plugin URL
        define( 'RBP_Downloads_Fields_URL', plugin_dir_url( __FILE__ ) );
        
    }
    
    /**
     * Add a bunch of metaboxes to the Downloads Post Type
     * 
     * @access      public
     * @since       0.1.0
     * @return      void
     */
    public function add_meta_boxes() {
        
        add_meta_box(
            RBP_Downloads_Fields::$plugin_id . '_testimonials_meta_box', // Metabox ID
            sprintf( __( '%1$s Testimonials', 'easy-digital-downloads' ), edd_get_label_singular(), edd_get_label_plural() ), // Metabox Label
            array( $this, 'testimonial_meta_box' ), // Callback function to populate Meta Box
            'download',
            'normal', // Position
            'high' // Priority
        );

        add_meta_box(
            RBP_Downloads_Fields::$plugin_id . '_features_meta_box', // Metabox ID
            sprintf( __( '%1$s Features', 'easy-digital-downloads' ), edd_get_label_singular(), edd_get_label_plural() ), // Metabox Label
            array( $this, 'features_meta_box' ), // Callback function to populate Meta Box
            'download',
            'normal', // Position
            'high' // Priority
        );

        add_meta_box(
            RBP_Downloads_Fields::$plugin_id . '_video_meta_box', // Metabox ID
            sprintf( __( '%1$s Video', 'easy-digital-downloads' ), edd_get_label_singular(), edd_get_label_plural() ), // Metabox Label
            array( $this, 'video_meta_box' ), // Callback function to populate Meta Box
            'download',
            'normal', // Position
            'high' // Priority
        );

        add_meta_box(
            RBP_Downloads_Fields::$plugin_id . '_requires_meta_box', // Metabox ID
            sprintf( __( '%1$s Requirements', 'easy-digital-downloads' ), edd_get_label_singular(), edd_get_label_plural() ), // Metabox Label
            array( $this, 'requires_meta_box' ), // Callback function to populate Meta Box
            'download',
            'normal', // Position
            'high' // Priority
        );
        
        add_meta_box(
            RBP_Downloads_Fields::$plugin_id . '_banner_colors', // Metabox ID
            sprintf( __( '%1$s Banner Colors', 'easy-digital-downloads' ), edd_get_label_singular(), edd_get_label_plural() ), // Metabox Label
            array( $this, 'banner_colors' ), // Callback function to populate Meta Box
            'download',
            'side', // Position
            'default' // Priority
        );
        
    }
    
    /**
     * Metabox callback for Download Testimonials
     * 
     * @access      public
     * @since       0.1.0
     * @return      void
     */
    public function testimonial_meta_box() {
    
        rbm_do_field_repeater( 'testimonials', false, array(
            'name' => array(
                'type' => 'text',
                'label' => __( 'Name', RBP_Downloads_Fields::$plugin_id ),
            ),
            'company' => array(
                'type' => 'text',
                'label' => __( 'Company', RBP_Downloads_Fields::$plugin_id ),
            ),
            'gravatar_email' => array(
                'type' => 'text',
                'label' => __( 'Gravatar E-mail', RBP_Downloads_Fields::$plugin_id ),
            ),
            'content' => array( 
                'type' => 'wysiwyg',
                'label' => __( 'Content', RBP_Downloads_Fields::$plugin_id ),
                'wysiwyg_args' => array(
                    'tinymce' => true,
                    'quicktags' => true,
                ),
            ),
        ) );
        
    }
    
    /**
     * Metabox callback for Download Features
     * 
     * @access      public
     * @since       0.1.0
     * @return      void
     */
    public function features_meta_box() {

        rbm_do_field_repeater( 'features', false, array(
            'image' => array(
                'type' => 'image',
                'label' => __( 'Image - Recommended Size: 1000px * 750px', RBP_Downloads_Fields::$plugin_id ),
                false,
                array(
                    'preview' => 'thumbnail',
                )
            ),
            'title' => array( 
                'type' => 'text',
                'label' => __( 'Title', RBP_Downloads_Fields::$plugin_id ),
            ),
            'content' => array( 
                'type' => 'wysiwyg',
                'label' => __( 'Content', RBP_Downloads_Fields::$plugin_id ),
                'wysiwyg_args' => array(
                    'tinymce' => true,
                    'quicktags' => true,
                ),
            ),
        ) );

    }
    
    /**
     * Metabox callback for the Download Video URL
     * 
     * @access      public
     * @since       0.1.0
     * @return      void
     */
    public function video_meta_box() {

        rbm_do_field_text( 'video', 'Video URL' );

    }
    
    /**
     * Metabox callback for Download Requirements
     * 
     * @access      public
     * @since       0.1.0
     * @return      void
     */
    public function requires_meta_box() {

        rbm_do_field_repeater( 'requirements', false, array(
            'requirement' => array(
                'type' => 'text',
                'label' => __( 'Requirement', RBP_Downloads_Fields::$plugin_id ),
            ),
        ) );

    }
    
    public function banner_colors() {
        
        rbm_do_field_colorpicker( 'primary_color', _x( 'Primary Color', 'Primary Color Label', RBP_Downloads_Fields::$plugin_id ), false, array(
            'description' => _x( 'Should match the background color of the Download Image', 'Primary Color Description', RBP_Downloads_Fields::$plugin_id ),
            'default' => '#12538f',
        ) );
        
        rbm_do_field_colorpicker( 'secondary_color', _x( 'Secondary Color', 'Secondary Color Label', RBP_Downloads_Fields::$plugin_id ), false, array(
            'description' => _x( 'Accent Color used for Borders and Drop Shadows', 'Secondary Color Description', RBP_Downloads_Fields::$plugin_id ),
            'default' => '#51a0e9',
        ) );
        
    }
    
    /**
     * Error Message if dependencies aren't met
     * 
     * @access      public
     * @since       0.1.0
     * @return      void
     */
    public static function missing_dependencies() { ?>

        <div class="notice notice-error">
            <p>
                <?php printf( __( 'To use the %s Plugin, both %s and %s must be active as either a Plugin or a Must Use Plugin!', RBP_Downloads_Fields::$plugin_id ), '<strong>RBP Downloads Fields</strong>', '<a href="//github.com/realbig/rbm-field-helpers/" target="_blank">RBM Field Helpers</a>', '<a href="//wordpress.org/plugins/easy-digital-downloads/" target="_blank">Easy Digital Downloads</a>' ); ?>
            </p>
        </div>
        
        
        <?php
    }

}

/**
 * The main function responsible for returning the one true RBP_Downloads_Fields
 * instance to functions everywhere
 *
 * @since       0.1.0
 * @return      \RBP_Downloads_Fields The one true RBP_Downloads_Fields
 */
add_action( 'plugins_loaded', function() {

    if ( ! class_exists( 'Easy_Digital_Downloads' ) || ! class_exists( 'RBM_FieldHelpers' ) ) {

        add_action( 'admin_notices', array( 'RBP_Downloads_Fields', 'missing_dependencies' ) );

    }
    else {
        
        return RBP_Downloads_Fields::get_instance();
        
    }
    
} );