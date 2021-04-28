
        <?php
        #Revision history 
        #2021-03-04      Alireza Gholami     adding created function Header/footer/navigation
        #2021-03-05      Alireza Gholami     adding Ad part/site description/adding css for all new part
        #2021-03-06      Alireza Gholami     adding some comments
        #2021-03-12      Alireza Gholami     adding Error handeler
        #2021-04-26      Alireza Gholami     HTTPS function 
        
        
        
        
        #declere constant
        define("FOLDER_PHP_FUNCTIONS", 'php/');
        define("FILE_PHP_FUNCTION", FOLDER_PHP_FUNCTIONS . "functions.php");
        
        #Define some picture for advertising
        define("FOLDER_IMAGES_AD_FUNCTION", 'images/');
        define("FILE_Ad1_FUNCTION", FOLDER_IMAGES_AD_FUNCTION ."Ad1.jpg");
        define("FILE_Ad2_FUNCTION", FOLDER_IMAGES_AD_FUNCTION ."Ad2.png");
        define("FILE_Ad3_FUNCTION", FOLDER_IMAGES_AD_FUNCTION ."Ad3.jpg");
        define("FILE_Ad4_FUNCTION", FOLDER_IMAGES_AD_FUNCTION ."Ad4.jpg");
        define("FILE_Ad5_FUNCTION", FOLDER_IMAGES_AD_FUNCTION ."Ad5.png");
        
        #import the php commin function file
        require_once (FILE_PHP_FUNCTION);

        #use created function to force user to enter with HTTPS
        enterHTTPS();
        
        #creating Error and excepthion handeler to avoidng display server side problems to end users.
        set_error_handler("manageError");
        set_exception_handler("manageExceptions");

        createPageHeder("Home Page");
        ?>
            <div class="navigation-menu">
                <?php
                    CreateLogo();
                    createNavigationMenu();
                ?>
            </div >
        <?php
        #Randomize the picture to show(Create an arrary to store all the add)
        $Advertising = array(FILE_Ad1_FUNCTION, FILE_Ad2_FUNCTION, FILE_Ad3_FUNCTION,FILE_Ad4_FUNCTION,FILE_Ad5_FUNCTION);
        #Create a variable to get advertising array and show it randomly
        $randomImage = $Advertising[array_rand($Advertising)]; 
        CreateLoginPage();
        ?>
        
        <!-- This is a short description of the website -->
        <div class="description">
            <h1 class="topic">Sell your car in <span class="Bold">30 minutes</span></h1>
            <section>
                <p>
                KGH offers a new, safe and convenient way of selling your car throughout the Canadian world. 
                Use our free car valuation service regardless of make and model to determine the best used car price.
                </p>
            </section>
            <section>
                <p>
                Take advantage of the professional and gratis car inspection and the fast car buying service by KGH - 
                the perfect alternative to time-consuming and tiring advertisements.
                </p>
            </section>
            <section>
                <p>
                KGH offers free car deregistration, part-exchange and settlement of bank loans and mortgages. 
                In any situation we offer you a fast, easy and fair car buying service.
                </p>
            </section>
        </div><br>
        <hr class="spliter">
        <!-- After descripthion here i will show advertising showing advertising -->
        <div class="advertisement">
             
            <h3>Advertising</h3>

            <?php
                #if the Selected photo is the Ad2 then it will change the style of advertising
                if($randomImage == FILE_Ad2_FUNCTION)
                {
                    ?> 
                        <a href="https://www.pinterest.com/pin/57209857755222025/"> 
                        <img class="SpecialAD" src="<?php echo $randomImage; ?>" alt="Ad"/> </a>
                    <?php
                }
                else #else advertising will show in normal style with normal size
                {
                    ?> 
                        <a href="https://www.amazon.ca/Stretch-Universal-Australian-Sheepskin-35cm-44cm/dp/B07HG7NH9J/ref=bmx_7?pd_rd_w=8sqIs&pf_rd_p=8af304ab-1485-4db5-b3be-498075a005a9&pf_rd_r=1R745BF2XFFKGBG81ZZM&pd_rd_r=ce2b067c-b73e-4059-95ee-251b540c26e6&pd_rd_wg=bk0r5&pd_rd_i=B07HG7NH9J&psc=1"> 
                        <img class="Ad"  src="<?php echo $randomImage; ?>" alt="Ad"/></a>
                    <?php
                    
                }
            ?>
        </div>
        
        <?php
        
        createPageFooter();

        ?>
