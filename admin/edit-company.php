<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

if(isset($_GET['edit']))
	{
		$editid=$_GET['edit'];
	}


	
if(isset($_POST['submit']))
  {
	$idedit=$_POST['idedit'];
	$company_name=$_POST['company_name'];
    $c_location=$_POST['c_location'];
    $cgpa=$_POST['cgpa'];
    $backlog_allowed=$_POST['backlog_allowed'];
    $package=$_POST['package'];
    $yeardown_allowed=$_POST['yeardown_allowed'];
	$deadbacklog_count=$_POST['deadbacklog_count'];
	$dateof=$_POST['dateof'];

	$sql="UPDATE company SET company_name=(:company_name),c_location=(:c_location),cgpa=(:cgpa),backlog_allowed=(:backlog_allowed),package=(:package),yeardown_allowed=(:yeardown_allowed),deadbacklog_count=(:deadbacklog_count), dateof=(:dateof) WHERE id=(:idedit)";
	$query = $dbh->prepare($sql);
	$query-> bindParam(':company_name', $company_name, PDO::PARAM_STR);
	$query-> bindParam(':c_location', $c_location, PDO::PARAM_STR);
	$query-> bindParam(':cgpa', $cgpa, PDO::PARAM_STR);
    $query-> bindParam(':backlog_allowed', $backlog_allowed, PDO::PARAM_STR);
    $query-> bindParam(':package', $package, PDO::PARAM_STR);
    $query-> bindParam(':yeardown_allowed', $yeardown_allowed, PDO::PARAM_STR);
	$query-> bindParam(':deadbacklog_count', $deadbacklog_count, PDO::PARAM_STR);
	$query-> bindParam(':dateof', $dateof, PDO::PARAM_STR);
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
	
	<title>Edit Company</title>

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
		$sql = "SELECT * from company where id = :editid";
		$query = $dbh -> prepare($sql);
		$query->bindParam(':editid',$editid,PDO::PARAM_INT);
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
						<h3 class="page-title">Edit Company : <?php echo htmlentities($result->name); ?></h3>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Edit Info</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data" name="imgform">
<div class="form-group">
                            <label class="col-sm-1 control-label">COMPANY NAME<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="company_name" class="form-control" required value="<?php echo htmlentities($result->company_name);?>">
                            </div>
                            <label class="col-sm-1 control-label">LOCATION<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="text" name="c_location" class="form-control" required value="<?php echo htmlentities($result->c_location);?>">
                            </div>
                            </div>

                            <div class="form-group">
                            <label class="col-sm-1 control-label">CGPA REQUIRED<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" step="any" name="cgpa" class="form-control" id="password" required value="<?php echo htmlentities($result->cgpa);?>">
                            </div>

                            <label class="col-sm-1 control-label">BACKLOGS ALLOWED <span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" name="backlog_allowed" class="form-control" required value="<?php echo htmlentities($result->backlog_allowed);?>">
                            
                            </div>
                            </div>

                             <div class="form-group">
                            <label class="col-sm-1 control-label">GIVING PACKAGE<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" step="any" name="package" class="form-control" required value="<?php echo htmlentities($result->package);?>">
                            </div>

                            <label class="col-sm-1 control-label">YEAR DOWN ALLOWED<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" name="yeardown_allowed" class="form-control" required value="<?php echo htmlentities($result->yeardown_allowed);?>">
                            </div>
                            </div>

                            <div class="form-group">
                            <label class="col-sm-1 control-label">DEAD BACKLOGS COUNT<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="number" name="deadbacklog_count" class="form-control" required value="<?php echo htmlentities($result->deadbacklog_count);?>">
                            </div>

							<div class="form-group">
                            <label class="col-sm-1 control-label">ARRIVAl DATE<span style="color:red">*</span></label>
                            <div class="col-sm-5">
                            <input type="date" name="dateof" class="form-control" required value="<?php echo htmlentities($result->dateof);?>">
                            </div>

                            </div>

<div class="form-group">
<div class="col-sm-8 col-sm-offset-2">
        <input type="hidden" name="idedit" value="<?php echo htmlentities($result->id);?>" >
		<button class="btn btn-primary" name="submit" type="submit">Save Changes</button>
	</div>
	
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