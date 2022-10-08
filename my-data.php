<?php
/**
 * Plugin Name: My Data.
 */

add_action( 'init', function() {
	register_post_meta(
		'post',
		'_my_data',
		[
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
			'auth_callback' => function() {
				return current_user_can( 'edit_posts' );
			}
		]
	);
	add_action( 'enqueue_block_editor_assets', function() {
		wp_enqueue_script(
			'my-data',
			trailingslashit( plugin_dir_url( __FILE__ ) ) . 'my-data.min.js',
			[ 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ],
			'0.1.0',
			true
		);
	} );
} );


add_filter( 'the_content', 'show_meta_data_content' );
function show_meta_data_content( $content ) {
	$some_meta = ( get_post_meta( get_the_ID(), '_my_data', true ) ?: 'meta unset' );
	return '<pre>' . $some_meta . '<br>' . __FUNCTION__ . '</pre>' . $content;
}
