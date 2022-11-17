<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet" />
    <title>وظفني</title>
</head>

<body>
    <!-- Default form register -->
    <form style="max-width:550px; margin: auto;" class="text-center border border-light p-5" action="#!" method="POST">

        <p class="h4 mb-4">إنشاء حساب</p>

        <div class="form-row mb-4">
            <div class="col">
                <!-- First name -->
                <input type="text" id="defaultRegisterFormFirstName" class="form-control" placeholder="الأسم الاول" required name="fName">
            </div>
            <br>
            <div class="col">
                <!-- Last name -->
                <input type="text" id="defaultRegisterFormLastName" class="form-control" placeholder="اسم العائلة" required name="lName">
            </div>
        </div>

        <!-- E-mail -->
        <input type="email" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="البريد الألكتروني" required name="email">

        <!-- Password -->
        <input type="password" id="defaultRegisterFormPassword" class="form-control" placeholder="كلمة السر" aria-describedby="defaultRegisterFormPasswordHelpBlock" required minlength="8" name="password">
        <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
        يرجى وضع 8 حروف على الأقل
    </small>

        <!-- Phone number -->
        <input type="text" id="defaultRegisterPhonePassword" class="form-control" placeholder="رقم الهاتف" required aria-describedby="defaultRegisterFormPhoneHelpBlock" required name="num">
        <small id="defaultRegisterFormPhoneHelpBlock" class="form-text text-muted mb-4">
        
    </small>

        <!-- Newsletter -->
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="defaultRegisterFormNewsletter">
            <label class="custom-control-label" for="defaultRegisterFormNewsletter">الإشتراك في النشرة الإخبارية</label>
        </div>

        <!-- Sign up button -->
        <button class="btn btn-info my-4 btn-block" type="submit" name="register">انشاء</button>

        <!-- Social register -->
        <p>أو سجل بإستخدام :</p>

        <a href="#" class="mx-2" role="button"><i class="fab fa-facebook-f light-blue-text"></i></a>
        <a href="#" class="mx-2" role="button"><i class="fab fa-twitter light-blue-text"></i></a>
        <a href="#" class="mx-2" role="button"><i class="fab fa-linkedin-in light-blue-text"></i></a>
        <a href="#" class="mx-2" role="button"><i class="fab fa-github light-blue-text"></i></a>

        <hr>

        <!-- Terms of service -->
        <p>عند الضغط على
            <em>إنشاء</em> فـ انت توافق على
            <a href="" target="_blank">سياسة الإستخدام</a>

    </form>
    <!-- Default form register -->



    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"></script>
    
    <?php

$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost; dbname=signup;", $username, $password);



if(isset($_POST['register'])){
    $checkEmail = $database->prepare("SELECT * FROM users WHERE EMAIL = :EMAIL");
    $email = $_POST['email'];
    $checkEmail->bindParam(':EMAIL',$email);
    $checkEmail->execute();
    
    if($checkEmail->rowCount()>0){
        echo '<div class="alert alert-warning" role="alert">
        البريد الإلكتروني مسجل مسبقاً !
      </div>';
     
    } else{
        $fName = $_POST['fName'] ;
        $lName = $_POST['lName'] ;
        $password = $_POST['password'] ;
        $email = $_POST['email'] ; 
        $num = $_POST['num'] ;
        
        $addUser = $database->prepare("INSERT INTO users(FNAME,LNAME,EMAIL,PASSWORD,NUMBER,SECURITY_CODE) VALUES(:FNAME,:LNAME,:EMAIL,:PASSWORD,:NUMBER,:SECURITY_CODE)");
        $addUser->bindParam("FNAME", $fName);
        $addUser->bindParam("LNAME", $lName);
        $addUser->bindParam("EMAIL", $email);
        $addUser->bindParam("PASSWORD", $password);
        $addUser->bindParam("NUMBER", $num);
        $securityCode = md5(date("h:i:s"));
        $addUser->bindParam("SECURITY_CODE", $securityCode);
        if($addUser->execute()){
            echo '<div class="alert alert-success" role="alert">
        تم إنشاء الحساب
      </div>';
      
      require_once "mail.php";
      $mail->addAddress($email);
      $mail->Subject = "رمز التحقق من حسابك";
      $mail->Body = '<h1>شكراً لتسجيلك في وظفني </h1>'.
       "<div> يرجى الضغط على الرابط التالي لتأكيد حسابك </div>" 
      . "<a href='http://localhost/Work/active.php?code=".$securityCode . "'>" . "http://localhost/Work/active.php" .
      "?code=" .$securityCode . "</a>";
      
      $mail->setFrom("ahmedalshamally@gmail.com", "وظفني");
      $mail->send();
      
    }else{echo '<div class="alert alert-warning" role="alert">
       الحساب مسجل مسبقاً !
      </div>';}
        }
        
        
}

    ?>
</body>

</html>