<?php
//require_once 'sendEmails.php';
session_start();
$username = "";
$email = "";
$mobile = "";
$first_name = "";
$last_name = "";
$errors = [];
$userData =[];

$servername = "192.254.190.210";
$username = "banbeis";
$password = "hm*Fnw#N4L";
$db = "banbeis_mtpool";

//$servername = "localhost";
//$username = "root";
//$password = "";
//$db = "book_share";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*Service - subject*/
function getSubjects()
{
    global $conn;
    $query = "SELECT * FROM subject";
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row['name'];
        }
        return $arr;
    }
}

/*Service - getDistricts*/
function getDistricts()
{
    $query = "SELECT * FROM districts";
    global $conn;
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row['name'];
        }
        return $arr;
    }
}

/*Service - getUpazilas*/
function getUpazilas()
{
    $query = "SELECT * FROM upazilas";
    global $conn;
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row['name'];
        }
        return $arr;
    }
}

/*Service - getPublishedBook */
function getPublishedBook()
{
    $query = "SELECT * FROM book where user_id=? and available=1";
    global $conn;

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['id']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row;
        }
        return $arr;
    }
}

/*Service - toakenMatch */
function tokenMatch($request_id, $token)
{
    $query = "SELECT * FROM token where request_id=? and code=?";
    global $conn;

    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $request_id, $token);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows) {
            $query1 = "UPDATE token set accepted=1 where request_id=?";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bind_param('i', $request_id);
            if ($stmt1->execute()) {
                $query2 = "update book set available=0, collector_id=? where id=(select book_id from request where id=?)";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bind_param('ii', $_SESSION['id'], $request_id);
                if ($stmt2->execute()) {
                    header('location: requestedBook.php');
                    $_SESSION['message'] = 'Thanks For Collecting Book!';
                    $_SESSION['type'] = 'alert-success';
                }
            }
        } else {
            header('location: requestedBook.php');
            $_SESSION['message'] = 'Token did not match';
            $_SESSION['type'] = 'alert-danger';
        }
    }
}

/*Service - requestedBook */
function getRequestedBook()
{
    $query = "SELECT l.id, i.name, i.subject, i.course, i.conditions, i.created, j.first_name, j.last_name, k.name as subject_name, l.accept, (select name from districts where id=h.district) as district, (select name from upazilas where id=h.upazila) as upazila FROM users h, book i, user_academic_info j, subject k, request l where i.user_id=j.user_id and h.id = j.user_id and i.available=true and l.requester_id =? and l.book_id = i.id and i.subject = k.id";
    global $conn;

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['id']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row;
        }
        return $arr;
    }
}

/*token function*/
function token($request_id)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 5; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $request_id . $randomString;
}

/*Service - requestedBook */
function acceptBookRequested($request_id)
{
    $query = "update request set accept=1 where id = ?";
    global $conn;

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $request_id);
    if ($stmt->execute()) {
        $query1 = "insert into token set code=?, request_id=?, accepted=0, created=now()";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param('si', token($request_id), $request_id);
        if ($stmt1->execute()) {
            header('location: bookRequested.php');
            $_SESSION['message'] = 'Request  Accepted!';
            $_SESSION['type'] = 'alert-success';
        } else {
            header('location: bookRequested.php');
            $_SESSION['message'] = 'Database Error!';
            $_SESSION['type'] = 'alert-danger';
        }
    } else {
        header('location: bookRequested.php');
        $_SESSION['message'] = 'Database Error!';
        $_SESSION['type'] = 'alert-danger';
    }
}

/*Service - getBookRequested */
function getBookRequested()
{
    $query = "select i.id, i.name, i.subject, i.course, i.conditions, j.first_name, j.last_name, k.accept, k.id as request_id, k.created, (select code from token where request_id=k.id) as code from book i, user_academic_info j, request k where k.user_id=? and k.book_id=i.id and k.requester_id=j.user_id and i.available=1";
    global $conn;

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['id']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row;
        }
        return $arr;
    }
}


/*Service - booksCollected */
function booksCollected()
{
    $query = "select i.id, i.name, i.subject, i.course, i.conditions, j.first_name, j.last_name,  (select name from districts where id=h.district) as district, (select name from upazilas where id=h.upazila) as upazila, k.accept, k.id as request_id, k.created, l.code from users h, book i, user_academic_info j, request k, token l where h.id = i.user_id and i.collector_id=? and i.user_id=j.user_id and k.book_id=i.id and l.request_id=k.id and i.available=0";
    global $conn;

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['id']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row;
        }
        return $arr;
    }
}

/*Service - booksGiven */
function booksGiven()
{
    $query = "select i.id, i.name, i.subject, i.course, i.conditions, j.first_name, j.last_name,  (select name from districts where id=h.district) as district, (select name from upazilas where id=h.upazila) as upazila, k.accept, k.id as request_id, k.created, l.code from users h, book i, user_academic_info j, request k, token l where h.id = i.collector_id and i.user_id=? and i.collector_id=j.user_id and k.book_id=i.id and l.request_id=k.id and i.available=0";
    global $conn;

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['id']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row;
        }
        return $arr;
    }
}

/*Service - getAvailable */
function getAvailableBook()
{
    $query = "SELECT i.id, i.name, i.subject, i.course, i.conditions, i.created, j.first_name, j.last_name, k.name as subject_name, if ((select requester_id from request where requester_id=? and book_id=i.id) is null ,0,1) as requested FROM book i, user_academic_info j, subject k where i.user_id=j.user_id and i.available=true and i.user_id !=? and i.subject = k.id";
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $_SESSION['id'], $_SESSION['id']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $arr = [];
        while ($row = mysqli_fetch_array($result)) {
            $arr[] = $row;
        }
        return $arr;
    }
}

/*Service - getProfileDetails*/

function getProfileDetails()
{
    $fname =0;
    $lname =0;
    $photo =0;
    $mobile=0;
    $index =0;
    $eiin =0;
    $attestation =0;
    $designation =0;
    $course =0;
    $email =0;

    global $conn;
    $query = "SELECT * FROM users i, user_academic_info j WHERE i.id=? and j.user_id=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $_SESSION['id'], $_SESSION['id']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        /*profile percentage*/
        /*profile percentage*/
        $_SESSION['username'] = $user['username'];
        $_SESSION['district'] = $user['district'];
        $_SESSION['upazila'] = $user['upazila'];
        if ($user['course'] == 1) {
            $_SESSION['course'] = "Computer Basic and Office Productivity";
        } else {
            $_SESSION['course'] = "Computer Hardware, Troubleshooting and Maintenance";
        }
        $_SESSION['mobile'] = $user['mobile'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['index_number'] = $user['index_number'];
        $_SESSION['eiin'] = $user['eiin'];
        $_SESSION['post'] = $user['post'];
        $_SESSION['photo'] = $user['photo'];
        $_SESSION['ambassador'] = $user['ambassador'];
        $_SESSION['ambassador_file'] = $user['ambassador_file'];
        $_SESSION['contentuploader'] = $user['contentuploader'];
        $_SESSION['contentuploader_file'] = $user['contentuploader_file'];
        $_SESSION['banbeistraining'] = $user['banbeistraining'];
        $_SESSION['banbeistraining_file'] = $user['banbeistraining_file'];
        $_SESSION['icteducation'] = $user['icteducation'];
        $_SESSION['icteducation_file'] = $user['icteducation_file'];
        $_SESSION['bcctraining'] = $user['bcctraining'];
        $_SESSION['bcctraining_file'] = $user['bcctraining_file'];
        $_SESSION['attestation'] = $user['attestation'];
        $_SESSION['attestation_file'] = $user['attestation_file'];
        $_SESSION['verified'] = $user['verified'];
        $_SESSION['type'] = 'alert-success';
    }
}

/*Remove Published Book*/

function removePublishedBook($id)
{
    global $conn;
    $query = "delete from book where id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        header('location: publishedBook.php');
        $_SESSION['message'] = 'Item  removed!';
        $_SESSION['type'] = 'alert-success';
    }
}

/*admin view user*/

function getUserProfileDetails()
{
    $userId = $_GET['userid'];
    $fname =0;
    $lname =0;
    $photo =0;
    $mobile=0;
    $index =0;
    $eiin =0;
    $attestation =0;
    $designation =0;
    $course =0;
    $email =0;

    global $conn;
    $query = "SELECT * FROM users i, user_academic_info j WHERE i.id=? and j.user_id=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $userId, $userId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        /*profile percentage*/
        /*profile percentage*/
        global $userData;
        $userData['username'] = $user['username'];
        $userData['district'] = $user['district'];
        $userData['upazila'] = $user['upazila'];
        if ($user['course'] == 1) {
            $userData['course'] = "Computer Basic and Office Productivity";
        } else {
            $userData['course'] = "Computer Hardware, Troubleshooting and Maintenance";
        }
        $userData['mobile'] = $user['mobile'];
        $userData['email'] = $user['email'];
        $userData['first_name'] = $user['first_name'];
        $userData['last_name'] = $user['last_name'];
        $userData['index_number'] = $user['index_number'];
        $userData['eiin'] = $user['eiin'];
        $userData['post'] = $user['post'];
        $userData['photo'] = $user['photo'];
        $userData['ambassador'] = $user['ambassador'];
        $userData['ambassador_file'] = $user['ambassador_file'];
        $userData['contentuploader'] = $user['contentuploader'];
        $userData['contentuploader_file'] = $user['contentuploader_file'];
        $userData['banbeistraining'] = $user['banbeistraining'];
        $userData['banbeistraining_file'] = $user['banbeistraining_file'];
        $userData['icteducation'] = $user['icteducation'];
        $userData['icteducation_file'] = $user['icteducation_file'];
        $userData['bcctraining'] = $user['bcctraining'];
        $userData['bcctraining_file'] = $user['bcctraining_file'];
        $userData['attestation'] = $user['attestation'];
        $userData['attestation_file'] = $user['attestation_file'];
        $userData['verified'] = $user['verified'];
        $userData['type'] = 'alert-success';
    }
}
/*admin view user*/
/*Remove Published Book*/

function cancelRequestedBook($id)
{
    global $conn;
    $query = "delete from request where id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        header('location: requestedBook.php');
        $_SESSION['message'] = 'Request  Cancelled!';
        $_SESSION['type'] = 'alert-success';
    }
}

/*Request Book*/

function requestBook($book_id)
{
    global $conn;
    $query = "insert into request set book_id=?, requester_id=?, user_id=(select user_id from book where id=? ), created=now()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iii', $book_id, $_SESSION['id'], $book_id);
    if ($stmt->execute()) {
        header('location: collectBook.php');
        $_SESSION['message'] = 'Item  successfully requested!';
        $_SESSION['type'] = 'alert-success';
    }
}

// SIGN UP USER
if (isset($_POST['signup-btn'])) {

    if (empty($_POST['email'])) {
        $errors['email'] = 'Email required';
    }
    if (empty($_POST['mobile'])) {
        $errors['mobile'] = 'Phone Number required';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password required';
    }
    if (empty($_POST['first_name'])) {
        $errors['first_name'] = 'first name required';
    }
    if (empty($_POST['last_name'])) {
        $errors['last_name'] = 'last name required';
    }
    if (isset($_POST['password']) && $_POST['password'] !== $_POST['passwordConf']) {
        $errors['passwordConf'] = 'The two passwords do not match';
    }

    $email = $_POST['email'];
    $username = $email;
    $mobile = $_POST['mobile'];
    $course = $_POST['course'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $token = bin2hex(mt_rand(50, 1000)); // generate unique token
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypt password

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $errors['email'] = "Email already exists";
    }

    if (count($errors) === 0) {
        $query = "INSERT INTO users SET username=?, email=?, token=?, password=?, mobile=?, course=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss', $username, $email, $token, $password, $mobile, $course);
        $result = $stmt->execute();

        if ($result) {
            $user_id = $stmt->insert_id;
            $stmt->close();

            $query1 = "INSERT INTO user_academic_info SET user_id=?, first_name=?, last_name=?";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bind_param('iss', $user_id, $first_name, $last_name);
            $result1 = $stmt1->execute();

            if ($result1) {
                // TO DO: send verification email to user
                sendVerificationEmail($email, $token);

                $_SESSION['id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['verified'] = false;
                $_SESSION['type'] = 'alert-success';
                header('location: index.php');
            }
        } else {
            $errors['error_msg'] = "User Already Exists!: Could not register user";
        }
    }
}

// LOGIN
if (isset($_POST['login-btn'])) {
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username or email required';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password required';
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (count($errors) === 0) {
        $query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $username, $username);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) { // if password matches
                $stmt->close();

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = $user['verified'];
                $_SESSION['type'] = 'alert-success';
                if($user['username']=='admin'){
                    header('location: mtpooladmin/dashboard.php');
                }else{
                    header('location: index.php');
                }
                exit(0);
            } else { // if password does not match
                $errors['login_fail'] = "Wrong username / password";
            }
        } else {
            $_SESSION['message'] = "User Not Found";
            $_SESSION['type'] = "alert-danger";
        }
    }
}

//profile
// LOGIN
function fileUpload($user)
{
//    var_dump($user);exit;
    $returnArr = [];
    $fileNames = ['photo', 'ambassador_file', 'contentuploader_file', 'banbeistraining_file', 'bcctraining_file', 'attestation_file', 'icteducation_file'];
    for ($i = 0; $i < sizeof($fileNames); $i++) {
        if ($_FILES[$fileNames[$i]]['name'] != '') {
            $path_parts = pathinfo($_FILES[$fileNames[$i]]["name"]);
            if ($fileNames[$i] == 'photo') {
                $fileName = $_SESSION['id'] . rand() . $fileNames[$i] . '.jpg';
            } else {
                $fileName = $_SESSION['id'] . rand() . $fileNames[$i] . '.pdf';
            }
            move_uploaded_file($_FILES[$fileNames[$i]]['tmp_name'], '../upload/' . $fileName);
            array_push($returnArr, $fileName);
        } else {
            array_push($returnArr, $user[$fileNames[$i]]);
        }
    }
    return $returnArr;
}

// submit update profile
if (isset($_POST['update_profile_btn'])) {
    if (count($errors) === 0) {
        $query = "SELECT * FROM user_academic_info WHERE user_id=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $_SESSION['id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            $arrOfFile = fileUpload($user);
            $query = "update users set mobile=? where id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('si', $_POST['mobile'], $_SESSION['id']);

            if ($stmt->execute()) {
                $query1 = "update user_academic_info set 
                        first_name=?, 
                        last_name=?, 
                        eiin=?, 
                        index_number=?, 
                        post=?, 
                        ambassador=?, 
                        contentuploader=?, 
                        banbeistraining=?, 
                        bcctraining=?, 
                        attestation=?, 
                        icteducation=?,
                        photo=?,
                        ambassador_file=?,
                        contentuploader_file=?,
                        banbeistraining_file=?,
                        bcctraining_file=?,
                        attestation_file=?,
                        icteducation_file=?
                        where user_id=?";
                $stmt1 = $conn->prepare($query1);
                $stmt1->bind_param('ssiissssssssssssssi', $_POST['first_name'], $_POST['last_name'],
                    $_POST['eiin'],
                    $_POST['index_number'],
                    $_POST['post'],
                    $_POST['ambassador'],
                    $_POST['contentuploader'],
                    $_POST['banbeistraining'],
                    $_POST['bcctraining'],
                    $_POST['attestation'],
                    $_POST['icteducation'],
                    $arrOfFile[0],
                    $arrOfFile[1],
                    $arrOfFile[2],
                    $arrOfFile[3],
                    $arrOfFile[4],
                    $arrOfFile[5],
                    $arrOfFile[6],
                    $_SESSION['id']);

                if ($stmt1->execute()) {
                    $_SESSION['message'] = "Profile updated successfully!";
                    $_SESSION['type'] = "alert-success";
                    header('location: dashboard.php');
                    exit(0);

                } else {
                    $_SESSION['message'] = "Database error. Login failed!";
                    $_SESSION['type'] = "alert-danger";
                }
            } else {
                $_SESSION['message'] = "Database error. Login failed!";
                $_SESSION['type'] = "alert-danger";
            }
        }
    }
}
?>

<?php
// Publish Book
if (isset($_POST['publishBook'])) {

    if (count($errors) === 0) {
        $query = "insert into book set name=?, subject=?, course=?, conditions=?, available=1, user_id=?, created=now()";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssi', $_POST['name'], $_POST['subject'], $_POST['course'], $_POST['conditions'], $_SESSION['id']);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Book published successfully!";
            $_SESSION['type'] = "alert-success";
            header('location: dashboard.php');
            exit(0);
        } else {
//            printf("Error: %s.\n", $stmt->error);
            $_SESSION['message'] = "Database error. Login failed!";
            $_SESSION['type'] = "alert-danger";
        }
    }
}
?>