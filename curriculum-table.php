<?php include 'connect-db.php'; ?>

<?php
$query = "SELECT program, school_year, total_units, id FROM curriculum";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQUAP | Matching with Curriculum</title>
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
                    <input onclick="history.back()" class="btn btn-outline-secondary btn-lg" type="button" value="< BACK">
                    </a>
                </div>
            </nav>
            
            <br>
            <h6><small>First, upload the curricula. Then select a curriculum. </small></h6>

            <?php
            if (mysqli_num_rows($result) > 0) { ?>


                <table class="table table-hover table-responsive">
                    <tr>
                        <thead style="background-color: #d3d3d3;">
                            <th> PROGRAM </th>
                            <th> SY </th>
                            <th> UNITS</th>
                            <th> </th>
                        </thead>
                    </tr>

                    <?php

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td> <?php echo $row['program']; ?> </a> </td>
                            <td> <?php echo $row['school_year']; ?> </td>
                            <td> <?php echo $row['total_units']; ?> </td>
                            <td> <a href="course-table.php?id=<?php echo $row['id']; ?>" target="_self">Select</a></td>
                        </tr>

                    <?php
                    }
                    ?>
                </table>

            <?php
            } else {
                include 'matching-with-curriculum.php';
            }
            ?>
        </div>
</body>

</html>