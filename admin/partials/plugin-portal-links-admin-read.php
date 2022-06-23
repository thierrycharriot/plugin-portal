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
        <h3>Welcome to Read Links <?php echo ucfirst( $user_info->user_login ); ?></h3>
    </div>

</div><!--/container-->