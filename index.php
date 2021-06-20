<?php



// ************************************** EXISTING  USER  ****************************************************************
if ($foundUser != null){   // jeigu toks id jau yra sistemoje

    Echo "\n", "Welcome back ", $foundUser->name, " If you want to  edit appointment time enter:1, If you want to delete appointment enter:2 : ";
    $isInputValid = false;
    do {
        $input = trim(fgets(STDIN, 1024));

        if ($input == '1') {
            $isInputValid = true;
            echo "Enter new time: ";

            $dateTime = InputReader::readDateTime();
            
            
            $foundUser->dateTime =$dateTime;

            Json::getDB()->updateAdd($foundUser); 
            echo "Your new time is changed!";

           
        } 
        elseif ($input == '2') {
            $isInputValid = true;
           
            echo "your appointment date and time deleted";
            $foundUser->dateTime = null;
         
            Json::getDB()->updateAdd($foundUser);

        } else  {
            echo "Your input was inncorect, please try again! ";

        }
    }while ($isInputValid == false);
}

// **************************************  NEW USER  *********************************************************************
else {   // jeigu id nera sistemoje

    Echo "\n", "Hello, If you want to register for vactination, folow steps below: ", "\n";

    echo "Enter your name: ";
    
    $name =InputReader::readName();
    Echo "\n", "Name: ", $name, "\n";
   
    echo "\n", "Enter your email: ";
    $email =InputReader::readEmail();
    Echo "\n", "email: ", $email, "\n";

    echo "\n", "Enter your phone number: ";
    
    $phone =InputReader::readPhone();
    Echo "\n", "Phone number: ", $phone, "\n";


    echo "\n", "Enter vactination date and time: ";
    // $dateTime =InputReader::readDateTime(trim(fgets(STDIN, 1024)));
     $dateTime =InputReader::readDateTime();
    Echo "\n", "Vactination date and time: ", $dateTime, "\n", "\n";


    echo "Vactination is confirmed for ${name}";

    $user = new User;
    $user->name = ($name ?? 0);
    $user->email = ($email ?? 0);
    $user->phone = ($phone ?? 0);
    $user->nationalId = ($nationalId?? 0);
    $user->dateTime = ($dateTime ?? 0);
        
        Json::getDB()->store($user);  //sukurimas
        

    



}



?>