<?php

#Revision history 
#2021-03-04      Alireza Gholami     Create function Header/footer/logo/navigation
#2021-03-12      Alireza Gholami     Create function manageError/manageExceptions/get_browser_name
#2021-03-13      Alireza Gholami     add some comments/ add icon to browser tab / add log file and save data
#2021-04-26      Alireza Gholami     HTTPS function 


#declare global variable and constants
define("FOLDER_CSS_FUNCTION", 'css/');
define("FILE_CSS_FUNCTION", FOLDER_CSS_FUNCTION ."style.css");
#declare the folder path for images
define("FOLDER_IMAGES_FUNCTION", 'images/');
define("FILE_IMAGES_FUNCTION",  FOLDER_IMAGES_FUNCTION . "logo.png");
define("FILE_ICO_FUNCTION",  FOLDER_IMAGES_FUNCTION . "logo.ico");
#declare the file path for pages
define("HOME_PAGE_PATH", "index.php");
define("ORDERS_PAGE_PATH", "orders-page.php");
define("BUYING_PAGE_PATH", "buying-page.php");

#declare new path for log txt file
define("FOLDER_LOG" , 'log/');
define("FILE_LOG", FOLDER_LOG . 'WebsiteLog.txt');

#create a variable to turn off and on the developer mode
$debug = false;


/////////////////////////////// ALL FUNCTIONS ///////////////////////////////////////

#create a function for all pages header
function createPageHeder($TitleName)
{
    #create all the neccessery headers to prevent website to use cache data
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
    ?><!DOCTYPE html>
    
        <!-- provide structured metadata about a Web page -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Link css file to this function -->
        <link rel="stylesheet" href="<?php echo FILE_CSS_FUNCTION; ?>"/>
        
    <?php?>
        <html >
            <head>
                <meta charset="UTF-8">
                <!-- use the variable Titake name to create diffrent title names -->
                <title><?php echo $TitleName ?></title>
                <!-- add icon to website tab -->
                <link rel="icon" type="image/ico" href="<?php echo FILE_ICO_FUNCTION; ?>"/>
            </head>
            <body >
       
            
    <?php    
       
}

#creating a function for Assing a logo into the header of web pages
function CreateLogo()
{
    #echo some Html code and create the logo
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
    #create the footer and date() for grabbing the year
    ?>
        </body>
        <footer>
            <br><br>&#169 CopyRight Alireza Gholami (1931230)  <?php echo date('Y'); ?>
        </footer>
      </html>
    <?php    
}


#create a function to get the url commands
function changeColor()
{
    #if there is command in url
    if(isset($_GET["command"]))
    {
        #get the command
        $Changer = htmlspecialchars($_GET["command"]);
        #if the command is print
        if($Changer == "print")
        {
            #use the class text-print 
            $Changer="text-print";
        }
                
    }     
}

#creating a function for handeling errors
function manageError($errorNumber, $errorString, $errorFile, $errorLine)
{
    #create a global variable for easy accessing outside the function
    global $debug;
    #generic message for end-user
    ?><h1 class="top-message">An error occured on the website. Please counsult the log for more details</h1><?php
    
    #detaild info for the developers
    #save this into the file insted of using echo
    if($debug == true)
    {
        echo "An error occured in the file" . $errorFile . "on line" . $errorLine . " Error: $errorNumber - $errorString";
    }
    else
    {
        #create a variable to use the function get_browser_name
        $browserName = get_browser_name($_SERVER['HTTP_USER_AGENT']);
        #create a variable to store the micro second format 
        $date = DateTime::createFromFormat('U.u', microtime(TRUE));
        #change the date time format and convet it to a string to saving into the text file
        $dateTime = $date->format('Y-m-d H:i:s.u');
        #save the same info in the file
        #Create a string variable and store all the data in the variable
        $array = "Error Name : " . $errorString . " ,Error Code : " . $errorNumber . " ,Time : " . $dateTime 
        ." ,File Name : " . $errorFile . " ,Line Number : " . $errorLine . " ,Browser Name : " . $browserName;
            
        #convert array into jason
        $js = json_encode($array);
            
        #save json array into the text file
        file_put_contents(FILE_LOG , $js . "\n", FILE_APPEND);
    }
        #for exit the function  
        die();
}
#create a function to handele all the exceptions
function manageExceptions($error)
{
    #generic message for end-user
    ?><h1 class="top-message"> An Exception occured on the website. Please consult the log for more details.</h1><?php
    #if we were in developer mode then go inside if.
    if($debug == false)
    {
        #detailed info for developers
        echo "An error occured in the file " . $error->getFile() . " On Line " . $error->getLine() . " Error" . $error->getMessage();
    }
    else
    {
        #create a variable to use the function get_browser_name
        $browserName = get_browser_name($_SERVER['HTTP_USER_AGENT']);
        #create a variable to store the micro second format 
        $date = DateTime::createFromFormat('U.u', microtime(TRUE));
        #change the date time format and convet it to a string to saving into the text file
        $dateTime = $date->format('Y-m-d H:i:s.u');
        #save the same info in the file
        #Create a string variable and store all the data in the variable
        $array = "Error Name : " . $error->getMessage() . " ,Error Code : " . $error->getCode() . " ,Time : " . $dateTime 
        ." ,File Name : " . $error->getFile() . " ,Line Number : " . $error->getLine() . " ,Browser Name : " . $browserName;
            
        #convert array into jason
        $js = json_encode($array);
            
        #save json array into the text file
        file_put_contents(FILE_LOG , $js . "\n", FILE_APPEND);
    }
        #for exit the function  
        die();
}
#create a function to get the browser version of each user(for saving data into text file)
function get_browser_name($user_agent)
{
    #using simple if else(it will search in the long string if find any of browser names then it return the name of browser)
    if (strpos($user_agent, 'Opera')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
   
    return 'Other';
}

#create a function to force user to enter by HTTPS protocol 
function enterHTTPS()
{
    #to force the user to use https protocol
    if( !isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
    {
        header('Location: https://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
}

