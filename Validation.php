<?php

class Validation {

    public static function nationalId($nationalId, int $minDigits = 6, int $maxDigits = 14){
        
        if($nationalId==null) {   
                    return  1; 
        }elseif (!preg_match('~^[A-Z]{2}\d{11}$~',$nationalId)) {
        return false;
      }
        else {
            return $nationalId;
        }
    }

    public static function name($name){
        if($name==null) {   
                    return  1; 
        }elseif (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            return false;
        }
            else {
                return $name;
            }
        }

    public static function email($str){
        
     if($str==null) {   
        return  1; 
    }elseif (!filter_var($str, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    else {
         return $str;
        }
    }


    public static function phone($phone, int $minDigits = 6, int $maxDigits = 14){
        
        if($phone==null) {   
             return  1; 
        }elseif (!preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/',$phone)) {
            return false;
        }
        else {
            return $phone;
        }
    }



    public static function dateTime($str, int $minDigits = 11){
        
        if($timestamp = $str==null) {  
            return  1; 
        }elseif (($timestamp = strtotime($str)) === false) {
            return false;
        }else {
            return date('c', $timestamp);
        }
    }

}

?>