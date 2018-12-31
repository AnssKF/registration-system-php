<header class="position-relative vh-100 w-100">

    <div class="v-center  position-absolute">
        <div class="card shadow mx-auto" style="width:25em">
            <div class="card-body text-center">
                
                <?php
                    if( isset($_SESSION['loggedInUser']) ):
                ?>

                    <img src="./media/<?=$_SESSION['loggedInUser']->profile_picture?>" class="card-img-top rounded-circle position-relative w-50 mx-auto img-thumbnail border-0 mb-3 d-block" alt="<?=$_SESSION['loggedInUser']->name?>">
                    <h5 class="card-title"><?= $_SESSION['loggedInUser']->name ?></h5>
                    <p class="card-text"><?= $_SESSION['loggedInUser']->email ?></p>
                    <a href="member.php?v=logout" class="card-link">Logout</a>
                    <a href="member.php?v=update" class="card-link">Update</a>

                <?php
                    else:
                ?>

                    <div class="alert alert-info text-center">
                        <p>Login to view your profile</p>
                        <p> <a href="member.php?v=login">Login</a> or <a href="member.php?v=signup">Signup</a> </p>
                    </div>
                <?php
                    endif;
                ?>

            </div>
        </div>
    </div>

</header>