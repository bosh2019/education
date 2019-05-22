<?php
ob_start();
session_start();
include('../db_class/dbconfig.php');
include('../db_class/hr_functions.php');
$buid=$_SESSION['buid'];
checkIntrusion($buid,$builderbaseurl);

$title="Payment Plans";

$page="addpricing.php";

$lid=$_GET['id'];
$level=base64_decode($_GET['id']);
$levelName=getColoumnNameById($conn,'name','edu_levels',$level);



if(isset($_POST['update'])){

	extract($_POST);
	$questions=mysqli_real_escape_string($conn,$questions);
	$timings=mysqli_real_escape_string($conn,$timings);
	$id=$_POST['hidId'];
	$dbnqfeatuesArr=getNQfeaturessById($conn,$id);
	$dbqfeatuesArr=getQfeaturessByIdnew($conn,$id);
	
	
	$upsQry=mysqli_query($conn,"UPDATE `edu_pricing` SET `name` = '$name', `price` = '$price'  WHERE `id` ='$id';");
	
	

	if($upsQry){

   

	
	$nqidstodelete=array_diff($dbnqfeatuesArr,$nfeatures);
	$nqidstoadd=array_diff($nfeatures,$dbnqfeatuesArr);
	
	$qidstodelete=array_diff($dbqfeatuesArr,$qfeatures);
	

	$qidstoadd=array_diff($qfeatures,$dbqfeatuesArr);

    	if(count($nqidstoadd)>0){
			
			foreach($nqidstoadd as $nfid){
				$insQry1=mysqli_query($conn,"INSERT INTO `edu_pricingnonqfeatures` (`id`, `pricingid`, `nqfeatureid`, `status`, `view`) VALUES (NULL, '$id', '$nfid', '1', '1');");
				if(!$insQry1){
					$flag=0;
				}
			}
		}
		
		if(count($nqidstodelete)>0){
			
			foreach($nqidstodelete as $nffid){
				$insQry1=mysqli_query($conn,"Update  `edu_pricingnonqfeatures` set `view` ='0' where `pricingid`='$id' and `nqfeatureid` ='$nffid'");
				if(!$insQry1){
					$flag=0;
				}
			}
		}
		
				if(count($qidstoadd)=="0")
				{
				foreach($qfeatures as $qfid){
					
					 $priceText=$_POST["qfeaturesprice".$qfid];
				$price=$priceText;
				
				$insQry1=mysqli_query($conn,"Update  `edu_pricingqfeatures` set `sets` ='$price' where `pricingid`='$id' and `qfeatureid` ='$qfid'");
				if(!$insQry1){
					$flag=0;
				}
			}	
					
			
					  
				} 

		if(count($qidstoadd)>0){
			foreach($qidstoadd as $qfid){
				$priceText=$_POST["qfeaturesprice".$qfid];
				$price=$priceText;
				
				$insQry2=mysqli_query($conn,"INSERT INTO `edu_pricingqfeatures` (`id`, `pricingid`, `qfeatureid`, `status`, `view`,`sets`) VALUES (NULL, '$id', '$qfid', '1', '1','$price');");
				if(!$insQry2){
					$flag=0;
				}
			}
		}




		if(count($qidstodelete)>0){
			foreach($qidstodelete as $nffid){
				$insQry1=mysqli_query($conn,"Update  `edu_pricingqfeatures` set `view` ='0' where `pricingid`='$id' and `qfeatureid` ='$nffid'");
				if(!$insQry1){
					$flag=0;
				}
			}
		}
		
		header("location:".$page."?msg=ups&id=$lid");
	}else{
		header("location:".$page."?msg=upf&id=$lid");
	}

	  

	

}





if(isset($_GET['did'])){

	$did=base64_decode($_GET['did']);

		$insQry=mysqli_query($conn,"update  edu_pricing  set `view`='0' where`id` = '$did';");

	if($insQry){

		//	updatelogs($conn,3,$buid,$buid,1,$projtype);

		header("location:".$page."?msg=dls&id=$lid");

	}else{

		header("location:".$page."?msg=dlf&id=$lid");

	}



}



if(isset($_POST['submit'])){

	extract($_POST);
	$inclusionsall=array();
	$name=mysqli_real_escape_string($conn,$name);
	$price=mysqli_real_escape_string($conn,$price);
	//$nights=mysqli_real_escape_string($conn,$nights);
	$flag=1;
	$pdate=date("Y-m-d");
	$ptime=date("h:i a");
	
	mysqli_query($conn,"BEGIN");
	$insQry=mysqli_query($conn,"INSERT INTO `edu_pricing` (`id`, `level_id`, `name`, `price`, `status`, `view`, `pdate`) VALUES (NULL, '$hidId', '$name', '$price', '1', '1', '$pdate');");

	if($insQry){

		$insId=mysqli_insert_id($conn);
		if(count($nfeatures)>0){
			foreach($nfeatures as $nfid){
				$insQry1=mysqli_query($conn,"INSERT INTO `edu_pricingnonqfeatures` (`id`, `pricingid`, `nqfeatureid`, `status`, `view`) VALUES (NULL, '$insId', '$nfid', '1', '1');");
				if(!$insQry1){
					$flag=0;
				}
			}
		}
		
		
		if(count($qfeatures)>0){
			foreach($qfeatures as $qfid){
				$priceText="qfeaturesprice".$qfid;
				$price=$$priceText;
				
				$insQry2=mysqli_query($conn,"INSERT INTO `edu_pricingqfeatures` (`id`, `pricingid`, `qfeatureid`, `status`, `view`,`sets`) VALUES (NULL, '$insId', '$qfid', '1', '1','$price');");
				if(!$insQry2){
					$flag=0;
				}
			}
		}
		

		

	}else{
		$flag=0;

		

	}
	
	if($flag==1){
		mysqli_query($conn,"COMMIT");
		header("location:".$page."?msg=ins&id=$lid");
	}else{
		mysqli_query($conn,"REVOKE");
	header("location:".$page."?msg=inf&id=$lid");	
	}

	

	

}





if(isset($_GET['msg'])){

	$msg=$_GET['msg'];

	switch($msg){

	case 'ins':

		$msgText="Content has been added successfully";

		$className="success";

	break;

	

	case 'inf':

		$msgText="Content was not added successfully";

		$className="danger";

	break;

	

	

	case 'ups':

		$msgText="Content has been updated successfully";

		$className="success";

	break;

	

	case 'upf':

		$msgText="Content was not updated successfully";

		$className="danger";

	break;

	

	case 'dls':

		$msgText="Content has been deleted successfully";

		$className="success";

	break;

	

	case 'dlf':

		$msgText="Content was not deleted successfully";

		$className="danger";

	break;

	

	

	default:

	    $msgText="";

		$className="";

	break;

		

	}

}

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title><?php echo getSiteName($conn)?></title>



   <script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

    <style>

	.img-circle

   {

	border-radius:5%;   

   }

   .img-circle.profile_img{

	width:90%;   

   }

	</style>

  



<script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

<script src="<?php echo $baseurl ?>/js/builder.js"></script>



  <script>



function validate(){

	

	if(document.getElementById('type').value!='3'){

		if(document.getElementById('image').value==''){

		alert("Please select a pdf ");

		return false;	

		}

	}else{

	//alert('dasd')	

	var nicE = new nicEditors.findEditor('answers');

	alert('dasd')	

	question = nicE.getContent();	



	document.getElementById('answers').value=question	

	

	}

}

</script>

  </head>



  <body class="nav-md">

    <div class="container body">

      <div class="main_container">

        <?php include_once('sidepanel.php') ?>



        <!-- top navigation -->

         <?php include_once('toppanel.php') ?>

        <!-- /top navigation -->



        <!-- page content -->

        <div class="right_col" role="main">

          <div class="">

            <div class="page-title">

            <!--  <div class="title_left">

                <h3><?php echo $title; ?></h3>

              </div>-->



              

            </div>



            <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

         



<?php if(isset($_GET['msg'])){?>	

	<div class='btn-<?php echo $className ?>' style="text-align:center;padding:5px;"><?php echo $msgText ?> <span style="float:right;cursor:pointer;font-weight:bold;" onClick="window.location.href='<?php echo $page; ?>?id=<?php echo $lid ?>'"> X </span></div>

<?php }?>

                <div class="x_panel">

                  <div class="x_title">

                    <h2><span style="color:#C60;">Add Payment plans for Level </span> - <span style="color:#0066CC;"><?php echo $levelName; ?></span>  </h2>

                    

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    
                     <?php if( isset($_GET['eid']) && ($_GET['eid']!='')){

						$eid= base64_decode($_GET['eid']);

						$categoryArr=getTableDetailsById($conn,'edu_pricing',$eid);

                        $nqfeatuesArr=getNQfeaturessById($conn,$eid);
						$qfeatuesArr=getQfeaturessById($conn,$eid);
						 
//print_r($qfeatuesArr);
					  ?>

                     

                     <form action=""  method="Post"   enctype="multipart/form-data" id="addpricing_form"> 

                     <table width="100%" border="0" class="table table-striped table-bordered">

    
 			 <tr>

                <td><label style="color:#069;font-weight:bold;">Add Name *</label></td>
                <td width="31%"><input type="text" name="name" id="name" class="form-control"  value="<?php echo htmlentities(stripslashes($categoryArr['name'])) ?>"  required></td>
                <td width="16%"> <label style="color:#069;font-weight:bold;"> Add Price *</label> </td>
                <td width="34%"><input type="text" class="form-control" name="price" id="price"  value="<?php echo htmlentities(stripslashes($categoryArr['price'])) ?>"  required></td>
            </tr>
            
            <tr>
              <td><label style="color:#069;font-weight:bold;">Attach Non Quantitative Features*</label></td>
              <td colspan="3">
              <table width="100%" border="0"  class="table table-striped table-bordered">
                <tr>
   			 <th width="10%">Select</th>
   			 <th>Description</th>
  			</tr>
                 <?php 
				$ds=mysqli_query($conn,"SELECT * FROM `nqfeatures` where `view`='1' order by `id` desc " ); 
				$numrows=mysqli_num_rows($ds);
				if( $numrows >0){
				while($fetch=mysqli_fetch_array($ds)){
					$nid=$fetch['id'];
				?>
                 <tr>
    <td width="10%"><input type="checkbox" name="nfeatures[]" value="<?php echo $fetch['id'] ?>" <?php if(in_array($nid,$nqfeatuesArr) ){ ?> checked <?php }?>></td>
    <td><?php echo $fetch['name'] ?></td>
  </tr>
				
				
				<?php }}?>
             
 
</table>

              
              </td>
            </tr>
            

           <tr>
              <td><label style="color:#069;font-weight:bold;">Attach  Quantitative Features*</label></td>
              <td colspan="3">
              <table width="100%" border="0"  class="table table-striped table-bordered">
               <tr>
                    <th width="10%">Select</th>
                    <th>Description</th>
                    <th>No Of Sets</th>
 				</tr>
                 <?php 
				$ds=mysqli_query($conn,"SELECT * FROM `qfeature` where `view`='1' order by `id` desc " ); 
				$numrows=mysqli_num_rows($ds);
				if( $numrows >0){
				while($fetch=mysqli_fetch_array($ds)){
					 $qid=$fetch['id'];
					//print_r($nqfeatuesArr);
				?>
                 <tr>
    <td width="10%"><input type="checkbox" name="qfeatures[]" value="<?php echo $fetch['id'] ?>" <?php if($qfeatuesArr[$qid]>0 ){ ?> checked <?php }?>></td>
    <td><?php echo $fetch['name'] ?></td>
     <td><input type="text" name="qfeaturesprice<?php echo $fetch['id'] ?>" class="form-control" value="<?php echo $qfeatuesArr[$qid];?>"></td>
  </tr>
				
				
				<?php }}?>
             
 
</table>

              
              </td>
            </tr>
           


  

  <tr>

    <td>&nbsp;</td>

    <td colspan="3"><input type="hidden" name="hidId" id="hidId" value="<?php echo $eid; ?>"><input type="submit" name="update"  value="Proceed To Change" class="btn btn-success"> </td>

  </tr>

</table>



                     </form>

                     <?php }else{?>

                     <form action=""  method="Post"  enctype="multipart/form-data" id="addpricing_form"> 

                     <table width="100%" border="0" class="table table-striped table-bordered">
 
    

            <!--<tr>
              <td><label style="color:#069;font-weight:bold;">Attach Subject*</label></td>
              <td colspan="3"><select  name="subject" id="subject" class="form-control"  required >
                <option value="0">Select Subject</option>
                
                <?php 
				$ds=mysqli_query($conn,"SELECT * FROM `subjects` where `view`='1' order by `id` desc " ); 
				$numrows=mysqli_num_rows($ds);
				if( $numrows >0){
				while($fetch=mysqli_fetch_array($ds)){
				?>
                <option value="<?php echo $fetch['id'] ?>"><?php echo $fetch['name'] ?></option>
				
				
				<?php }}?>
             
                
                </select></td>
            </tr>-->
           <tr>

                <td><label style="color:#069;font-weight:bold;">Add Name *</label></td>
                <td width="31%"><input type="text" name="name" id="name" class="form-control"  value=""  required></td>
                <td width="16%"> <label style="color:#069;font-weight:bold;"> Add Price *</label> </td>
                <td width="34%"><input type="text" class="form-control" name="price" id="price"  value=""  required></td>
            </tr>
            
            <tr>
              <td><label style="color:#069;font-weight:bold;">Attach Non Quantitative Features*</label></td>
              <td colspan="3">
              <table width="100%" border="0"  class="table table-striped table-bordered">
                <tr>
    <th width="10%">Select</th>
    <th>Description</th>
  </tr>
                 <?php 
				$ds=mysqli_query($conn,"SELECT * FROM `nqfeatures` where `view`='1' order by `id` desc " ); 
				$numrows=mysqli_num_rows($ds);
				if( $numrows >0){
				while($fetch=mysqli_fetch_array($ds)){
				?>
                 <tr>
    <td width="10%"><input type="checkbox" name="nfeatures[]" value="<?php echo $fetch['id'] ?>"></td>
    <td><?php echo $fetch['name'] ?></td>
  </tr>
				
				
				<?php }}?>
             
 
</table>

              
              </td>
            </tr>
            

           <tr>
              <td><label style="color:#069;font-weight:bold;">Attach  Quantitative Features*</label></td>
              <td colspan="3">
              <table width="100%" border="0"  class="table table-striped table-bordered">
               <tr>
                    <th width="10%">Select</th>
                    <th>Description</th>
                    <th>No Of Sets</th>
 				</tr>
                 <?php 
				$ds=mysqli_query($conn,"SELECT * FROM `qfeature` where `view`='1' order by `id` desc " ); 
				$numrows=mysqli_num_rows($ds);
				if( $numrows >0){
				while($fetch=mysqli_fetch_array($ds)){
				?>
                 <tr>
    <td width="10%"><input type="checkbox" name="qfeatures[]" value="<?php echo $fetch['id'] ?>"></td>
    <td><?php echo $fetch['name'] ?></td>
     <td><input type="text" name="qfeaturesprice<?php echo $fetch['id'] ?>" class="form-control" value=""></td>
  </tr>
				
				
				<?php }}?>
             
 
</table>

              
              </td>
            </tr>
           
  

  <tr>

    <td>&nbsp;</td>

    <td colspan="3"><input type="submit" name="submit"  value="Proceed To Add" class="btn btn-success"><input type="hidden" name="hidId" id="hidId" value="<?php echo $level; ?>"> </td>
  </tr>
</table>



                    </form>

                     

                     <?php }?>

                     

                     <div>

<table class="table table-responsive table-bordered" id="ls-editable-table">

  				            <thead class="thead-dark text-center">
  

  <tr>

            <th width="3%">Sno</th>
            <th width="36%">Subject</th>
            
            <th width="12%" style="text-align:center;">Action</th>
             <th width="16%" style="text-align:center;">Approval</th>

  </tr>
</thead>
  <?php

  //echo "SELECT * FROM $table where `projid`='$buid' and `whichcontent`='2' order by id asc ";
//echo "SELECT * FROM packages where `view`='1' and `countryid` IN ($allLocations)  order by `id` desc " ;
    $ds=mysqli_query($conn,"SELECT * FROM edu_pricing where `view`='1' and `level_id`='$level' order by `id` desc " ); 

	$numrows=mysqli_num_rows($ds);

	

	if(  $numrows >0){

		while($fetch=mysqli_fetch_array($ds)){

			$id=$fetch['id'];

			$i++;

			$name=$fetch['name'];
			
			

			

			?>

			

		    <tr>

                <td><?php echo $i; ?></td>
               
            
                
                   <td><?php echo $name; ?></td>
                  
                      <td style="text-align:center;">&nbsp;&nbsp;<a href="<?php echo $page ?>?eid=<?php echo base64_encode($id); ?>&id=<?php echo $lid ?>" style="color:#06F;">Edit</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a onClick="return confirm('Are you sure you want to delete!')" href="<?php echo $page ?>?did=<?php echo base64_encode($id); ?>&id=<?php echo $lid ?>" style="color:#F00;">Delete</a> 
                        
                        
                        
                        
                        
                        </th>
                        
                      <td><table width="100%" border="0" class="table table-bordered table-striped">

  <tr>

   <td align="left" style="width:30px"  ><input class='uniform' type="checkbox" id="check<?php echo $fetch['id']  ?>" value="<?php echo $fetch['status']  ?>" onClick="updateStatus('<?php echo $fetch['id'];  ?>','edu_pricing',4)" <?php if($fetch['status']==1){echo 'checked';} ?>></td>

        

        <td align="left"  class="smalltext" width="50px"><div  style="width:50px" id="status<?php echo $fetch['id']  ?>" ><?php echo getStatus($fetch['status']);  ?></div></td>

  </tr>

</table></td>

                

 			 </tr> 

		    

			

			

		<?php }

		

		

		

	}

  

  ?>







 

  </table>

 					 </div>

                   

                     


					 

                     

					

                    

                    


                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <?php include_once('footerpanel.php') ?>

        <!-- /footer content -->

      </div>

    </div>

    <script>

	function checkType(val){

		//alert(val)

		if(val==3){

			 $('#textonly').show('slow')	

			//CKEDITOR.replace( 'answers' );

			//alert('das')

			 $('#imgonly').hide()	

			 document.getElementById('cont').innerHTML=''

			 

			 $('#label').html('Update Content')	 

		}else{

			 $('#textonly').hide()

			 $('#imgonly').show('slow')	

			  $('#label').html('Browse (Image/PDF version only)') 	 

		}

	}

	</script>

 <script>

			CKEDITOR.replace( 'answer' );
			CKEDITOR.replace( 'include' );
			CKEDITOR.replace( 'exclude' );
			CKEDITOR.replace( 'terms' );
			CKEDITOR.replace( 'payment' );

		</script>

   

  </body>

</html>

