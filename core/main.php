<?php
function old($field){
    if(isset($_SESSION['error'][$field][1])){
        if(empty($_SESSION['error'][$field][1])){
            return null;
        }else{
            return $_SESSION['error'][$field][1];
        }
    }
}

function show($field){
    if(isset($_SESSION['error'][$field][1])){
        if($_SESSION['error'][$field][0] == 1){
            return 'none';
        }else{
            return 'block';
        }
    }
    return 'none';
}

function error($field){
    if(isset($_SESSION['error'][$field][1])){
        if($_SESSION['error'][$field][0] != 1){
            return $_SESSION['error'][$field][0];
        }else{
            return null;
        }
    }
}

function passOrMail(){
    if(isset($_SESSION['error']['error'])){
        if(!empty($_SESSION['error']['error'])){
            return $_SESSION['error']['error'];
        }
    }
    return null;
}