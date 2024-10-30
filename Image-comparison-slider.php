<?php
/*
  Plugin Name: Image Comparison Slider
  Plugin URI: http://www.media-extensions.com
  Description: Thanks for installing Image Comparison Slider
  Version: 1.0
  Author: Media Extensions
  Author URI: http://www.media-extensions.com/
 */
require_once('inc/Image-comparison-slider-post.php');
require_once('Image-comparison-shortcode.php');
Class Bs_Img_Comparison{
	public function __construct(){
        $custom_post=new Bs_Img_Comparison_Post('bs-img-Comparison-slider');
        $custom_post->Bs_Make_Img_Comparison('bs_img_comparison','Responsive Image Comparison','Responsive Image Comparisons',array('supports'=>array('title')));
        add_action('admin_init', array($this, 'bs_image_comparison_metabox_feild'));
        add_action('admin_init', array($this, 'bs_image_comparison_metabox_feild_shortcode'));
        add_action('save_post', array($this, 'bs_save_image_comparison'), 10, 2);
        add_action('admin_head', array($this, 'bs_image_comparison_admin_css'));
        add_action('admin_enqueue_scripts', array($this, 'bs_image_comparison_wp_media_files'));
	}
	public function bs_image_comparison_metabox_feild() {
        add_meta_box('bs_image_comparison_meta_id', 'Add Comaparison Image', array($this, 'display_bs_image_comparison_metabox'), 'bs_img_comparison', 'normal', 'high');
    }
    public function display_bs_image_comparison_metabox($bs_img_comparison){
    	wp_nonce_field('bs_image_comparison_nonce', 'bs_image_comparison_nonce_field');
        $data_tables = get_post_meta($bs_img_comparison->ID, '_bs_img_comparison', true);
        include dirname(__FILE__) . '/inc/metabox.php';
    	
    }
    public function bs_image_comparison_metabox_feild_shortcode() {
        add_meta_box('bs_image_comparison_meta_shortcode', 'ShortCode', array($this, 'display_bs_image_comparison_shortcode'), 'bs_img_comparison', 'side', 'low');
    }
    public function display_bs_image_comparison_shortcode($bs_image_slider) {
        ?>
        <div class="bs_img_comparison_sh">
            <input type="text" class="input_shortcode_comparison" name="bs_image_slider_shortcode[]" value="[bs_image_comparison id='<?= get_the_id(); ?>']" disabled></input>
        </div>

        <?php
    }
    public function bs_save_image_comparison($post_id, $bs_img_comparison) {
    	//wp_die( '<pre>'. print_r( $bs_img_comparison, true) . '</pre>' );
        if (!isset($_POST['bs_image_comparison_nonce_field']) || !wp_verify_nonce($_POST['bs_image_comparison_nonce_field'], 'bs_image_comparison_nonce')) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        if ($bs_img_comparison->post_type == 'bs_img_comparison') { 
           if (isset($_POST['bs_image_comparison_group']) &&
                    $_POST['bs_image_comparison_group'] != '') {
                update_post_meta($post_id, '_bs_img_comparison', $_POST['bs_image_comparison_group']);
            }
        }
    }

    public function bs_image_comparison_admin_css() {
        wp_enqueue_style('bs_image_comparison_admin_css', plugin_dir_url(__FILE__) . 'css/admin_style.css');
        
    }
    public function bs_image_comparison_wp_media_files(){
    	wp_enqueue_media();
    }


}

new Bs_Img_Comparison();

?>