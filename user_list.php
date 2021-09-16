<?php 
/*
file name:etf_trader_list.php
purpose:To fetch,display  extracted records
*/
//connecting database
include("database.php");

require_once('settings.php');
require_once('google-login-api.php');
session_start(); 
if (!isset($_SESSION['user_name'])) 
{
	// Unset all of the session variables.
	session_unset();
	// Finally, destroy the session.
	session_destroy();
	//header("location: ../access_denied.php");
	
	// If login is wrong take me to the access denied page	
	
	header("location: index.php");
	exit;
} 

//for pagination
if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$no_of_records_per_page = 30;
$offset = ($pageno-1) * $no_of_records_per_page;

$msg = isset($_GET['msg']) && $_GET['msg']!= '' ? base64_decode($_GET['msg']) : '';
//print_r($_GET);
define('YEAR_START_RANGE', '2000:2050');
$d = date('d');
$m = date('m');
$y = date('Y');
$date_print = $y."-".$m."-".$d;
if(isset($_GET['url_key']))
{
	$check=base64_decode($_GET['url_key']);
	
	$get_variables = explode('&',$check);
	//print_r($get_variables);
	$count=count($get_variables);
	if(isset($get_variables) && !empty($get_variables))
	{
		foreach($get_variables as $k=>$v)
		{			
			if($v!='')
			{
				$get_variables = explode('=',$v);
				$_GET[$get_variables[0]]=($get_variables[1]);
				
			}
		}
	}
}
//end
//function to display total records showing (pagination)
function display_count($query_numrows, $max_rows_per_page, $current_page_number, $text_output) {
$to_num = ($max_rows_per_page * $current_page_number);
  if ($to_num > $query_numrows) $to_num = $query_numrows;
  $from_num = ($max_rows_per_page * ($current_page_number - 1));
  if ($to_num == 0) {
	$from_num = 0;
  } else {
	$from_num++;
  }

  return sprintf($text_output, $from_num, $to_num, $query_numrows);
}

$user_name = isset($user_name) && $user_name!= '' ? $user_name : '';
$email = isset($email) && $email!= '' ? $email : '';
$age = isset($age) && $age!= '' ? $age : '';
$status = isset($status) && $status!= '' ? $status : '';
$append_sql = isset($append_sql) && $append_sql!= '' ? $append_sql : '';
if(isset($_POST['user_name'])&& ($_POST['user_name']!='')){
	$user_name = ($_POST['user_name']);

}else if(isset($_GET['user_name'])&& ($_GET['user_name']!='')){
	$user_name = ($_GET['user_name']);

}
if(isset($_POST['email'])&& ($_POST['email']!='')){
	$email = ($_POST['email']);
	
}
else if(isset($_GET['email'])&& ($_GET['email']!='')){
	$email = ($_GET['email']);
	
}
if(isset($_POST['age'])&& ($_POST['age']!='')){
	$age = ($_POST['age']);
	
}else if(isset($_GET['age'])&& ($_GET['age']!='')){
	$age = ($_GET['age']);
	
}
if(isset($_POST['status'])&& ($_POST['status']!='')){
	$status = ($_POST['status']);
	
}else if(isset($_GET['status'])&& ($_GET['status']!='')){
	$status = ($_GET['status']);
	
}
if($from_date!='' && $to_date!='')
{
	$append_sql=" and date >= '".$from_date."' AND date <= '".$to_date."' ";
	$param="&from_date=".$from_date;
	$param.="&to_date=".$to_date;
}
if($user_name!='')
{
	$append_sql.=" and user_name like '%".($user_name)."%'";
	$param.="&user_name=".$user_name;

}
if($email!='')
{
	$append_sql.=" and email like '%".($email)."%'";
	$param.="&email=".$email;

}
if($status!='')
{
	$append_sql.=" and status ='".$status."'";
	$param.="&status=".$status;

}
if($age!='')
{
	$append_sql.=" and age =$age";
	$param.="&age=".$age;

}
//fetching records from db
$qry="select * from users where 1=1  $append_sql ORDER BY user_name";
$res=mysqli_query($con,$qry);

$num_industry_rows  = mysqli_num_rows($res);
  $sql = "SELECT * FROM users where 1=1  $append_sql ORDER BY user_name LIMIT $offset, $no_of_records_per_page";
$res_data = mysqli_query($con,$sql);

$total_pages = ceil($num_industry_rows / $no_of_records_per_page);
$num_rows  = mysqli_num_rows($res_data);
?>
	
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
.search1 {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 80%;
}
td, th {
  border: 1px solid;
  text-align: left;
  padding: 8px;
}
#btn_search {
	text-align: center;
}


 </style>
 <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
<link rel="stylesheet" href="css/jquery-ui.css">

<script src = "js/jquery.min.js"
 ></script>
<script src="js/jquery-1.12.4.js"></script>
<script src="js/jquery-ui.js"></script>


<script language="javascript">
//to display datepicker
var j = jQuery.noConflict();
    j( function() {
        j( "#from_date" ).datepicker({
			autoclose: true,
			constrainInput: true,
			dateFormat: 'yy-mm-dd',
			 showOn: "button",
			buttonImage: "images/calendar1.jpg",
			buttonImageOnly: true,
			buttonText: "Select Date",
			
			changeMonth: true,
			changeYear: true,
			yearRange: "<?php echo YEAR_START_RANGE?>:+nn",
			 maxDate: new Date()
		});
		j( "#to_date" ).datepicker({
			autoclose: true,
			constrainInput: true,
			dateFormat: 'yy-mm-dd',
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
	
function go_search()
{
	var user_name=document.getElementById("user_name").value;
	var email=document.getElementById("email").value;
	var email=document.getElementById("age").value;
	var email=document.getElementById("status").value;

} 
function delete_row(id){
	//alert(id);
if (confirm("Are you sure you want to delete?")) {
	  $.ajax({
	type: "POST",
	url: "ajax_delete.php",
	data:'user_id='+id,
	success: function(data){
		alert('deleted successfully!');
	 window.location.reload();
	}
	});
} else {
  return false;
}
	
}
</script>	
</head>
<?php 
echo '<div class="panel-heading">Welcome '.$_SESSION['user_name'].'</div><div class="panel-body"></div>';
 ?>
<h2 align="center">User management System </h2></br>

<div align="center"><font color=red><?php echo base64_decode($_GET['msg']);?></font></div>
<form name="search_report" id="search_report" action="" method="post">

	<table  align="center" cellpadding="5" class="search1" cellspacing="1" border="0">	
			<tr>
				<td  align="right"><b>Name</b>
				
				<input type="text" name="user_name"  id="user_name" size="20" value="<?php echo ($user_name);?>" />
				</td>
				
				<td width="" align="right"><b>Email:</b>
				
					<input type="text" name="email"  id="email" size="20" value="<?php echo ($email);?>" />
				
		       </td>
				<td width="" align="right"><b>Age:</b>
				
					<input type="text" name="age"  id="age" size="20" value="<?php echo ($age);?>" />
				</td>
				<td width="" align="right"><b>Status:</b>
				
					<input type="radio"name="status" id="status" value="active">Active
						<input type="radio" name="status" id="status" value="inactive">Inactive
				</td>
				<tr>
						
					<td colspan="4" align="center"  id="btn_search"><input type="submit" id="btn_go" value="Search" onClick="go_search()"></td>
				</tr>						
			</tr>
			
			
  </table>
  </br>

<table  align="center" style="border:black; border-width:2px; border-style:solid;" cellspacing="1" cellpadding="5">
	
	<?php 
	$i=0;
	
	$i=($pageno-1)* 30;
	if($num_industry_rows > 0)
	{   
	?> 
	 <tr style='background-color:grey;color:white;'> 
		<td width="85" height="20"  align="center"><b>Sr No</b></td>
		<td width="184" height="20" align="center"><b>Profile Picture</b></td>
		<td width="184" height="20" align="center"><b>Name</b></td>
		<td width="184" height="20" align="center"><b>Email</b></td>
		<td width="184" height="20" align="center"><b>Age</b></td>
		<td width="184" height="20" align="center"><b>status</b></td>
		<td height="20" class="top_content" align="center" valign="center" nowrap width="170"><b>Action</b></td>
	  </tr>
		<?php while($result=mysqli_fetch_assoc($res_data))
		{ 
			//print_r($result);	
			$max_price='';$max='';
		    $user_name = isset($result['user_name']) && $result['user_name']!= '' ? $result['user_name'] : '';
		   $date = isset($result['dob']) && $result['dob']!= '' ? $result['dob'] : '';
		   $age = isset($result['age']) && $result['age']!= '' ? $result['age'] : '';
		   $email = isset($result['email']) && $result['email']!= '' ? $result['email'] : '';
		   $status = isset($result['status']) && $result['status']!= '' ? $result['status'] : '';
		   $profile = isset($result['profile']) && $result['profile']!= '' ? $result['profile'] : '';
		   $user_id = isset($result['user_id']) && $result['user_id']!= '' ? base64_encode($result['user_id']) : '';
		   //query to fetch highest closing price amongst all
			$qry_select="select max(closing_price) as max from etf_trader_data where 1=1 $append_sql and comp_symbol='".$comp_symbol."'";
			$res_sel=mysqli_query($db_con,$qry_select);
			$result_select=mysqli_fetch_array($res_sel);
			
		?>
		<tr>
			<td width="85" height="20" ><?php echo ++$i; ?></td>
				<td width="85" height="20" ><a target="_blank" href="images/<?php echo $profile; ?>">
                 <img src="images/<?php echo $profile; ?>" alt="Forest" style="width:150px">
            </a></td>
			<td width="85" height="20" ><?php echo $user_name;?></td>
			<td width="85" height="20" ><?php echo $email;?></td>
	        <td width="85" height="20" ><?php echo $age ;?></td>
			<td width="85" height="20" ><?php echo $status ;?></td>
			<td width="85" height="20"><a href="user.php?&u_id=<?php echo $user_id;?>&action=edit">Edit</a>|<a href="user_view.php?&u_id=<?php echo ($user_id);?>">View</a>|<a href="#" onclick="delete_row(<?php echo base64_decode($user_id) ;?>)">Delete</a></td>
			
		</tr>
			<?php 	
		}
			
	}else { ?>
	    <div align="center"><font color=red>No records found</font></div>
	<?php }?>
					
</table>
  <?php 
  //pagination
  if($num_industry_rows > 0)
	{  
    if($param!='')
	{
		
		$parameters='url_key='.base64_encode($param);
		
	}
?>
	<div align="left">
	<span class="smallText" valign="top"><FONT SIZE="2" face="verdana" COLOR="#663300"><B><?php echo display_count($num_industry_rows,30, $pageno, "Displaying <b>%d</b> to <b>%d</b> (of <b>$num_industry_rows</b> Results)"); ?></B></FONT></span>
	</div>
   <div class="pagination" align="right">
        <a href="?<?php echo $parameters; ?>&pageno=1">First</a></li><span class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="?<?php echo $parameters; ?><?php if($pageno <= 1){ echo '#'; } else { echo "?&pageno=".($pageno - 1); } ?>">Prev</a>
        </span>
        
        <span class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="?<?php echo $parameters; ?><?php if($pageno >= $total_pages){ echo '#'; } else { echo "?&pageno=".($pageno + 1); } ?>">Next</a>
        </span>
        <span><a href="?<?php echo $parameters; ?>&pageno=<?php echo $total_pages; ?>">Last</a></span>
    </div>
	<?php }?>
</br>
<div align="center"><input type="button" value="Add user" onClick='javascript:window.location="user.php";'></div>
</form>
