<?php
Class Bs_image_conparison_shortcode {

    public function __construct() {
        
        add_shortcode('bs_image_comparison', array($this, 'show_shortcode_bs_image_comparison'));
        add_action('wp_enqueue_scripts', array($this, 'bs_image_comparison_enqueue_scripts'));
    }

    private function bs_image_comparison($atts, $content = NULL) {
        extract(shortcode_atts(
                        array(
            'id' => '',
                        ), $atts)
        );
        $query_args = array(
            'p' => (!empty($id)) ? $id : -1,
            'posts_per_page' => -1,
            'post_type' => 'bs_img_comparison',
            'order' => 'DESC',
            'orderby' => 'menu_order',
        );
        $wp_query = new WP_Query($query_args);
        if ($wp_query->have_posts()):while ($wp_query->have_posts()) : $wp_query->the_post();
                return $data_tables = get_post_meta($id, '_bs_img_comparison', true);
            endwhile;
        else: echo 'No Image Slider Found';
        endif;
    }
    
    public function show_shortcode_bs_image_comparison($atts, $content = NULL) {
        $data_values = $this->bs_image_comparison($atts, $content = NULL);
        ob_start();
        ?>
        <figure class="cd-image-container">
            <img src="<?php echo $data_values[0]['bs_img_comparison_before']; ?>" alt="Original Image">
            <span class="cd-image-label" data-type="original">Original</span>

            <div class="cd-resize-img"> <!-- the resizable image on top -->
                <img src="<?php echo $data_values[1]['bs_img_comparison_after'];?>" alt="Modified Image">
                <span class="cd-image-label" data-type="modified">Modified</span>
            </div>
            <span class="cd-handle"></span>
        </figure>
        <?php
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }

    public function bs_image_comparison_enqueue_scripts() {
        wp_enqueue_style('bs_table_css', plugin_dir_url(__FILE__) . 'css/style.css');
        wp_enqueue_script('bs_imgae_comparison_js', plugin_dir_url(__FILE__) . 'js/main.js', array('jquery'), true);
    }

}

new Bs_image_conparison_shortcode();


