
<?php
include 'database.php';
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
define('YEAR_START_RANGE', '2000:2050');
$append_sql = isset($append_sql) && $append_sql!= '' ? $append_sql : '';
$action = isset($_GET['action']) && $_GET['action']!= '' ? $action='edit' : '';
if(isset($_GET['u_id'])&& ($_GET['u_id']!='')){
	
	$append_sql=" and user_id='".base64_decode($_GET['u_id'])."'";
	 
} 

if($action=='edit'){
	
	$qry="select * from users where 1=1  $append_sql ORDER BY user_name";
	$res=mysqli_query($con,$qry);
	$result=mysqli_fetch_assoc($res);
	$num_industry_rows  = mysqli_num_rows($res);
 }

     $user_name = isset($result['user_name']) && $result['user_name']!= '' ? $result['user_name'] : '';
	 $email= isset($result['email']) && $result['email']!= '' ? $result['email'] : '';
	 $address = isset($result['address']) && $result['address']!= '' ? $result['address'] : '';
	 $dob = isset($result['dob']) && $result['dob']!= '' ? date('d-m-Y',strtotime($result['dob'])) : '';
	 $status = isset($result['status']) && $result['status']!= '' ? $result['status'] : '';
	 $education = isset($result['education']) && $result['education']!= '' ? $result['education'] : '';
	 $pin_code = isset($result['pin_code']) && $result['pin_code']!= '' ? $result['pin_code'] : '';
	 $country = isset($result['country']) && $result['country']!= '' ? $result['country'] : '';
	 $city = isset($result['city']) && $result['city']!= '' ? $result['city'] : '';
	 $profile = isset($result['profile']) && $result['profile']!= '' ? $result['profile'] : '';
	 $chec = isset($result['status']) && $result['status']== 'active' ? 'checked' : '';
	 $chec_in = isset($result['status']) && $result['status']== 'inactive' ? 'checked' : '';
	
if(isset($_POST['Submit'])){
	
		$input_arr=$_POST;
		unset($input_arr['Submit']);
		unset($input_arr['dob']);
		$dob=date('Y-m-d',strtotime($_POST['dob']));
		$input_arr['dob'] =$dob;
		$diff=date_diff(date_create($dob), date_create(date('Y-m-d')));
		$input_arr['age'] =$diff->format('%y');
		if($_FILES['profile']['name']==''){
		$input_arr['profile'] =$_POST['profie'];
		
		}else {
			$input_arr['profile'] =$_FILES['profile']['name'];
		}
	   //print_r($input_arr);exit;
	   $cond = "";$error = '';
		 if($_POST['user_id']!='')
		{
			$cond =' AND user_id != "'.$_POST['user_id'].'"';
		} 
		if($_POST['user_name'] != '' && $_POST['email'] != ""){
			
			$sql_insurance_validate = 'SELECT user_id,profile FROM users WHERE user_name="'.$_POST['user_name'].'" AND email="'.$_POST['email'].'"'.$cond;
												
			$result_insurance_validate=mysqli_query($con,$sql_insurance_validate) or die($con->error);
			$row=mysqli_fetch_array($result_insurance_validate);
			$numrow=mysqli_num_rows($result_insurance_validate);
			
			if($numrow > 0)
			{
				$error = 'User Name and Email already exist';
			}
		} 
	if($error=='' ){
			if($_FILES['profile']['name']){
				if(!file_exists("images/".$_FILES['profile']['name'])){
				move_uploaded_file($_FILES['profile']['tmp_name'], "images/".$_FILES['profile']['name']);
				$img="images/".$_FILES['profile']['name'];
				}
		} 
    
		if($_POST['user_id']== '')
		{
		
		
		   $input_arr['added_on'] = date("Y-m-d H:i:s");

			$q="INSERT INTO `users` ";
			$v=''; $n='';
			foreach($input_arr as $key=>$val){
				
				$n.="`$key`, ";
				
				
				if(strtolower($val)=='null') $v.="NULL, ";
				elseif(strtolower($val)=='now()') $v.="NOW(), ";
				else $v.= "'".stripslashes(mysqli_real_escape_string($con,$val))."', ";
			}

			$q.= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");"; 
			 echo "insertrow<br>".$q;exit;
			if(mysqli_query($con,$q) or die($con->error)){
				//return mysqli_insert_id($con);
				$msg = 'data added Successfully!';
			//$q="UPDATE `users` SET ";
			  $check_param="msg=".base64_encode($msg);
			  

			header('location:user_list.php?'.$check_param);
			}
			
		}
	  else if(isset($_POST['user_id']) && $_POST['user_id'] != '')
		{   
			 if($numrow <= 0)
			{   
				unset($input_arr['user_id']);
				$input_arr['updated_on'] = date("Y-m-d H:i:s");
			    $q="UPDATE `users` SET ";
			
			    foreach($input_arr as $key=>$val){
				$q.= "$key='".($val)."', ";
			    }
			    $q = rtrim($q, ', ') . ' WHERE user_id='.$_POST['user_id'].';';
			
			   mysqli_query($con,$q) or die($con->error);
			   $msg = 'data updated Successfully!';
			   $check_param="msg=".base64_encode($msg);
			   header('location:user_list.php?'.$check_param);

			}
		}  
	}
}
 
?>
<html>
	<head>
	<meta charset="UTF-8">
	<title></title>
	<script src="js/jquery.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"
 ></script>

<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-1.12.4.js"></script>
<script src="js/jquery-ui.js"></script>


<script language="javascript">
//for display datepicker
var j = jQuery.noConflict();
    j( function() {
        j( "#dob" ).datepicker({
			autoclose: true,
			constrainInput: true,
			dateFormat: 'dd-mm-yy',
			 showOn: "button",
			buttonImage: "images/calendar1.jpg",
			buttonImageOnly: true,
			buttonText: "Select Date",
			
			changeMonth: true,
			changeYear: true,
			yearRange: "<?php echo YEAR_START_RANGE?>:+nn",
			 maxDate: new Date()
		});
    } );
	function frmvalidate()
	{    

		var name = document.getElementById("user_name").value;
		var email = document.getElementById("email").value;
		var address = document.getElementById("address").value;
		var dob = document.getElementById("dob").value;
		var status = document.getElementById("status").value;
		var education = document.getElementById("education").value;
		var pin_code = document.getElementById("pin_code").value;
		var profile = document.getElementById("profile").value;
		var city = document.getElementById("city-list").value;
		var country = document.getElementById("country").value; 
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
		const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
		//var upload_other = $('#upload_hra_doc_').get(0).files.length ;
		if(name==''){
			alert('Please enter user name');
			
			document.getElementById("user_name").focus();
			return false;
		}
		else if(email==''){
			alert('Please enter email');
			document.getElementById("email").focus();
			return false;
		} else if(!filter.test(email)){
		
             alert('Please provide a valid email address');
			 return false;
		}
       else if(address==''){
			alert('Please enter address');
			document.getElementById("address").focus();
			return false;
		} 
        else if(dob==''){
			alert('Please enter DOB');
			document.getElementById("closeDate").focus();
			return false;
		} 
        else if(status==''){
			alert('Please select status');
			document.getElementById("status").focus();
			return false;
		} 
       else if(education==''){
			alert('Please select education');
			document.getElementById("education").focus();
			return false;
		} 	
        else if(pin_code==''){
			alert('Please select Pin code');
			document.getElementById("pin_code").focus();
			return false;
		}	
       else if(profile==''){
			alert('Please upload Profile picture');
			document.getElementById("profile").focus();
			return false;
		}
		
	    else if (!re.exec(profile)) {
		  alert("File extension not supported!");
		  return false;
		}			   
       else if (file >= 4096) {
            alert("please select a file less than 4mb");
        } 	         
		
        else if(country==''){
			alert('Please select country');
			document.getElementById("country").focus();
			return false;
		}	
        else if(city-list==''){
			alert('Please select city');
			document.getElementById("city-list").focus();
			return false;
		}		
       else {
       return true;
		 
	   }

}
function getcity(val) {
$.ajax({
	type: "POST",
	url: "get_city.php",
	data:{
		country_id:val,
		<?php if($action=='edit'){ ?>
		city:<?php echo $city; ?>,
		<?php } ?>
		},

	success: function(data){
	  $("#city-list").html(data);
	}
});
}
</script>
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
<body <?php if($action=='edit') { ?>onload="getcity(<?php echo $country; ?>,<?php echo $city; ?>);" <?php } ?>>
<h2 align="center">User management System </h2></br>
<table align="center" width="500"  style="border:black; border-width:2px; border-style:solid;" cellpadding="4">
	<form method="POST" enctype="multipart/form-data">
		<tr>
			   <td>Name <font color=red>* </font>:</td>
				<td>
					
					<input type="text" name="user_name" id="user_name" value="<?php echo $user_name;?>">
				</td>
			</tr>
			<tr>
				  <td>Email <font color=red>* </font>:</td>
				<td>
					
					<input type="text" name="email" id="email" value="<?php echo $email;?>">
				</td>
			</tr>
			<tr>
				 <td>Address <font color=red>* </font>:</td>
				<td>
					
					<textarea type="password" name="address" id="address"><?php echo $address;?></textarea>
				</td>
			</tr>
			<tr>
				<td>DOB <font color=red>* </font>:</td>
				<td>
					
					<input class=""  name="dob" id="dob" type="text" value="<?php echo $dob;?>" autocomplete="off" readonly />
			<div class="input-group-addon" type="button">
				<span class="glyphicon glyphicon-calendar"></span>
			</div>
				</td>
			</tr>
			<tr>
				<td>Status <font color=red>* </font>:</td>
				<td>
					
					<input type="radio"name="status" id="status" value="active" <?php echo $chec ;?>>Active
					<input type="radio" name="status" id="status" value="inactive" <?php echo $chec_in; ?>>Inactive
				</td>
			</tr>
			<tr>
			   <td>Education <font color=red>* </font>:</td>
				<td>
				
					<select name="education" id="education">
						<option value="">Select</option>
						<option value="Undergraduate" <?php if($education=='Undergraduate'){
						echo $selected='selected';} ?>>Undergraduate</option>
						<option value="Diploma" <?php if($education=='Diploma'){
						echo $selected='selected';} ?>>Diploma</option>
						<option value="Graduate" <?php if($education=='Graduate'){
						echo $selected='selected';} ?>>Graduate</option>
					</select>
				</td>
			</tr>
			<tr>
			   <td>Pin Code <font color=red>* </font>:</td>
				<td>
					
					<input type="text" name="pin_code" id="pin_code" maxlength="6" value="<?php echo $pin_code;?>">
				</td>
			</tr>
			<tr>
				<td>Profile Pic <font color=red>* </font> :</td>
				<td>
				  <?php  if($action=='edit') { ?>
					<a target="_blank" href="images/<?php echo $profile; ?>">
						<img src="images/<?php echo $profile; ?>" alt="Forest" style="width:150px">
				   </a>
				  <?php } ?>
					<input type="file" name="profile" id="profile">
				</td>
			</tr>
			<tr>
				<td>Country <font color=red>* </font>:</td>
				<td>
				
					<select onChange="getcity(this.value,'');"  name="country" id="country" class="form-control" >
					<option value="">Select</option>
					<?php $query =mysqli_query($con,"SELECT * FROM country");
					while($row=mysqli_fetch_array($query))
					{ 
					  if($row['country_id']==$country){
						  $selected='selected';
					  }else {
						  $selected='';
					  }
					 ?>
					<option value="<?php echo $row['country_id'];?>" <?php echo $selected;?> ><?php echo $row['country_name'];?></option>
					<?php
					}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>City <font color=red>* </font>:</td>
				<td>
				
					<select name="city" id="city-list" class="form-control">
					<option value="">Select</option>
					</select>
				</td>
			</tr>
			<tr><td></td>
				<td>
					<input class="btn btn-warning" name="Submit" type="submit" onClick="return frmvalidate()" value="Submit">
				</td>
			</tr>	
				
			 <input type="hidden" id="user_id" name="user_id" value="<?php echo base64_decode($_GET['u_id']); ?>">
			 <input type="hidden" id="profile" name="profile" value="<?php echo $profile; ?>">
		</form>
		</table>
	</body>
</html>