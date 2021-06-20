<?php

class Json
{

    private static $jsonObj;
    private $data;


    public static function getDB()    //funkcija kuri mums grazins sukurta json objekta
    {
        return self::$jsonObj ?? self::$jsonObj = new self;  
    }


    private function __construct()
    {
        if (!file_exists(DIR . 'data/accounts.json')) {    // pirma karta sukuriam json faila, jeigu jo dar nera
            $data = json_encode([]); //uzkoduojam sita faila i json kaip masyva, ojame yra objektai
            file_put_contents(DIR . 'data/accounts.json', $data); //irasom i json faila.
        }
        $data = file_get_contents(DIR . 'data/accounts.json'); // jeigu jau egzistuoja, pasiimu faila
        $this->data = json_decode($data); //iraso objekta this data i json faila.
    }


    public function __destruct()     //pasileidzia tada, kai objektas buna istrintas is atminties   
    {
        file_put_contents(DIR . 'data/accounts.json', json_encode($this->data));  //tiesiog irasom i sita faila ir nieko negrazinam  
    }

    public function readData(): array  
    {
        return $this->data; //grazinu iskoduoda json faila
    }

    public function writeData(array $data): void 
    {
        $this->data = json_encode($data);
    }


    public function getUserByNationalId($nationalId): ?object 
    {
        foreach ($this->data as $user) {
            if ($user->nationalId == $nationalId) { 
                return $user;   
            }
        }
        return null;  
    }




    public function store(User $user): void 
    {
        $id = $this->getNextId();
        
         $user->id = $id; //pridedu i sita objekta ID
        $this->data[] = $user;   
    }


    public function updateAdd(object $updateUser): void // nieko negrazina, bet paima kieki ir prideda pinigus
    {
        foreach ($this->data as $key => $user) {     // jeigu yra $user, tada  foreachinam per user
            if ($user->id == $updateUser->id) {         // jeigu $user[id] sutama su mano ieskoma $id
                $this->data[$key] = $updateUser;
                return;
            }
        }
    }


    public function delete(int $id): void 
    {

       

        foreach ($this->data as $key => $user) {
            if ($user->id == $id & $user->balance == 0 ) { // jeigu $user[id] sutama su mano iieskoma $id
                unset($this->data[$key]);   
                // normalizuojam masyva iki normalaus masyvo be "skyliu"
                $this->data = array_values($this->data);
                //
                /*
                pvz indeksai pries trynima 0 1 2 3 4
                trinam 2 elementa
                indeksai po trynimo 0 1 3 4
                indeksai po normalizavimo 0 1 2 3
                */
                return;
            } else
             die;
        }
    }


    private function getNextId(): int  
    {
        if (!file_exists(DIR . 'data/indexes.json')) {    // pirma karta sukuriam json faila, jeigu jo dar nera
            $index = json_encode(['id' => 1]); //uzkoduojam sita faila i json su pirmu indexu.,
            file_put_contents(DIR . 'data/indexes.json', $index); //irasom i json faila.
        }
        $index = file_get_contents(DIR . 'data/indexes.json');
        $index = json_decode($index, 1);
        $id = (int) $index['id'];  // paverciam ji i (int), kad gautume skaiciu.
        $index['id'] = $id + 1; // sukuriam nauja masyva ir pridedam jam +1
        $index = json_encode($index);
        file_put_contents(DIR . 'data/indexes.json', $index);
        return $id;
    }


}

?>