<?php


#Connect to a data base with PDO: SERVER  DatataBase User pwd
$connection = new PDO("mysql:host=localhost; dbname=database-1921230", "root", "kasra1377");

#set the PDO error mode to exception , so invalid queries (you write) will be catched
 $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


