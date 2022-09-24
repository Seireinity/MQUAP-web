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
                            ':curriculum_code' => $row[1],
                            ':course_code' => $row[2],
                            ':certification_code' => $row[3],
                            ':name' => $row[4],
                            ':faculty' => $row[5],
                            ':year_level' => $row[6],
                            ':term' => $row[7],
                            ':units' => $row[8],
                        );

                        $query = "
                        INSERT INTO course (id, curriculum_code, course_code, certification_code, name, faculty, year_level, term, units) 
                        VALUES (:id, :curriculum_code, :course_code, :certification_code, :name, :faculty, :year_level, :term, :units);
                
                        UPDATE course JOIN curriculum 
                        ON course.curriculum_code = curriculum.curriculum_code 
                        SET course.curriculum_id = curriculum.id;

                        UPDATE course JOIN certification 
                        ON course.certification_code = certification.certification_code 
                        SET course.certification_id = certification.id;";

                        $statement = $connect->prepare($query);
                        $statement->execute($insert_data);
                    }                                                               
                }
            }
                $message = '<div class="alert alert-success"> <strong> Success! Courses Uploaded! </strong> 
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