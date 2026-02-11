<?php
function UnSetSessionAccountLocked()
{
    $Time = 2 * 60 * 60;
    if(!isset($_SESSION['account_locked_at'])) return ;

    if (time() - $_SESSION['account_locked_at'] >= $Time) {
        unset($_SESSION['account_locked_at']);
        unset($_SESSION['AccountLocked']);

    }
}
function CheckLockedAccout()
{
    UnSetSessionAccountLocked();
    if (isset($_SESSION['AccountLocked'])) {
        die("Account Locked");
    }
}
CheckLockedAccout();
