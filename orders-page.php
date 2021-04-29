<?php
#Revision history 
#2021-03-06      Alireza Gholami     Creating This page
#2021-03-08      Alireza Gholami     table created(HTML/PHP/CSS) / Read from file tested/
#2021-03-12      Alireza Gholami     adding Error handeler
#2021-03-13      Alireza Gholami     add comments/ read data logic changed/ add change color for subTotal
#2021-04-26      Alireza Gholami     HTTPS function 

    
    #declere constant to accsess the files and folders
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
    #declare new path for txt file
    define("FOLDER_DATA" , 'data/');
    define("FILE_DATA_purchases", FOLDER_DATA . 'purchases.txt');
    #declear a variable for accessing cheat sheet
    define("FILE_DATA_CHEATSHEET", FOLDER_DATA . 'cheatSheet');
       
    #import the php commin function file
    require_once (FILE_PHP_FUNCTION);

    #use created function to force user to enter with HTTPS
    enterHTTPS();
        
    #creating Error and excepthion handeler to avoidng display server side problems to end users.
    set_error_handler("manageError");
    set_exception_handler("manageExceptions");
    #call the function to create page header    
    createPageHeder("Orders Page");
    
    ?>

        <div class="navigation-menu">
            <?php
                #call the function to create logo 
                CreateLogo();
                #call the function to create navigation menu
                createNavigationMenu();
                
            ?>
        </div >
        <?php 
        #call the login function 
        CreateLoginPage(); 
        ?>
            <h2 class="top-message" >SUCCESSFUL TRANSACTIONS.</h2>
        <div class="table">
    <?php
        
            #read the file in case the file exists
            if(file_exists(FILE_DATA_purchases))
            {
                #read all file with one step
                $purchases = fopen(FILE_DATA_purchases , "r") or exit("The file could not be open");
                
                #Enterung PHP to create first part of the table
                ?>  
                    <!-- create a table -->
                    <div class="table-continer">
                    <table >
                            <!-- Create one row -->
                            <tr class="row">
                                <!-- Create one column and its contents -->
                                <td>Product ID </td>
				<td>First name </td>
				<td>Last name </td>
                                <td>City </td>
				<td>Price </td>
				<td>Quantity </td>
                                <td>Comment </td>
				<td>Subtotal </td>
				<td>Taxes </td>
                                <td>Grand total </td>
                            </tr>
                <?php
                #read the file one line at time
                while(!feof($purchases))
                {
                    #create the next row for desplaying data from txt file
                    echo "<tr >";
                        #decode the text file content
                        $line = json_decode(fgets($purchases));

                        #create a variable to make a array from jason
                        $arraylined = (array)$line;

                        #useing $_GET to check if command add to url
                        if(isset($_GET["command"]))
                        {
                            #gettingthe command from url and preventing of any special characther injection
                            $subColorClass = htmlspecialchars($_GET["command"]);
                            #get the value of the subtotal from each row
                            $subNum = $arraylined["subtotal"];
                            #if the command that provided from url is color then go inside the loop
                            if($subColorClass == "color")
                            {
                                #if its less than 100 then chnage the color to red
                                if($subNum < 100){$subColorClass = "text-color-red";}
                                #if its more than 100 and less than 999.99 then chnage the color to orange
                                elseif ($subNum >= 100 && $subNum <= 999.99 ) {$subColorClass = "text-color-orange";}
                                #if its more than 999.99 then chnage the color to green
                                else{$subColorClass = "text-color-green";}
                                
                            } 
                           
                        }
                        else 
                        {
                           #if there is no command color inside the url then the color will be normal
                           $subColorClass = "text-color-normal";
                        }
                        

                        #Create columns of a row and put data inside the table 
                        echo "<td>".$arraylined["product"]."</td>";
                        echo "<td>".$arraylined["fname"]."</td>";
                        echo "<td>".$arraylined["lname"]."</td>";
                        echo "<td>".$arraylined["city"]."</td>";
                        echo "<td>".$arraylined["price"]."$</td>";
                        echo "<td>".$arraylined["quantity"]."</td>";
                        echo "<td>".$arraylined["comments"]."</td>";
                        #based on the url the variable $subColorClass will change and the css class will be diffrent
                        ?><td class="<?php echo $subColorClass; ?>"><?php echo $arraylined["subtotal"]; ?>$</td> <?php
                        echo "<td>".$arraylined["taxAmount"]."$</td>";
                        echo "<td>".$arraylined["FinalPrice"]."$ </td>";
                }
                    #close the row of the table
                    echo "</tr>";
                   
            
                #close the table
                echo "</table>";
                echo "</div>";
                #close the text file
                fclose($purchases); 
            }
            else #show the message if there is no any text file in this directory
            {
                ?>"<h2 class="top-message" >Cannot Open the file because it does not exist!</h2>" <?php
            }
    ?>
            </div>
            <!-- creating Cheat sheet button -->
            <div class="cheatSheet">   
                <a class="BtncheatSheet" href="data/cheatSheet" >Cheat Sheet</a>
            </div>
    <?php

        #create the page footer
        createPageFooter();


