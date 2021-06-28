<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
include('includes/config.php');
if(isset($_POST['submit']))
{

// $file = $_FILES['image']['name'];
// $file_loc = $_FILES['image']['tmp_name'];
// $folder="images/"; 
// $new_file_name = strtolower($file);
// $final_file=str_replace(' ','-',$new_file_name);

// $name=$_POST['name'];
// $email=$_POST['email'];
// $password=md5($_POST['password']);
// $gender=$_POST['gender'];
// $mobileno=$_POST['mobileno'];
// $designation=$_POST['designation'];

$company_name=$_POST['company_name'];
$c_location=$_POST['c_location'];
$cgpa=$_POST['cgpa'];
$backlog_allowed=$_POST['backlog_allowed'];
$package=$_POST['package'];
$yeardown_allowed=$_POST['yeardown_allowed'];
$deadbacklog_count=$_POST['deadbacklog_count'];
$dateof=$_POST['dateof'];

// if(move_uploaded_file($file_loc,$folder.$final_file))
// 	{
// 		$image=$final_file;
//     }
$notitype='Create Company';
$reciver='Admin';
$sender=$company_name;


$sqlnoti="insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
$querynoti = $dbh->prepare($sqlnoti);
$querynoti-> bindParam(':notiuser', $sender, PDO::PARAM_STR);
$querynoti-> bindParam(':notireciver',$reciver, PDO::PARAM_STR);
$querynoti-> bindParam(':notitype', $notitype, PDO::PARAM_STR);
$querynoti->execute();    


$sqlselect="select company_name from company where company_name=(:company_name)";
$queryselect= $dbh -> prepare($sqlselect);
$queryselect-> bindParam(':company_name', $company_name, PDO::PARAM_STR);
$queryselect->execute();
$results=$queryselect->fetchAll(PDO::FETCH_OBJ);
// echo"<script>alert(".$queryselect->rowCount().")</script>";

if($queryselect->rowCount() > 0)
{
    echo"<script>alert('Company aleady exist')</script>";
}
else{
    $sql ="INSERT INTO company(company_name,c_location, cgpa, backlog_allowed, package, yeardown_allowed, deadbacklog_count , dateof) VALUES(:company_name, :c_location, :cgpa, :backlog_allowed, :package, :yeardown_allowed, :deadbacklog_count, :dateof)";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':company_name', $company_name, PDO::PARAM_STR);
    $query-> bindParam(':c_location', $c_location, PDO::PARAM_STR);
    $query-> bindParam(':cgpa', $cgpa, PDO::PARAM_STR);
    $query-> bindParam(':backlog_allowed', $backlog_allowed, PDO::PARAM_STR);
    $query-> bindParam(':package', $package, PDO::PARAM_STR);
    $query-> bindParam(':yeardown_allowed', $yeardown_allowed, PDO::PARAM_STR);
    $query-> bindParam(':deadbacklog_count', $deadbacklog_count, PDO::PARAM_STR);
    $query-> bindParam(':dateof', $dateof, PDO::PARAM_STR);
    $query->execute();
}


$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script type='text/javascript'>alert('Company Entered Sucessfull!');</script>";
// echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
else 
{
$error="Something went wrong. Please try again";
}

}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Add Company</title>
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
						<h1 class="text-center text-bold mt-2x">Register New Company</h1>
                        <div class="hr-dashed"></div>
						<div class="well row pt-2x pb-3x bk-light text-center">
                         <form method="post" class="form-horizontal" enctype="multipart/form-data" name="regform" onSubmit="return validate();">
                            <div class="form-group">
                            <label class="col-sm-1 control-label">COMPANY NAME<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="company_name" class="form-control" required>
                            </div>
                            <label class="col-sm-1 control-label">LOCATION<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="c_location" class="form-control" required>
                            </div>
                            </div>

                            <div class="form-group">
                            <label class="col-sm-1 control-label">CGPA REQUIRED<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" name="cgpa" class="form-control" id="password" required >
                            </div>

                            <label class="col-sm-1 control-label">BACKLOGS ALLOWED <span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="backlog_allowed" class="form-control" required>
                            
                            </div>
                            </div>

                             <div class="form-group">
                            <label class="col-sm-1 control-label">GIVING PACKAGE<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" name="package" class="form-control" required>
                            </div>

                            <label class="col-sm-1 control-label">YEAR DOWN ALLOWED<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="yeardown_allowed" class="form-control" required>
                            </div>
                            </div>

                            <div class="form-group">
                            <label class="col-sm-1 control-label">DEAD BACKLOGS COUNT<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" name="deadbacklog_count" class="form-control" required>
                            </div>

                            <label class="col-sm-1 control-label">DATE<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="date" name="dateof" class="form-control" required>
                            </div>

                            </div>
                            <!--
                            <div class="form-group">
                            <label class="col-sm-1 control-label">Avtar<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="button" value="send">
                            </div>
                            </div>-->

                            <br>
                            <button class="btn btn-primary" name="submit" type="submit">ADD COMPANY</button>
                            </form>
                            <br>
                            <br>
                            <p>Already Registerd Company? <a href="company.php" >Click here</a></p>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	
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