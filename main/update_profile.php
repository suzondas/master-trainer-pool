<?php include 'controllers/authController.php' ?>
<?php getProfileDetails(); ?>

<?php
// redirect user to login page if they're not logged in
if (empty($_SESSION['id'])) {
    header('location: login.php');
}
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

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
</head>
<body>
<br>
<h2 align="center">Update Your Profile</h2>
<hr>
<div class="container" style="padding:20px;background-color: aliceblue;">
    <form action="update_profile.php" method="post">
        <div class="row">
            <div class="col-md-6">
                <b>First Name:</b>
                <br>
                <input class="form-control" type="text" placeholder="First Name" value="<?= $_SESSION['first_name'] ?>"
                       name="first_name">
                <br>
                <b>Mobile Number:</b>
                <br>
                <input class="form-control" type="text" placeholder="Mobile" value="<?= $_SESSION['mobile'] ?>"
                       name="mobile">
                <br>
                <b>Selected Course:</b>
                <br>
                <input class="form-control" type="text" placeholder="" value="<?= $_SESSION['course'] ?>"
                       disabled>
                <br>
                <br>
            </div>
            <div class="col-md-6">
                <b>Last Name:</b> <br>

                <input class="form-control" type="text" placeholder="Last Name" name="last_name"
                       value="<?= $_SESSION['last_name'] ?>">
                <br>
                <b>Email:</b> <br>

                <input class="form-control" type="text" placeholder="Last Name" name="email"
                       value="<?= $_SESSION['email'] ?>" disabled>

                <br>
                <b>Your Index No:</b> <br>

                <input class="form-control" type="text" placeholder="Index Number" name="index"
                       value="">

                <br><br>
            </div>
            <br>
            <hr>
            <div class="col-md-6">

                <b>EIIN of Institution:</b> <br>
                <div class="row">
                    <div class="col-md-9">
                <input id="eiin" class="form-control" type="number" placeholder="EIIN" name="eiin"
                       value="<?= $_SESSION['eiin'] ?>">
                    </div>
                    <div class="col-md-3">
                    <input type="button" class="btn btn-warning" onclick="searchEiin()" value="Fetch"/>
                </div>
                </div>

                <br>
                <div  class="ng-scope">
                    Institute Name:
                    <input class="form form-control" id="instName" value="" readonly disabled/>
                    <br>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="insType">Institute Type</label>
                            <input type="text" ng-model="res.INSTITUTE_TYPE_NAME" id="insType"
                                   class="form-control ng-pristine ng-valid ng-not-empty ng-touched" readonly="">
                        </div>
                        <div class="col-md-6">
                            <label for="division">Division</label>
                            <input type="text" ng-model="res.DIVISION_NAME" id="division"
                                   class="form-control ng-pristine ng-untouched ng-valid ng-not-empty" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="district">District</label>
                            <input type="text" ng-model="res.DISTRICT_NAME" id="district"
                                   class="form-control ng-pristine ng-valid ng-not-empty ng-touched" readonly="">
                        </div>
                        <div class="col-md-6">
                            <label for="thana">Thana</label>
                            <input type="text" ng-model="res.THANA_NAME" id="thana"
                                   class="form-control ng-pristine ng-untouched ng-valid ng-not-empty" readonly="">
                        </div>
                    </div>
                    <br>
                    <label for="district">Your Post</label>
                    <input type="text"  id="post" name="post"
                           class="form-control">
                    <br>
                    <br>
                    <br>
                </div>
            </div>
            <div class="col-md-6" style="background: beige;">
                <br>
                <hr>
                <div class="row">
                <div class="col-md-1">
                    <input class="" type="checkbox"/>
                </div>
                <div class="col-md-6">
                    Selected as District ICT Ambassador
                </div>
                <div class="col-md-4">
                    <input type="file"/>
                </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        <input class="" type="checkbox"/>
                    </div>
                    <div class="col-md-6">
                        Selected as best content uploader in Shikkhok Batayan
                    </div>
                    <div class="col-md-4">
                        <input type="file"/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        <input class="" type="checkbox"/>
                    </div>
                    <div class="col-md-6">
                        Participated in Trainig from BANBEIS
                    </div>
                    <div class="col-md-4">
                        <input type="file"/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        <input class="" type="checkbox"/>
                    </div>
                    <div class="col-md-6">
                        Attestation of Institution Head
                    </div>
                    <div class="col-md-4">
                        <input type="file"/>
                    </div>
                </div>
            </div>

            <br>
            <br>
            <input style="margin-left:20px;" class="submit_btn btn btn-success" type="submit" value="Update Your Profile"
                   name="update_profile_btn">&nbsp;
            <a href="dashboard.php"><input class="btn btn-warning" type="button" value="Cancel"></a>
        </div>
    </form>

</div>

<script>
    //your code here
    function searchEiin() {
        if ($("#eiin").val() === '') {
            alert("No EIIN found!")
        } else {
            var form = new FormData();
            form.append('eiin', $("#eiin").val());
            $.ajax({
                url: 'searchEiin.php', // point to server-side PHP script
                dataType: 'text', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                type: 'post',
                success: function (output) {
                    var array = JSON.parse(output);
                    if (array !== undefined && array.length != 0) {
                        $("#instName").val(array[0].INSTITUTE_NAME_NEW)
                        $("#insType").val(array[0].INSTITUTE_TYPE_NAME)
                        $("#division").val(array[0].DIVISION_NAME)
                        $("#district").val(array[0].DISTRICT_NAME)
                        $("#thana").val(array[0].THANA_NAME)
                    } else {
                        $("#eiin").val('');
                        alert('Wrong EIIN!')
                    }
                },
                error: function (err) {
                    alert('Something went wrong. Try Again!')

                }
            });
        }
    }
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</body>
</html>
