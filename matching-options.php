<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="matching-with-curriculum.css" rel="stylesheet">
    <link href="matching.css" rel="stylesheet">
</head>

<body>

    <div class="row align-items-center">
        <div class="col-3 text-white" style="background-color: #EC1D25;">
            <?php include 'sidebar.php'; ?>
            <?php include 'menubar.php'; ?>
        </div>

        <div class="col-sm-9">
            <nav class="navbar navbar-expand-sm">
            </nav>

            <div class="container-fluid p-5 text-white text-center" style="background-color: #ED2939;">
                <h1>MATCHING YOUR COURSES AND CERTIFICATIONS</h1>
            </div>

            <br>
            <h5><small>Check if your certifications or courses are match for each other. This will provide a percentage match.</small></h5>
            <br>

            <div class="d-grid gap-3 col-8 mx-auto">
                <h6 class="text-center"><small> Check which certification(s) are a match to one of your academic courses. </small></h6>
                <a class="btn btn-lg btn-outline-danger" href="curriculum-table.php" role="button"> Course To Certifications</a>

                <h6 class="text-center"><small>Check which course(s) are a match to one certification. </small></h6>
                <a type="button" class="btn btn-lg btn-outline-danger" href="certification2.php" role="button">Certification To Courses</a>
            </div>
        </div>

    </div>
</body>

</html>