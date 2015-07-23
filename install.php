<?php
if(file_exists('index.php_txt')){
    rename('index.php','index_installation.php');
    rename ("index.php_txt", "index.php");
    rename (".htaccess_txt", ".htaccess");
    header('Location: ./');
}
?>