<?php
/*
 * Explody Bits Wordpress Ajax Widget Demo
 * 
 * PHP version 5
 * 
 * @category Wordpress
 * @package xb-widget-ajax-demo
 * @author Matthew Hail <matt@oneuplogic.com>
 * @copyright 2011 One Up Logic LLC.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPL 2.0
 * @version 0.1
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

// Derived from Wordpress codex example (http://codex.wordpress.org/Widgets_API#Developing_Widgets)
class Xb_Widget_Ajax_Demo extends Xb_Widget_Ajax {
    
    /** constructor */
    function __construct() {
            parent::__construct( 'xb_widget_ajax_demo', __CLASS__, array( 'description' => 'Xb Widget Ajax Demo' ) );

    }

    /** @see WP_Widget::widget */
    function widget( $args, $instance ) {
            extract( $args );
            $title = apply_filters( 'widget_title', $instance['title'] );
            echo $before_widget;
            if ( $title )
                    echo $before_title . $title . $after_title; 
            ?>
                    <a href="#" title="Call ajax" class="ajax-button">Update</a>
                    <div class="widget-content">

                    </div>
                    <script type="text/javascript">
                    ///<![CDATA[
                    (function($) {

                        $(function(e)
                        {
                            var widget = $('#<?php echo $widget_id ?>');
                            var div = $('.widget-content', widget);
                            var ajax_url = '<?php echo $this->ajax_url() ?>';

                            $('a.ajax-button', widget).click(function() {

                               $.ajax({
                                  url: ajax_url,
                                  cache: false,
                                  success: function(html){
                                    div.html(html);
                                  }
                               });
                               
                               // Cancel the click
                               return false;
                            });
                        });
                    })(jQuery);
                    ///]]>
                    </script>
            <?php 
            echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
            if ( $instance ) {
                $title = esc_attr( $instance[ 'title' ] );
            }
            else {
                $title = __( 'Xb Wiget Ajax Demo', 'text_domain' );
            }
            
            $title_id = $this->get_field_id('title');
            $title_name = $this->get_field_name('title');
            
            ?>
            <p>
            <label for="<?php echo $title_id; ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $title_id; ?>" name="<?php echo $title_name; ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <?php 
	}
        
    // This needs to be overridden in the derived class
    //   so that the correct widget is called by the ajax callback.  
    function ajax_url($widget = __CLASS__) {
        return parent::ajax_url($widget);
    }


    public function ajax() {
        // Do cool ajax stuff here.
        ?>
        <span>Ajax Content @ <?php echo strftime('%c'); ?></span> 
        <?php
    }
    
} 
