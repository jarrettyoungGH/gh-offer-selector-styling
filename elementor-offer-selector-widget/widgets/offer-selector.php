<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Offer_Selector extends \Elementor\Widget_Base {

    public function get_name() {
        return 'offer_selector';
    }

    public function get_title() {
        return __('Offer Selector', 'plugin-name');
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        // Add WooCommerce Product Selector
        $this->start_controls_section(
            'product_selection',
            [
                'label' => __('Product Selection', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        // Fetch WooCommerce products
        $products = [];
        $args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];
        $loop = new WP_Query($args);
        if ($loop->have_posts()) {
            while ($loop->have_posts()) {
                $loop->the_post();
                $products[get_the_ID()] = get_the_title();
            }
            wp_reset_postdata();
        }
    
        // Add product selector control
        $this->add_control(
            'linked_product',
            [
                'label' => __('Linked WooCommerce Product', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $products,
                'description' => __('Select a WooCommerce product to link with this offer selector widget.', 'plugin-name'),
            ]
        );
    
        $this->end_controls_section(); // End Product Selection Section
    
        // Offer Selector Settings
        $this->start_controls_section(
            'offer_selector_settings',
            [
                'label' => __('Offer Selector Settings', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'products',
            [
                'label' => __('Variations', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'product_name',
                        'label' => __('Product Name', 'plugin-name'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '', // Empty default
                        'placeholder' => __('Enter product name', 'plugin-name'), // Placeholder for clarity
                    ],
                    [
                        'name' => 'regular_price',
                        'label' => __('Regular Price', 'plugin-name'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '', // Empty default
                        'placeholder' => __('Enter regular price', 'plugin-name'),
                    ],
                    [
                        'name' => 'member_price',
                        'label' => __('Member Price', 'plugin-name'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '', // Empty default
                        'placeholder' => __('Enter member price', 'plugin-name'),
                    ],
                    [
                        'name' => 'savings_amount',
                        'label' => __('Savings Amount', 'plugin-name'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '', // Empty default
                        'placeholder' => __('Enter savings amount', 'plugin-name'),
                    ],
                    [
                        'name' => 'show_savings_amount',
                        'label' => __('Show Savings Amount', 'plugin-name'),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => __('Show', 'plugin-name'),
                        'label_off' => __('Hide', 'plugin-name'),
                        'return_value' => 'yes',
                        'default' => 'yes',
                    ],
                ],
                'default' => [],
                'title_field' => '{{{ product_name }}}',
                'delete_button' => true, // Allows variations to be deleted
            ]
        );


        // Add control for default selected variation (number select)
        $this->add_control(
            'default_selected_variation',
            [
                'label' => __('Default Selected Variation', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 0,
                'description' => __('Select which variation should be selected by default when the page loads. Use the index of the variation (0-based).', 'plugin-name'),
            ]
        );


        $this->end_controls_section(); // Close offer_selector_settings section


// Product Options Container Style Section
$this->start_controls_section(
    'product_options_container_style',
    [
        'label' => __('Product Options Container', 'plugin-name'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

// Background color for product-options container
$this->add_control(
    'product_options_background_color',
    [
        'label' => __('Product Options Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-options' => 'background-color: {{VALUE}};',
        ],
    ]
);


// Padding control for product-options container
$this->add_responsive_control(
    'product_options_container_padding',
    [
        'label' => __('Padding', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .product-options' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Margin control for product-options container
$this->add_responsive_control(
    'product_options_container_margin',
    [
        'label' => __('Margin', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .product-options' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Border control for product-options container
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'product_options_container_border',
        'label' => __('Border', 'plugin-name'),
        'selector' => '{{WRAPPER}} .product-options',
    ]
);

// Border width control for product-options container
$this->add_responsive_control(
    'product_options_container_border_width',
    [
        'label' => __('Border Width', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
            '{{WRAPPER}} .product-options' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Border radius control for product-options container
$this->add_responsive_control(
    'product_options_container_border_radius',
    [
        'label' => __('Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .product-options' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Border color control for product-options container
$this->add_control(
    'product_options_container_border_color',
    [
        'label' => __('Border Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-options' => 'border-color: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();


// Product Option Style Section

$this->start_controls_section(
    'product_option_style',
    [
        'label' => __('Product Option', 'plugin-name'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

// Padding control for product-option
$this->add_responsive_control(
    'product_option_padding',
    [
        'label' => __('Padding', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .product-option' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Margin control for product-option
$this->add_responsive_control(
    'product_option_margin',
    [
        'label' => __('Margin', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .product-option' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Background color control for product-option
$this->add_control(
    'product_option_background_color',
    [
        'label' => __('Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-option' => 'background-color: {{VALUE}};',
        ],
    ]
);

// Hover state background color control
$this->add_control(
    'product_option_hover_background_color',
    [
        'label' => __('Hover Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-option:hover' => 'background-color: {{VALUE}};',
        ],
    ]
);

// Hover state border color control
$this->add_control(
    'product_option_hover_border_color',
    [
        'label' => __('Hover Border Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-option:hover' => 'border-color: {{VALUE}};',
        ],
    ]
);

// Selected state background color control
$this->add_control(
    'product_option_selected_background_color',
    [
        'label' => __('Selected Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-option.selected' => 'background-color: {{VALUE}};',
        ],
    ]
);

// Selected state border color control
$this->add_control(
    'product_option_selected_border_color',
    [
        'label' => __('Selected Border Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-option.selected' => 'border-color: {{VALUE}};',
        ],
    ]
);

// Border control for product-option
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'product_option_border',
        'label' => __('Border', 'plugin-name'),
        'selector' => '{{WRAPPER}} .product-option',
    ]
);

// Add border width control for product-option
$this->add_responsive_control(
    'product_option_border_width',
    [
        'label' => __('Border Width', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
            '{{WRAPPER}} .product-option' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Add border radius control for product-option
$this->add_responsive_control(
    'product_option_border_radius',
    [
        'label' => __('Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .product-option' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


        // Product Option Radio Button Style Section
$this->start_controls_section(
    'product_option_radio_style',
    [
        'label' => __('Product Option Radio Button', 'plugin-name'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

// Radio Button Border Width Control
$this->add_responsive_control(
    'radio_border_width',
    [
        'label' => __('Radio Border Width', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 10,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .product-options input[type="radio"]' => 'border-width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

// Radio Button Border Color Control (unselected)
$this->add_control(
    'radio_border_color',
    [
        'label' => __('Radio Border Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-options input[type="radio"]' => 'border-color: {{VALUE}};',
        ],
    ]
);

// Radio Button Selected Border Color Control
$this->add_control(
    'radio_selected_border_color',
    [
        'label' => __('Radio Selected Border Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-options input[type="radio"]:checked' => 'border-color: {{VALUE}};',
        ],
    ]
);

// Radio Button Width Control
$this->add_responsive_control(
    'radio_button_width',
    [
        'label' => __('Radio Button Width', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 10,
                'max' => 50,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .product-options input[type="radio"]' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

// Radio Button Height Control
$this->add_responsive_control(
    'radio_button_height',
    [
        'label' => __('Radio Button Height', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 10,
                'max' => 50,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .product-options input[type="radio"]' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);


// Radio Button Selected Background Color Control
$this->add_control(
    'radio_selected_background_color',
    [
        'label' => __('Selected Radio Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .product-options input[type="radio"]:checked::after' => 'background-color: {{VALUE}};',
        ],
    ]
);


// Radio Button Inner Circle Size Control
$this->add_responsive_control(
    'radio_inner_circle_size',
    [
        'label' => __('Radio Inner Circle Size', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['%'],
        'range' => [
            '%' => [
                'min' => 10,
                'max' => 90,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .product-options input[type="radio"]:checked::after' => 'width: {{SIZE}}%; height: {{SIZE}}%;',
        ],
    ]
);



$this->end_controls_section();

    

        // Styling controls for Product Name
        $this->start_controls_section(
            'product_name_style',
            [
                'label' => __('Product Name', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'product_name_color',
            [
                'label' => __('Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_name_typography',
                'selector' => '{{WRAPPER}} .product-name',
            ]
        );

        $this->add_responsive_control(
            'product_name_padding',
            [
                'label' => __('Padding', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'product_name_margin',
            [
                'label' => __('Margin', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'product_name_background_color',
            [
                'label' => __('Background Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-name' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_name_hover_color',
            [
                'label' => __('Hover Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Border Type Control
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'product_name_border',
        'label' => __('Border', 'plugin-name'),
        'selector' => '{{WRAPPER}} .product-name',
    ]
);

// Border Radius Control
$this->add_responsive_control(
    'product_name_border_radius',
    [
        'label' => __('Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .product-name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

        $this->end_controls_section();


        // Styling controls for Regular Price
        $this->start_controls_section(
            'regular_price_style',
            [
                'label' => __('Regular Price', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'regular_price_color',
            [
                'label' => __('Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-regular-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'regular_price_typography',
                'selector' => '{{WRAPPER}} .product-regular-price',
            ]
        );

        $this->add_responsive_control(
            'regular_price_padding',
            [
                'label' => __('Padding', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-regular-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'regular_price_margin',
            [
                'label' => __('Margin', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-regular-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'regular_price_background_color',
            [
                'label' => __('Background Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-regular-price' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'regular_price_hover_color',
            [
                'label' => __('Hover Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-regular-price:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Regular Price Border Controls
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'regular_price_border',
        'label' => __('Border', 'plugin-name'),
        'selector' => '{{WRAPPER}} .product-regular-price',
    ]
);

// Border Radius Control for Regular Price
$this->add_responsive_control(
    'regular_price_border_radius',
    [
        'label' => __('Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .product-regular-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);


        $this->end_controls_section();

        // Member Price Style Section
$this->start_controls_section(
    'member_price_style',
    [
        'label' => __('Member Price', 'plugin-name'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

// Color Control
$this->add_control(
    'member_price_color',
    [
        'label' => __('Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .member-price-message p' => 'color: {{VALUE}};',
        ],
    ]
);

// Typography Control
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'member_price_typography',
        'label' => __('Typography', 'plugin-name'),
        'selector' => '{{WRAPPER}} .member-price-message p',
    ]
);

// Padding Control
$this->add_responsive_control(
    'member_price_padding',
    [
        'label' => __('Padding', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .member-price-message p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Margin Control
$this->add_responsive_control(
    'member_price_margin',
    [
        'label' => __('Margin', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .member-price-message p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Background Color Control
$this->add_control(
    'member_price_background_color',
    [
        'label' => __('Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .member-price-message p' => 'background-color: {{VALUE}};',
        ],
    ]
);

// Hover Color Control
$this->add_control(
    'member_price_hover_color',
    [
        'label' => __('Hover Text Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .member-price-message p:hover' => 'color: {{VALUE}};',
        ],
    ]
);

// Member Price Border Controls
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'member_price_border',
        'label' => __('Border', 'plugin-name'),
        'selector' => '{{WRAPPER}} .member-price-message p',
    ]
);

// Border Radius Control for Member Price
$this->add_responsive_control(
    'member_price_border_radius',
    [
        'label' => __('Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .member-price-message p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);


$this->end_controls_section(); // End Member Price Style section


// Styling controls for Savings Amount
$this->start_controls_section(
    'savings_amount_style',
    [
        'label' => __('Savings Amount', 'plugin-name'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'savings_amount_color',
    [
        'label' => __('Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .savings-message' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'savings_amount_typography',
        'label' => __('Typography', 'plugin-name'),
        'selector' => '{{WRAPPER}} .savings-message',
    ]
);

$this->add_responsive_control(
    'savings_amount_padding',
    [
        'label' => __('Padding', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .savings-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'savings_amount_margin',
    [
        'label' => __('Margin', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .savings-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'savings_amount_background_color',
    [
        'label' => __('Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .savings-message' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'savings_amount_hover_color',
    [
        'label' => __('Hover Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .savings-message:hover' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'savings_amount_border',
        'label' => __('Border', 'plugin-name'),
        'selector' => '{{WRAPPER}} .savings-message',
    ]
);

$this->add_responsive_control(
    'savings_amount_border_radius',
    [
        'label' => __('Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .savings-message' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();


        // Styling controls for Add to Cart Button
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => __('Add to Cart Button', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Button Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Typography', 'plugin-name'),
                'selector' => '{{WRAPPER}} .add-to-cart',
            ]
        );        

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Hover Background Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => __('Hover Text Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Border', 'plugin-name'),
                'selector' => '{{WRAPPER}} .add-to-cart',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => __('Margin', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );        

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );        

        $this->end_controls_section();

// Logged Out Message Style Section
$this->start_controls_section(
    'logged_out_message_style',
    [
        'label' => __('Logged Out Message', 'plugin-name'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'logged_out_message_margin',
    [
        'label' => __('Margin', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'logged_out_message_padding',
    [
        'label' => __('Padding', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'logged_out_message_border',
        'label' => __('Border', 'plugin-name'),
        'selector' => '{{WRAPPER}} .logged-out-message-container',
    ]
);

$this->add_responsive_control(
    'logged_out_message_border_width',
    [
        'label' => __('Border Width', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'logged_out_message_border_color',
    [
        'label' => __('Border Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container' => 'border-color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'logged_out_message_border_radius',
    [
        'label' => __('Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'logged_out_background_color',
    [
        'label' => __('Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container' => 'background-color: {{VALUE}};',
        ],
    ]
);

// "Or pay member price of" Text Color
$this->add_control(
    'logged_out_message_text_color',
    [
        'label' => __('Message Text Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container p' => 'color: {{VALUE}};',
        ],
    ]
);

// "Or pay member price of" Typography
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'logged_out_message_typography',
        'selector' => '{{WRAPPER}} .logged-out-message-container p',
    ]
);

// Member Price Text Color
$this->add_control(
    'member_price_text_color',
    [
        'label' => __('Member Price Text Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .member-price' => 'color: {{VALUE}};',
        ],
    ]
);

// Login Link Styling
$this->add_control(
    'login_link_heading',
    [
        'label' => __('Login Link', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::HEADING,
    ]
);

// Login Link Typography
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'login_link_typography',
        'selector' => '{{WRAPPER}} .logged-out-message-container .login-link',
    ]
);

// Login Link Color
$this->add_control(
    'login_link_color',
    [
        'label' => __('Link Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link' => 'color: {{VALUE}};',
        ],
    ]
);

// Login Link Background Color
$this->add_control(
    'login_link_background_color',
    [
        'label' => __('Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link' => 'background-color: {{VALUE}};',
        ],
    ]
);

// Login Link Hover Color
$this->add_control(
    'login_link_hover_color',
    [
        'label' => __('Hover Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link:hover' => 'color: {{VALUE}};',
        ],
    ]
);

// Login Link Hover Background Color
$this->add_control(
    'login_link_hover_background_color',
    [
        'label' => __('Hover Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link:hover' => 'background-color: {{VALUE}};',
        ],
    ]
);

// Login Link Border Type Control
$this->add_control(
    'login_link_border_type',
    [
        'label' => __('Login Link Border Type', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'none' => __('None', 'plugin-name'),
            'solid' => __('Solid', 'plugin-name'),
            'double' => __('Double', 'plugin-name'),
            'dotted' => __('Dotted', 'plugin-name'),
            'dashed' => __('Dashed', 'plugin-name'),
            'groove' => __('Groove', 'plugin-name'),
        ],
        'default' => 'none',
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link' => 'border-style: {{VALUE}};',
        ],
    ]
);

// Login Link Border Width Control
$this->add_responsive_control(
    'login_link_border_width',
    [
        'label' => __('Login Link Border Width', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Login Link Border Radius Control
$this->add_responsive_control(
    'login_link_border_radius',
    [
        'label' => __('Login Link Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Login Link Border Color Control
$this->add_control(
    'login_link_border_color',
    [
        'label' => __('Login Link Border Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link' => 'border-color: {{VALUE}};',
        ],
    ]
);

// Login Link Padding Control
$this->add_responsive_control(
    'login_link_padding',
    [
        'label' => __('Login Link Padding', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Login Link Margin Control
$this->add_responsive_control(
    'login_link_margin',
    [
        'label' => __('Login Link Margin', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .login-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Sign Up Link Styling
$this->add_control(
    'sign_up_link_heading',
    [
        'label' => __('Sign Up Link', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::HEADING,
    ]
);

// Sign Up Link Typography
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'sign_up_link_typography',
        'selector' => '{{WRAPPER}} .logged-out-message-container .sign-up-link',
    ]
);

// Sign Up Link Color
$this->add_control(
    'sign_up_link_color',
    [
        'label' => __('Link Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link' => 'color: {{VALUE}};',
        ],
    ]
);

// Sign Up Link Background Color
$this->add_control(
    'sign_up_link_background_color',
    [
        'label' => __('Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link' => 'background-color: {{VALUE}};',
        ],
    ]
);

// Sign Up Link Hover Color
$this->add_control(
    'sign_up_link_hover_color',
    [
        'label' => __('Hover Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link:hover' => 'color: {{VALUE}};',
        ],
    ]
);

// Sign Up Link Hover Background Color
$this->add_control(
    'sign_up_link_hover_background_color',
    [
        'label' => __('Hover Background Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link:hover' => 'background-color: {{VALUE}};',
        ],
    ]
);

// Sign Up Link Border Type Control
$this->add_control(
    'sign_up_link_border_type',
    [
        'label' => __('Sign Up Link Border Type', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
            'none' => __('None', 'plugin-name'),
            'solid' => __('Solid', 'plugin-name'),
            'double' => __('Double', 'plugin-name'),
            'dotted' => __('Dotted', 'plugin-name'),
            'dashed' => __('Dashed', 'plugin-name'),
            'groove' => __('Groove', 'plugin-name'),
        ],
        'default' => 'none',
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link' => 'border-style: {{VALUE}};',
        ],
    ]
);

// Sign Up Link Border Width Control
$this->add_responsive_control(
    'sign_up_link_border_width',
    [
        'label' => __('Sign Up Link Border Width', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Sign Up Link Border Radius Control
$this->add_responsive_control(
    'sign_up_link_border_radius',
    [
        'label' => __('Sign Up Link Border Radius', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Sign Up Link Border Color Control
$this->add_control(
    'sign_up_link_border_color',
    [
        'label' => __('Sign Up Link Border Color', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link' => 'border-color: {{VALUE}};',
        ],
    ]
);

// Sign Up Link Padding Control
$this->add_responsive_control(
    'sign_up_link_padding',
    [
        'label' => __('Sign Up Link Padding', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Sign Up Link Margin Control
$this->add_responsive_control(
    'sign_up_link_margin',
    [
        'label' => __('Sign Up Link Margin', 'plugin-name'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors' => [
            '{{WRAPPER}} .logged-out-message-container .sign-up-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();



    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        echo '<div class="ghm-offer-selector">';
        echo '<div class="product-options">';
    
        // Loop through each product and display
        foreach ($settings['products'] as $index => $product) {
            $checked = ($settings['default_selected_variation'] !== 'none' && $index == $settings['default_selected_variation']) ? 'checked' : ''; // Select which variation is checked
            echo '<div class="product-option">';
            echo '<input type="radio" id="product_' . $index . '" name="product_option" ' . $checked . ' ';
            echo 'data-regular-price="' . esc_attr($product['regular_price']) . '" ';
            echo 'data-member-price="' . esc_attr($product['member_price']) . '" />';
            echo '<label for="product_' . $index . '" class="product-label">';
            echo '<span class="custom-radio"></span>'; // Custom radio button element
            echo '<div class="product-info-container">';
            echo '<div class="product-details">';
            echo '<div class="product-name">' . esc_html($product['product_name']) . '</div>';
            echo '<div class="pricing-info">';
            // Add the condition here to show the savings amount if enabled
    if ($product['show_savings_amount'] === 'yes') {
        echo '<span class="savings-message">' . esc_html($product['savings_amount']) . '</span>';
    }
            echo '<span class="product-regular-price">' . esc_html($product['regular_price']) . '</span>';
            echo '</div>'; // End pricing-info
            echo '</div>'; // End product-details
            echo '<div class="member-price-message">';
            echo '<p>Or ' . esc_html($product['member_price']) . ' with a free account</p>';
            echo '</div>'; // End member-price-message
            echo '</div>'; // End product-info-container
            echo '</label>';
            echo '</div>'; // End product-option
        }

        echo '</div>'; // End .product-options

        // Add the data-price elements in the button and message for JavaScript to target
        echo '<div class="button-container">';
        echo '<button class="add-to-cart">Add to Cart - <span class="cart-price">$79.95</span></button>';
        echo '</div>';

        echo '<div class="logged-out-message-container">';
        echo '<div class="member-price-message">';
        echo '<p>Or pay member price of <span class="member-price">$49.95</span></p>';
        echo '</div>';
        echo '<div class="auth-links">';
        echo '<a href="#" class="login-link">Log In</a> or <a href="#" class="sign-up-link">Sign Up</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>'; // End .ghm-offer-selector

        // Inline JavaScript to handle price changes
        ?>

        
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('.ghm-offer-selector input[name="product_option"]');
        const productOptions = document.querySelectorAll('.product-option');
        const cartPriceElement = document.querySelector('.ghm-offer-selector .cart-price');
        const addToCartButton = document.querySelector('.ghm-offer-selector .add-to-cart');
        const loggedOutMessageContainer = document.querySelector('.ghm-offer-selector .logged-out-message-container');
        const memberPriceElement = document.querySelector('.ghm-offer-selector .member-price');

        // Hide the Add to Cart button and logged out message initially
        addToCartButton.style.display = 'none';
        loggedOutMessageContainer.style.display = 'none';

        // Function to update prices when a radio button is selected
        function updatePrices(regularPrice, memberPrice) {
            cartPriceElement.textContent = regularPrice ? regularPrice : '';
            memberPriceElement.textContent = memberPrice ? memberPrice : '';

            if (regularPrice) {
                addToCartButton.style.display = 'inline-block';
                loggedOutMessageContainer.style.display = 'block';
            } else {
                addToCartButton.style.display = 'none';
                loggedOutMessageContainer.style.display = 'none';
            }
        }

        // Add event listener for radio buttons to update prices and class
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    const regularPrice = this.getAttribute('data-regular-price');
                    const memberPrice = this.getAttribute('data-member-price');
                    updatePrices(regularPrice, memberPrice);

                    // Remove 'selected' class from all product options
                    productOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add 'selected' class to the parent product option
                    const parentOption = radio.closest('.product-option');
                    if (parentOption) {
                        parentOption.classList.add('selected');
                    }
                }
            });
        });

        // Add click event to product options to select the radio button
        productOptions.forEach(option => {
            option.addEventListener('click', function () {
                const radioButton = this.querySelector('input[type="radio"]');
                if (radioButton) {
                    radioButton.checked = true;

                    // Remove 'selected' class from all product options
                    productOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add 'selected' class to the clicked product option
                    this.classList.add('selected');

                    // Update prices
                    const regularPrice = radioButton.getAttribute('data-regular-price');
                    const memberPrice = radioButton.getAttribute('data-member-price');
                    updatePrices(regularPrice, memberPrice);
                }
            });
        });

        // Update prices for the initially checked radio button and add 'selected' class
        const initialChecked = document.querySelector('.ghm-offer-selector input[name="product_option"]:checked');
        if (initialChecked) {
            const initialRegularPrice = initialChecked.getAttribute('data-regular-price');
            const initialMemberPrice = initialChecked.getAttribute('data-member-price');
            updatePrices(initialRegularPrice, initialMemberPrice);

            const initialParentOption = initialChecked.closest('.product-option');
            if (initialParentOption) {
                initialParentOption.classList.add('selected');
            }
        } else {
            // If no option is checked, hide the add-to-cart button and logged out message container
            updatePrices(null, null);
        }
    });
</script>

        <?php
    }

    protected function content_template() {}
}