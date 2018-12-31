<?php

function showSessionMessage( $msgKey, $htmlMsgTag ){
    if(isset($_SESSION[$msgKey])){
        echo $htmlMsgTag;
        unset($_SESSION[$msgKey]);
    }else{}
}

function fileIsValid($file, $validExtensions=[], $validSize=0 ){

    if( !in_array( strtolower((string)pathinfo($file['name'])['extension']) , $validExtensions)){
        return false;
    }

    if( $file['size'] > $validSize ){
        return false;
    }

    return true;
}