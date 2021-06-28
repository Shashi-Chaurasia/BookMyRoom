<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
    <script type="text/javascript">

	
        
</script>
</head>

<body>
	<div class="login-page bk-img">
		<div class="form-content">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1 class="text-center text-bold mt-2x">Register</h1>
                        <div class="hr-dashed"></div>
						<div class="well row pt-2x pb-3x bk-light text-center">
                         <form method="post" class="form-horizontal" enctype="multipart/form-data" name="regform" >
                            <div class="form-group">
                            <label class="col-sm-1 control-label">Name<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="name" class="form-control" required>
                            </div>
                            <label class="col-sm-1 control-label">Email<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="email" class="form-control" required>
                        
                            </div>
                            </div>

                            <div class="form-group">
                            <label class="col-sm-1 control-label">Password<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="password" name="password" class="form-control" id="password" required >
                            </div>

                            <label class="col-sm-1 control-label">Designation<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <!-- <input type="text" name="designation" class="form-control" required> -->
                            
                            <select name="designation" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Student">Student</option>
                            </select>

                            </div>
                            </div>

                            <div class="form-group">
                            <label class="col-sm-1 control-label">Gender<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <select name="gender" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            </select>
                            </div>

                            <label class="col-sm-1 control-label">Phone<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" name="mobileno" class="form-control" required>
                            </div>
                            </div>

                            
								<br>
                                <button class="btn btn-primary" name="submit" type="submit" onclick="tasks();">Register</button>
                               
                            </form>
                                <br>
                                <br>
								<p>Already Have Account? <a href="index.php" >Signin</a></p>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	
    <script type="text/javascript">
        function tasks() 
        {
            <?php
                //include_once('email/email_test.php');
                include('admin/includes/config.php');
                if(isset($_POST['submit']))
                {


                $name=$_POST['name'];
                $email=$_POST['email'];
                $password=md5($_POST['password']);
                $gender=$_POST['gender'];
                $mobileno=$_POST['mobileno'];
                $designation=$_POST['designation'];


                $notitype='Create Account';
                $reciver='Admin';
                $sender=$email;


                $sqlnoti="insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
                $querynoti = $dbh->prepare($sqlnoti);
                $querynoti-> bindParam(':notiuser', $sender, PDO::PARAM_STR);
                $querynoti-> bindParam(':notireciver',$reciver, PDO::PARAM_STR);
                $querynoti-> bindParam(':notitype', $notitype, PDO::PARAM_STR);
                $querynoti->execute();    


                $sqlselect="select email from users where email=(:email)";
                $queryselect= $dbh -> prepare($sqlselect);
                $queryselect-> bindParam(':email', $email, PDO::PARAM_STR);
                $queryselect->execute();
                $results=$queryselect->fetchAll(PDO::FETCH_OBJ);
                // echo"<script>alert(".$queryselect->rowCount().")</script>";

                if($queryselect->rowCount() > 0)
                {
                    echo"<script>alert('Email aleady exist')</script>";
                }
                else{

                    
                    $verikey = md5(rand());

                    $sql ="INSERT INTO users(name,email, password, gender, mobile, designation,verkey) VALUES(:name, :email, :password, :gender, :mobileno, :designation,:verkey)";
                    $query= $dbh -> prepare($sql);
                    $query-> bindParam(':name', $name, PDO::PARAM_STR);
                    $query-> bindParam(':email', $email, PDO::PARAM_STR);
                    $query-> bindParam(':password', $password, PDO::PARAM_STR);
                    $query-> bindParam(':gender', $gender, PDO::PARAM_STR);
                    $query-> bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
                    $query-> bindParam(':designation', $designation, PDO::PARAM_STR);
                    $query-> bindParam(':verkey', $verikey, PDO::PARAM_STR);
                    // $query-> bindParam(':image', $image, PDO::PARAM_STR);
                    $query->execute();
                }


                

                }
            
           // document.submit.action = "email/email_test.php"; 
            
                
                include_once('admin/includes/config.php');
                
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;
                require 'PHPMailer/PHPMailer/vendor/autoload.php';

                $mail = new PHPMailer(true);
                try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                         // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'shashichaurasia886@gmail.com';                                    // SMTP username
                $mail->Password = 'Nikee@1010';                                    // SMTP password
                $mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 25;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('shashichaurasia886@gmail.com', 'MIT-AOE');
                $mail->AddAddress($_POST['email'], $_POST['name']);     // Add a recipient
                // $mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('shashichaurasia886@gmail.com', 'MIT-AOE');

                //Content
                $base_url = "http://localhost/WT_Project/";
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Registration Link For Placement Portal';
                //include_once('../register.php');
                $mail->Body    = "
                <p>Hi ".$_POST['name'].",</p>
                <p>Thanks for Registration.</p>
                <p>Please Open this link to verify your email address - ".$base_url."email_verification.php?verkey1=".$verikey."
                <p>To Login into your account click on ".$base_url." </p>
                <p>Best Regards,<br />Placement Portal MIT-AOE</p>
                ";
                if($mail->send()) {
                    echo "<script type=\"text/javascript\">".
                    "alert('Email verification link has been sent successfully. Please check your mail');".
                    "</script>";
                    }
               // echo 'Message has been sent';
            } catch (Exception $e) {
                    echo "<script type=\"text/javascript\">".
                        "alert('We are unable to send email verification code to your email address! Mailer Error:. $mail->ErrorInfo');".
                        "</script>";
                }
                
            ?>
        }
            
        
   
        
    </script>
	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

    
    

</body>
</html>