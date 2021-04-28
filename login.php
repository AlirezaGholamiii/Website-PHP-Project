<?php
#Revision history 
#2021-04-27      Alireza Gholami     Creating This page


    
    #declere constant to accsess the files and folders
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
       
    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);

    #use created function to force user to enter with HTTPS
    enterHTTPS();
        
    #creating Error and excepthion handeler to avoidng display server side problems to end users.
    set_error_handler("manageError");
    set_exception_handler("manageExceptions");
    #call the function to create page header    
    createPageHeder("Login Page");
    
    #call the function to create logo 
    echo "<div class='loginLogo'>";
    CreateLogo();
    echo "</div>";
    ?>

        <div class="container">
            <form action="login.php" method="post">
                <!-- First text section for ACCOUNT -->
                <h3 class="AccountTitle">ACCOUNT LOGIN</h3>
                <hr class="hr-form">

                </span><br>
                <!-- First text section for username -->
                <label class="lbl">USERNAME</label><span class="star">*</span><br>
                <input type="text" name="username"  placeholder="Your user..." value="<?php #echo $quantity ?>"><br>
                <span class="error">
                    <?php #echo $errorQuantity; ?>
                </span><br>
                
                <!-- First text section for PASSWORD -->
                <label class="lbl">PASSWORD</label><span class="star">*</span><br>
                <input type="text" name="password"  placeholder="Your pass..." value="<?php #echo $quantity ?>"><br>
                <span class="error">
                    <?php #echo $errorQuantity; ?>
                </span><br>
                
                
               <!-- submit button to save data into text file --> 
              <input type="submit" value="L O G I N" name="login">
              
              <div class="need">
                <label class="needAcc"> Need a user account ? </label>
              </div>
              <div class="cheatSheet">  
                <a class="BtncheatSheet" href="index.php" >R e g i s t e r</a>
            </div>
            </form>
        </div>
 


<?php
#create a fotter
    createPageFooter();