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
    // Generate One UUID 3 bit
    private function GenerateOneUUID($sizeUUID)
    {
        return bin2hex(random_bytes($sizeUUID));
    }
    // Make 
    protected function Generate4UUID()
    {
        $UUID = "";
        $UUID .= $this->GenerateOneUUID(3) . "-";
        $UUID .= $this->GenerateOneUUID(3) . "-";
        $UUID .= $this->GenerateOneUUID(3) . "-";
        $UUID .= $this->GenerateOneUUID(3);
        return $UUID;
    }
    protected function validateSearch($search)
    {
        if (empty($search)) {
            return false;
        }
        if (strlen($search) <= 2) {
            return false;
        }
        return true;
    }
    protected function processSearch($search)
    {
        $cleanSearch =  htmlspecialchars($search);
        return $cleanSearch;
    }
}
