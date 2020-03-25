<?php
    /*
     * Plugin Name:       Blockspare
     * Plugin URI:
     * Description:       Elegant Page Building Blocks for WordPress
     * Version:           1.0.0
     * Author:            Blockspare
     * Author URI:        https://profiles.wordpress.org/blockspare
     * Text Domain:       blockspare
     * License:           GPL-2.0+
     * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
     */
    
    defined('ABSPATH') or die('No script kiddies please!');  // prevent direct access
    
    if (!class_exists('Blockspare')) :
        
        class Blockspare
        {
            
            
            /**
             * Plugin version.
             *
             * @var string
             */
            const VERSION = '1.0.6';
            
            /**
             * Instance of this class.
             *
             * @var object
             */
            protected static $instance = null;
            
            
            /**
             * Initialize the plugin.
             */
            public function __construct()
            {
                
                /**
                 * Define global constants
                 **/
                defined('BS_BASE_FILE') or define('BS_BASE_FILE', __FILE__);
                defined('BS_BASE_DIR') or define('BS_BASE_DIR', dirname(BS_BASE_FILE));
                defined('BS_PLUGIN_URL') or define('BS_PLUGIN_URL', plugin_dir_url(__FILE__));
                defined('BS_PLUGIN_DIR') or define('BS_PLUGIN_DIR', plugin_dir_path(__FILE__));
                
                
                include_once 'src/init.php';
                
            } // end of contructor
            
            /**
             * Return an instance of this class.
             *
             * @return object A single instance of this class.
             */
            public static function get_instance()
            {
                
                // If the single instance hasn't been set, set it now.
                if (null == self::$instance) {
                    self::$instance = new self;
                }
                return self::$instance;
            }
            
            
        }// end of the class
        
        add_action('plugins_loaded', array('Blockspare', 'get_instance'), 0);
    
    endif;
