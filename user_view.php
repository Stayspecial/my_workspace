<?php
error_reporting(E_ALL);
session_start(); 
if (!isset($_SESSION['user_name'])) 
{
	// Unset all of the session variables.
	session_unset();
	// Finally, destroy the session.
	session_destroy();
	//header("location: ../access_denied.php");
	
	// If login is wrong take me to the index page	
	
	header("location: index.php");
	exit;
} 
include 'database.php';
$append_sql = isset($append_sql) && $append_sql!= '' ? $append_sql : '';
if(isset($_GET['u_id'])&& ($_GET['u_id']!='')){
	
	 $append_sql=" and user_id='".base64_decode($_GET['u_id'])."'";
	 
} 
$qry="select * from users where 1=1  $append_sql ORDER BY user_name";
$res=mysqli_query($con,$qry);
$result=mysqli_fetch_assoc($res);
$num_industry_rows  = mysqli_num_rows($res);
 $user_name = isset($result['user_name']) && $result['user_name']!= '' ? $result['user_name'] : '';
 $email= isset($result['email']) && $result['email']!= '' ? $result['email'] : '';
 $address = isset($result['address']) && $result['address']!= '' ? $result['address'] : '';
 $dob = isset($result['dob']) && $result['dob']!= '' ? $result['dob'] : '';
 $status = isset($result['status']) && $result['status']!= '' ? $result['status'] : '';
 $education = isset($result['education']) && $result['education']!= '' ? $result['education'] : '';
 $pin_code = isset($result['pin_code']) && $result['pin_code']!= '' ? $result['pin_code'] : '';
 $country = isset($result['country']) && $result['country']!= '' ? $result['country'] : '';
 $city = isset($result['city']) && $result['city']!= '' ? $result['city'] : '';
 $profile = isset($result['profile']) && $result['profile']!= '' ? $result['profile'] : '';
?>
<html>
<head>
<meta charset="UTF-8">
<title></title>
	
<style>
#list table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
#list td, th {
  border: 1px solid;
  text-align: left;
  padding: 8px;
}
</style>
</head>
<body>
<h2 align="center">User management System </h2></br>
<table align="center" width="500"  style="border:black; border-width:2px; border-style:solid;" cellpadding="4">
	<form method="POST" enctype="multipart/form-data">
		<tr>
		   <td>Name:</td>
			<td>
				<?php echo $user_name; ?>
				
			</td>
		</tr>
		<tr>
			  <td>Email:</td>
			<td>
				
				<?php echo $email; ?>
			</td>
		</tr>
		<tr>
			 <td>Address :</td>
			<td>
				
				<?php echo $address; ?>
			</td>
		</tr>
		<tr>
			<td>DOB :</td>
			<td>
				
				<?php echo date('d-m-Y',strtotime($dob)); ?>
			</td>
		</tr>
		<tr>
			<td>Status :</td>
			<td>
				
				<?php echo $status; ?>
			</td>
		</tr>
		<tr>
		   <td>Education :</td>
			<td>
			
				<?php echo $education; ?>
			</td>
		</tr>
		<tr>
		   <td>Pin Code :</td>
			<td>
				
				<?php echo $pin_code; ?>
			</td>
		</tr>
		<tr>
			<td>Profile Pic   :</td>
			<td>
			<a target="_blank" href="images/<?php echo $profile; ?>">
                 <img src="images/<?php echo $profile; ?>" alt="Forest" style="width:150px">
            </a>
			</td>
		</tr>
		<tr>
			<td>Country :</td>
			<td>
			
				<?php $query =mysqli_query($con,"SELECT * FROM country where country_id=".$country);
				$row=mysqli_fetch_array($query);
				echo $row['country_name'];
				 ?>
				
				</select>
			</td>
		</tr>
		<tr>
			<td>City :</td>
			<td>
			
				<?php $query =mysqli_query($con,"SELECT * FROM city where city_id=".$city);
				$row=mysqli_fetch_array($query);
				echo $row['city_name'];
				 ?>
			</td>
		</tr>
		<tr><td></td>
			<td>
				<input type="button" name="back" value="Back" onclick="location.href='user_list.php';" /></td>
			</td>
		</tr>
			
		</form>
		</table>
	</body>
</html>