<?php
function length($value , $field){
    return strlen($value) < 4 ? "$field be more than four" : 1; 
}

function isEmail($email){
    return filter_var($email , FILTER_VALIDATE_EMAIL) ? 1 : "email must be email";
}

function isNumber($number){
    return is_numeric($number) ? 1 : "Phone number must be numeric";
}

function required($value , $field){
    return empty($value) ? "$field is required" : 1;
}

function moreFour($number){
    return $number >= 4 ? 1 : "price must be more than four";
}