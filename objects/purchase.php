<?php
#Revision History            DATE         COMMENTS
#Alireza Gholami 1921230     2020-04-26     create private variables/getter and setters/constructors/and 3 methods delete,save,load


#import the PHP commin function file
require_once 'php/connection.php';


class purchase {
    
#define constant variable for validations of each private fields.
const QUANTITY_MAX_LENGTH = 999;
const COMMENT_MAX_LENGTH = 200;
const UUID_MAX_LENGTH = 36;
    
    
    #define private variables for customer
    private $purchaseID="";
    private $fkCustomer="";
    private $fkProduct="";
    private $quantity="";
    private $comment="";
    private $date;
    private $time;
    

    //create a function constractor to recive prameters
    function __construct($newpurchaseID="",$newFkCustomer,$newFkProduct,$newQuantity,
            $newComment , $newDate="", $newTime="")
    {
        
        #this purchaseID called everytime "= new purchase()" is called
        if($newpurchaseID<>""){
            $this->setPurchaseID($newpurchaseID);
        }
        
        #check if customerID is not empty
        if($newFkCustomer<>""){
            $this->setFkCustomer($newFkCustomer);
        }
        
         #check if product ID is not empty
        if($newFkProduct<>""){
            $this->setFkProduct($newFkProduct);
        }
        
         #check if quantity is not empty
        if($newQuantity<>""){
            $this->setQuantity($newQuantity);
        }
        
         #check if comment is not empty
        if($newComment<>""){
            $this->setComment($newComment);
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
        public function getPurchaseID(){
            #use "self" when you want to access CONSTANTS
            #echo self::DEAFULT_purchaseID;
            #use this (*current object) when you want to acces variables
            return $this->purchaseID;
        }
        public function getFkCustomer()
        {
            #USE this current object
            return $this->fkCustomer;
        }
        public function getFkProduct()
        {
            #USE this current object
            return $this->fkProduct;
        }
        public function getQuantity()
        {
            #USE this current object
            return $this->quantity;
        }
        public function getComment()
        {
            #USE this current object
            return $this->comment;
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
    public function setPurchaseID($newpurchaseID)
    {
        #check if it not empty
        if(strlen($newpurchaseID) == 0){
            return "The purchase ID connot be empty!";
        }
        else{
         
         $this->purchaseID = $newpurchaseID;
         return"";
         
        }
    }
    
    #setter for customer ID code
    public function setFkCustomer($newFkCustomer)
    {
        #check if it not empty
        if(strlen($newFkCustomer) == 0)
        {
            return "Customer ID can't be empty!";
        }
        elseif (strlen($newFkCustomer)> self::UUID_MAX_LENGTH) 
        {
           return "Customer ID cannot be more than ". UUID_MAX_LENGTH ." characters!";
        }
        else
        {
           $this->fkCustomer = $newFkCustomer;
           return"";
        }
    }

    
    #setter for product ID
    public function setFkProduct($newFkProduct)
    {
        #check if it not empty
        if(strlen($newFkProduct)== 0)
        {
            return "Product ID cannot be empty!";
        }#check if product ID is not too long
        elseif (strlen($newFkProduct)> self::UUID_MAX_LENGTH) 
        {
            return "Product ID cannot be more than ". UUID_MAX_LENGTH ." characters!";
        }#set the product ID
        else
        {
            $this->fkProduct = $newFkProduct;
            return"";
        }
    }
    
    
    #setter for quantity
    public function setQuantity($newQuantity){
        #check if it's not empty
        if(!is_numeric($newQuantity)) 
        {
            return "Please enter a numeric value!";
        }#check if quantity is not too long
        elseif ($newQuantity > self::QUANTITY_MAX_LENGTH) 
        {
            return "Please enter a numeric value less than " . QUANTITY_MAX_LENGTH;
        } 
        else 
        {
            $this->quantity = $newQuantity;
            return"";
        }
    }
    
    
    #setter for comment
    public function setComment($newComment)
    {
        #check if comment is not too long
        if (strlen($newComment)> self::COMMENT_MAX_LENGTH) 
        {
            return "Comment cannot be more than ". COMMENT_MAX_LENGTH ." characters!";
        }#set the Comment
        else
        {
            $this->comment = $newComment;
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
    
        
    #load a purchaseI  information by it's purchase id  
    function load($purchaseID)
    {


       global $connection;

       #call the created STORED PROCEDURE 
       $sqlQuery = "CALL select_A_purchase(:purchaseID)";

       #to execute the query
       $PDOStatement = $connection->prepare($sqlQuery);
       $PDOStatement ->bindParam(":purchaseID",$purchaseID);
       $PDOStatement ->execute();

       #check if the purchaseID with this id is found and put it's infromation in the object
       if($row = $PDOStatement-> fetch())
       {

           #get infromation from data base 
           $this-> purchaseID = $row["purchase_id"];
           $this->fkCustomer = $row["fk_customer"];
           $this->fkProduct = $row["fk_product"];
           $this->quantity= $row["purchase_quantity"];
           $this->comment= $row["purchase_comment"];
           $this->date= $row["product_date"];
           $this->time= $row["product_time"];
           return true;

        }

    }
    
    #create a function to save a purchase into database
    function Save()
    {
        #use global connection to connect to database
        global $connection;
        
        
        #check if this purchaseID does not exist in database then  insert customer
        if($this->purchaseID == "")
        {
            #call the stored procedures to insert
            $sqlQuery ="CALL purchases_insertion(:fkCustomer, :fkProduct, :quantity, :comment);";
            #insert into the data base
            $PDOStatement = $connection->prepare($sqlQuery);
            $PDOStatement ->bindParam(":fkCustomer",$this->fkCustomer);
            $PDOStatement ->bindParam(":fkProduct",$this->fkProduct);
            $PDOStatement ->bindParam(":quantity",$this->quantity);
            $PDOStatement ->bindParam(":comment",$this->comment);

            #then execute the command
            $PDOStatement ->execute();
            
            #everything goes well so return true
            return true;
        }
        else
        {
            #if the purchaseID exist then it will update information into database
            $sqlQuery ="CALL purchases_update(:purchaseID, :fkCustomer, :fkProduct, :quantity, :comment);";
            $PDOStatement = $connection->prepare($sqlQuery);
            # update the customer information
            $PDOStatement ->bindParam(":purchaseID",$this->purchaseID);
            $PDOStatement ->bindParam(":fkCustomer",$this->fkCustomer);
            $PDOStatement ->bindParam(":fkProduct",$this->fkProduct);
            $PDOStatement ->bindParam(":quantity",$this->quantity);
            $PDOStatement ->bindParam(":comment",$this->comment);
            
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
        #check if the purchaseID exist in the data base
        if($this->purchaseID == ":purchaseID")
        {
            #delete the customer if the id found in data base
            $sqlQuery = "CALL purchases_delete(:purchaseID)";
            $PDOStatement = $connection->prepare($sqlQuery);
            $PDOStatement ->bindParam(":purchaseID",$this->purchaseID);
            $PDOStatement ->execute();
            return true;
        }
        else
        {
            echo "This purchase ID does not exist.";
            return false;
        }

   }
    
    
    
    
}



