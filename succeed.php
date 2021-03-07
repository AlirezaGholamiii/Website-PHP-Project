<?php
#Revision history 
#2021-03-06      Alireza Gholami     Creating This page / adding message / button to next page
      
    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
 
       
    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);

    //set_error_handler("manageError");
    //set_exception_handler("manageExceptions");

        createPageHeder("Successful Purchase");
    ?>
        <div class="navigation-menu">
            <?php
                CreateLogo();
                createNavigationMenu();
            ?>
        </div >
        <div class="message">
            <div>
                <h1 class="top-message" >Congrats, You made the purchase.</h1>
            </div>

            <div class="back-button">
                <button class="button" onclick="document.location='index.php'" ><span>Back To Main Page</span></button>
            </div>
        </div>
        
    <?php
        
  
        
        createPageFooter();
