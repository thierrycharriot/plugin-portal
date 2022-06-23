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
        <h3>Welcome to List Links <?php echo ucfirst( $user_info->user_login ); ?></h3>
    </div>

    <?php

        $args = array (
            'post_type'     => 'cpt-links',
            'post_status'   => 'publish',
            'order'         => 'ASC',
            'orderby'       => 'title'  
        );

       /**
        * https://developer.wordpress.org/reference/classes/wp_query/
        * The WordPress Query class.
        */

        // The Query
        $the_query = new WP_Query( $args );

        //var_dump( $the_query->get_posts() ); // Deebug OK
        
        // The Loop
        if ( $the_query->have_posts() ) {
            echo '<ul class="list-group">';
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                /**
                 * https://developer.wordpress.org/reference/functions/sanitize_text_field/
                 * sanitize_text_field( string $str )
                 * Sanitizes a string from user input or from the database.
                 * 
                 * https://developer.wordpress.org/reference/functions/get_the_content/
                 * get_the_content( string $more_link_text = null, bool $strip_teaser = false, WP_Post|object|int $post = null )
                 * Retrieves the post content.
                 */
                echo '<li class="list-group-item"><a href="' . sanitize_text_field( get_the_content() ) . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
        } else {
            ?>
            <div class="alert alert-danger" role="alert"><h2>Pas de liens connus! :)</h2></div>
            <?php
        }
        /* Restore original Post Data */
        wp_reset_postdata();

    ?>

</div><!--/container-->


