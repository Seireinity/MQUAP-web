<?php include 'connect-db.php'; ?>
<?php

$id = $_GET["id"]; //course id

$query = "SELECT percentage.id, percentage.percentage, certification.name, certification.industry
        FROM percentage
        INNER JOIN certification ON percentage.certification_id = certification.id
        INNER JOIN course ON certification.course_id = course.id
        WHERE course.id = $id";
$result = mysqli_query($db, $query);

$query2 = "SELECT * FROM course WHERE id = $id";
$result2 = mysqli_query($db, $query2);
$course = mysqli_fetch_assoc($result2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQUAP | Certification Percentage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="matching.css" rel="stylesheet">
</head> 

<body>

<div class = "row">
    <div class = "col-3 text-white" style="background-color: #EC1D25;"> 
        <?php include 'sidebar.php'; ?>
        <?php include 'menubar.php'; ?>
    </div>

<div class = "col-sm-9">
<nav class="navbar navbar-expand-sm">
  <div class="container-fluid">
    <input onclick="history.back()" class ="btn btn-outline-secondary btn-lg" type="button" value="< BACK">
    </a>
  </div>
</nav>

<br>
<p style="font-size: 1.5rem; font-weight: bold;"> <?php echo htmlspecialchars($course['name']); ?> </p>
<p style="font-size: 1.2rem; font-weight: normal;">Select a certification to view their comparison of topics.</p>

<?php
    if(mysqli_num_rows($result)>0){
?>

<table class = "table table-hover table-responsive">
    <tr>
    <thead style = "background-color: #d3d3d3;">
        <th> CERTIFICATION NAME </th>
        <th> INDUSTRY </th>
        <th> RESULT <th>
        <th> TEST <th>
    </thead>
    </tr>
    
    <?php

        while ($row = mysqli_fetch_array($result)){
    ?>
        <tr> 
            <td> <?php echo $row['name']; ?> </td>
            <td> <?php echo $row['industry']; ?> </a> </td>
            <td> <?php echo $row['percentage']; ?> </a> </td>
            <td> <?php echo $row['id']; ?> </a> </td>
            <!--<td> <a href="view-topics-comparison.php?id=<?php //echo $row['id'];?>"target="_self">Select</a></td>-->
        </tr>   
                
    <?php
        }
    ?> 
    </table>
    
    <?php
    }
    else{
        echo "No File Found";
    }
    ?>

    </div>
</body>
</html>