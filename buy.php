<?php
#Revision history 
#2021-5-1      Alireza Gholami     Creating This page


    
    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");

    #local tax
    define("LOCAL_TAX", 15.2);
    
    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);
    
    #use created function to force user to enter with HTTPS
    enterHTTPS();
    
    require_once 'objects/purchase.php';
    
    #creating Error and excepthion handeler to avoidng display server side problems to end users.
    set_error_handler("manageError");
    set_exception_handler("manageExceptions"); 

      #Call the function to create title and all the HTML tags
        createPageHeder("Buy Page");
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
               
                CreateLoginPage();
            }
            else 
            {
                $customer = new customer();
                
                $userSSS = $_SESSION["user"];
              
                $customer->load($userSSS);
                ?> <h2 class="top-message"> Welcome Back <?php  echo $customer->getFirstName() ." ". $customer->getLastName(). "</h2>";
                
                ?>
                <div class="top-message">
                    <form  action="index.php" method="post">
                        <input type="submit" value="L O G O U T" name="logout">
                    </form>
                </div><br><br>
                    
                    <!-- create a buying form -->
                <?php
                $errorComments = "";
                $errorProduct = "";
                $errorQuantity = "";
                
                
                $products = new products();
                $product = new product();
                $pCode = "";
                
                $price=0;
                $quantity=0;
                $subtotal=0;
                $taxCalculation=0;
                $taxesAmount =0;
                #if login button clicked
                if(isset($_POST["buy"]))
                {    
                    $purchase = new purchase();
                    #check if setQuantity and setComment have errors
                    if($purchase->setQuantity(htmlspecialchars(trim($_POST["quantity"]))) != "" || $purchase->setComment(htmlspecialchars(trim($_POST["comments"]))) != "" || $_POST["product"] = "")
                    {
                        #then save errors in a variable to show the user
                        $errorQuantity = $purchase->setQuantity($_POST["quantity"]);
                        $errorComments = $purchase->setComment($_POST["comments"]);
                        $errorProduct = "At least one product must be selected.";
                        #Header message
                        ?><h2 class="top-message" >Please fill all the necessary fields.</h2><?php
                    }
                    else
                    {

                      
                      $product->load($_POST["Product"]) ;


                       $price = (float)$product->getPrice();
                       $quantity = (int)$_POST["quantity"];
                       $subtotal = $price * $quantity;
                       $taxCalculation =  LOCAL_TAX / 100;
                       $taxesAmount = $subtotal * $taxCalculation;
                       $grandTotal = $taxesAmount + $subtotal; 


                        $purchase->setFkCustomer($userSSS);
                        $purchase->setFkProduct($_POST["Product"]);
                        $purchase->setQuantity($_POST["quantity"]);
                        $purchase->setComment($_POST["comments"]);
                        
                        
                        $purchase->setPrice($price);
                        $purchase->setSubTotal($subtotal);
                        $purchase->setTaxAmount($taxesAmount);
                        $purchase->setGrandTotal($grandTotal);
   
                        
                        $purchase->Save();

                        if(alert("Congrats, You made the purchase."))
                        {
                            header('Location: buy.php');
                            exit(); 
                        }
                        
                        
                    }
                }
                
                ?>
                <h2 class="top-message" >Please fill all the necessary fields.</h2>
                <div class="container">
                    <form action="buy.php" method="post">
                        <!-- First text section for product -->
                        <h3 class="requierd">* = required</h3>
                        <hr class="hr-form">
                        <label class="lbl">Product code:</label><span class="star">*</span><br>
                        <!-- set the value to product -->
                        <select name="Product" >
                            
                            <?php   
                            foreach ($products->items as $product)
                            {
                                ?> <option value="<?php echo $product->getProductId() ?>"> <?php echo $product->getCode() . " - " . $product->getDescription() . " (". $product->getPrice() . "$". ")" ?> </option > <?php
                            }
                                
                            ?>      
                        </select><br>
                        <span class="error" >
                            <!-- if it has error then save it into errorProduct variable -->
                            <?php echo $errorProduct; ?>

                        </span><br>
                        <!-- First text section for quantity -->
                        <label class="lbl">Quantity:</label><span class="star">*</span><br>
                        <input type="text" name="quantity"  placeholder="Product Quantity..." ><br>
                        <span class="error">
                            <?php echo $errorQuantity; ?>
                        </span><br>

                        <!-- First text section for comments -->
                        <label class="lbl">Comment:</label><br>
                        <textarea class="comment" type="text" name="comments" placeholder="If You Have Any Comment..." ></textarea><br>
                        <span class="error">
                            <?php echo $errorComments; ?>
                        </span><br>
                       <!-- submit button to save data into text file --> 
                      <input type="submit" value="B U Y" name="buy">
                    </form>
                </div> 
            
                <?php 
                
                
                //if logout clicked
                if(isset($_POST["logout"]))
                {
                    deleteCookie();
                }
            }

    

        #call function to create footer
        createPageFooter();