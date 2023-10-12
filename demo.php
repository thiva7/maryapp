<?php

// show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);



require 'C:/Users/paris/vendor/autoload.php';
$sender = $_POST['sender'];

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a new spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->getColumnDimension('A')->setWidth(26);
    $sheet->getColumnDimension('B')->setWidth(4);

    $sheet->setCellValue('A3', 'ΕΊΔΟΣ');
    $sheet->setCellValue('C3', 'ΤΕΜΆΧΙΑ');

    $sheet->getStyle('A3')->getFont()->setBold(true);
    $sheet->getStyle('C3')->getFont()->setBold(true);
    // set font size 14
    $sheet->getStyle('A3')->getFont()->setSize(14);
    $sheet->getStyle('C3')->getFont()->setSize(14);

    // Initialize row counter
    $row = 5;

    // Loop through the POST data and populate the spreadsheet
    foreach ($_POST as $category => $items) {

        if ($category === 'sender') {
            continue;
        }

        if (is_array($items)) {
            $category = str_replace('_' , " ", $category);
            // Set the label in column A and make it bold
            $sheet->setCellValue('A' . $row, $category);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true);
            $sheet->getStyle('A'. $row)->getFont()->setSize(14);

            // Increment the row counter
            $row++;

            // Loop through the items in the category
            foreach ($items as $itemKey => $itemValue) {
                // Set the input value in column A
//                $itemKey = str_replace('_' , " ", $itemKey);
                $sheet->setCellValue('A' . $row, $itemKey);

                // Get the input value
                $inputValue = isset($itemValue) ? $itemValue : '';

                // Set the input value in column C
                $sheet->setCellValue('C' . $row, $inputValue);

                // Increment the row counter
                $row++;
            }
        } else {
            // Set the label in column A and make it bold
            $category = str_replace('_' , " ", $category);
            $sheet->setCellValue('A' . $row, $category);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true);
            $sheet->getStyle('A'. $row)->getFont()->setSize(14);

            // Get the input value
            $inputValue = isset($items) ? $items : '';

            // Set the input value in column C
            $sheet->setCellValue('C' . $row, $inputValue);

            // Increment the row counter
            $row++;
        }
    }

    // Save the spreadsheet as an Excel file
    $writer = new Xlsx($spreadsheet);
    $excelFilePath = 'output.xlsx';
    $writer->save($excelFilePath);

    // Offer the Excel file for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$sender.'.xlsx"');
    readfile($excelFilePath);
    exit;
}