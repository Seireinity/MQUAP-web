<?php include 'connect-db.php'; ?>
<?php
    $id = $_GET["id"]; //course id

    $query = "SELECT *
            FROM certification 
            WHERE certification.course_id = $id";
    $result = mysqli_query($db, $query);

    $query2 = "SELECT * FROM course WHERE id = $id";
    $result2 = mysqli_query($db, $query2);
    $course = mysqli_fetch_assoc($result2); 

    $query3 = "SELECT * FROM certification WHERE id = $id";
    $result3 = mysqli_query($db, $query3);
    $certification = mysqli_fetch_assoc($result3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQUAP | Matching with Certification</title>
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

<?php
    if(mysqli_num_rows($result)>0){
?>

<table class = "table table-hover table-responsive">
    <tr>
    <thead style = "background-color: #d3d3d3;">
        <th> CERTIFICATION NAME </th>
        <th> INDUSTRY </th>
        <th>  </th>
    </thead>
    </tr>
    
    <?php

        while ($row = mysqli_fetch_array($result)){
    ?>
        <tr> 
            <td> <?php echo $row['name']; ?> </td>
            <td> <?php echo $row['industry']; ?> </a> </td>
            <td> <a href="certification-content-table.php?id=<?php echo $row['id'];?>"target="_self"> View Content</a></td>
        </tr>   
                
    <?php
        }
    ?> 
    </table>
    
    <?php
    }
    else{
        include 'matching-with-certification.php';
    }
    ?>

<div class="container my-12 bg-light fixed-bottom">
<div class="col-md-12 text-center">
  <a href="Matching/test.php?id=<?php echo $course['id'];?>"target="_self">
    <input class ="btn btn-outline-secondary  btn-lg" type="button" value="PROCEED TO MATCHING">
    </a>
  </div>
  </div>

</div>
</body>
</html>