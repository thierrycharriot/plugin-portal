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
        <h3>Welcome to Link Create <?php echo ucfirst( $user_info->user_login ); ?></h3>
    </div>

    <form>
        <div class="mb-3">
            <label for="exampleInputUrl" class="form-label">Url</label>
            <input type="text" class="form-control" id="exampleInputUrl" aria-describedby="urlHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputLink" class="form-label">Link</label>
            <input type="text" class="form-control" id="exampleInputLink">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div><!--/container-->



