<?php
#Revision History            DATE         COMMENTS
#Alireza Gholami 1931230     2020-04-26   create the class and it's constructor

#import the classes connection/collection and customers
require_once 'php/connection.php';
require_once 'php/collection.php';
require_once 'product.php';


class products  extends collection{
       
    function __construct() 
    {
        #establish a connection with database
        global $connection;
 
        #call the procedure
        #select all the customers from the database
        $SQLQuery ="CALL select_all_products;";
        #prepare the command
        $PDOStatement = $connection->prepare($SQLQuery);
        
        #execute the command
        $PDOStatement->execute();
        
        #put all products into collection 
        while($row = $PDOStatement->fetch())
        {
            #create a new product object with all prameters
            $product = new product(
                $row["product_id"] ,
                $row["product_code"],
                $row["product_description"],
                $row["product_price"],
                $row["product_cost_price"],
                $row["product_date"],
                $row["product_time"]);
                
                
                #add this product to array list.
                $this->add($row["product_id"], $product);
            
        }
    }
}

