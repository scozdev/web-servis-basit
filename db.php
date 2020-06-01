<?php

try{
    $db = new PDO('mysql:host=localhost;dbname=fetchapi', 'root', '');

}catch(Exception $e){
    echo $e->getMessage();
}