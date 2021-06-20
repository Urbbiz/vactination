<?php

class InputReader {

    public static function readNationalId(){ 
        $result = null;
        
        do {
            $input = trim(fgets(STDIN, 1024));
            $result=  Validation::nationalId($input);
           
            if($result == false){
                echo "Error! Id contains 2 capital Letters, ans 11 digits  LLXXXXXXXXXXX. Pleas try again:  ";
            } elseif ($result == 1){
                echo "Error! You didn't enter national Id.";
            } 
        } while ($result == false || $result == 1 );
        return $result;  
    }

    public static function readName(){ 
        $result = null;
        
        do {
            $input = trim(fgets(STDIN, 1024));
            $result=  Validation::name($input);
           
            if($result == false){
                echo "Only letters and white space allowed! try again: ";
            } elseif ($result == 1){
                echo "Error! You didn't enter name.";
            } 
        } while ($result == false || $result == 1 );
        return $result;  
    }


    public static function readEmail(){
        $result = null;

        do {
            $input = trim(fgets(STDIN, 1024));
            $result=  Validation::email($input);
           
           if($result == false){
                echo "Email format is inncorect! Try again: ";
            } elseif ($result == 1){
                echo "Error! You didn't enter email.";
            }
        } while ($result == false || $result == 1 );
        return $result;   
    }


    public static function readPhone(){
        $result = null;

        do {
            $input = trim(fgets(STDIN, 1024));
            $result=  Validation::phone($input);
            if($result == false){
                echo "phone number format is inncorect! Use only numbers, min length 6, min length 14! Try again: ";
            } elseif ($result == 1){
                echo "Error! You didn't enter phone number! Please try again: ";
            }
        } while ($result == false || $result == 1 );
        return $result; 
    }


    public static function readDateTime(){
        $result = null;

        do {
            $input = trim(fgets(STDIN, 1024));
            $result=  Validation::dateTime($input);
            if($result == false){
                echo "date format is inncorect! Use YYYY-MM-DD H:MM , Only numbers are allowed!";
            } elseif ($result == 1){
                echo "Error! You didn't enter vactination time.";
            }
        } while ($result == false || $result == 1 );
        return $result;   
    }

    


}