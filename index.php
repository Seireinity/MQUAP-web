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

<style>
    div.container1 {
        position: relative;
        text-align: center;
        color: white;
    }
  
    h1.welcomeText {
        position: absolute;
        bottom: 20%;
        left: 15px;
        font-size: 130px;
        letter-spacing: -22px;
    }

    div.mquap {
        position: absolute;
        bottom: 14%;
        left: 16px;
        font-size: 30px;
    }

</style>
    
</head> 
<body>
<div class = "row">
    <div class = "col-3 text-white" style="background-color: #EC1D25;"> 
        <?php include 'sidebar.php'; ?>
        <?php include 'menubar.php'; ?>
    </div>

<div class = "col-sm-9">
    <div class="container1">
        <img src="hp.png" alt="Homepage" style="width:100%;">
        <h1 class="welcomeText"> <img class="a" src="unc.png" width="140" height="140">
        <b>
            <span style = "color: #000000"> M </span>
            <span style = "color: #000000"> Q </span>
            <span style = "color: #000000"> U </span>
            <span style = "color: #D22B2B"> A </span>
            <span style = "color: #D22B2B"> P </span>
        </b>
        </h1>
        <div class = "mquap"><b> 
            <span style = "color: #000000">Multi </span>
            <span style = "color: #D22B2B">Qualification </span>
            <span style = "color: #000000">Acquisition </span>
            <span style = "color: #D22B2B">Program </span>
        </b></div>
    </div>   
</div>
</body>
</html>