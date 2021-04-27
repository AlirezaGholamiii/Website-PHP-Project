<?php
#Revision history 
#2021-03-06      Alireza Gholami     Creating This page / adding message / button to next page
#2021-03-13      Alireza Gholami     Active error handeler / add some comments
#2021-04-26      Alireza Gholami     HTTPS function 
      
    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
 
       
    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);
    
    #use created function to force user to enter with HTTPS
    enterHTTPS();
        
    #Error handerer for avoiding to diplay error to end user
    set_error_handler("manageError");
    set_exception_handler("manageExceptions");
        #create header and title
        createPageHeder("Successful Purchase");
    ?>
        <div class="navigation-menu">
            <?php
                #call function to create logo
                CreateLogo();
                #call function to create navigation bar
                createNavigationMenu();
            ?>
        </div >
        <div class="message">
            <div>
                <!-- display the message -->
                <h1 class="top-message" >Congrats, You made the purchase.</h1>
            </div>
            <!-- create a button to send the user to main page -->
            <div class="back-button">
                <button class="button" onclick="document.location='index.php'" ><span>Back To Main Page</span></button>
            </div>
        </div>
        
    <?php
        
  
        #call function to to create footer
        createPageFooter();
