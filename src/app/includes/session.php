<?php
    function NotAllowDisplayPage(): void
{
    if (!isset($_SESSION['role'])) {
        header("location:/Madad/");
        exit();
    }
}
NotAllowDisplayPage();

?> 