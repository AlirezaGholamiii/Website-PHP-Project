<?php
#Revision History            DATE         COMMENTS
#Alireza Gholami 1931230     2020-04-26   create the class and it's constructor

#import the classes connection/collection and customers
require_once 'php/connection.php';
require_once 'php/collection.php';
require_once 'purchase.php';


class purchases extends collection{
       
    function __construct($customer_id) 
    {
        #establish a connection with database
        global $connection;
 
        #call the procedure
        #select all the customers from the database
        $SQLQuery ="CALL Filter_purchases;";
        #prepare the command
        $PDOStatement = $connection->prepare($SQLQuery);
        $PDOStatement->bindparam(":customer_id",$customer_id);
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
                $row["price"],
                $row["subtotal"],
                $row["taxes_amount"],
                $row["grand_total"],
                $row["purchase_date"],
                $row["purchase_time"]);
                
                #add this purchase to array list.
                $this->add($row["purchase_id"], $purchase);
            
        }
    }
    
    
    function SearchWithYear($year) 
    {
        global $connection;
        
        #call your stored prucedure
        
        $sqlQuary = "SELECT car_id, brand, year, transmission FROM cars WHERE year >= :year ORDER BY year desc";
        
        $PDOStatement = $connection->prepare($sqlQuary);
        $PDOStatement->bindparam(":year",$year);
        $PDOStatement->execute();
        
        while($row = $PDOStatement->fetch())
        {
            $car = new car($row["car_id"], $row["brand"], $row["year"]);
            $this->add($row["car_id"], $car);
             
        }
    }
}
