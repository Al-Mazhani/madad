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
    protected function validateID($id) : void
    {
        $lenghtID = strlen($id);
        if ($lenghtID !== 27 ) {
            $this->NotAllowDisplayPage();
        }

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
