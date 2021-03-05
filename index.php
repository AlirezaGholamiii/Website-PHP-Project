
        <?php
        #Revision history 
        #2021-03-04      Alireza Gholami     adding created function Header/footer/navigation
        
        
        
        #declere constant
        define("FOLDER_PHP_FUNCTIONS", 'php/');
        define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
        
        #import the php commin function file
        require_once (FILE_PHP_FUNCTION);

        //set_error_handler("manageError");
        //set_exception_handler("manageExceptions");


        //put your code here to create website
        createNavigationMenu();
        createPageHeder("Home Page");
        createPageFooter();

        ?>
