
<?php

//import.php

include 'vendor/autoload.php';

try{

    $connect = new PDO("mysql:host=localhost; dbname=mquap", "root", "");   
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_FILES["import_excel"]["name"] != '')
    {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["import_excel"]["name"]);
        $file_extension = end($file_array);

        if(in_array($file_extension, $allowed_extension))
        {
            $file_name = time() . '.' . $file_extension;
            move_uploaded_file($_FILES['import_excel']['tmp_name'], $file_name);
            $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

            $spreadsheet = $reader->load($file_name);

            unlink($file_name);

            $sheetCount = $spreadsheet->getSheetCount();

            for($i=0; $i<$sheetCount; $i++){
                
                $sheet = $spreadsheet->getSheet($i);
                $data = $sheet->toArray();

                if($i==0){
                    foreach($data as $row)
                    {
                        $insert_data = array(
                            ':id' => $row[0],
                            ':course_code' => $row[1],
                            ':certification_code' => $row[2], 
                            ':objective' => $row[3]
                        );
                        $query = "
                            INSERT INTO certification_objectives (id, course_code, certification_code, objective) 
                            VALUES (:id, :course_code, :certification_code, :objective);

                            UPDATE certification_objectives JOIN course 
                            ON certification_objectives.course_code = course.course_code 
                            SET certification_objectives.course_id = course.id;

                            UPDATE certification_objectives JOIN certification 
                            ON certification_objectives.certification_code = certification.certification_code 
                            SET certification_objectives.certification_id = certification.id;";

                        $statement = $connect->prepare($query);
                        $statement->execute($insert_data);
                    }
                }
            }
                $message = '<div class="alert alert-success"> <strong> Success! Certification Objectives Uploaded! </strong> 
                Redirect to curriculum <a href="curriculum-table.php" class="alert-link">Click here</a></div>';
        }
        else
        {
            $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
        }
    }
    else
    {
        $message = '<div class="alert alert-danger">Please Select File</div>';
    }
    echo $message;
} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}

$connect = null;
?>