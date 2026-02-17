<?php
    function NotAllowDisplayPage(): void
{
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
        header("location:/Madad/");
        exit();
    }
}
// NotAllowDisplayPage();  

?> 