<?php

include 'connect-db.php'; 
include 'similarity.php';
include 'BruteForce.php';

$id = $_GET["id"]; //course id

$query2 = "SELECT * FROM course WHERE id = $id";
$result2 = mysqli_query($db, $query2);
$course = mysqli_fetch_assoc($result2); 

/////////////////////// COSINE SIMILARITY - PERCENTAGE MATCH

$wordsTarget = $word; //identical words
$certifications = $y; //certification content

//$articles = $certifications;

//get dot product 
$dot = Similarity::dot(call_user_func_array("array_merge", array_column($certifications, "tags")));

//get cosine similarity by the dot product
foreach($certifications as $certification) {
	$score[$certification['certification']] = Similarity::cosine($wordsTarget, $certification['tags'], $dot);
}

//format percentage result to 2 decimal places
foreach($score as $x => $x_value) {
	$score[$x] = round($x_value * 100, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> MQUAP | Certification Percentage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../matching.css" rel="stylesheet">
</head> 
<body>

<div class = "row">
    <div class = "col-3 text-white" style="background-color: #EC1D25;"> 
        <?php include ('../sidebar.php'); ?> 
        <?php include ('../menubar.php'); ?>
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

<table class = "table table-hover table-responsive">
	<tr>
		<thead style = "background-color: #d3d3d3;">
			<th> CERTIFICATION NAME </th>
			<th> PERCENTAGE MATCH </th>
			<th>  </th>
		</thead>
	</tr>

<?php

	foreach($score as $name => $percent) { ?>
	<tr>
			<td><?php echo $name?></td>
			<td><b><?php echo $percent; echo " %";?> </b></td>
	</tr>
	<?php }
?>

</body>
</html>
