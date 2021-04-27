<?php
#Revision History            DATE         COMMENTS
#Alireza Gholami 1921230     2020-04-26     create private variables/getter and setters/constructors/and 3 methods delete,save,load


#import the PHP commin function file
require_once 'php/connection.php';


class product {
    
#define constant variable for validations of each private fields.
const PRODUCT_CODE_MAX_LENGTH = 12;
const DESCRIPTION_MAX_LENGTH = 100;
const PRICE_MAX_LENGTH = 10000;

    
    
    #define private variables for customer
    private $product_id="";
    private $code="";
    private $description="";
    private $price="";
    private $costPrice="";
    private $date;
    private $time;
    

    //create a function constractor to recive prameters
    function __construct($newProductId="",$newCode,$newDescription,$newPrice,
            $newCostPrice , $newDate="", $newTime="")
    {
        
        #this product id called everytime "= new product()" is called
        if($newProductId<>""){
            $this->setProductID($newProductId);
        }
        
        #check if code is not empty
        if($newCode<>""){
            $this->setCode($newCode);
        }
        
         #check if description is not empty
        if($newDescription<>""){
            $this->setDescription($newDescription);
        }
        
         #check if price is not empty
        if($newPrice<>""){
            $this->setPrice($newPrice);
        }
        
        
         #cost price doesnt need to check because it allows to be null
        
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
   public function getProductId(){
        #use "self" when you want to access CONSTANTS
        #echo self::DEAFULT_product id;
        #use this (*current object) when you want to acces variables
        return $this->product_id;
        }
        public function getCode()
        {
            #USE this current object
            return $this->code;
        }
        public function getDescription()
        {
            #USE this current object
            return $this->description;
        }
        public function getPrice()
        {
            #USE this current object
            return $this->price;
        }
        public function getCostPrice()
        {
            #USE this current object
            return $this->costPrice;
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
    public function setProductId($newProductId)
    {
        #check if it not empty
        if(strlen($newProductId) == 0){
            return "The Product ID connot be empty!";
        }
        else{
         
         $this->product_id = $newProductId;
         return"";
         
        }
    }
    
    #setter for product code
    public function setCode($newCode)
    {
        #check if it not empty
        if(strlen($newCode) == 0)
        {
            return "Product Code can't be empty!";
        }
        elseif (strlen($newCode)> self::PRODUCT_CODE_MAX_LENGTH) 
        {
           return "PRODUCT CODE cannot be more than 12 characters!";
        }
        else
        {
           $this->code = $newCode;
           return"";
        }
    }

    
    #setter for Description
    public function setDescription($newDescription)
    {
        #check if it not empty
        if(strlen($newDescription)== 0)
        {
            return "Description cannot be empty!";
        }#check if Description is not too long
        elseif (strlen($newDescription)> self::DESCRIPTION_MAX_LENGTH) 
        {
            return "Description cannot be more than 100 characters!";
        }#set the Description
        else
        {
            $this->description = $newDescription;
            return"";
        }
    }
    
    
    #setter for Price
    public function setPrice($newPrice){
        #check if it's not empty
        if(!is_numeric($newPrice)) 
        {
            return "Please enter a numeric value!";
        }#check if price is not too long
        elseif ($newPrice > self::PRICE_MAX_LENGTH) 
        {
            return "Please enter a numeric value less than " . PRICE_MAX_LENGTH;
        } 
        else 
        {
            $this->price = $newPrice;
            return"";
        }
    }
    
    
    #setter for Cost Price 
    public function setCostPrice($newCostPrice){
        #check if it's not empty
        if(!is_numeric($newCostPrice)) 
        {
            return "Please enter a numeric value!";
        }#check if CostPrice  is not too long 
        else 
        {
            $this->costPrice = $newCostPrice ;
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
    
        
    #load a product information by it's product id  
    function load($product_id)
    {


       global $connection;

       #call the created STORED PROCEDURE 
       $sqlQuery = "CALL select_A_product(:product_id)";

       #to execute the query
       $PDOStatement = $connection->prepare($sqlQuery);
       $PDOStatement ->bindParam(":product_id",$product_id);
       $PDOStatement ->execute();

       #check if the product_id with this id is found and put it's infromation in the object
       if($row = $PDOStatement-> fetch())
       {

           #get infromation from data base 
           $this-> product_id = $row["product_id"];
           $this->code = $row["product_code"];
           $this->description = $row["product_description"];
           $this->Price= $row["product_price"];
           $this->costPrice= $row["product_cost_price"];
           $this->date= $row["product_date"];
           $this->time= $row["product_time"];
           return true;

        }

    }
    
    #create a function to save a product into database
    function Save()
    {
        #use global connection to connect to database
        global $connection;
        
        
        #check if this customer id  does not exist in database then  insert customer
        if($this->product_id == "")
        {
            #call the stored procedures to insert
            $sqlQuery ="CALL product_insertion(:code, :description, :Price, :costPrice);";
            #insert into the data base
            $PDOStatement = $connection->prepare($sqlQuery);
            $PDOStatement ->bindParam(":code",$this->code);
            $PDOStatement ->bindParam(":description",$this->description);
            $PDOStatement ->bindParam(":Price",$this->Price);
            $PDOStatement ->bindParam(":costPrice",$this->costPrice);

            #then execute the command
            $PDOStatement ->execute();
            
            #everything goes well so return true
            return true;
        }
        else
        {
            #if the customer id exist then it will update information into database
            $sqlQuery ="CALL products_update(:product_id, :code, :description, :Price, :costPrice);";
            $PDOStatement = $connection->prepare($sqlQuery);
            # update the customer information
            $PDOStatement ->bindParam(":product_id",$this->product_id);
            $PDOStatement ->bindParam(":code",$this->code);
            $PDOStatement ->bindParam(":description",$this->description);
            $PDOStatement ->bindParam(":Price",$this->Price);
            $PDOStatement ->bindParam(":costPrice",$this->costPrice);
            
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
        #check if the product_id exist in the data base
        if($this->product_id == ":product_id")
        {
            #delete the customer if the id found in data base
            $sqlQuery = "CALL products_delete(:product_id)";
            $PDOStatement = $connection->prepare($sqlQuery);
            $PDOStatement ->bindParam(":product_id",$this->product_id);
            $PDOStatement ->execute();
            return true;
        }
        else
        {
            echo "This product id does not exist.";
            return false;
        }

   }
    
    
    
    
}

