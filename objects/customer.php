<?php
#Revision History            DATE         COMMENTS
#Alireza Gholami 1921230     2020-04-26     create private variables/getter and setters/constructors/and 3 methods delete,save,load


#import the PHP commin function file
require_once 'php/connection.php';


class customer {
    
#define constant variable for validations of each private fields.
const FNAME_MAX_LENGTH = 20;
const LNAME_MAX_LENGTH = 20;
const ADDRESS_MAX_LENGTH = 25;
const CITY_MAX_LENGTH = 25;
const PROVINCE_MAX_LENGTH = 25;
const PCODE_MAX_LENGTH = 7;
const USERNAME_MAX_LENGTH = 12;
const PASSWORD_MAX_LENGTH = 255;
    
    
    #define private variables for customer
    private $customer_id="";
    private $fname="";
    private $lname="";
    private $city="";
    private $province="";
    private $pcode="";
    private $address="";
    private $username="";
    private $password="";
    private $date;
    private $time;
    
    
    
    
    
    
    //create a function constractor to recive prameters
    function __construct($newCustomerId="",$newFirstname="",$newLastname="",$newCity="", $newProvince="",
            $newAddress="" , $newPostalCode="",$newUsername="", $newPassword="", $newDate="", $newTime="")
    {
        
        #this code id called everytime "= new customer()" is called
        if($newCustomerId<>""){
            $this->setCustomerId($newCustomerId);
        }
        
        #check if firstname is not empty
        if($newFirstname<>""){
            $this->setFirstname($newFirstname);
        }
        
         #check if lastname is not empty
        if($newLastname<>""){
            $this->setLastname($newLastname);
        }
        
         #check if username is not empty
        if($newUsername<>""){
            $this->setUserName($newUsername);
        }
        
        
         #check if password is not empty
        if($newPassword<>""){
            $this->setPassword($newPassword);
        }
        
         #check if city is not empty
        if($newCity<>""){
            $this->setCity($newCity);
        }
        
         #check if province is not empty
        if($newProvince<>""){
            $this->setProvince($newProvince);
        }
        
        
         #check if address is not empty
        if($newAddress<>""){
            $this->setAddress($newAddress);
        }
        
         #check if postalcode is not empty
        if($newPostalCode<>""){
            $this->setPostalCode($newPostalCode);
        }
        
         #check if date is not empty
        if($newDate<>""){
            $this->setDate($newDate);
        }
        
         #check if time is not empty
          if($newTime<>""){
            $this->setTime($newTime);
        }
    }
    
//=================CREATE ALL GETTERS FOR VARIABLES======================= 
   public function getCustomerId(){
        #use "self" when you want to access CONSTANTS
        #echo self::DEAFULT_Customer id;
        #use this (*current object) when you want to acces variables
        return $this->customer_id;
        }
        public function getFirstName()
        {
            #USE this current object
            return $this->fname;
        }
        public function getLastName()
        {
            #USE this current object
            return $this->lname;
        }
        public function getAddress()
        {
            #USE this current object
            return $this->address;
        }
        public function getCity()
        {
            #USE this current object
            return $this->city;
        }
        public function getProvince()
        {
            #USE this current object
            return $this->province;
        }
        public function getPostalCode()
        {
            #USE this current object
            return $this->pcode;
        }
        public function getUserName()
        {
            #USE this current object
            return $this->username;
        }
        public function getPassword()
        {
            #USE this current object
            return $this->password;
        }
        public function getDate()
        {
            #USE this current object
            return $this->date;
        }
        public function getTime()
        {
            #USE this current object
            return $this->time;
        }
        
//=================CREATE ALL SETTERS AND VALIDATION FOR VARIABLES=======================      
    public function setCustomerId($newcustomerid)
    {
        #check if it not empty
        if(strlen($newcustomerid) == 0){
            return "The customer ID connot be empty!";
        }
        else{
         
         $this->customer_id = $newcustomerid;
         return"";
         
        }
    }
    
    #setter for first name
    public function setFirstname($newfirstname)
    {
        #check if it not empty
        if(strlen($newfirstname) == 0)
        {
            return "Firstname can't be empty";
        }
        elseif (strlen($newfirstname)> self::FNAME_MAX_LENGTH) 
        {
           return "Firstname cannot be more than 20 characters!";
        }
        else
        {
           $this->fname = $newfirstname;
           return"";
        }
    }
        
    #setter for last name  
    public function setLastname($newlastname){
        #check if it not empty
        if(strlen($newlastname)== 0)
        {
            return "Lastname cannot be empty!";
        }
        elseif (strlen($newlastname)> self::LNAME_MAX_LENGTH)
        {
            return "Lastname cannot be more than 20 characters!";
        }
        else
        {
            $this->lname = $newlastname;
            return"";
        }
    }
    
    
    
    #setter for city 
    public function setCity($newcity)
    {
        #check if it not empty
        if(strlen($newcity)== 0)
        {
            return "City cannot be empty!";
        }#check if city is not too long
        elseif (strlen($newcity)> self::CITY_MAX_LENGTH) 
        {
            return "City cannot be more than 25 characters!";
        }#set the city
        else
        {
            $this->city = $newcity;
            return"";
        }
    }
    
    
    #setter for province
    public function setProvince($newprovince){
        #check if it's not empty
        if(strlen($newprovince) == 0) 
        {
            return "Province cannot be empty!";
        }#check if province is not too long
        elseif (strlen($newprovince) > self::PROVINCE_MAX_LENGTH) 
        {
            return "Province cannot be more than 25 characters!";
        } 
        else 
        {
            $this->province = $newprovince;
            return"";
        }
    }
    
    
    #setter for address
    public function setAddress($newaddress){
        #check if the address is not empty
        if(strlen($newaddress) == 0) 
        {
            return "Address cannot be empty!";
        }#check if the address is not too long
        elseif (strlen($newaddress) > self::ADDRESS_MAX_LENGTH) 
        {
            return "Address cannot be more than 25 characters!";
        } 
        else 
        {
            $this->address = $newaddress;
            return"";
        }
    }
    
    
   #setter for postal code
   public function setPostalCode($newpostalcode){
        #check if the postalcode is not empty
        if(strlen($newpostalcode) == 0) 
        {
            return "Postalcode cannot be empty!";
        }#check if the postal code is not longer than 7 characters
        elseif (strlen($newpostalcode) > self::PCODE_MAX_LENGTH) 
        {
            return "Postalcode cannot be more than 7 characters!";
        } 
        else 
        {
            $this->pcode = $newpostalcode;
            return"";
        }
    }

    #setter for username
    public function setUserName($newusername){
        #check if it not empty
        if(strlen($newusername) == 0)
        {
            return "Username cannot be empty!";
        }
        elseif (strlen($newusername)> self::USERNAME_MAX_LENGTH) 
        {
            return "Username cannot be more than 12 characters!";
        }
        else
        {
            $this->username = $newusername;
            return"";
        }
    }
    
    
    #setter for password
    public function setPassword($newpassword)
    {
        #check if the password is not empty
        if(strlen($newpassword)== 0)
        {
            return "Password cannot be empty!";
        }#check if password is long
        elseif (strlen($newpassword)> self::PASSWORD_MAX_LENGTH) {
            return "Username cannot be more than 255 characters!";
        }#set the password into the database
        else
        {
            $this->password = sha1($newpassword);
            return"";
        }
    }    
    
    #setter for date
    public function setDate($newdate){
    
        $this->date = $newdate;
        return"";
    }
    
    #set the time
    public function setTime($newtime){
    
        $this->time = $newtime;
        return"";
    }
    

    
    //=================CREATE ALL METHODS FOR INTRACTING WITH DATABASE=======================
    
        
    #load a customer information by it's customer id  
    function load($customer_id)
    {


       global $connection;

       #call the created STORED PROCEDURE 
       $sqlQuery = "CALL select_A_customer(:customer_id)";

       #to execute the query
       $PDOStatement = $connection->prepare($sqlQuery);
       $PDOStatement ->bindParam(":customer_id",$customer_id);
       $PDOStatement ->execute();

       #check if the customer with this id is found and put it's infromation in the object
       if($row = $PDOStatement-> fetch())
       {

           #get infromation from data base 
           $this-> customer_id = $row["customer_id"];
           $this->fname = $row["customer_fname"];
           $this->lname = $row["customer_lname"];
           $this->address= $row["customer_address"];
           $this->city= $row["customer_city"];
           $this->province= $row["customer_province"];
           $this->pcode= $row["customer_pcode"];
           $this->username= $row["customer_username"];
           $this->password= $row["customer_pass"];
           $this->date= $row["customer_date"];
           $this->time= $row["customer_time"];
           return true;

        }

    }
    
    #create a function to save a customer into database
    function Save()
    {
        #use global connection to connect to database
        global $connection;
        
        #for testing purposes;
        
        #check if this customer id  does not exist in database then  insert customer
        if($this->customer_id == "")
        {
            #call the stored procedures to insert
            $sqlQuery ="CALL customer_insertion(:fname, :lname, :username, :password, :city, :address, :province, :pcode);";
            #insert into the data base
            $PDOStatement = $connection->prepare($sqlQuery);
            $PDOStatement ->bindParam(":fname",$this->fname);
            $PDOStatement ->bindParam(":lname",$this->lname);
            $PDOStatement ->bindParam(":city",$this->city);
            $PDOStatement ->bindParam(":address",$this->address);
            $PDOStatement ->bindParam(":province",$this->province);
            $PDOStatement ->bindParam(":postalcode",$this->pcode);
            $PDOStatement ->bindParam(":username",$this->username);
            $PDOStatement ->bindParam(":password",$this->password);

            #then execute the command
            $PDOStatement ->execute();
            
            #everything goes well so return true
            return true;
        }
        else
        {
            #if the customer id exist then it will update information into database
            $sqlQuery ="CALL customers_update(:customer_id, :fname, :lname, :username, :password, :city, :address, :province, :pcode);";
            $PDOStatement = $connection->prepare($sqlQuery);
            # update the customer information
            $PDOStatement ->bindParam(":customer_id",$this->customer_id);
            $PDOStatement ->bindParam(":fname",$this->fname);
            $PDOStatement ->bindParam(":lname",$this->lname);
            $PDOStatement ->bindParam(":city",$this->city);
            $PDOStatement ->bindParam(":address",$this->address);
            $PDOStatement ->bindParam(":province",$this->province);
            $PDOStatement ->bindParam(":postalcode",$this->pcode);
            $PDOStatement ->bindParam(":username",$this->username);
            $PDOStatement ->bindParam(":password",$this->password);
            
            #then execute the command
            $PDOStatement ->execute();
            
            #everything goes well so return true
            return true;
        }
        
    }
    
    
  #create a method for deleting info from database
  function delete()
  {
        #check if you have a primary key(uuid()) and then delete that row
        global $connection;
        
        #call your STORED PROCEDURE
        #check if the customer exist in the data base
        if($this->customer_id == ":customer_id")
        {
            #delete the customer if the id found in data base
            $sqlQuery = "CALL customer_delete(:customer_id)";
            $PDOStatement = $connection->prepare($sqlQuery);
            $PDOStatement ->bindParam(":customer_id",$this->customer_id);
            $PDOStatement ->execute();
            return true;
        }
        else
        {
            echo "This customer id does not exist.";
            return false;
        }

   }
   
 
//      #create a method for deleting info from database
//    function login($user, $pwd)
//    {
//        #check if you have a primary key(uuid()) and then delete that row
//        global $connection;
//        
//        #with procedure
//                $SQLQuery = "CALL `login`(:user, :pwd)";
//                
//                #prepare the sql query and binf the parameters
//                $PDOStatement = $connection->prepare($SQLQuery);
//
//                #bind parameters to variables
//                $PDOStatement->bindParam(":user", $user);
//                $PDOStatement->bindParam(":pwd", $pwd);
//                
//                #create a PDO statement object
//                $PDOStatement->execute();
//          #foreach($PDOstatement as $row)
//                # ->fetch(PDO::FETCH_ASSOC)
//                while ($row = $PDOStatement->fetch()) 
//                {
//                    echo "<br> welcome " . $row["customer_fname"];
//                }
//        #call your STORED PROCEDURE
//        #check if the customer exist in the data base
//        if($this->username == $user)
//        {
//            if($this->password == ":pwd")
//            {
//                
//                #foreach($PDOstatement as $row)
//                # ->fetch(PDO::FETCH_ASSOC)
//                while ($row = $PDOStatement->fetch()) 
//                {
//                    echo "<br> welcome " . $row["customer_fname"];
//                }
//                
//                return true;
//            }
//            else
//            {
//                echo "This Password does not exist!";
//                return false;                
//            }
//  
//        }
//        else
//        {
//            echo "This user name does not exist!";
//            return false;
//        }
//   } 
   
   
   
   function login($Username,$Password)
   {
        #check if you have a primary key
        
        #if yes, delete that row
         
           global $connection;
        
           #call your STORED PROCEDURE
           #check if the customer exist in the data base

           
        $sqlQuery = "CALL `login`(:Username, :Password);";

        $PDOStatement = $connection->prepare($sqlQuery);
        $PDOStatement ->bindParam(":Username", $Username);
        $PDOStatement ->bindParam(":Password",$Password);
        $PDOStatement ->execute();
        
            if($row = $PDOStatement-> fetch())
            {
            
                $this->customer_id= $row["customer_id"];
                $this->fname= $row["customer_fname"];
                $this->lname= ["customer_lname"];
                $this->username= $row["customer_username"];
                $this->password= $row["customer_pass"];
                $this->city= $row["customer_city"];
                $this->province= $row["customer_province"];
                $this->address= $row["customer_address"];
                $this->pcode= $row["customer_pcode"];
                $this->date= $row["customer_date"];
                $this->time= $row["customer_time"];

                 return true;
            }
            
            return false;
      
         
    }
}