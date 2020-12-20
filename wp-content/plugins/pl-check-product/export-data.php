<?php
require_once ('function.php');

if(isset($_POST['export'])) { 
    ExportData(); 
} 
function ExportData(){
    $conn = Connection();
    $sql = "Select id 'ID', id_product 'Product ID', code 'Product Code', create_date 'Created Date' from pl_code_product";

    $file_ending = "xls";
    //header info for browser
    header("Content-Type: application/xls");    
    header("Content-Disposition: attachment; filename=ProductCode.xls");  
    header("Pragma: no-cache"); 
    header("Expires: 0");
    $result = $conn->query($sql);

    $conn->close();
    $isPrintHeader = false;
    foreach ($result as $row) {
            if (! $isPrintHeader) {
                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
        exit();
} 
?>