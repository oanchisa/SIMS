<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มแก้ไขข้อมูล</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
    <?php
    require_once('./connection.php');
    $error = [
        "id" => "",
        "email" => "",
        "en_name" => "",
        "en_surname" => "",
        "th_name" => "",
        "th_surname" => "",
        "major_code" => "",
    ];
    $id_old = $_GET["id"];
    $id = $email = $en_name = $en_surname = $th_name = $th_surname = $major_code = "";

    function protectInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        empty($_POST["id"]) ? $error["id"] = "*" : $id = protectInput($_POST["id"]);
        if(!empty($_POST["email"])){
            !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ? $error["email"] = "*กรอกE-mailให้ถูกต้อง" : $email = protectInput($_POST["email"]);
        }
        empty($_POST["en_name"]) ? $error["en_name"] = "*" : $en_name = protectInput($_POST["en_name"]);
        empty($_POST["en_surname"]) ? $error["en_surname"] = "*" : $en_surname = protectInput($_POST["en_surname"]);
        empty($_POST["th_name"]) ? $error["th_name"] = "*" : $th_name = protectInput($_POST["th_name"]);
        empty($_POST["th_surname"]) ? $error["th_surname"] = "*" : $th_surname = protectInput($_POST["th_surname"]);
        if(!empty($_POST["email"])){
            $major_code = protectInput($_POST["major_code"]);
        }
        if(empty($error["email"]) && empty($error["major_code"]) && !empty($_POST["id"]) && !empty($_POST["en_name"]) && !empty($_POST["en_surname"]) && !empty($_POST["th_name"]) && !empty($_POST["th_surname"])){
            $sql = "UPDATE `std_info` SET `id`='$id',`en_name`='$en_name',`en_surname`='$en_surname',`th_name`='$th_name',`th_surname`='$th_surname',`major_code`='$major_code',`email`='$email' WHERE `id` = $id_old";
            $query = mysqli_query($connection, $sql);
            if(!$query){
                echo '<script> Swal.fire("การเพิ่มข้อมูลล้มเหลว", "") </script>';
            }else{
                header("Location: ./index.php?status=3");
                exit();
            }
        }else{
            echo '<script> Swal.fire("กรุณากรอกข้อมูลให้ครบถ้วน", "") </script>';
        }
    }
    ?>
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="card mb-3">
            <div class="card-header h1">UPDATE</div>
            <div class="card-body">
                <?php
                    $sql = "SELECT `id`, `en_name`, `en_surname`, `th_name`, `th_surname`, `major_code`, `email` FROM `std_info` WHERE `id` = '$id_old'";
                    $query = mysqli_query($connection, $sql);
                    if(!$query){
                        die('<script> Swal.fire("การแสดงข้อมูลล้มเหลว", "") </script>');
                    }else{
                        while($result = mysqli_fetch_object($query)){
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $result->id); ?>" method="post" class="row">
                    <div class="col-6 mb-3">
                        <label for="studentID" class="form-label">รหัสนักศึกษา</label>
                        <?php if ($error["id"]) { ?>
                            <input name="id" type="text" class="form-control is-invalid" id="studentID">
                            <div class="invalid-feedback"><?php echo $error["id"]; ?></div>
                        <?php } else if (!empty($id)) { ?>
                            <input name="id" type="text" class="form-control is-valid" id="studentID" value="<?php echo $id; ?>">
                        <?php } else { ?>
                            <input name="id" type="text" class="form-control" id="studentID" value="<?php echo $result->id ?>">
                        <?php } ?>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="studentMajor" class="form-label">Major</label>
                        <?php if ($error["major_code"]) { ?>
                            <input name="major_code" type="text" class="form-control is-invalid" id="studentMajor">
                            <div class="invalid-feedback"><?php echo $error["major_code"]; ?></div>
                        <?php } else if (!empty($major_code)) { ?>
                            <input name="major_code" type="text" class="form-control is-valid" id="studentMajor" value="<?php echo $major_code; ?>">
                        <?php } else { ?>
                            <input name="major_code" type="text" class="form-control" id="studentMajor" value="<?php echo $result->major_code ?>">
                        <?php } ?>
                    </div>
                    
                    <div class="col-6 mb-3">
                        <label for="studentNameEng" class="form-label">Name</label>
                        <?php if ($error["en_name"]) { ?>
                            <input name="en_name" type="text" class="form-control is-invalid" id="studentNameEng">
                            <div class="invalid-feedback"><?php echo $error["en_name"]; ?></div>
                        <?php } else if (!empty($en_name)) { ?>
                            <input name="en_name" type="text" class="form-control is-valid" id="studentNameEng" value="<?php echo $en_name; ?>">
                        <?php } else { ?>
                            <input name="en_name" type="text" class="form-control" id="studentNameEng" value="<?php echo $result->en_name ?>">
                        <?php } ?>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="studentSurnameEng" class="form-label">Surname</label>
                        <?php if ($error["en_surname"]) { ?>
                            <input name="en_surname" type="text" class="form-control is-invalid" id="studentSurnameEng">
                            <div class="invalid-feedback"><?php echo $error["en_surname"]; ?></div>
                        <?php } else if (!empty($en_surname)) { ?>
                            <input name="en_surname" type="text" class="form-control is-valid" id="studentSurnameEng" value="<?php echo $en_surname; ?>">
                        <?php } else { ?>
                            <input name="en_surname" type="text" class="form-control" id="studentSurnameEng" value="<?php echo $result->en_surname ?>">
                        <?php } ?>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="studentNameTh" class="form-label">ชื่อ</label>
                        <?php if ($error["th_name"]) { ?>
                            <input name="th_name" type="text" class="form-control is-invalid" id="studentNameTh">
                            <div class="invalid-feedback"><?php echo $error["th_name"]; ?></div>
                        <?php } else if (!empty($th_name)) { ?>
                            <input name="th_name" type="text" class="form-control is-valid" id="studentNameTh" value="<?php echo $th_name; ?>">
                        <?php } else { ?>
                            <input name="th_name" type="text" class="form-control" id="studentNameTh" value="<?php echo $result->th_name ?>">
                        <?php } ?>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="studentSurnameTh" class="form-label">นามสกุล</label>
                        <?php if ($error["th_surname"]) { ?>
                            <input name="th_surname" type="text" class="form-control is-invalid" id="studentSurnameTh">
                            <div class="invalid-feedback"><?php echo $error["th_surname"]; ?></div>
                        <?php } else if (!empty($th_surname)) { ?>
                            <input name="th_surname" type="text" class="form-control is-valid" id="studentSurnameTh" value="<?php echo $th_surname; ?>">
                        <?php } else { ?>
                            <input name="th_surname" type="text" class="form-control" id="studentSurnameTh" value="<?php echo $result->th_surname ?>">
                        <?php } ?>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="studentEmail" class="form-label">Email</label>
                        <?php if ($error["email"]) { ?>
                            <input name="email" type="text" class="form-control is-invalid" id="studentEmail">
                            <div class="invalid-feedback"><?php echo $error["email"]; ?></div>
                        <?php } else if (!empty($email)) { ?>
                            <input name="email" type="text" class="form-control is-valid" id="studentEmail" value="<?php echo $email; ?>">
                        <?php } else { ?>
                            <input name="email" type="text" class="form-control" id="studentEmail" value="<?php echo $result->email ?>">
                        <?php } ?>
                    </div>
                    
                    <center><button type="submit"class="col-8 btn btn-outline-success ms-3">UPDATE</button></center>
                        </br></br>
                    <center><a href="./index.php" class="col-3 btn btn-outline-danger ms-3">BACK</a>
                </form>
                <?php } } ?>
            </div>
        </div>
    </div>
    <?php mysqli_close($connection); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>