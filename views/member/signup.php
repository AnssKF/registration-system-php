<header class="position-relative vh-100 w-100">

    <div class="v-center  position-absolute">
        <div class="card shadow mx-auto" style="width:25em">
            
            <div class="card-body">
                
                <h1 class="card-title">Signup</h1>
            
                <?php
                    if( isset($_SESSION['loggedInUser']) ):
                ?>

                    <div class="alert alert-info text-center">
                        <p>You need to Logout first</p>
                        <p> <a href="?v=logout">Logout</a> </p>
                    </div>

                <?php
                    else:
                ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" name="name" class="form-control">
                            
                            <?php showSessionMessage('ERR_EMPTY_NAME', '<h6 class="alert alert-danger my-1">Name Can\'t Be Empty</h6>'); ?>

                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control">
                            
                            <?php showSessionMessage('ERR_SIGNUP_EMAIL_EXIST', '<h6 class="alert alert-danger my-1">This Email Exists Before</h6>'); ?>
                            <?php showSessionMessage('ERR_EMPTY_EMAIL', '<h6 class="alert alert-danger my-1">Email Can\'t Be Empty</h6>'); ?>
                            
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password1" class="form-control mb-1">
                            <label>ReEnter Your Password</label>
                            <input type="password" name="password2" class="form-control">

                            <?php showSessionMessage('ERR_SIGNUP_PASSWORD_ERR', '<h6 class="alert alert-danger my-1">Please Check Your Passwords</h6>'); ?>

                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control-file">
                            <?php showSessionMessage('ERR_INVALID_IMAGE', '<h6 class="alert alert-danger my-1">Invalid Image -- Should be less than 2MB & in jpeg/jpg/png Format</h6>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="signup" value="Submit" class="btn btn-block btn-outline-info">
                        </div>
                    </form>

                <?php
                    endif;
                ?>

            </div>
        </div>
    </div>

</header>