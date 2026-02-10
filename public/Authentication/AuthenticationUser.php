<?php
function CheckLockedAccout()
{
    if (isset($_SESSION['AccountLocked'])) {
        die("Account Locked");
    }
}
CheckLockedAccout();

