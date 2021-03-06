<?php

#Revision history 
#2021-03-04      Alireza Gholami     Create function Header/footer/logo/navigation

#declare content
define("MAKE_MAX_LENGHT", 10);
define("MODEL_MAX_LENGHT", 15);





#declare global variable and constants
define("FOLDER_CSS_FUNCTION", 'css/');
define("FILE_CSS_FUNCTION", FOLDER_CSS_FUNCTION ."style.css");

define("FOLDER_IMAGES_FUNCTION", 'images/');
define("FILE_IMAGES_FUNCTION",  FOLDER_IMAGES_FUNCTION . "logo.png");

define("HOME_PAGE_PATH", "index.php");
define("ORDERS_PAGE_PATH", "orders-page.php");
define("BUYING_PAGE_PATH", "buying-page.php");




/////////////////////////////// ALL FUNCTIONS ///////////////////////////////////////
//
//
//


#create a function for all pages header
function createPageHeder($TitleName)
{
 
    ?><!DOCTYPE html>
    
    <!-- provide structured metadata about a Web page -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link css file to this function -->
    <link rel="stylesheet" href="<?php echo FILE_CSS_FUNCTION; ?>"/> 
    <?php  ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $TitleName ?></title>
        </head>
        <body class="color">
       
            
    <?php    
       
}

#creating a function for Assing a logo into the header of web pages
function CreateLogo()
{
    #echo some Html code
    ?>
            <img class="logo" src="<?php echo FILE_IMAGES_FUNCTION; ?>" alt="Logo"/>
    <?php    
  
}

#creating a function for creating navigation 
function createNavigationMenu()
{
    #Using constant to call each page path 
    ?>
            <nav>
                <a  href="<?php echo HOME_PAGE_PATH  ?>">Home Page</a>
                <a  href="<?php echo ORDERS_PAGE_PATH  ?>">Orders Page</a>
                <a  href="<?php echo BUYING_PAGE_PATH  ?>">Buying page</a>
            </nav>
    <?php
}




function createPageFooter()
{
    
    
    #echo some Html code
    ?>
        </body>
        <footer>
            <br><br>&#169 CopyRight Alireza Gholami (1931230)  <?php echo date('Y'); ?>
        </footer>
      </html>
    
    
    <?php    
  
}