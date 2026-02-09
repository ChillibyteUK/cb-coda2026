<?php
/**
 * LC Theme Functions
 *
 * This file contains theme-specific functions and customizations for the LC Harrier 2025 theme.
 *
 * @package cb-coda2026
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require_once CB_THEME_DIR . '/inc/cb-utility.php';
require_once CB_THEME_DIR . '/inc/cb-acf-theme-palette.php';
require_once CB_THEME_DIR . '/inc/cb-posttypes.php';
require_once CB_THEME_DIR . '/inc/cb-taxonomies.php';


require_once CB_THEME_DIR . '/inc/cb-blocks.php';

/**
 * Editor styles: opt-in so WP loads editor.css in the block editor.
 * With theme.json present, this just adds your custom CSS on top (variables, helpers).
 */
add_action(
    'after_setup_theme',
    function () {
        add_theme_support( 'editor-styles' );
        add_editor_style( 'css/custom-editor-style.min.css' );
    },
    5
);

/**
 * Neutralise legacy palette/font-size support (if parent/Understrap adds them).
 * theme.json is authoritative, but some themes still register supports in PHP.
 * Remove them AFTER the parent has added them (high priority).
 */
add_action(
    'after_setup_theme',
    function () {
        remove_theme_support( 'editor-color-palette' );
        remove_theme_support( 'editor-gradient-presets' );
        remove_theme_support( 'editor-font-sizes' );
    },
    99
);

/**
 * (Optional) Ensure custom colours *aren’t* forcibly disabled by parent.
 * If Understrap disables custom colours, this re-enables them so theme.json works fully.
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' ); // performance nicety.

/**
 * Removes specific page templates from the available templates list.
 *
 * @param array $page_templates The list of page templates.
 * @return array The modified list of page templates.
 */
function child_theme_remove_page_template( $page_templates ) {
    unset(
        $page_templates['page-templates/blank.php'],
        $page_templates['page-templates/empty.php'],
        $page_templates['page-templates/left-sidebarpage.php'],
        $page_templates['page-templates/right-sidebarpage.php'],
        $page_templates['page-templates/both-sidebarspage.php']
    );
    return $page_templates;
}
add_filter( 'theme_page_templates', 'child_theme_remove_page_template' );

/**
 * Removes support for specific post formats in the theme.
 */
function remove_understrap_post_formats() {
    remove_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
add_action( 'after_setup_theme', 'remove_understrap_post_formats', 11 );
/**
 * Enqueue team filter script.
 */
add_action(
    'wp_enqueue_scripts',
    function () {
        $rel = '/js/team-filter.js';
        $abs = get_stylesheet_directory() . $rel;
        if ( file_exists( $abs ) ) {
            wp_enqueue_script(
                'hub-team-filter',
                get_stylesheet_directory_uri() . $rel,
                array(),
                filemtime( $abs ),
                true
            );
        }
    },
    20
);

/**
 * Enqueue accordion scroll script.
 */
add_action(
    'wp_enqueue_scripts',
    function () {
        $rel = '/js/accordion-scroll.js';
        $abs = get_stylesheet_directory() . $rel;
        if ( file_exists( $abs ) ) {
            wp_enqueue_script(
                'hub-accordion-scroll',
                get_stylesheet_directory_uri() . $rel,
                array(),
                filemtime( $abs ),
                true
            );
        }
    },
    20
);



if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page(
        array(
            'page_title' => 'Site-Wide Settings',
            'menu_title' => 'Site-Wide Settings',
            'menu_slug'  => 'theme-general-settings',
            'capability' => 'edit_posts',
        )
    );
}

/**
 * Initializes widgets, menus, and theme supports.
 *
 * This function registers navigation menus, unregisters sidebars and menus,
 * and adds theme support for custom editor color palettes.
 */
function widgets_init() {

    register_nav_menus(
        array(
            'primary_nav'  => __( 'Primary Nav', 'cb-coda2026' ),
            'footer_menu1' => __( 'Footer Nav 1', 'cb-coda2026' ),
            'footer_menu2' => __( 'Footer Nav 2', 'cb-coda2026' ),
        )
    );

    unregister_sidebar( 'hero' );
    unregister_sidebar( 'herocanvas' );
    unregister_sidebar( 'statichero' );
    unregister_sidebar( 'left-sidebar' );
    unregister_sidebar( 'right-sidebar' );
    unregister_sidebar( 'footerfull' );
    unregister_nav_menu( 'primary' );

    add_theme_support( 'disable-custom-colors' );
}
add_action( 'widgets_init', 'widgets_init', 11 );

// phpcs:disable
// add_filter('wpseo_breadcrumb_links', function( $links ) {
//     global $post;
//     if ( is_singular( 'post' ) ) {
//         $t = get_the_category($post->ID);
//         $breadcrumb[] = array(
//             'url' => '/guides/',
//             'text' => 'Guides',
//         );

//         array_splice( $links, 1, -2, $breadcrumb );
//     }
//     return $links;
// }
// );
// phpcs:enable


/**
 * Enqueues theme-specific scripts and styles.
 *
 * This function deregisters jQuery and disables certain styles and scripts
 * that are commented out for potential use in the theme.
 */
function hub_theme_enqueue() {
    $the_theme = wp_get_theme();

	// phpcs:disable
    // wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox-plus-jquery.min.js', array(), $the_theme->get('Version'), true);
    // wp_enqueue_script('parallax', get_stylesheet_directory_uri() . '/js/parallax.min.js', array('jquery'), null, true);
    // wp_enqueue_style( 'splide-stylesheet', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css', array(), null );
    // wp_enqueue_script( 'splide-scripts', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js', array(), null, true );
    // wp_enqueue_style('lightbox-stylesheet', get_stylesheet_directory_uri() . '/css/lightbox.min.css', array(), $the_theme->get('Version'));
    // wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox.min.js', array(), $the_theme->get('Version'), true);
    // wp_enqueue_style( 'glightbox-style', 'https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.1/css/glightbox.min.css', array(), $the_theme->get( 'Version' ) );
    // wp_enqueue_script( 'glightbox', 'https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.1/js/glightbox.min.js', array(), $the_theme->get( 'Version' ), true );
    // wp_deregister_script( 'jquery' ); // needed by gravity forms
    // phpcs:enable
}
add_action( 'wp_enqueue_scripts', 'hub_theme_enqueue' );

// Performance: Remove WordPress global styles and SVG filters (WP 6.0+).
// This prevents FOUC by removing unnecessary inline styles in the head.
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );


add_action(
    'admin_head',
    function () {
        echo '<style>
        .block-editor-page #wpwrap {
        overflow-y: auto !important;
        }
   </style>';
    }
);

/**
 * Add defer attribute to scripts for better performance.
 *
 * @param string $tag    The script tag HTML.
 * @param string $handle The script handle.
 * @return string Modified script tag.
 */
function add_defer_to_scripts( $tag, $handle ) {
    // Defer child theme scripts.
    if ( 'child-theme-scripts' === $handle ) {
        return str_replace( ' src', ' defer src', $tag );
    }

	// phpcs:disable
    // Defer jQuery when it's loaded (for Gravity Forms pages).
    // Note: This may break some plugins if they expect jQuery immediately.
    // if ( in_array( $handle, array( 'jquery-core', 'jquery-migrate' ), true ) ) {
    //     return str_replace( ' src', ' defer src', $tag );
    // }
	// phpcs:enable

    return $tag;
}
add_filter( 'script_loader_tag', 'add_defer_to_scripts', 10, 2 );

/**
 * Remove id attributes from nav menu links to prevent duplicate IDs.
 * This is necessary when using the same menu in both desktop and mobile (offcanvas) views.
 *
 * @param array $atts HTML attributes applied to the anchor element.
 * @return array Modified attributes without id.
 */
function remove_nav_menu_item_id( $atts ) {
    unset( $atts['id'] );
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'remove_nav_menu_item_id' );


// ===========================================================================
// Gravity Forms WCAG 2.1 AA 1.3.5 Compliance - Add autocomplete attributes
// ===========================================================================

/**
 * Add autocomplete attributes to Gravity Forms fields for WCAG 2.1 AA 1.3.5 compliance.
 *
 * @param string $field_content The field HTML content.
 * @param object $field         The field object.
 * @return string Modified field HTML with autocomplete attribute.
 */
function add_autocomplete_to_gform_fields( $field_content, $field ) {
	// Map Gravity Forms field labels to autocomplete values.
	$autocomplete_map = array(
		// Name fields.
		'name'         => 'name',
		'first name'   => 'given-name',
		'first'        => 'given-name',
		'last name'    => 'family-name',
		'last'         => 'family-name',
		'full name'    => 'name',

		// Contact fields.
		'email'        => 'email',
		'phone'        => 'tel',
		'telephone'    => 'tel',
		'mobile'       => 'tel-national',

		// Address fields.
		'address'      => 'street-address',
		'street'       => 'address-line1',
		'city'         => 'address-level2',
		'state'        => 'address-level1',
		'zip'          => 'postal-code',
		'postcode'     => 'postal-code',
		'country'      => 'country-name',

		// Company fields.
		'company'      => 'organization',
		'organization' => 'organization',

		// Other common fields.
		'job title'    => 'organization-title',
		'website'      => 'url',
	);

	// Get field label in lowercase for comparison.
	$field_label = strtolower( trim( $field->label ) );

	// Determine autocomplete value.
	$autocomplete_value = '';

	// Check for exact matches first.
	if ( isset( $autocomplete_map[ $field_label ] ) ) {
		$autocomplete_value = $autocomplete_map[ $field_label ];
	} else {
		// Check for partial matches.
		foreach ( $autocomplete_map as $key => $value ) {
			if ( strpos( $field_label, $key ) !== false ) {
				$autocomplete_value = $value;
				break;
			}
		}
	}

	// Add autocomplete attribute if a match was found.
	if ( ! empty( $autocomplete_value ) && strpos( $field_content, 'autocomplete=' ) === false ) {
		// For text, email, tel, and url inputs.
		if ( in_array( $field->type, array( 'text', 'email', 'phone', 'website' ), true ) ) {
			$field_content = str_replace( '<input', '<input autocomplete="' . esc_attr( $autocomplete_value ) . '"', $field_content );
		}
	}

	// Handle name fields specifically (they have sub-fields).
	if ( 'name' === $field->type ) {
		// First name - add both autocomplete and aria-label.
		$field_content = preg_replace(
			'/(<input[^>]*name=[\'"]input_' . $field->id . '\.3[\'"][^>]*)(>)/i',
			'$1 autocomplete="given-name" aria-label="First Name"$2',
			$field_content
		);
		// Last name - add both autocomplete and aria-label.
		$field_content = preg_replace(
			'/(<input[^>]*name=[\'"]input_' . $field->id . '\.6[\'"][^>]*)(>)/i',
			'$1 autocomplete="family-name" aria-label="Last Name"$2',
			$field_content
		);
	}

	// Handle CAPTCHA fields - ensure proper labeling and autocomplete.
	if ( 'captcha' === $field->type ) {
		// Add autocomplete="off" to CAPTCHA input fields.
		$field_content = preg_replace(
			'/(<input[^>]*type=[\'"]text[\'"][^>]*)(>)/i',
			'$1 autocomplete="off" aria-label="CAPTCHA verification code"$2',
			$field_content
		);

		// Ensure the CAPTCHA image has proper alt text.
		$field_content = preg_replace(
			'/(<img[^>]*class=[\'"][^\'\"]*gfield_captcha[^\'\"]*[\'"][^>]*)(\/?>)/i',
			'$1 alt="CAPTCHA verification image - please enter the characters shown"$2',
			$field_content
		);
	}

	return $field_content;
}
add_filter( 'gform_field_content', 'add_autocomplete_to_gform_fields', 10, 2 );

/**
 * Add custom menu item to primary navigation.
 *
 * @param string $items The HTML list content for the menu items.
 * @param object $args  An object containing wp_nav_menu() arguments.
 * @return string Modified menu items HTML.
 */
function add_custom_menu_item( $items, $args ) {
    if ( 'primary_nav' === $args->theme_location ) {

        $new_item = '<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" class="menu-item menu-item-type-post_type menu-item-object-page nav-item fs-subtle"><a href="' . get_home_url() . '/zh/" class="nav-link">中文</a></li>';

        $items .= $new_item;
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_custom_menu_item', 10, 2 );
