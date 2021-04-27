<?php
#Revision History            DATE         COMMENTS
#Alireza Gholami 1931230     2020-04-26   create the class and it's constructor

#import the classes connection/collection and customers
require_once 'php/connection.php';
require_once 'php/collection.php';
require_once 'purchase.php';


class purchases extends collection{
       
    function __construct() 
    {
        #establish a connection with database
        global $connection;
 
        #call the procedure
        #select all the customers from the database
        $SQLQuery ="CALL select_all_purchases;";
        #prepare the command
        $PDOStatement = $connection->prepare($SQLQuery);
        
        #execute the command
        $PDOStatement->execute();
        
        #put all customer into collection 
        while($row = $PDOStatement->fetch())
        {
            #create a new purchase object with all prameters
            $purchase = new purchase(
                $row["purchase_id"] ,
                $row["fk_customer"],
                $row["fk_product"],
                $row["purchase_quantity"],
                $row["purchase_comment"],
                $row["purchase_date"],
                $row["purchase_time"]);
                
                #add this purchase to array list.
                $this->add($row["purchase_id"], $purchase);
            
        }
    }
}
