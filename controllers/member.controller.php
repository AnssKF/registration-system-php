<?php

class MemberController {

    public function signup(){
        if(isset($_SESSION['loggedInUser'])){
            header('Location:index.php?v=home');
            exit();
        }

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
                }
                $user->save();
                mail($user->email,'Registration','Welcome'.$user->name.'I hope u got a nice experience');
                $_SESSION['loggedInUser'] = $user;
                header('Location:index.php?v=home');
                exit();
            }else{
                header('Location:index.php?v=signup');
                exit();
            }
        }

        require_once './views/member/signup.php';
    }
    
    public function login(){


        require_once './views/member/login.php';
    }

    public function logout(){
        session_unset();
        session_destroy();
        header('Location:index.php?v=login');
        exit();
    }

}