<?php
#Revision history 
#2021-5-3      Alireza Gholami     Creating This page


    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");

    
    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);
    
    #use created function to force user to enter with HTTPS
    enterHTTPS();
    
    require_once 'objects/purchase.php';
    
    #creating Error and excepthion handeler to avoidng display server side problems to end users.
    set_error_handler("manageError");
    set_exception_handler("manageExceptions"); 

      #Call the function to create title and all the HTML tags
        createPageHeder("Purchase Page");
    ?>
        <!-- Creating a block to show logo and nav bar in one block -->
        <div class="navigation-menu">
            <?php
                #calling function logo to create logo
                CreateLogo();
                #calling function to create nav bar in the top
                createNavigationMenu();
            ?>
        </div >
    <?php

            #this blockof code must place before the html code because it works with headers
            #check if the save button has been clicked
            session_start();
            //echo "you need to log in to view this page.";
            if(readCookie() == "")
            {
                echo "you need to log in to view this page.";
                CreateLoginPage();
            }
            else 
            {
                $customer = new customer();
                
                $userSSS = $_SESSION["user"];
              
                $customer->load($userSSS);
                ?> <h2 class="top-message"> Welcome Back <?php  echo $customer->getFirstName() ." ". $customer->getLastName(). "</h2>";
                ?> <h2 class="top-message"> Your seesion is: <?php  echo $userSSS . "</h2>";
                ?>
                <div class="top-message">
                    <form  action="index.php" method="post">
                        <input type="submit" value="L O G O U T" name="logout">
                    </form>
                </div><br><br>
                
            <?php

                #if search button clicked
                if(isset($_POST["search"]))
                {    
                    $purchase = new purchase();
                    #check if setQuantity and setComment have errors
                    if($_POST["date"] = "" || validateDate($_POST["date"]) == false)
                    {
                     
                        $purchase = new purchase($userSSS);
                        
                        $purchase->setFkCustomer($userSSS);
                        $purchase->setFkProduct($_POST["Product"]);
                        $purchase->setQuantity($_POST["quantity"]);
                        $purchase->setComment($_POST["comments"]);
                        
                        $purchase->setPrice($price);
                        $purchase->setSubTotal($subtotal);
                        $purchase->setTaxAmount($taxesAmount);
                        $purchase->setGrandTotal($grandTotal);
                        
                    }
                    else
                    {

                       $pCode = $_POST["Product"];
                       $product->load("2378c9bb-a643-11eb-901d-0c9d923793e4") ;

                        

                                          
                        
                        $purchase->setFkCustomer($userSSS);
                        $purchase->setFkProduct($_POST["Product"]);
                        $purchase->setQuantity($_POST["quantity"]);
                        $purchase->setComment($_POST["comments"]);
                        
                        $purchase->setPrice($price);
                        $purchase->setSubTotal($subtotal);
                        $purchase->setTaxAmount($taxesAmount);
                        $purchase->setGrandTotal($grandTotal);

                        //$purchase->Save();

                        if(alert("Congrats, You made the purchase."))
                        {
                            header('Location: buy.php');
                            exit(); 
                        }
                        
                        
                    }
                }
                ?>
                    <!-- create the table to ask date form -->
                    
                    <div class="container">
                        <form action="purchases.php" method="post">
                        <!-- First text section for product -->
                        <h3 class="requierd">* = required</h3>
                        <hr class="hr-form">

                    
                        <!-- First text section for quantity -->
                        <label class="lbl">Date:</label><span class="star"></span><br>
                        <input type="text" name="date"  placeholder="Date Ex: 2021-05-30..." ><br>
                        </span><br>

                       <!-- submit button to save data into text file --> 
                      <input type="submit" value="SEARCH" name="search">
                    </form>
                </div> 
                <?php
                
                                ?>  
                    <!-- create a table -->
                <div class="table-continer">
                <table >
                <!-- Create one row -->
                <tr class="row">
                    <!-- Create one column and its contents -->
                    <td>Delete </td>
                    <td>Product ID </td>
                    <td>First name </td>
                    <td>Last name </td>
                    <td>City </td>
                    <td>Price </td>
                    <td>Quantity </td>
                    <td>Comment </td>
                    <td>Subtotal </td>
                    <td>Taxes </td>
                    <td>Grand total </td>
                </tr>
                <?php
                
                //if logout clicked
                if(isset($_POST["logout"]))
                {
                    deleteCookie();
                }
            }

    

        #call function to create footer
        createPageFooter();