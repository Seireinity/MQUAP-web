<?php include 'connect-db.php'; ?>
<?php
$id = $_GET["id"]; //curriculum id

$query = "SELECT *
            FROM course 
            WHERE course.curriculum_id = $id";
$result = mysqli_query($db, $query);


$query2 = "SELECT * FROM curriculum WHERE id = $id";
$result2 = mysqli_query($db, $query2);
$curriculum = mysqli_fetch_assoc($result2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQUAP | Courses </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="matching.css" rel="stylesheet">
</head>

<body>

    <div class="row">
        <div class="col-3 text-white" style="background-color: #EC1D25;">
            <?php include 'sidebar.php'; ?>
            <?php include 'menubar.php'; ?>
        </div>

        <div class="col-sm-9">
            <nav class="navbar navbar-expand-sm">
                <div class="container-fluid">
                    <a href="curriculum-table.php">
                        <input class="btn btn-outline-secondary btn-lg" type="button" value="< BACK">
                    </a>
                </div>
            </nav>

            <br>
            <p style="font-size: 1.5rem; font-weight: bold;"> <?php echo htmlspecialchars($curriculum['program']); ?> </p>
            <h6><small>First, upload the courses you want to match. <br>
                    Upload your course topics and course outcomes per course on VIEW CONTENT.<br>
                    Upload the certifications you want to match with your course on CERTIFICATIONS. </small></h6><br>
            <?php
            if (mysqli_num_rows($result) > 0) {
            ?>

                <table class="table table-hover table-responsive">
                    <tr>
                        <thead style="background-color: #d3d3d3;">
                            <th> COURSE CODE </th>
                            <th> NAME </th>
                            <th> FACULTY </th>
                            <th> YEAR LEVEL </th>
                            <th> TERM </th>
                            <th> UNITS </th>
                            <th> </th>
                            <th> </th>
                        </thead>
                    </tr>

                    <?php

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td> <?php echo $row['course_code']; ?> </td>
                            <td> <?php echo $row['name']; ?> </a> </td>
                            <td> <?php echo $row['faculty']; ?> </a> </td>
                            <td> <?php echo $row['year_level']; ?> </a> </td>
                            <td> <?php echo $row['term']; ?> </a> </td>
                            <td> <?php echo $row['units']; ?> </a> </td>
                            <td> <a href="certification-table.php?id=<?php echo $row['id']; ?>" target="_self">Certifications</a></td>
                            <td> <a href="course-content-table.php?id=<?php echo $row['id']; ?>" target="_self"> View Content</a></td>
                        </tr>

                    <?php
                    }
                    ?>
                </table>

            <?php
            } else {
                include 'matching-with-course.php';
            }
            ?>
        </div>
</body>

</html>