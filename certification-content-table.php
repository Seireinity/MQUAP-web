<?php include 'connect-db.php'; ?>
<?php
    $id = $_GET["id"]; //certification id

    $query = "SELECT *
            FROM certification_topics 
            WHERE certification_topics.certification_id = $id";
    $result = mysqli_query($db, $query);

    $query3 = "SELECT *
            FROM certification_objectives
            WHERE certification_objectives.certification_id = $id";
    $result3 = mysqli_query($db, $query3);

    $query2 = "SELECT * FROM certification WHERE id = $id";
    $result2 = mysqli_query($db, $query2);
    $certification = mysqli_fetch_assoc($result2);    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQUAP | Certification Content </title>
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
<p style="font-size: 1.5rem; font-weight: bold;"> <?php echo htmlspecialchars($certification['name']); ?> </p>

<?php
    if(mysqli_num_rows($result)>0){
?>
<table class = "table table-hover table-responsive">
    <tr>
        <thead style = "background-color: #d3d3d3;">
            <th> TOPIC OUTLINE </th>
        </thead>
    </tr>
    
    <?php while ($row = mysqli_fetch_array($result)){?>
        <tr> 
            <td> <?php echo $row['topic']; ?> </td>
        </tr>   
    
    <?php } ?>
    </table>
    
    <?php
    }
    else{
        include 'matching-with-certification-content.php';
    }
    ?>

<?php
    if(mysqli_num_rows($result3)>0){
?>
<table class = "table table-hover table-responsive">
    <tr>
        <thead style = "background-color: #d3d3d3;">
            <th> CERTIFICATION OBJECTIVES </th>
        </thead>
    </tr>
    
    <?php while ($row = mysqli_fetch_array($result3)){?>
        <tr> 
            <td> <?php echo $row['objective']; ?> </td>
        </tr>   
    
    <?php } ?>
    </table>
    
    <?php
    }
    else{
        //include 'matching-with-certification-content.php';
    }
?>
</body>
</html>