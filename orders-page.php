<?php
#Revision history 
#2021-03-06      Alireza Gholami     Creating This page
      
    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");

       
    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);

    //set_error_handler("manageError");
    //set_exception_handler("manageExceptions");

        createPageHeder("Orders Page");
    ?>
        <div class="navigation-menu">
            <?php
                CreateLogo();
                createNavigationMenu();
            ?>
        </div >
    <?php
        
  
        
        createPageFooter();
