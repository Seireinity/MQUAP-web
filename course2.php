<?php include 'connect-db.php'; ?>
<?php
$id = $_GET["id"]; //certification2.php id

$query = "SELECT * FROM course";
$result = mysqli_query($db, $query);


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
            <p style="font-size: 1.5rem; font-weight: bold;"> <?php echo htmlspecialchars($certification['name']); ?> </p>
            <h6><small>First, upload the Course List you want to match. <br>
                    Upload your course topics and course outcomes per course on VIEW CONTENT.<br>
                    Proceed to Matching to view percentage results. </small></h6><br>
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
                            <td> <a href="course-content-table.php?id=<?php echo $row['id']; ?>" target="_self"> View Content</a></td>
                        </tr>

                        <div class="container my-12 bg-light fixed-bottom">
                            <div class="col-md-12 text-center">
                                <a href="Matching/test2.php?id=<?php echo $certification['id']; ?>" target="_self">
                                    <input class="btn btn-outline-secondary  btn-lg" type="button" value="PROCEED TO MATCHING">
                                </a>
                            </div>
                        </div>

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