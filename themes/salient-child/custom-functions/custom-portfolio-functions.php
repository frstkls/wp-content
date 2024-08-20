<?php

function custom_portfolio_masonry_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 6,
    ), $atts);

    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => $atts['count'],
    );

    $portfolio_items = get_posts($args);

    $output = '<div class="portfolio-wrap">
                 <span class="portfolio-loading"></span>
                 <div class="portfolio-items masonry isotope-activated" data-starting-filter="" data-gutter="default" data-masonry-type="default" data-ps="1" data-categories-to-show="" data-col-num="4">';
    
    foreach ($portfolio_items as $item) {
        $featured_image = get_the_post_thumbnail_url($item->ID, 'full');
        $gallery_images = get_post_meta($item->ID, '_custom_gallery', true);
        
        $output .= '<div class="portfolio-item" data-id="'. $item->ID. '">';
        $output .= '<a href="' . $featured_image . '" class="portfolio-lightbox" data-fancybox="gallery" data-caption="<h3>' . esc_attr($item->post_title) . '</h3>">';
        $output .= '<div class="element style-2" data-custom-content="">';
        $output .= '<img class="attachment-full size-full wp-post-image" src="' . $featured_image . '" alt="' . esc_attr($item->post_title) . '">';
        $output .= '<div class="work-info-bg"></div>';
        $output .= '<div class="work-info">';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</a>';
        
        if (!empty($gallery_images) && is_array($gallery_images)) {
            foreach ($gallery_images as $image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'full');
                if ($image_url) {
                    $output .= '<a href="' . $image_url . '" class="portfolio-lightbox" data-fancybox="gallery" data-caption="<h3>' . esc_attr($item->post_title) . '</h3>" style="display: none;"></a>';
                }
            }
        }
        
        $output .= '</div>';
    }
    
    $output .= '</div></div>';

    return $output; // Dit zorgt ervoor dat het HTML-output daadwerkelijk wordt weergegeven.
}

add_shortcode('portfolio_masonry', 'custom_portfolio_masonry_shortcode');
?>
