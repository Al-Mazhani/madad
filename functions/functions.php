<?php


function Encryption($password)
{
    $hashPassword = "";
    for ($i = 0; $i < strlen($password); $i++) {
        $ascii = ord($password[$i]);
        $new   = chr($ascii + 4);
        $hashPassword .= $new;
    }
    return $hashPassword;
}
