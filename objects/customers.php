<?php
#Revision History            DATE         COMMENTS
#Alireza Gholami 1931230     2020-04-26   create the class and it's constructor

#import the classes connection/collection and customers
require_once 'php/connection.php';
require_once 'php/collection.php';
require_once 'customer.php';


class customers  extends collection{
       
    function __construct() 
    {
        #establish a connection with database
        global $connection;
 
        #call the procedure
        #select all the customers from the database
        $SQLQuery ="CALL select_all_customers;";
        #prepare the command
        $PDOStatement = $connection->prepare($SQLQuery);
        
        #execute the command
        $PDOStatement->execute();
        
        #put all customer into collection 
        while($row = $PDOStatement->fetch())
        {
            #create a new customer object with all prameters
            $customer = new customer(
                $row["customer_id"] ,
                $row["customer_fname"],
                $row["customer_lname"],
                $row["customer_address"],
                $row["customer_city"],
                $row["customer_province"],
                $row["customer_pcode"],
                $row["customer_username"],
                $row["customer_pass"],
                $row["customer_date"],
                $row["customer_time"]);
                
                #add this customer to array list.
                $this->add($row["customer_id"], $customer);
            
        }
    }
}



