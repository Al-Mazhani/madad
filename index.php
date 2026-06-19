<?php
require 'autoload.php';

$Author = clsAuthor::FindByName("Noor");

    echo "<pre>";
    print_r($Author);
    echo "<pre>";
    echo "<hr>";
    echo $Author->Age();

