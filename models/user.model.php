<?php

/**
 *  Validation modes
 */

 define('NORMAL_VALIDATION','0',true);
 define('UPDATE_VALIDATION','1',true);

class User extends Db {

    public function getById($id){
        $stmt = Db::runQuery('SELECT * FROM `users` WHERE id = :id', [ ':id' => $id ] );
        if($stmt->rowCount() > 0){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach($data as $key => $value){
                $this->{$key} = $value;
            }
            return true;
        }else {
            return null;
        }
    }

    public function getByEmail($email){
        $stmt = Db::runQuery('SELECT * FROM `users` WHERE email = :email', [ ':email' => $email ] );
        if($stmt->rowCount() > 0){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach($data as $key => $value){
                $this->{$key} = $value;
            }
            return true;
        }else {
            return null;
        }
    }

    public function new($userData){
        foreach($userData as $key => $value){
            $this->{$key} = $value;
        }
    }

    public static function isExist($email){
        $user = new User();
        $x = $user->getByEmail($email);
        return $x ? true : false;
    }

    public function isAuthenticated(){
        $existUser = new User();
        $existUser->getByEmail($this->email);
        if($existUser){
            if( password_verify( $this->password , $existUser->password ) ){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function isValid($mode=NORMAL_VALIDATION){

        if($mode==UPDATE_VALIDATION){
            
            if(isset($this->email) && isset($this->password1) && isset($this->password2)){
                if( empty($this->email) || filter_var($this->email, FILTER_VALIDATE_EMAIL) === false ){
                    return false;
                }
    
                if(empty($this->name)){
                    return false;
                }
                
                if(!($this->password1 == null && $this->password2 == null) ){
                    if(($this->password1 !== $this->password2)){
                        return false;
                    }else{
                        $this->password = password_hash( $this->password1, PASSWORD_BCRYPT);
                    }
                }

            }else{
                return false;
            }

        }else{
            
            if(isset($this->email) && isset($this->password1) && isset($this->password2)){
                if( empty($this->email) || filter_var($this->email, FILTER_VALIDATE_EMAIL) === false || User::isExist($this->email)){
                    return false;
                }
    
                if(empty($this->name)){
                    return false;
                }
                
                if(($this->password1 !== $this->password2) || empty($this->password1) || empty($this->password2)){
                    return false;
                }else{
                    $this->password = password_hash( $this->password1, PASSWORD_BCRYPT);
                }
            }else{
                return false;
            }
        }

        return true;
    }

    public function save($id=null) {
        if($id==null){
            if($this->isValid()){
                $stmt = Db::runQuery('INSERT INTO `users` (`name`,`email`,`password`,`profile_picture`) values (:name,:email,:password,:profile_picture)'
                                        , [ ':name'=> $this->name, ':email'=>$this->email, 
                                            ':password'=>$this->password, ':profile_picture'=> isset($this->profile_picture) ? $this->profile_picture : null ] );
                $this->id = Db::$connection->lastInsertId();
            }
        }else{
            /**
             *  update
             */
            $stmt = Db::runQuery('UPDATE `users` SET `name` =:name ,`email` = :email ,`password` = :password,`profile_picture`=:profile_picture WHERE `id` = :id'
                                        , [ ':id'=>$id, ':name'=> $this->name, ':email'=>$this->email, 
                                            ':password'=>$this->password, 
                                            ':profile_picture'=> isset($this->profile_picture) ? $this->profile_picture : null ] );
        }
    }

}