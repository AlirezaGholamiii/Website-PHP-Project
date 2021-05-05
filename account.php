<?php
#Revision history 
#2021-5-3      Alireza Gholami     Creating This page


    
    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");


    #declere variable for error messeges.
    $errorFname = "";
    $errorLname = "";
    $errorAdress = "";
    $errorPcode = "";
    $errorCity = "";
    $errorUsername = "";
    $errorPassword = "";
    
    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);
    
    #use created function to force user to enter with HTTPS
    enterHTTPS();
    
    require_once 'objects/purchase.php';
    
    #creating Error and excepthion handeler to avoidng display server side problems to end users.
    set_error_handler("manageError");
    set_exception_handler("manageExceptions"); 

      #Call the function to create title and all the HTML tags
        createPageHeder("Account Page");
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
                    
                    <!-- create a update form -->
                    
                <?php
                #check if the save button has been clicked
                if(isset($_POST["update"]))
                {
                        #create customer constractor
                        $customer = new customer();

                    #check if username and password have errors
                    if($customer->setFirstname(htmlspecialchars(trim($_POST["fname"]))) != "" || 
                        $customer->setLastname(htmlspecialchars(trim($_POST["lname"]))) != "" || $customer->setAddress(htmlspecialchars(trim($_POST["adress"]))) != "" ||
                        $customer->setCity(htmlspecialchars(trim($_POST["city"]))) != "" || $customer->setPostalCode(htmlspecialchars(trim($_POST["Pcode"]))) != "" ||
                        $customer->setUserName(htmlspecialchars(trim($_POST["userName"]))) != "" || $customer->setPassword(htmlspecialchars(trim($_POST["password"]))) != "")
                    {
                        #then save errors in a variable to show the user
                        $errorFname = $customer->setFirstname($_POST["fname"]);
                        $errorLname = $customer->setLastname($_POST["lname"]);
                        $errorAdress = $customer->setAddress($_POST["adress"]);
                        $errorCity = $customer->setCity($_POST["city"]);
                        $errorPcode = $customer->setPostalCode($_POST["Pcode"]);
                        $errorUsername = $customer->setUserName($_POST["userName"]);
                        $errorPassword = $customer->setPassword($_POST["password"]);
                        #Header message
                        ?><h2 class="top-message" >Please make sure all information is valid.</h2><?php
                    }
                    else if($customer->findUsername(($_POST["userName"]) == true))
                    {
                        $errorUsername = "This customer already exists! Please try another username.";
                        ?><h2 class="top-message" >Please make sure all information is valid.</h2><?php
                    }
                    else
                    {
                        /////////////////////////////////ENCRIPTING PASSWORD/////////////////////
                        $encripted_pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

                        $customer->setCustomerId($userSSS);
                        $customer->setFirstname($_POST["fname"]);
                        $customer->setLastname($_POST["lname"]);
                        $customer->setAddress($_POST["adress"]);
                        $customer->setCity($_POST["city"]);
                        $customer->setProvince($_POST["city"]);
                        $customer->setPostalCode($_POST["Pcode"]);
                        $customer->setUserName($_POST["userName"]);
                        $customer->setPassword($encripted_pass);

                        $customer->Save();

                        
                        if(alert("Information, Updated."))
                        {
                            #reload the page...
                            header('Location: index.php');
                            exit(); 
                        }
                    }
                }
                else 
                {
                    #Header message
                    ?><h2 class="top-message" >PLEASE FIIL THIS FORM TO UPDATE YOUR INFORMATION.</h2><?php
                }

                    #creating form in HTML
                $customer->load($userSSS);
                ?>
                <div class="container">
                    <form action="account.php" method="post">
                        <!-- First text section for product -->
                        <h3 class="requierd">* = required</h3>
                        <hr class="hr-form">


                        <!-- text section for First name -->
                        <label class="lbl">First Name:</label><span class="star">*</span><br>
                        <input type="text" name="fname" value="<?php echo $customer->getFirstName() ?>"><br>
                        <span class="error">
                            <?php echo $errorFname; ?>
                        </span><br>
                        <!--  text section for last name -->
                        <label class="lbl">Last Name:</label><span class="star">*</span><br>
                        <input type="text" name="lname" value="<?php echo $customer->getLastName() ?>" ><br>
                        <span class="error">
                            <?php echo $errorLname; ?>
                        </span><br>
                        <!--  text section for adress -->
                        <label class="lbl">Adress:</label><span class="star">*</span><br>
                        <input type="text" name="adress"  value="<?php echo $customer->getAddress() ?>" ><br>
                        <span class="error">
                            <?php echo $errorAdress; ?>
                        </span><br>
                        <!--  text section for city -->
                        <label class="lbl">City:</label><span class="star">*</span><br>
                        <input type="text" name="city" value="<?php echo $customer->getCity() ?>"><br>
                        <span class="error">
                            <?php echo $errorCity; ?>
                        </span><br>
                        <!-- First text section for Pcode -->
                        <label class="lbl">Postal Code:</label><span class="star">*</span><br>
                        <input type="text" name="Pcode"  value="<?php echo $customer->getPostalCode() ?>"><br>
                        <span class="error">
                            <?php echo $errorPcode; ?>
                        </span><br>

                        <!--  text section for username -->
                        <label class="lbl">UserName:</label><span class="star">*</span><br>
                        <input type="text" name="userName" value="<?php echo $customer->getUserName() ?>" ><br>
                        <span class="error">
                            <?php echo $errorUsername; ?>
                        </span><br>
                        <!-- First text section for password -->
                        <label class="lbl">Password:</label><span class="star">*</span><br>
                        <input type="password" name="password"  ><br>
                        <span class="error">
                            <?php echo $errorPassword; ?>
                        </span><br>


                       <!-- submit button to save data into  database --> 
                      <input type="submit" value="UPDATE" name="update">
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
