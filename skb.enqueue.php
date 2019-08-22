<?php

function skb_styles() {
	wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css');

	wp_register_style('skb-filters-style', SKB_ROOTURL ."dist/css/skb-filter.styles.css");
}
add_action( 'wp_enqueue_scripts', 'skb_styles' );
add_action( 'admin_enqueue_scripts', 'skb_styles' );

function skb_scripts() {
	// General Functions
	wp_register_script('skb-functions-script', SKB_ROOTURL ."skb.functions.js", array('jquery'), null, true);

	// SKB-FILTER skb.filter.js
	wp_register_script('skb-filter-script', SKB_ROOTURL ."skb-filter/skb.filter.js", array('skb-functions-script'), null, true);
}
add_action( 'wp_enqueue_scripts', 'skb_scripts' );
add_action( 'admin_enqueue_scripts', 'skb_scripts' );