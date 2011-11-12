<?php
/**
 * Explody Bits Wordpress Ajax Widget Class
 * 
 * PHP version 5
 * 
 * @category Wordpress
 * @package XbWidgetAjax
 * @author Matthew Hail <matt@oneuplogic.com>
 * @copyright 2011 One Up Logic LLC.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPL 2.0
 * @version 0.1
 * 
 */


/**
 * Wordpress Ajax Widget Class
 */
class Xb_Widget_Ajax extends WP_Widget {
    
    /**
     * Action calback for detecting ajax callback
     * @return void
     */
    public static function action_init() {
        $widget = $_GET['widget_ajax'];
        $nonce = $_GET['nonce'];
        
        if (isset($widget)) {
            if (wp_verify_nonce($nonce, $widget) && class_exists($widget) && is_subclass_of($widget, __CLASS__)) {
                $class = new $widget(false, 'widget');
                $id = $_GET['widget_id'];
                if (isset ($id)) {
                    $class->id = $id;
                }
                
                do_action( 'xb_widget_ajax', $widget, $class );
                
                call_user_func(array($class, 'ajax'));
            }

            exit(0);
        }
    }

    /**
     * Initializes the ajax callback
     * @uses add_action
     * @return void
     */
    public static function load() {
        add_action('init',  array(__CLASS__, 'action_init'));
    }

    /**
     * Ajax calback method
     * @return void
     */
    public function ajax() {
        wp_die('ajax_url method was not defined in derived widget class');
    }

    /**
     * Creates the ajax callback url
     * @param string $widget
     * @return string
     *
     * @uses add_query_arg
     * @uses wp_create_nonce
     */
    protected function ajax_url($widget = __CLASS__) {
        return add_query_arg( array(
            'widget_ajax' => $widget,
            'widget_id' => $this->id,
            'nonce' => wp_create_nonce($widget)
        ));
    }
}