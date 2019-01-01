<?php

class MemberController {

    public function signup(){

        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['signup'])){

            $userData = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password1' => $_POST['password1'],
                'password2' => $_POST['password2'],
            ];
            $user = new User();
            $user->new($userData);

            /**
             *  Validate Data
             */
            $DataNotValidFlag = false;
            if(!$user->isValid()){
                $DataNotValidFlag = true;

                if(empty($user->email)){
                    $_SESSION['ERR_EMPTY_EMAIL'] = true;
                }else if(User::isExist($userData['email'])){
                    $_SESSION['ERR_SIGNUP_EMAIL_EXIST'] = true;
                }
                
                if(empty($user->name)){
                    $_SESSION['ERR_EMPTY_NAME'] = true;
                }
                
                if($userData['password1'] !== $userData['password2']){
                    $_SESSION['ERR_SIGNUP_PASSWORD_ERR'] = true;
                }
            }
            
            if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error']!=4){
                if(!fileIsValid($_FILES['profile_picture'],['jpeg','jpg','png'],(2*1024*1024))){
                    $DataNotValidFlag = true;
                    $_SESSION['ERR_INVALID_IMAGE'] = true;
                }
            }
            

            if(!$DataNotValidFlag){
                if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error']!=4){
                    $ppFileName = $user->email . '-' . (string)rand() . $_FILES['profile_picture']['name'];
                    move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'media/'.$ppFileName);
                    $user->profile_picture = $ppFileName;
                }else{
                    $user->profile_picture = null;
                }
                $user->save();
                mail($user->email,'Registration','Welcome'.$user->name.'I hope u got a nice experience');
                header('Location:member.php?v=login');
                exit();
            }else{
                header('Location:member.php?v=signup');
                exit();
            }
        }

        require_once './views/member/signup.php';
    }
    
    public function login(){

        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login'])){
            $userData = [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
            ];

            $user = new User();
            $user->new($userData);

            if(User::isExist($user->email)){

                if($user->isAuthenticated()){
                    /**
                     *  Save session with logged in user
                     */

                    $user->getByEmail($user->email);
                    $_SESSION['loggedInUser'] = $user;

                    if(isset($_POST['stayLoggedIn'])){
                        setcookie("loggedInUser",$user->id,time()+(86400 * 30));
                    }

                    header('Location:index.php');
                    exit();

                }else {
                    $_SESSION['ERR_LOGIN_PASSWORD_ERR'] = true;
                }

            }else {
                $_SESSION['ERR_LOGIN_NOT_EXIST_BEFORE'] = true;
            }

        }

        require_once './views/member/login.php';
    }

    public function update(){
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update'])){

            $userData = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password1' => isset($_POST['password1']) ? $_POST['password1'] : null,
                'password2' => isset($_POST['password2']) ? $_POST['password2'] : null,
            ];
            $user = new User();
            $user->new($userData);

            /**
             *  Validate Data
             */
            $DataNotValidFlag = false;

            if(!$user->isValid( UPDATE_VALIDATION )){
                $DataNotValidFlag = true;

                if(empty($user->email)){
                    $_SESSION['ERR_EMPTY_EMAIL'] = true;
                }else if(User::isExist($userData['email'])){
                    $_SESSION['ERR_UPDATE_EMAIL_EXIST'] = true;
                }
                
                if(empty($user->name)){
                    $_SESSION['ERR_EMPTY_NAME'] = true;
                }
                
                if($user->password1 != null && $user->password2 != null){
                    if($userData['password1'] !== $userData['password2']){
                        $_SESSION['ERR_UPDATE_PASSWORD_ERR'] = true;
                    }
                }
            }
            
            /**
             *  File check
             */
            if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error']!=4){
                if(!fileIsValid($_FILES['profile_picture'],['jpeg','jpg','png'],(2*1024*1024))){
                    $DataNotValidFlag = true;
                    $_SESSION['ERR_INVALID_IMAGE'] = true;
                }
            }
            

            if(!$DataNotValidFlag){
                if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error']!=4){
                    $ppFileName = $user->email . '-' . (string)rand() . $_FILES['profile_picture']['name'];
                    move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'media/'.$ppFileName);
                    $user->profile_picture = $ppFileName;
                }else{
                    $user->profile_picture = $_SESSION['loggedInUser']->profile_picture;
                }

                if($user->password1 == null && $user->password2 == null){
                    $user->password = $_SESSION['loggedInUser']->password;
                }

                $user->save($_SESSION['loggedInUser']->id);

                $_SESSION['loggedInUser'] = $user;
                header('Location:index.php');
                exit();
            }else{
                header('Location:member.php?v=update');
                exit();
            }
        }

        require_once './views/member/update.php';
    }

    public function logout(){
        session_unset();
        session_destroy();
        setcookie("loggedInUser",'-1',time()-1);
        header('Location:member.php?v=login');
        exit();
    }

}