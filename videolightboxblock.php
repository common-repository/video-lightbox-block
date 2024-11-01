<?php
/**
 * Plugin Name:       Video lightbox Block - Modalvideo
 * Author:            Gutenplayer
 * Author URI:        https://profiles.wordpress.org/gutenplayer/
 * Description:       Modalvideo - video lightbox blocks - video popup blocks - video modal blocks for WordPress gutenberg blocks and WordPress gutenberg template library
 * Tags: video popup player, block, video lightbox player, gutenberg video modal player, modal, lightbox
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Tested up to:      6.0
 * Version:           1.0.0
 * Domain Path:       /languages
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       videopopupblock
 *
 * @package           videopopupblock
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// VideoPopupBlock
function videopopupblock_blocks_register_block_type($blockname, $options = array()){
    register_block_type(
        'videopopupblock/' . $blockname,
        array_merge(
            array(
                'api_version' => 2,
                'editor_script'   => 'videopopupblock-all-script',
                'editor_style'    => 'videopopupblock-editor-style',
                'script'          => 'videopopupblock-client-script',
                'style'           => 'videopopupblock-frontend-style',
            ),
            $options
        )
    );
}
function videopopupblock_blocks_register(){

    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');
    $client_asset_file = include( plugin_dir_path( __FILE__ ) . 'build/client.asset.php');

	wp_register_script(
		'videopopupblock-all-script',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version']
	);

	wp_register_script(
		'videopopupblock-client-script',
		plugins_url( 'build/client.js', __FILE__ ),
		$client_asset_file['dependencies'],
		$client_asset_file['version']
	);

    wp_register_style(
        'videopopupblock-editor-style',
        plugins_url( 'build/index.css', __FILE__ ),
    );

    wp_register_style(
        'videopopupblock-frontend-style',
        plugins_url( 'build/style-index.css', __FILE__ ),
    );

    wp_enqueue_style('videopopupblock-frontend-style');
    wp_enqueue_script('videopopupblock-client-script');
    videopopupblock_blocks_register_block_type('videopopupblock');
    videopopupblock_blocks_register_block_type('popup-player');
}
add_action( 'init', 'videopopupblock_blocks_register');


add_filter( 'block_categories_all', 'videopopupblock_plugin_block_categories', 10, 2 );
function videopopupblock_plugin_block_categories( $categories, $post ) {
    $videopopupblock_cat = array(
        'slug'  => 'videopopupblock',
        'title' => __( 'Video Lightbox Block', 'videopopupblock' ),
    );
    array_unshift( $categories, $videopopupblock_cat );
    return $categories;
}

// videopopupblock