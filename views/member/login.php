<header class="position-relative vh-100 w-100">

    <div class="v-center  position-absolute">
        <div class="card shadow mx-auto" style="width:25em">
            
            <div class="card-body">
                
                <h1 class="card-title">Login</h1>
            
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

                    <form method="POST">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control">
                            
                            <?php showSessionMessage('ERR_EMPTY_EMAIL', '<h6 class="alert alert-danger my-1">Email Can\'t Be Empty</h6>'); ?>
                            
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password1" class="form-control mb-1">

                            <?php showSessionMessage('ERR_LOGIN_PASSWORD_ERR', '<h6 class="alert alert-danger my-1">Please Check Your Password</h6>'); ?>

                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" value="Submit" class="btn btn-block btn-outline-info">
                        </div>
                    </form>

                <?php
                    endif;
                ?>

            </div>
        </div>
    </div>

</header>