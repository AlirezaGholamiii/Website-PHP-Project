<?php
#Revision history 
#2021-03-06      Alireza Gholami     Creating This page/ adding all the form html / all the validation for the form
#2021-03-07      Alireza Gholami     Finalize calculation part / saving form data to txt file / testing new part / debuging text file
#2021-03-08      Alireza Gholami     Debuging the round number of tax and grand total
#2021-03-12      Alireza Gholami     adding Error handeler
#2021-03-13      Alireza Gholami     change the array for purchase file(add key)/ add condition for save data in purchase file / add some comments
#2021-04-26      Alireza Gholami     HTTPS function 

    
    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
    #declare new path for txt file
    define("FOLDER_DATA" , 'data/');
    define("FILE_DATA_purchases", FOLDER_DATA . 'purchases.txt');

    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);
    
    #use created function to force user to enter with HTTPS
    enterHTTPS();
        
    #creating Error and excepthion handeler to avoidng display server side problems to end users.
    set_error_handler("manageError");
    set_exception_handler("manageExceptions"); 
    
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
    
       
    
    #error handeler for end users
    set_error_handler("manageError");
    set_exception_handler("manageExceptions");

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

    #call the login function 
    CreateLoginPage();
    
    #check if the save button has been clicked
    if(isset($_POST["save"]))
    {
        $product = htmlspecialchars(trim($_POST["product"]));
        if(! $product == "")
        {
            #check the first letter of the input if it is not p/P
            if(! (substr($product, 0,1) == "P" ||  substr($product, 0,1) == "p"))
            {
                $errorProduct = "The first word must be P or p.";
            }
            elseif (mb_strlen($product) > product_MAX_LENGHT) #check the lenght of string
            {
                $errorProduct ="The Product Code cannot contain more than ". product_MAX_LENGHT . " Character";
            }   
        }
        else 
        {
            #if its empty then show message
            $errorProduct = "The product Code cannot be empty";
        }
        
        
        
        
        
        #check the First name is empty
        $fname = htmlspecialchars(trim($_POST["fname"]));
        #if its empty then show message
        if($fname == "")
        {
            
            $errorFname = "Your First Name cannot be empty";
        }
        else
        {
            if(mb_strlen($fname) > FNAME_MAX_LENGHT)#check the lenght of string
            {
                $errorFname ="First Name cannot contain more than ". FNAME_MAX_LENGHT . " Character";
            }
        }
        
        #check the $lname is emty
        $lname = htmlspecialchars(trim($_POST["lname"]));
        #if its empty then show message
        if($lname == "")
        {
            $errorLname = "Your Last Name cannot be empty";
        }
        else
        {
            if(mb_strlen($lname) > LNAME_MAX_LENGHT)#check the lenght of string
            {
                $errorLname ="Your Last Name cannot contain more than ". LNAME_MAX_LENGHT . " Character";
            }
        }
        
        
        #check the $city is emty
        $city = htmlspecialchars(trim($_POST["city"]));
        #if its empty then show message
        if($city == "")
        {  
            $errorCity = "The City cannot be empty";
        }
        else
        {
            #check the lenght of string
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
        #to check if it is not a number
        if(!is_numeric($price))
        {
            $errorPrice = "Please enter a numeric value bettween " . PRICE_MIN_LENGHT . " and " . PRICE_MAX_LENGHT;
        }
        else
        {
            #check the price is in accepteable range
            if($price < PRICE_MIN_LENGHT || $price > PRICE_MAX_LENGHT)
            {
                $errorPrice = "Please enter a numeric value bettween" . PRICE_MIN_LENGHT . " and "
                    . PRICE_MAX_LENGHT;
            }
        }
        
       
        #check the quantity is empty or not
        $quantity = htmlspecialchars(trim($_POST["quantity"]));
        #to check if it is not a number
        if(!is_numeric($quantity))
        { 
            $errorQuantity = "Please enter a numeric value bettween " . QUANT_MIN_LENGHT . " and " . QUANT_MAX_LENGHT;
        }
        else
        {
            #ro check the number is float or not
            if(is_numeric($quantity) && floor($quantity) != $quantity)
            {
                $errorQuantity = "Decimal numbers are not acceptable!";
                
            }
            else 
            {
                #check the number is in accepteble rango or not
                if($quantity < QUANT_MIN_LENGHT || $quantity > QUANT_MAX_LENGHT)
                {
                $errorQuantity = "Please enter a numeric value bettween " . QUANT_MIN_LENGHT . " and "
                    . QUANT_MAX_LENGHT;
                }
                
            }
            
            
        }
        
        
        
        #after all validation check if the errors found / if there is no error then the final operation
        if($errorProduct=="" && $errorFname== "" && $errorLname== "" && $errorCity== "" && $errorComments== "" && $errorPrice=="" && $errorQuantity== "")
        {
            #Calculating of transaction price with tax
            $subtotal = $price * $quantity;
            $taxPercentage = LOCAL_TAX / 100;
            $taxAmount = $taxPercentage * $subtotal ;
            $grandTotal = $subtotal + $taxAmount;
            #round the final number and check it has 2 decimal not more
            $FinalPrice = number_format($grandTotal , 2);
            
            #Create an array and store all the data in the array with key
            $array = array("product"=>$product, "fname"=>$fname, "lname"=>$lname, "city"=>$city, "price"=>$price , "quantity"=>$quantity, "comments"=>$comments, "subtotal"=>$subtotal, "taxAmount"=>$taxAmount, "FinalPrice"=>$FinalPrice);
            
            #convert array into jason
            $js = json_encode($array);
            
            #save json array into the text file
            #if the text file exist then go to the next line and save data
            if(file_exists(FILE_DATA_purchases)) 
            {
                file_put_contents(FILE_DATA_purchases , "\n".$js , FILE_APPEND);
            } 
            else 
            {
                #else save the data without \n
                file_put_contents(FILE_DATA_purchases , $js , FILE_APPEND); 
            }

            #send the user to succeed page 
            header('Location: succeed.php');
            die();
            #remove all the text files
            $product=""; $fname=""; $lname=""; $city=""; $comments=""; $price=""; $quantity="";
            #Desplay the message
            ?><h2 class="top-message" >Congrats, You made the purchase.</h2><?php
        }
    }
    else 
    {
        #Header message
        ?><h2 class="top-message" >PLEASE FIIL THIS FORM.</h2><?php
    }
  
        #creating form in HTML
    ?>
        <div class="container">
            <form action="buying-page.php" method="post">
                <!-- First text section for product -->
                <h3 class="requierd">* = required</h3>
                <hr class="hr-form">
                <label class="lbl">Product code:</label><span class="star">*</span><br>
                <!-- set the value to product -->
                <input type="text" name="product" placeholder="The Product Code..."  value="<?php echo $product ?>"><br>
                <span class="error" >
                    <!-- if it has error then save it into errorProduct variable -->
                    <?php echo $errorProduct; ?>
                </span><br>
                <!-- text section for First name -->
                <label class="lbl">First Name:</label><span class="star">*</span><br>
                <input type="text" name="fname" placeholder="Your First Name..." value="<?php echo $fname ?>"><br>
                <span class="error">
                    <?php echo $errorFname; ?>
                </span><br>
                <!--  text section for last name -->
                <label class="lbl">Last Name:</label><span class="star">*</span><br>
                <input type="text" name="lname" placeholder="Your Last Name..." value="<?php echo $lname ?>"><br>
                <span class="error">
                    <?php echo $errorLname; ?>
                </span><br>
                <!--  text section for city -->
                <label class="lbl">City:</label><span class="star">*</span><br>
                <input type="text" name="city"  placeholder="Your City..." value="<?php echo $city ?>"><br>
                <span class="error">
                    <?php echo $errorCity; ?>
                </span><br>
                <!--  text section for price -->
                <label class="lbl">Price:</label><span class="star">*</span><br>
                <input type="text" name="price" placeholder="Product Price..." value="<?php echo $price ?>"><br>
                <span class="error">
                    <?php echo $errorPrice; ?>
                </span><br>
                <!-- First text section for quantity -->
                <label class="lbl">Quantity:</label><span class="star">*</span><br>
                <input type="text" name="quantity"  placeholder="Product Quantity..." value="<?php echo $quantity ?>"><br>
                <span class="error">
                    <?php echo $errorQuantity; ?>
                </span><br>
                
                <!-- First text section for comments -->
                <label class="lbl">Comment:</label><br>
                <textarea class="comment" type="text" name="comments" placeholder="If You Have Any Comment..." value="<?php echo $comments ?>"></textarea><br>
                <span class="error">
                    <?php echo $errorComments; ?>
                </span><br>
               <!-- submit button to save data into text file --> 
              <input type="submit" value="B U Y" name="save">
            </form>
        </div>    
    <?php
        #call function to create footer
        createPageFooter();

        
