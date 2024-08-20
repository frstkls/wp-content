<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	"title" => 'Title',
	'heading_tag' => 'default',
	'heading_tag_functionality' => 'default',
	'color' => 'Accent-Color'), 
	$atts));

$typography_class = ( in_array($heading_tag, array('h2','h3','h4','h5','h6')) ) ? 'nectar-inherit-'.$heading_tag.' toggle-heading' : 'toggle-heading';

$heading_tag_html = 'h3';
if( 'change_html_tag' === $heading_tag_functionality && 
	in_array($heading_tag, array('h2','h3','h4','h5','h6','span')) ) {
		$heading_tag_html = $heading_tag;
}

echo '<div class="toggle '.esc_attr(strtolower($color)).'" data-inner-wrap="true">';
echo '<'.$heading_tag_html.' class="toggle-title">';
echo '<a href="#" role="button" class="'.$typography_class.'"><svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 275 20.89"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#00adee;}</style></defs><title>toogle</title><polygon class="cls-1" points="0 0 135.61 20.89 274.51 0 275 0 0 0 0 0"/><path class="cls-2" d="M499.64,575.84l-29.9-4.61a.61.61,0,0,1-.52-.7.62.62,0,0,1,.71-.52l29.71,4.57L530.07,570a.62.62,0,0,1,.19,1.23Z" transform="translate(-362.5 -567)"/><path class="cls-2" d="M499.64,580.43l-29.9-4.61a.61.61,0,0,1-.52-.7.62.62,0,0,1,.71-.52l29.71,4.57,30.43-4.57a.62.62,0,0,1,.19,1.23Z" transform="translate(-362.5 -567)"/></svg><br >Meer voordelen</a>';
echo '</'.$heading_tag_html.'>';
echo '<div><div class="inner-toggle-wrap">' . do_shortcode(wp_kses_post($content)) . '</div></div>';
echo '</div>';

?>
