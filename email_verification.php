<?php

include('admin/includes/config.php');

$message = '';

if(isset($_GET['verkey1']))
{
	$query = "
		SELECT * FROM users 
		WHERE verkey = :verkey
	";
	$statement = $dbh->prepare($query);
	$statement->execute(
		array(
			':verkey'			=>	$_GET['verkey1']
		)
	);
	$no_of_row = $statement->rowCount();
	
	if($no_of_row > 0)
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
	<body>
		
		<div class="container">

			<h3><?php echo $message; ?></h3>
			
		</div>
	
	</body>
	
</html>
