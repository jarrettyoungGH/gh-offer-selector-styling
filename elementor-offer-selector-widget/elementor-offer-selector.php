<?php
/**
 * Plugin Name: Elementor Offer Selector Widget GH
 * Description: A stylish custom offer selector widget for Elementor.
 * Author: JarrettYoungGH
 * Version: 1.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Register the offer selector widget
function register_offer_selector_widget($widgets_manager) {
    require_once(__DIR__ . '/widgets/offer-selector.php');
    
    if (class_exists('Offer_Selector')) {
        $widgets_manager->register(new \Offer_Selector());
    }
}
add_action('elementor/widgets/register', 'register_offer_selector_widget');

// Enqueue the CSS for the widget
function offer_selector_enqueue_styles() {
    // Only enqueue on the frontend
    if (!is_admin()) {
        wp_enqueue_style(
            'offer-selector-style', // Handle name for the CSS
            plugins_url('assets/offer-selector.css', __FILE__), // Path to the CSS file
            array(), // Dependencies (leave empty if none)
            '1.0.0' // Version for cache busting
        );
    }
}
add_action('wp_enqueue_scripts', 'offer_selector_enqueue_styles');

