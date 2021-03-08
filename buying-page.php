<?php
#Revision history 
#2021-03-06      Alireza Gholami     Creating This page/ adding all the form html / all the validation for the form
#2021-03-07      Alireza Gholami     Finalize calculation part / saving form data to txt file / testing new part / debuging text file

      
    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
    #declare new path for txt file
    define("FOLDER_DATA" , 'data/');
    define("FILE_DATA_purchases", FOLDER_DATA . 'purchases.txt');

    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);
    
    
    #declare content
    define("product_MAX_LENGHT", 12);
    define("FNAME_MAX_LENGHT",20);
    define("LNAME_MAX_LENGHT",20);
    define("CITY_MAX_LENGHT",8);
    define("COMMENTS_MAX_LENGHT",200);
    define("PRICE_MIN_LENGHT",0);
    define("PRICE_MAX_LENGHT",10000);
    define("QUANT_MIN_LENGHT",1);
    define("QUANT_MAX_LENGHT",99);
    #Local tax amount
    define("LOCAL_TAX", 12.05);
    
    
    
    #creating variable to store errors 
    $errorProduct = "";
    $errorFname = "";
    $errorLname = "";
    $errorCity = "";
    $errorComments = "";
    $errorPrice = "";
    $errorQuantity = "";
    #creating variables to store value of each input
    $product ="";
    $fname="";
    $lname="";
    $city="";
    $comments="";
    $price="";
    $quantity="";
    
       
    

    //set_error_handler("manageError");
    //set_exception_handler("manageExceptions");

        #Call the function to create title and all the HTML tags
        createPageHeder("Buying Page");
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


  
    
    #check if the save button has been clicked
    if(isset($_POST["save"]))
    {
        $product = htmlspecialchars(trim($_POST["product"]));
        if(! $product == "")
        {
            if(! (substr($product, 0,1) == "P" ||  substr($product, 0,1) == "p"))
            {
                $errorProduct = "The first word must be P or p.";
            }
            elseif (mb_strlen($product) > product_MAX_LENGHT) 
            {
                $errorProduct ="The Product Code cannot contain more than ". product_MAX_LENGHT . " Character";
            }   
        }
        else 
        {
            $errorProduct = "The product Code cannot be empty";
        }
        
        
        
        
        
        #check the First name is emty
        $fname = htmlspecialchars(trim($_POST["fname"]));
        if($fname == "")
        {
            
            $errorFname = "Your First Name cannot be empty";
        }
        else
        {
            if(mb_strlen($fname) > FNAME_MAX_LENGHT)
            {
                $errorFname ="First Name cannot contain more than ". FNAME_MAX_LENGHT . " Character";
            }
        }
        
        #check the $lname is emty
        $lname = htmlspecialchars(trim($_POST["lname"]));
        if($lname == "")
        {
            
            $errorLname = "Your Last Name cannot be empty";
        }
        else
        {
            if(mb_strlen($lname) > LNAME_MAX_LENGHT)
            {
                $errorLname ="Your Last Name cannot contain more than ". LNAME_MAX_LENGHT . " Character";
            }
        }
        
        
        #check the $city is emty
        $city = htmlspecialchars(trim($_POST["city"]));
        if($city == "")
        {
            
            $errorCity = "The City cannot be empty";
        }
        else
        {
            if(mb_strlen($city) > CITY_MAX_LENGHT)
            {
                $errorCity ="The City cannot contain more than ". CITY_MAX_LENGHT . " Character";
            }
        }
        
        #check the comment is no longer than 200 char
        $comments = htmlspecialchars(trim($_POST["comments"]));
        if(mb_strlen($comments) > COMMENTS_MAX_LENGHT)
        {
            $errorComments ="Your comment cannot contain more than ". COMMENTS_MAX_LENGHT . " Character";
        }
        
        
        
        #check the price is empty or not
        $price = htmlspecialchars(trim($_POST["price"]));
        if(!is_numeric($price))
        {
            
            $errorPrice = "Please enter a numeric value bettween " . PRICE_MIN_LENGHT . " and "
                    . PRICE_MAX_LENGHT;
        }
        else
        {
            if($price < PRICE_MIN_LENGHT || $price > PRICE_MAX_LENGHT)
            {
                $errorPrice = "Please enter a numeric value bettween" . PRICE_MIN_LENGHT . " and "
                    . PRICE_MAX_LENGHT;
            }
        }
        
       
      #check the quantity is empty or not
        $quantity = htmlspecialchars(trim($_POST["quantity"]));
        if(!is_numeric($quantity))
        {
            
            $errorQuantity = "Please enter a numeric value bettween " . QUANT_MIN_LENGHT . " and "
                    . QUANT_MAX_LENGHT;
        }
        else
        {
            if(is_numeric($quantity) && floor($quantity) != $quantity)
            {
                $errorQuantity = "Decimal numbers are not acceptable!";
                
            }
            else 
            {
                if($quantity < QUANT_MIN_LENGHT || $quantity > QUANT_MAX_LENGHT)
                {
                $errorQuantity = "Please enter a numeric value bettween " . QUANT_MIN_LENGHT . " and "
                    . QUANT_MAX_LENGHT;
                }
                
            }
            
            
        }
        
        
        
        #after all validation check if the errors found
        if($errorProduct=="" && $errorFname== "" && $errorLname== "" && $errorCity== "" && $errorComments== "" && $errorPrice=="" && $errorQuantity== "")
        {
            #Calculating of transaction price with tax
            $subtotal = $price * $quantity;
            $taxPercentage = LOCAL_TAX / 100;
            $taxAmount = (float) number_format($taxPercentage * $subtotal , 2);
            $grandTotal = $subtotal + $taxAmount;
            $FinalPrice = (float) number_format($grandTotal , 2);
            
            #Create an array and store all the data in the array
            $array = array($product, $fname, $lname, $city, $price ,$quantity, $comments, $subtotal, $taxAmount, $FinalPrice);
            
            #convert array into jason
            $js = json_encode($array);
            
            #save json array into the text file
            file_put_contents(FILE_DATA_purchases , $js . "\n", FILE_APPEND);
          
            #send the user to succeed page 
            header('Location: succeed.php');
            die();
            #no error occured
            $product=""; $fname=""; $lname=""; $city=""; $comments=""; $price=""; $quantity="";
             
            
            ?><h2 class="top-message" >Congrats, You made the purchase.</h2><?php
        }
    }
    else 
    {
        ?><h2 class="top-message" >PLEASE FIIL THIS FORM.</h2><?php
    }
  
        #creating form in HTML
    ?>
        <div class="container">
            <form action="buying-page.php" method="post">
                
                <h3 class="requierd">* = required</h3>
                <hr class="hr-form">
                <label class="lbl">Product code:</label><span class="star">*</span><br>
                <input type="text" name="product" placeholder="The Product Code..."  value="<?php echo $product ?>"><br>
                <span class="error" >
                    <?php echo $errorProduct; ?>
                </span><br>

                <label class="lbl">First Name:</label><span class="star">*</span><br>
                <input type="text" name="fname" placeholder="Your First Name..." value="<?php echo $fname ?>"><br>
                <span class="error">
                    <?php echo $errorFname; ?>
                </span><br>

                <label class="lbl">Last Name:</label><span class="star">*</span><br>
                <input type="text" name="lname" placeholder="Your Last Name..." value="<?php echo $lname ?>"><br>
                <span class="error">
                    <?php echo $errorLname; ?>
                </span><br>

                <label class="lbl">City:</label><span class="star">*</span><br>
                <input type="text" name="city"  placeholder="Your City..." value="<?php echo $city ?>"><br>
                <span class="error">
                    <?php echo $errorCity; ?>
                </span><br>

                <label class="lbl">Price:</label><span class="star">*</span><br>
                <input type="text" name="price" placeholder="Product Price..." value="<?php echo $price ?>"><br>
                <span class="error">
                    <?php echo $errorPrice; ?>
                </span><br>

                <label class="lbl">Quantity:</label><span class="star">*</span><br>
                <input type="text" name="quantity"  placeholder="Product Quantity..." value="<?php echo $quantity ?>"><br>
                <span class="error">
                    <?php echo $errorQuantity; ?>
                </span><br>
                
                
                <label class="lbl">Comment:</label><br>
                <textarea class="comment" type="text" name="comments" placeholder="If You Have Any Comment..." value="<?php echo $comments ?>"></textarea><br>
                <span class="error">
                    <?php echo $errorComments; ?>
                </span><br>

              <input type="submit" value="B U Y" name="save">
            </form>
        </div>    
    <?php
        createPageFooter();

        
