<?php
session_start();
error_reporting(0);
include('admin/includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_GET['del']) && isset($_GET['company_name']))
{
$id=$_GET['del'];
$name=$_GET['company_name'];

$sql = "delete from company WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();    

$sql2 = "insert into deleteduser (email) values (:company_name)";
$query2 = $dbh->prepare($sql2);
$query2 -> bindParam(':company_name',$company_name, PDO::PARAM_STR);
$query2 -> execute();

$msg="Data Deleted successfully";
}

if(isset($_REQUEST['unconfirm']))
	{
	$aeid=intval($_GET['unconfirm']);
	$memstatus=1;
	$sql = "UPDATE company SET status=:status WHERE  id=:aeid";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':status',$memstatus, PDO::PARAM_STR);
	$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
	$query -> execute();
	$msg="Changes Sucessfully";
	}

	if(isset($_REQUEST['confirm']))
	{
	$aeid=intval($_GET['confirm']);
	$memstatus=0;
	$sql = "UPDATE company SET status=:status WHERE  id=:aeid";
	$query = $dbh->prepare($sql);
	$query -> bindParam(':status',$memstatus, PDO::PARAM_STR);
	$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
	$query -> execute();
	$msg="Changes Sucessfully";
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
	
	<title>Company List</title>

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
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Company List</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">List Company</div>
                        
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap" id="msgshow"><?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
												<th>Company Name</th>
                                                <th>Location</th>
                                                <th>CGPA Requied</th>
                                                <th>Backlogs Allowed</th>
                                                <th>Package</th>
                                                <th>Year Down Allowed</th>
                                                <th>Dead Backlogs Allowed</th>
											<!-- <th>Action</th>	 -->
										</tr>
									</thead>
									
									<tbody>

<?php 
$sqlstudent="SELECT * from users where id=(:infoid) ";
$querystudent = $dbh->prepare($sqlstudent);

$sql = "SELECT * from  company ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->company_name);?></td>
                                            <td><?php echo htmlentities($result->c_location);?></td>
                                            <td><?php echo htmlentities($result->cgpa);?></td>
                                            <td><?php echo htmlentities($result->backlog_allowed);?></td>
                                            <td><?php echo htmlentities($result->package);?></td>
                                            <td><?php echo htmlentities($result->yeardown_allowed);?></td>
                                            <td><?php echo htmlentities($result->deadbacklog_count);?></td>
                                            <!-- <td>
                                            <?php if($result->status == 1)
                                                    {?>
                                                    <a href="company.php?confirm=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Un-Confirm the Company')">Confirmed <i class="fa fa-check-circle"></i></a> 
                                                    <?php } else {?>
                                                    <a href="company.php?unconfirm=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Confirm the Company')">Un-Confirmed <i class="fa fa-times-circle"></i></a>
                                                    <?php } ?>
</td>
                                            </td> -->
											
<!-- <td>
<a href="edit-company.php?edit=<?php echo $result->id;?>" onclick="return confirm('Do you want to Edit');">&nbsp; <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
<a href="company.php?del=<?php echo $result->id;?>&name=<?php echo htmlentities($result->email);?>" onclick="return confirm('Do you want to Delete');"><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp;
</td> -->
										</tr>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>


                <div class="row">
					<div class="col-md-12">

						<h2 class="page-title">You can Apply For the following Company</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Company</div>
                        
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap" id="msgshow"><?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
												<th>Company Name</th>
                                                <th>Location</th>
                                                <th>CGPA Requied</th>
                                                <th>Backlogs Allowed</th>
                                                <th>Package</th>
                                                <th>Year Down Allowed</th>
                                                <th>Dead Backlogs Allowed</th>
											<!-- <th>Action</th>	 -->
										</tr>
									</thead>
									
									<tbody>

<?php $sql = "SELECT * from  company ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->company_name);?></td>
                                            <td><?php echo htmlentities($result->c_location);?></td>
                                            <td><?php echo htmlentities($result->cgpa);?></td>
                                            <td><?php echo htmlentities($result->backlog_allowed);?></td>
                                            <td><?php echo htmlentities($result->package);?></td>
                                            <td><?php echo htmlentities($result->yeardown_allowed);?></td>
                                            <td><?php echo htmlentities($result->deadbacklog_count);?></td>
                                            <!-- <td>
                                            <?php if($result->status == 1)
                                                    {?>
                                                    <a href="company.php?confirm=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Un-Confirm the Company')">Confirmed <i class="fa fa-check-circle"></i></a> 
                                                    <?php } else {?>
                                                    <a href="company.php?unconfirm=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Confirm the Company')">Un-Confirmed <i class="fa fa-times-circle"></i></a>
                                                    <?php } ?>
</td>
                                            </td> -->
											
<!-- <td>
<a href="edit-company.php?edit=<?php echo $result->id;?>" onclick="return confirm('Do you want to Edit');">&nbsp; <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
<a href="company.php?del=<?php echo $result->id;?>&name=<?php echo htmlentities($result->email);?>" onclick="return confirm('Do you want to Delete');"><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp;
</td> -->
										</tr>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>
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
