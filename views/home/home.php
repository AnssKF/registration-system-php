<header class="position-relative vh-100 w-100">

    <div class="v-center  position-absolute">
        <div class="card shadow mx-auto" style="width:25em">
            <div class="card-body">
                
                <?php
                    if( isset($_SESSION['loggedInUser']) ):
                ?>

                        <!-- Profile -->

                <?php
                    else:
                ?>

                    <div class="alert alert-danger text-center">
                        <p>You need to Login first</p>
                        <p> <a href="?v=login">Login</a> or <a href="?v=signup">Signup</a> </p>
                    </div>
                <?php
                    endif;
                ?>

            </div>
        </div>
    </div>

</header>