<?php

function salient_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/css/style.css', array('parent-style'));
}
add_action('wp_enqueue_scripts', 'salient_child_enqueue_styles');

require_once get_stylesheet_directory() . '/custom-functions/custom-portfolio-functions.php';

// Voeg metabox toe
function custom_gallery_metabox() {
    add_meta_box(
        'custom_gallery',
        'Project Gallery',
        'custom_gallery_callback',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'custom_gallery_metabox');

// Metabox callback functie
function custom_gallery_callback($post) {
    wp_nonce_field(basename(__FILE__), 'custom_gallery_nonce');
    $gallery_images = get_post_meta($post->ID, '_custom_gallery', true);
    ?>
    <div id="gallery_wrapper">
        <button id="add_gallery_image" class="button">Add Gallery Image</button>
        <ul id="gallery_images">
            <?php
            if (!empty($gallery_images)) {
                foreach ($gallery_images as $image) {
                    echo '<li><input type="hidden" name="custom_gallery[]" value="' . esc_attr($image) . '"><img src="' . esc_url(wp_get_attachment_url($image)) . '"><button class="remove_image button">Remove</button></li>';
                }
            }
            ?>
        </ul>
    </div>
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#add_gallery_image').on('click', function(e) {
            e.preventDefault();
            if (frame) {
                frame.open();
                return;
            }
            frame = wp.media({
                title: 'Select or Upload Images',
                button: {
                    text: 'Use this image'
                },
                multiple: true
            });
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                attachments.forEach(function(attachment) {
                    $('#gallery_images').append('<li><input type="hidden" name="custom_gallery[]" value="' + attachment.id + '"><img src="' + attachment.url + '"><button class="remove_image button">Remove</button></li>');
                });
            });
            frame.open();
        });

        $('#gallery_images').on('click', '.remove_image', function(e) {
            e.preventDefault();
            $(this).closest('li').remove();
        });
    });
    </script>
    <style>
        #gallery_images li {
            display: inline-block;
            margin-right: 10px;
        }
        #gallery_images li img {
            max-width: 100px;
            height: auto;
        }
    </style>
    <?php
}

// Sla galerijafbeeldingen op
function save_custom_gallery($post_id) {
    if (!isset($_POST['custom_gallery_nonce']) || !wp_verify_nonce($_POST['custom_gallery_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if ('portfolio' !== $_POST['post_type']) { // Pas dit aan naar je custom post type
        return $post_id;
    }
    $gallery_images = isset($_POST['custom_gallery']) ? array_map('intval', $_POST['custom_gallery']) : [];
    update_post_meta($post_id, '_custom_gallery', $gallery_images);
}
add_action('save_post', 'save_custom_gallery');

function enqueue_masonry_scripts() {
    wp_enqueue_script('masonry');
    wp_enqueue_script('custom-masonry', get_stylesheet_directory_uri() . '/js/custom-masonry.js', array('jquery', 'masonry'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_masonry_scripts');
