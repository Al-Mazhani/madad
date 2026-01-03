<?php
class BaseController
{
    // function To Include File Error URL 
    protected function NotAllowDisplayPage(): void
    {
        include __DIR__ . '/../view/errorURL.php';
        exit();
    }
    // Check IF ID has error
    protected function validateID($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            $this->NotAllowDisplayPage();
        }
        $cleanID = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if ($cleanID < 0) {
            $this->NotAllowDisplayPage();
        }
        return $cleanID;
    }
}
