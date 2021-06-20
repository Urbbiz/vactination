<?php

require __DIR__.'/bootstrap.php';

Echo " if you are medical personel start from beginning and use: php index.php --medicalPersonel. ";

if($argc > 1 && ($argv[1] == '--medicalPersonel' || $argv[1] == '--mp')){
    echo "Enter the date you want to see the vaccination list: ";

    $date = date("Y-m-d", strtotime(InputReader::readDateTime()));
    $users = Json::getDB()->readData();
    $foundUsers = [];
    foreach($users as $user){
        $userDate = date("Y-m-d", strtotime($user->dateTime));
        if($userDate == $date){
            $foundUsers[] = $user;
        }
    }

    if(count($foundUsers) == 0){
        echo "No patients registered on $date";
    } else {
        usort($foundUsers, function($a, $b){ 
            if($a->dateTime == $b->dateTime)
                return 0;

            return ($a->dateTime < $b->dateTime) ? -1 : 1;
         });
    
         $data = array();
         foreach($foundUsers as $user){
            $data[]= array($user->name, $user->dateTime ); 
          
             echo "{$user->dateTime} {$user->name}", "\n";
         
         }

    
        //  CSV Headers
         $headers = array("name", "time");
       

        // Open/create csv file
        $fh =fopen("file.csv","w");
        // Create the heder
        fputcsv($fh, $headers);
        // Populate the data
        foreach($data as $fields){
            fputcsv($fh, $fields);
        }
        // Close the file
        fclose($fh);
    }
    exit(0);
    
}

echo "If you want to register for vactination", "\n";
echo "Enter national identification number: ";

// $nationalId = trim(fgets(STDIN, 1024));
$nationalId =InputReader::readNationalId();


echo "\n", "Your national identification number: ",  $nationalId, "\n";



$foundUser = Json::getDB()->getUserByNationalId($nationalId);




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