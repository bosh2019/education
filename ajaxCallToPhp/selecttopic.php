<?php
 header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 header ("Cache-Control: no-cache, must-revalidate");
 header ("Pragma: no-cache");
 include('../db_class/dbconfig.php');
include('../db_class/hr_functions.php');

 $id=$_GET['id'];
 
 
 ?>
 <select  name="subtypid" id="subtypid" class="form-control" onChange="setval(this.value)"   >
                <option value="">Select Subtype</option>
                
                <?php
				 
				$ds=mysqli_query($conn,"SELECT * FROM `subtype` where `attachedid`='$id' and `status`='1' and `view`='1' order by `id` desc " ); 
				$numrows=mysqli_num_rows($ds);
				if( $numrows >0){
				while($fetch=mysqli_fetch_array($ds)){
					$sid=$fetch['subject_id'];
					$subname=getSubjectdetails($conn,$sid);
					$name=$fetch['name'];
				?>
                <option value="<?php echo $fetch['id'] ?>"><?php echo $name; ?></option>
				
				
				<?php }}?>
             
                
                </select>





