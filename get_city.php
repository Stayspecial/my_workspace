<?php
require_once("database.php");

if(!empty($_POST["country_id"]))
{

	$query =mysqli_query($con,"SELECT * FROM city WHERE country_id = '" . $_POST["country_id"] . "'");

?>
<option value="">Select City</option>
<?php
while($row=mysqli_fetch_array($query))
{
	 if($row['city_id']==$_POST["city"]){
		$selected='selected';
	  }
?>
<option value="<?php echo $row["city_id"]; ?>" <?php echo $selected; ?>><?php echo $row["city_name"]; ?></option>
<?php
}
}
?>