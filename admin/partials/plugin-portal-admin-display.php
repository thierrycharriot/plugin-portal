<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/thierrycharriot
 * @since      1.0.0
 *
 * @package    Plugin_Portal
 * @subpackage Plugin_Portal/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="container">

    <div class="alert alert-info text-center" role="alert">
        <?php 
            # https://developer.wordpress.org/reference/functions/wp_get_current_user/
            # wp_get_current_user()
            # Retrieve the current user object.
            $user_info = wp_get_current_user(); 
            #var_dump($user_info);
            #die(); # debug OK
        ?>
        <h3>Welcome to Dashboard Portal <?php echo ucfirst( $user_info->user_login ); ?></h3>
    </div>

    <?php
        global $wpdb;

        $post_row = $wpdb->get_row(
            $wpdb->prepare('SELECT * from wp_posts WHERE ID = %d', 1)
        );

        echo '<pre>';
        print_r($post_row);
        echo '</pre>'
    ?>

</div><!--/container-->
