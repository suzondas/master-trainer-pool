<?php include '../controllers/adminController.php' ?>
<?php getUserProfileDetails(); ?>

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
    <title>View Profile</title>
    <link rel="stylesheet" href="../../src/css/bootstrap.min.css">
</head>
<body>
<br>
<h2 align="center"> Profile of <?= $userData['first_name'] ?></h2>
<hr>
<div class="container" style="padding:20px;background-color: aliceblue;">
    <form action="#" method="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4">
                <b>First Name:</b>
                <br>
                <input class="form-control" type="text" placeholder="First Name" value="<?= $userData['first_name'] ?>"
                       name="first_name">
                <br>
                <b>Mobile Number:</b>
                <br>
                <input class="form-control" type="text" placeholder="Mobile" value="<?= $userData['mobile'] ?>"
                       name="mobile">
                <br>
                <b>Selected Course:</b>
                <br>
                <input class="form-control" type="text" placeholder="" value="<?= $userData['course'] ?>"
                       disabled>
                <br>
                <br>
            </div>
            <div class="col-md-4">
                <b>Last Name:</b> <br>

                <input class="form-control" type="text" placeholder="Last Name" name="last_name"
                       value="<?= $userData['last_name'] ?>">
                <br>
                <b>Email:</b> <br>

                <input class="form-control" type="text" placeholder="Last Name" name="email"
                       value="<?= $userData['email'] ?>" disabled>

                <br>
                <b>Your Index No:</b> <br>

                <input class="form-control" type="number" placeholder="Index Number" name="index_number"
                       value="<?= $userData['index_number'] ?>">

                <br><br>
            </div>
            <div class="col-md-4">
                <b>Your Photo</b> <br>
                <img alt="Your Photo" src="
                <?php if (isset($userData['photo'])) {
                    echo '../../upload/' . $userData['photo'];
                } else {
                    echo "data:image/png;base64,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";
                }
                ?>
                " id="photoPreview" style="width:200px;height: 180px;background-color: white;"/>
            </div>
            <br>
            <hr>
            <div class="col-md-6">
                <b>EIIN of Institution:</b> <br>
                <div class="row">
                    <div class="col-md-9">
                        <input id="eiin" class="form-control" type="number" placeholder="EIIN" name="eiin"
                               value="<?= $userData['eiin'] ?>">
                    </div>
                    <div class="col-md-3">
                        <input type="button" class="btn btn-warning" onclick="searchEiin()" value="View"/>
                    </div>
                </div>

                <br>
                <div class="ng-scope">
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
                    <label for="post">Your Designation</label>

                    <select class="form-control" name="post" id="post">
                        <?php $univArray = array("Assistant Teacher", "Head Teacher", "Lecturer", "Lecturer in ICT", "Principle", "Assistant Professor", "Professor");
                        foreach ($univArray as $key => $value) {
                            if ($key == $userData['post']) {
                                echo "<option value='" . $key . "' selected>" . $value . "</option>";
                            } else {
                                echo "<option value='" . $key . "'>" . $value . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
            <div class="col-md-6" style="background: beige;">
                <br>
                Upload files in PDF format
                <hr>
                <div class="row">
                    <div class="col-md-1">
                        <input class="" value="1" name="attestation"
                               type="checkbox" <?= $userData['attestation'] ? 'checked' : '' ?>/>
                    </div>
                    <div class="col-md-6">
                        শিক্ষা প্রতিষ্ঠান প্রধানের প্রত্যয়নপত্র
                    </div>
                    <div class="col-md-4">
                        <?php if ($userData['attestation_file'] != '') {
                            echo '<a target="_blank" href="../../upload/' . $userData['attestation_file'] . '">View</a>';
                        }
                        ?>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-1">
                        <input class="" value="1" name="ambassador"
                               type="checkbox" <?= $userData['ambassador'] ? 'checked' : '' ?>/>
                    </div>
                    <div class="col-md-6">
                        জেলা আইসিটি এম্বাসেডর
                    </div>
                    <div class="col-md-4">
                        <?php if ($userData['ambassador_file'] != '') {
                            echo '<a target="_blank" href="../../upload/' . $userData['ambassador_file'] . '">View</a>';
                        }
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        <input class="" value="1" name="contentuploader"
                               type="checkbox" <?= $userData['contentuploader'] ? 'checked' : '' ?>/>
                    </div>
                    <div class="col-md-6">
                        শিক্ষক বাতায়নে শ্রেষ্ঠ কন্টেন্ট আপলোডার
                    </div>
                    <div class="col-md-4">
                        <?php if ($userData['contentuploader_file'] != '') {
                            echo '<a target="_blank" href="../../upload/' . $userData['contentuploader_file'] . '">View</a>';
                        }
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        <input class="" value="1" name="banbeistraining"
                               type="checkbox" <?= $userData['banbeistraining'] ? 'checked' : '' ?>/>
                    </div>
                    <div class="col-md-6">
                        ব্যানবেইস কর্তৃক আয়োজিত প্রশিক্ষণে অংশগ্রহণ
                    </div>
                    <div class="col-md-4">
                        <?php if ($userData['banbeistraining_file'] != '') {
                            echo '<a target="_blank" href="../../upload/' . $userData['banbeistraining_file'] . '">View</a>';
                        }
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        <input class="" value="1" name="bcctraining"
                               type="checkbox" <?= $userData['bcctraining'] ? 'checked' : '' ?>/>
                    </div>
                    <div class="col-md-6">
                        বিসিস/সেসিপ/টিটিসি কর্তৃক আয়োজিত মাল্টিমিডিয়া কন্টেন্ট তৈরী বিষয়ক প্রশিক্ষণে অংশগ্রহণ
                    </div>
                    <div class="col-md-4">
                        <?php if ($userData['bcctraining_file'] != '') {
                            echo '<a target="_blank" href="../../upload/' . $userData['bcctraining_file'] . '">View</a>';
                        }
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        <input class="" value="1" name="icteducation"
                               type="checkbox" <?= $userData['icteducation'] ? 'checked' : '' ?>/>
                    </div>
                    <div class="col-md-6">
                        আইসিটি বিষয়ক শিক্ষাগত যোগ্যতা (অনার্স/মাস্টার্স/ডিপ্লোমা)
                    </div>
                    <div class="col-md-4">
                        <?php if ($userData['icteducation_file'] != '') {
                            echo '<a target="_blank" href="../../upload/' . $userData['icteducation_file'] . '">View</a>';
                        }
                        ?>
                    </div>
                </div>

            </div>

            <br>
            <br>
<!--            <input style="margin-left:20px;" class="submit_btn btn btn-success" type="submit"-->
<!--                   value="Update Your Profile"-->
<!--                   name="update_profile_btn">&nbsp;-->
            <a href="manage-students.php"><input class="btn btn-warning" type="button" value="Cancel"></a>
        </div>
    </form>

</div>

<script>
    var loadFile = function (event) {
        var output = document.getElementById('photoPreview');
        output.src = URL.createObjectURL(event.target.files[0]);
    };

    //your code here
    function searchEiin() {
        if ($("#eiin").val() === '') {
            alert("No EIIN found!")
        } else {
            var form = new FormData();
            form.append('eiin', $("#eiin").val());
            $.ajax({
                url: '../searchEiin.php', // point to server-side PHP script
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
