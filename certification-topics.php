
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
                            ':course_id' => $row[1],
                            ':course_code' => $row[2],
                            ':certification_id' => $row[3],
                            ':certification_code' => $row[4], 
                            ':topic' => $row[5]
                        );
                        $query = "
                            INSERT INTO certification_topics (id, course_id, course_code, certification_id, certification_code, topic) 
                            VALUES (:id, :course_id, :course_code, :certification_id, :certification_code, :topic);                            
                            
                            UPDATE certification_topics JOIN course 
                            ON certification_topics.course_code = course.course_code 
                            SET certification_topics.course.id = course.id;

                            UPDATE certification_topics JOIN certification 
                            ON certification_topics.certification_code = certification.certification_code 
                            SET certification_topics.certification_id = certification.id;";

                        $statement = $connect->prepare($query);
                        $statement->execute($insert_data);
                    }
                }
            }
                $message = '<div class="alert alert-success"> <strong> Success! Certification Topics Uploaded! </strong> 
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

/*
UPDATE certification_topics JOIN course 
                            ON certification_topics.course_code = course.course_code 
                            SET certification_topics.course.id = course.id;
                            */
$connect = null;
?>