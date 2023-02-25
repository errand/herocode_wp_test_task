<?php

/**
 * Here we register Custom Guttenberg blocks
 */

add_action('init', 'shatskikhRegisterCustomBlock');
function shatskikhRegisterCustomBlock()
{
    // Check if this is the intended custom post type
    if (is_admin()) {
        global $pagenow;
        $current_type = '';
        if ( 'post-new.php' === $pagenow ) {
            if ( isset( $_REQUEST['post_type'] ) && post_type_exists( $_REQUEST['post_type'] ) ) {
                $current_type = $_REQUEST['post_type'];
            };
        } elseif ( 'post.php' === $pagenow ) {
            if ( isset( $_GET['post'] ) && isset( $_POST['post_ID'] ) && (int) $_GET['post'] !== (int) $_POST['post_ID'] ) {
                // Do nothing
            } elseif ( isset( $_GET['post'] ) ) {
                $post_id = (int) $_GET['post'];
            } elseif ( isset( $_POST['post_ID'] ) ) {
                $post_id = (int) $_POST['post_ID'];
            }
            if ( $post_id ) {
                $post = get_post( $post_id );
                $current_type = $post->post_type;
            }
        }
        if (!in_array($current_type,['product', 'set'])) {
            return;
        }
    }

  register_block_type( __DIR__ . '/../src/product-block/build/block.json');
}
