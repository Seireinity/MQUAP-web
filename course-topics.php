
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
                            ':topic' => $row[2]
                        );
                        $query = "
                            INSERT INTO course_topics (id, course_code, topic) 
                            VALUES (:id, :course_code, :topic);

                            UPDATE course_topics JOIN course 
                            ON course_topics.course_code = course.course_code 
                            SET course_topics.course_id = course.id;";

                        $statement = $connect->prepare($query);
                        $statement->execute($insert_data);
                    }
                }
            }
                $message = '<div class="alert alert-success"> <strong> Success! Course Topics Uploaded! </strong> 
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