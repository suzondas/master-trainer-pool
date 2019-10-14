<?php include 'controllers/authController.php' ?>
<?php
// redirect user to login page if they're not logged in
if (empty($_SESSION['id'])) {
    header('location: login.php');
}
getProfileDetails()
?>

<?php if (count($errors) > 0): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <li>
                <?php echo $error; ?>
            </li>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<!-- Display messages -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert <?php echo $_SESSION['type'] ?>">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        unset($_SESSION['type']);
        ?>
    </div>
<?php endif; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="../src/css/bootstrap.min.css"/>
    <script type="text/javascript" src="../src/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../src/js/popper.min.js"></script>
    <script type="text/javascript" src="../src/js/bootstrap.min.js"></script>
    <style>
        .site-logo {
            height: 50px;
            background: green;
            border-radius: 30%;
            padding: 5px;
        }
        .dropdown-menu li{
            padding: 5px;
            background-color: dodgerblue;
            border-bottom: 1px solid black;
            margin: 2px;
            color:white;
            font-weight: bold;
        }
        .dropdown-menu li a{
            color:white;
        }
    </style>
</head>

<body style="height: 500px !important;background: url(../src/images/bg-pattern.jpg);
">


<div id="container" style="height: 500px !important;background: white;padding: 10px;">

    <div class="row header">
        <div class="col-md-2" style="color:white; padding: 5px;font-weight: bold;font-size: 16px;">
            BANBEIS <br>Master Trainer Pool
        </div>
        <div class="col-md-10">
            <div class="row" style="text-align: right; padding-top:10px;">
                <div class="col-md-9">

                    <a href="update_profile.php">
                        <button class="btn btn-info">Manage Your Profile
                        </button>
                    </a>
                </div>
                <div class="col-md-3">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">
                           Settings
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <li role="presentation"><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12" style="padding:10px;">
        <br>

        <h3>Welcome <?php echo $_SESSION['first_name']. " ". $_SESSION['last_name']; ?><br>Right now you are not enrolled as master trainer in any course.</h3>
        <button class="btn btn-success">Take an Exam</button>
    </div>

</div>



</body>
</html>