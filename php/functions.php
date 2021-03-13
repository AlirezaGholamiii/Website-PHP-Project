<?php

#Revision history 
#2021-03-04      Alireza Gholami     Create function Header/footer/logo/navigation
#2021-03-13      Alireza Gholami     Create function manageError/manageExceptions/get_browser_name

#declare content






#declare global variable and constants
define("FOLDER_CSS_FUNCTION", 'css/');
define("FILE_CSS_FUNCTION", FOLDER_CSS_FUNCTION ."style.css");

define("FOLDER_IMAGES_FUNCTION", 'images/');
define("FILE_IMAGES_FUNCTION",  FOLDER_IMAGES_FUNCTION . "logo.png");

define("HOME_PAGE_PATH", "index.php");
define("ORDERS_PAGE_PATH", "orders-page.php");
define("BUYING_PAGE_PATH", "buying-page.php");

#declare new path for log txt file
define("FOLDER_LOG" , 'log/');
define("FILE_LOG", FOLDER_LOG . 'WebsiteLog.txt');

#create a variable to turn off and on the developer mode
$debug=true;



/////////////////////////////// ALL FUNCTIONS ///////////////////////////////////////



#create a function for all pages header
function createPageHeder($TitleName)
{global $Changer;
 
    ?><!DOCTYPE html>
    
        <!-- provide structured metadata about a Web page -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Link css file to this function -->
        <link rel="stylesheet" href="<?php echo FILE_CSS_FUNCTION; ?>"/>
        
    <?php changeColor() ?>
        <html >
            <head>
                <meta charset="UTF-8">
                <title><?php echo $TitleName ?></title>
            </head>
            <body class="<?php echo $Changer; ?>" >
       
            
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


function changeColor()
{
            if(isset($_GET["command"]))
            {
                $Changer = htmlspecialchars($_GET["command"]);
        
                if($Changer == "print")
                {
                    $Changer="text-print";
                }
                else 
                {
                    if($Changer == "color")
                    {
                        $Changer = "text-color";
                    }
                    else
                    {
                         #default value
                        $Changer = "text-default";
                    }
                }
            }
    
        ?>
      <?php
}


function manageError($errorNumber, $errorString, $errorFile, $errorLine)
{
    
    
    #generic message for end-user
    echo "1-KasraaAn error occured on the website. Please counsult the log for more details";
    
    #detaild info for the developers (dont use echo)
    #save this into the file insted of using echo
    if($debug = false)
    {
    echo "2-KasraaAn error occured in the file" . $errorFile . "on line" . $errorLine 
            . " Error: $errorNumber - $errorString";
    }
    else
    {
        #save the same info in the file
        #Create an array and store all the data in the array
        $browserName = get_browser_name($_SERVER['HTTP_USER_AGENT']);         
        $date = DateTime::createFromFormat('U.u', microtime(TRUE));
        $dateTime = $date->format('Y-m-d H:i:s.u');
            $array = "Error Name : " . $errorString . " ,Error Code : " . $errorNumber . " ,Time : " . $dateTime 
                    ." ,File Name : " . $errorFile . " ,Line Number : " . $errorLine . " ,Browser Name : " . $browserName;
            
            #convert array into jason
            $js = json_encode($array);
            
            #save json array into the text file
            file_put_contents(FILE_LOG , $js . "\n", FILE_APPEND);
    }
            die();
}

function manageExceptions($error)
{
    #generic message for end-user
    echo "\n3-KasraaAn exception occured on the website. Please consult the log for more details";
    
    #detailed info for developers (dont use echo)
    echo "4-KasraaAn error occured in the file " . $error->getFile() . " On Line " .
            $error->getLine() . " Error" . $error->getMessage();
    
            die();
}

function get_browser_name($user_agent)
{
    if (strpos($user_agent, 'Opera')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
   
    return 'Other';
}

