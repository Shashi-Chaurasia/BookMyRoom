<!--email_verification code-->

<?php
include('admin/includes/config.php');
include_once('register.php');

$message = '';

if(isset($_GET['verkey']))
{
	$query = "
		SELECT * FROM users 
		WHERE email = :email
	";
	$statement = $dbh->prepare($query);
	$statement->execute(
		array(
			':email'			=>	$_GET['email']
		)
	);
	$no_of_row = $statement->rowCount();
	
	if($no_of_row > 0 && $no_of_row <= 1 )
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if($row['status'] == '0')
			{
				$update_query = "
				UPDATE users
				SET status = '1' 
				WHERE id = '".$row['id']."'
				";
				$statement = $dbh->prepare($update_query);
				$statement->execute();
				$sub_result = $statement->fetchAll();
				if(isset($sub_result))
				{
					$message = '<label class="text-success">Your Email Address Successfully Verified <br />You can login here - <a href="index.php">Login</a></label>';
				}
			}
			else
			{
				$message = '<label class="text-info">Your Email Address Already Verified</label>';
			}
		}
	}
	else
	{
		$message = '<label class="text-danger">Invalid Link</label>';
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
			
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body action="index.php">
		
		<div class="container">
			<h3><?php echo $message; ?></h3>
		</div>
	
	</body>
	
</html>