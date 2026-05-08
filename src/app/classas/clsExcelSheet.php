<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

enum enSaveResultExcel: int {}
class clsExcelSheet
{

    private $Sheet;
    public function __construct()
    {
        $this->Sheet = new Spreadsheet();
    }
    private  function _GetSheet()
    {
        return $this->Sheet->getActiveSheet();
    }
    private function _SetHeader($sheet)
    {

        $sheet->setCellValue("A1", "ID");
        $sheet->setCellValue("B1", "UserName");
        $sheet->setCellValue("C1", "Email");
        $sheet->setCellValue("D1", "Role");
        $sheet->setCellValue("E1", "Created At");
        $sheet->setCellValue("F1", "Active");
    }
    private function _AddRow($sheet, int $Row, clsUser $User)
    {
        $sheet->setCellValue("A$Row", $User->ID());
        $sheet->setCellValue("B$Row", $User->Username());
        $sheet->setCellValue("C$Row", $User->Email());
        $sheet->setCellValue("D$Row", $User->Role());
        $sheet->setCellValue("F$Row", $User->Active());
        $sheet->setCellValue("E$Row", $User->Created_at());
    }

    public  function Table(array $Users)
    {
        $sheet = $this->_GetSheet();
        $this->_SetHeader($sheet);
        $Row = 2;
        foreach ($Users as $user) {
            $this->_AddRow($sheet, $Row, $user);
            $Row++;
        }
    }
    public function Save($fileName = "users.xlsx")
    {
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($this->Sheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
};
