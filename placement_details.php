<?php
session_start();
error_reporting(0);
include('admin/includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
	
if(isset($_POST['submit']))
  {	
	// $file = $_FILES['image']['name'];
	// $file_loc = $_FILES['image']['tmp_name'];
	// $folder="images/";
	// $new_file_name = strtolower($file);
	// $final_file=str_replace(' ','-',$new_file_name);
	
	$name=$_POST['name'];
	$email=$_POST['email'];
	$mobileno=$_POST['mobile'];
	$designation=$_POST['designation'];
    $idedit=$_POST['editid'];
    
    $cgpa=$_POST['cgpa'];
	$sgpa1=$_POST['sgpa1'];
	$sgpa2=$_POST['sgpa2'];
	$sgpa3=$_POST['sgpa3'];
	$sgpa4=$_POST['sgpa4'];
	$sgpa5=$_POST['sgpa5'];
	$sgpa6=$_POST['sgpa6'];
	$sgpa7=$_POST['sgpa7'];
    $sgpa8=$_POST['sgpa8'];
    $back=$_POST['back'];
    $placed=$_POST['placed'];

	// $image=$_POST['image'];

	// if(move_uploaded_file($file_loc,$folder.$final_file))
	// 	{
	// 		$image=$final_file;
	// 	}

	$sql="UPDATE users SET name=(:name), email=(:email), mobile=(:mobileno), designation=(:designation), cgpa=(:cgpa), sgpa1=(:sgpa1), sgpa2=(:sgpa2), sgpa3=(:sgpa3), sgpa4=(:sgpa4), sgpa5=(:sgpa5), sgpa6=(:sgpa6), sgpa7=(:sgpa7), sgpa8=(:sgpa8), backlogs =(:back), status_comp=(:placed) WHERE id=(:idedit)";
	$query = $dbh->prepare($sql);
	$query-> bindParam(':name', $name, PDO::PARAM_STR);
	$query-> bindParam(':email', $email, PDO::PARAM_STR);
	$query-> bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query-> bindParam(':designation', $designation, PDO::PARAM_STR);
    
    $query-> bindParam(':cgpa', $cgpa, PDO::PARAM_STR);
    $query-> bindParam(':sgpa1', $sgpa1, PDO::PARAM_STR);
    $query-> bindParam(':sgpa2', $sgpa2, PDO::PARAM_STR);
    $query-> bindParam(':sgpa3', $sgpa3, PDO::PARAM_STR);
    $query-> bindParam(':sgpa4', $sgpa4, PDO::PARAM_STR);
    $query-> bindParam(':sgpa5', $sgpa5, PDO::PARAM_STR);
    $query-> bindParam(':sgpa6', $sgpa6, PDO::PARAM_STR);
    $query-> bindParam(':sgpa7', $sgpa7, PDO::PARAM_STR);
    $query-> bindParam(':sgpa8', $sgpa8, PDO::PARAM_STR);

    $query-> bindParam(':back', $back, PDO::PARAM_STR);
    $query-> bindParam(':placed', $placed, PDO::PARAM_STR);

	// $query-> bindParam(':image', $image, PDO::PARAM_STR);
	$query-> bindParam(':idedit', $idedit, PDO::PARAM_STR);
	$query->execute();
	$msg="Information Updated Successfully";
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
	<meta name="theme-color" content="#3e454c">
	
	<title>Edit Profile</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">

	<script type= "text/javascript" src="../vendor/countries.js"></script>
	<style>
	.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
	background: #dd3d36;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
	background: #5cb85c;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>


</head>

<body>
<?php
		$email = $_SESSION['alogin'];
		$sql = "SELECT * from users where email = (:email);";
		$query = $dbh -> prepare($sql);
		$query-> bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$result=$query->fetch(PDO::FETCH_OBJ);
		$cnt=1;	
?>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading"><?php echo htmlentities($_SESSION['alogin']); ?></div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">

<div class="form-group">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
	</div>
</div>

<div class="form-group">
	<!-- <label class="col-sm-2 control-label">Name<span style="color:red">*</span></label> -->
	<div class="col-sm-4">
	<input type="hidden" name="name" class="form-control" required value="<?php echo htmlentities($result->name);?>">
	</div>

	<!-- <label class="col-sm-2 control-label">Email<span style="color:red">*</span></label> -->
	<div class="col-sm-4">
	<input type="hidden" name="email" class="form-control" required value="<?php echo htmlentities($result->email);?>">
	</div>
</div>

<div class="form-group">
	<!-- <label class="col-sm-2 control-label">Mobile<span style="color:red">*</span></label> -->
	<div class="col-sm-4">
	<input type="hidden" name="mobile" class="form-control" required value="<?php echo htmlentities($result->mobile);?>">
	</div>

	<!-- <label class="col-sm-2 control-label">Designation<span style="color:red">*</span></label> -->
	<div class="col-sm-4">
	<input type="hidden" name="designation" class="form-control" required value="<?php echo htmlentities($result->designation);?>">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">CGPA All Semester<span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="cgpa" class="form-control" required value="<?php echo htmlentities($result->cgpa);?>">
	</div>
    
</div>

<div class="form-group">

	<label class="col-sm-2 control-label"> Semester 1 SGPA <span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="sgpa1" class="form-control" required value="<?php echo htmlentities($result->sgpa1);?>">
	</div>

    <label class="col-sm-2 control-label"> Semester 2 SGPA <span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="sgpa2" class="form-control" required value="<?php echo htmlentities($result->sgpa2);?>">
	</div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"> Semester 3 SGPA <span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="sgpa3" class="form-control" required value="<?php echo htmlentities($result->sgpa3);?>">
	</div>

    <label class="col-sm-2 control-label"> Semester 4 SGPA <span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="sgpa4" class="form-control" required value="<?php echo htmlentities($result->sgpa4);?>">
	</div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"> Semester 5 SGPA <span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="sgpa5" class="form-control" required value="<?php echo htmlentities($result->sgpa5);?>">
	</div>

    <label class="col-sm-2 control-label"> Semester 6 SGPA <span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="sgpa6" class="form-control" required value="<?php echo htmlentities($result->sgpa6);?>">
	</div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label"> Semester 7 SGPA <span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="sgpa7" class="form-control" required value="<?php echo htmlentities($result->sgpa7);?>">
	</div>

    <label class="col-sm-2 control-label"> Semester 8 SGPA <span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="sgpa8" class="form-control" required value="<?php echo htmlentities($result->sgpa8);?>">
	</div>
    </div>

    <div class="form-group">
    <label class="col-sm-2 control-label">Back Logs<span style="color:red">*</span></label>
	<div class="col-sm-4">
	<input type="number" name="back" class="form-control" required value="<?php echo htmlentities($result->backlogs);?>">
	</div>

    <!-- <label class="col-sm-2 control-label">Status<span style="color:red">*</span></label>
	<div class="col-sm-4">    
    <input type="radio" name="placed" <?php if($result->status_comp=="Un-Placed"){ echo "checked"; } ?> value="Un-Placed">Un-Placed<br>
    <input type="radio" name="placed" <?php if($result->status_comp=="Placed"){ echo "checked"; } ?> value="Placed">Placed<br>
	</div> -->
</div>


<input type="hidden" name="editid" class="form-control" required value="<?php echo htmlentities($result->id);?>">

<div class="form-group">
	<div class="col-sm-8 col-sm-offset-2">
		<button class="btn btn-primary" name="submit" type="submit">Save Changes</button>
	</div>
</div>

</form>
									</div>
								</div>
							</div>
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
	<script type="text/javascript">
				 $(document).ready(function () {          
					setTimeout(function() {
						$('.succWrap').slideUp("slow");
					}, 3000);
					});
	</script>
</body>
</html>
<?php } ?>