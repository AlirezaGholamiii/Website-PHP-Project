<?php
#Revision history 
#2021-03-06      Alireza Gholami     Creating This page
#2021-03-08      Alireza Gholami     table created(HTML/PHP/CSS) / Read from file tested/      
    #declere constant
    define("FOLDER_PHP_FUNCTIONS", 'php/');
    define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
    #declare new path for txt file
    define("FOLDER_DATA" , 'data/');
    define("FILE_DATA_purchases", FOLDER_DATA . 'purchases.txt');
       
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
                        $array = json_decode(fgets($purchases));
                        #create a loop to retrieve data in each cell
                        foreach ((array)$array as $value) 
                        {
                            # craete a new column
                            echo "<td>";
                                #display the value that will process by loop
                                echo $value;
                            echo "</td>";

                        }
                    echo "</tr>";
                   
                }
                #close the table
                echo "</table>";
                echo "</div>";
                #close the text file
                fclose($purchases);
            }
            else #show the message if there is no any text file in this directory
            {
                ?>"<h2 class="top-message" >Canot Open the file because it does not exist!</h2>" <?php
            }
    ?>
        </div>
    <?php
        #create the page footer
        createPageFooter();

