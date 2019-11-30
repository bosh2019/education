<?php
ob_start();
session_start();
include('../db_class/dbconfig.php');
include('../db_class/hr_functions.php');

$buid=$_SESSION['buid'];
if($buid==1){
$status=1;
}else{
$status=0;
}
checkIntrusion($buid,$builderbaseurl);
 
 $button=0;
$title="Question Management";

$page="addquestions.php";

//$colname='e_brochure_file';
if(isset($_GET['id']))
{
	
	$att_topic_id=$_GET['id'];
		$en_topic_id=base64_decode($_GET['id']);
		
		$tb_topic=getTableDetailsById($conn,'attachedtopics',$en_topic_id);
		$attach_id=$tb_topic['attachedid'];
		
				$tb_attach=getTableDetailsById($conn,'levelsubjects',$attach_id);
$subjectid=$tb_attach['subject_id'];

$subject_tb=getTableDetailsById($conn,'subjects',$subjectid);

		$sub_id=$tb_topic['subtype_id'];
		$tb_name="subtype";
		$colname='name';
		$sub_name=getColoumnNameByIdtableval($conn,$colname,$tb_name,$sub_id);
		$levelname;
		$subject_name=$subject_tb['name'];
		$topic_name=$tb_topic['topics'];

}

if(isset($_GET['eid']))
{
	
	$equedid=$_GET['eid'];
		$quesid=base64_decode($_GET['eid']);
	$tb_questions=getTableDetailsById($conn,'questions',$quesid);
	$button='1';		
}


if(isset($_POST['update'])){
	
	extract($_POST);
	$recordid=$hidId;
	$question1=mysqli_real_escape_string($conn,$questions);
		 $question = str_ireplace(array("\r","\n",'\r','\n'),'', $question1); 

		$question=mysqli_real_escape_string($conn,$question);
	$option1=mysqli_real_escape_string($conn,$option1);
	$option2=mysqli_real_escape_string($conn,$option2);
	$option3=mysqli_real_escape_string($conn,$option3);
	$option4=mysqli_real_escape_string($conn,$option4);
	$correctans=mysqli_real_escape_string($conn,$correctans);
	$fullsol=mysqli_real_escape_string($conn,$fullsol);
	$en_tid=base64_encode($topicid);

	
	 $query="UPDATE `questions` SET `question`='$question',`option1`='$option1',`option2`='$option2',`option3`='$option3',`option4`='$option4',`correct`='$correctans',`solution`='$fullsol',`difficulty`='$difficulty' WHERE `id`='$recordid'"; 
	
	$selq=mysqli_query($conn,$query);
	if($selq)
	{
		
		
				header("location:".$page."?msg=ups&id=$en_tid");

	}
	
	else
	{
		
						header("location:".$page."?msg=upf&id=$en_tid");

		
		
	}
	
	}





if(isset($_GET['did'])){

	$did=base64_decode($_GET['did']);
	$adid=$_GET['id'];

		$insQry=mysqli_query($conn,"update  questions  set `view`='0' where`id` = '$did';");

	if($insQry){

		//	updatelogs($conn,3,$buid,$buid,1,$projtype);

		header("location:saved_questions.php?msg=dls&id=$adid");

	}else{

		header("location:saved_questions.php?msg=dlf&id=$adid");

	}



}



if(isset($_POST['submit'])){

	extract($_POST);
	$question1=mysqli_real_escape_string($conn,$questions);
	 $question = str_ireplace(array("\r","\n",'\r','\n'),'', $question1); 


		$question=mysqli_real_escape_string($conn,$question);
	$option1=mysqli_real_escape_string($conn,$option1);
	$option2=mysqli_real_escape_string($conn,$option2);
	$option3=mysqli_real_escape_string($conn,$option3);
	$option4=mysqli_real_escape_string($conn,$option4);
	$correctans=mysqli_real_escape_string($conn,$correctans);
	$fullsol=mysqli_real_escape_string($conn,$fullsol);


$en_tid=base64_encode($topicid);
$pdate=date("Y-m-d");
	

	$insQry=mysqli_query($conn,"INSERT INTO `questions`(`question`, `option1`, `option2`, `option3`, `option4`, `correct`, `solution`, `topic_id`, `status`, `view`, `pdate`,`difficulty`) VALUES ('$question','$option1','$option2','$option3','$option4','$correctans','$fullsol','$topicid','1','1','$pdate','$difficulty');");

	if($insQry){

			//updatelogs($conn,3,$buid,$buid,1,$projtype);

		header("location:".$page."?msg=ins&id=$en_tid");

	}else{

		header("location:".$page."?msg=inf&id=$en_tid");

	}

	

	

}





if(isset($_GET['msg'])){

	$msg=$_GET['msg'];

	switch($msg){

	case 'ins':

		$msgText="New Question has been added successfully";

		$className="success";

	break;

	

	case 'inf':

		$msgText="New Question was not added successfully";


		$className="danger";

	break;

	

	

	case 'ups':

		$msgText="Question has been updated successfully";

		$className="success";

	break;

	

	case 'upf':

		$msgText="Question was not updated successfully";

		$className="danger";

	break;

	

	case 'dls':

		$msgText="Question has been deleted successfully";

		$className="success";

	break;

	

	case 'dlf':

		$msgText="Question was not deleted successfully";

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




    <style>

	.img-circle

   {

	border-radius:5%;   

   }

   .img-circle.profile_img{

	width:90%;   

   }

	</style>

  




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

              <!--<div class="title_left">

                <h3>Welcome</h3>

              </div>-->



              

            </div>



            <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

         



<?php if(isset($_GET['msg'])){?>	

	<div class='btn-<?php echo $className ?>' style="text-align:center;padding:5px;"><?php echo $msgText ?> <span style="float:right;cursor:pointer;font-weight:bold;" onClick="window.location.href='<?php echo $page; ?>&id=<?php echo $countryId ?>'"> X </span></div>

<?php }?>

                <div class="x_panel">

                  <div class="x_title">

                    <h2><span style="color:#666"><?php echo $subject_name;?></span> / <span style="color:#666"><?php echo $sub_name; ?></span> / <span style="color:#FF0000;">  <?php echo $topic_name; ?></span> </h2>

                    

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    
                     

                    

                    

                     

                     <div>

                     <table width="100%" border="0" class="table table-bordered table">

  
    
  <tr>

            <th width="3%">Sno</th>
            <th width="36%">View</th>
         <th width="36%">Posted On</th>
         <th width="12%" style="text-align:center;">Assign (Test Papers)</th>
            <th width="12%" style="text-align:center;">Action</th>
             <th width="16%" style="text-align:center;">Approval</th>

  </tr>

  <?php
    $ds=mysqli_query($conn,"SELECT * FROM questions where `topic_id`='$en_topic_id' and `view`='1' order by `id` desc " ); 

	 $numrows=mysqli_num_rows($ds);

	 

	if(  $numrows >0){

		while($fetch=mysqli_fetch_array($ds)){

			$id=$fetch['id'];

			$i++;

			$att_topic_id=base64_encode($en_topic_id);
$decid=base64_encode($id);
$date=$fetch['pdate'];			

			?>

			

		    <tr>

                <td><?php echo $i; ?></td>
                <td><a href="view_question.php?qid=<?php echo $decid;?>&id=<?php echo $att_topic_id;?>"><img src="../images/view.png" style="text-align:center; width:40px; height:40px;"></a></td>  
                 <th width="36%"><?php echo  changeDateToSlash($conn,$date); ?></th>
<td align="center"><a href="assignpaper.php?qid=<?php echo $decid;?>&id=<?php echo $att_topic_id;?>"><img src="<?php echo $baseurl?>/admin/images/assignment.png" style="text-align:center; width:40px; height:40px;"></a></td>                     <td style="text-align:center;">&nbsp;&nbsp;<a href="<?php echo $page ?>?eid=<?php echo base64_encode($id); ?>&id=<?php echo $att_topic_id ?>" style="color:#06F;">Edit</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a onClick="return confirm('Are you sure you want to delete!')" href="saved_questions.php?did=<?php echo base64_encode($id); ?>&id=<?php echo $att_topic_id ?>" style="color:#F00;">Delete</a> 
                       
                       
                       
                       
                       
                       </th>
                       
                     <td><table width="100%" border="0" class="table table-bordered table-striped">

  <tr>

   <td align="left" style="width:30px"  ><input class='uniform' type="checkbox" id="check<?php echo $fetch['id']  ?>" value="<?php echo $fetch['status']  ?>" onClick="updateStatus('<?php echo $fetch['id'];  ?>','questions',9)" <?php if($fetch['status']==1){echo 'checked';} ?>></td>

        

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

			CKEDITOR.replace( 'option1', {
      extraPlugins: 'uploadimage,eqneditor',
      height: 300,

      // Upload images to a CKFinder connector (note that the response type is set to JSON).
      uploadUrl: 'upload.php?command=QuickUpload&type=Files&responseType=json',

      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      filebrowserBrowseUrl: 'browse.php',
      filebrowserImageBrowseUrl: 'browse.php?type=Images',
      filebrowserUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: 'upload.php?command=QuickUpload&type=Images',

      // The following options are not necessary and are used here for presentation purposes only.
      // They configure the Styles drop-down list and widgets to use classes.

      stylesSet: [{
          name: 'Narrow image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-narrow'
          }
        },
        {
          name: 'Wide image',
          type: 'widget',
          widget: 'image',
          attributes: {

            'class': 'image-wide'
          }
        }
      ],

      // Load the default contents.css file plus customizations for this sample.
      contentsCss: [
        'http://cdn.ckeditor.com/4.11.3/full-all/contents.css',
        'assets/css/widgetstyles.css'
      ],

      // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
      // resizer (because image size is controlled by widget styles or the image takes maximum
      // 100% of the editor width).
      image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
      image2_disableResizer: true
    });
			CKEDITOR.replace( 'option2',{
      extraPlugins: 'uploadimage',
      height: 300,

      // Upload images to a CKFinder connector (note that the response type is set to JSON).
      uploadUrl: 'upload.php?command=QuickUpload&type=Files&responseType=json',

      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      filebrowserBrowseUrl: 'browse.php',
      filebrowserImageBrowseUrl: 'browse.php?type=Images',
      filebrowserUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: 'upload.php?command=QuickUpload&type=Images',

      // The following options are not necessary and are used here for presentation purposes only.
      // They configure the Styles drop-down list and widgets to use classes.

      stylesSet: [{
          name: 'Narrow image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-narrow'
          }
        },
        {
          name: 'Wide image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-wide'
          }
        }
      ],

      // Load the default contents.css file plus customizations for this sample.
      contentsCss: [
        'http://cdn.ckeditor.com/4.11.3/full-all/contents.css',
        'assets/css/widgetstyles.css'
      ],

      // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
      // resizer (because image size is controlled by widget styles or the image takes maximum
      // 100% of the editor width).
      image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
      image2_disableResizer: true
    } );
			CKEDITOR.replace( 'option3' , {
      extraPlugins: 'uploadimage',
      height: 300,

      // Upload images to a CKFinder connector (note that the response type is set to JSON).
      uploadUrl: 'upload.php?command=QuickUpload&type=Files&responseType=json',

      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      filebrowserBrowseUrl: 'browse.php',
      filebrowserImageBrowseUrl: 'browse.php?type=Images',
      filebrowserUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: 'upload.php?command=QuickUpload&type=Images',

      // The following options are not necessary and are used here for presentation purposes only.
      // They configure the Styles drop-down list and widgets to use classes.

      stylesSet: [{
          name: 'Narrow image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-narrow'
          }
        },
        {
          name: 'Wide image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-wide'
          }
        }
      ],

      // Load the default contents.css file plus customizations for this sample.
      contentsCss: [
        'http://cdn.ckeditor.com/4.11.3/full-all/contents.css',
        'assets/css/widgetstyles.css'
      ],

      // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
      // resizer (because image size is controlled by widget styles or the image takes maximum
      // 100% of the editor width).
      image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
      image2_disableResizer: true
    });
			CKEDITOR.replace( 'option4',{
      extraPlugins: 'uploadimage',
      height: 300,

      // Upload images to a CKFinder connector (note that the response type is set to JSON).
      uploadUrl: 'upload.php?command=QuickUpload&type=Files&responseType=json',

      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      filebrowserBrowseUrl: 'browse.php',
      filebrowserImageBrowseUrl: 'browse.php?type=Images',
      filebrowserUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: 'upload.php?command=QuickUpload&type=Images',

      // The following options are not necessary and are used here for presentation purposes only.
      // They configure the Styles drop-down list and widgets to use classes.

      stylesSet: [{
          name: 'Narrow image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-narrow'
          }
        },
        {
          name: 'Wide image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-wide'
          }
        }
      ],

      // Load the default contents.css file plus customizations for this sample.
      contentsCss: [
        'http://cdn.ckeditor.com/4.11.3/full-all/contents.css',
        'assets/css/widgetstyles.css'
      ],

      // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
      // resizer (because image size is controlled by widget styles or the image takes maximum
      // 100% of the editor width).
      image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
      image2_disableResizer: true
    } );
						CKEDITOR.replace( 'question',{
      extraPlugins: 'uploadimage', 
      height: 300,

      // Upload images to a CKFinder connector (note that the response type is set to JSON).
      uploadUrl: 'upload.php?command=QuickUpload&type=Files&responseType=json',

      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      filebrowserBrowseUrl: 'browse.php',
      filebrowserImageBrowseUrl: 'browse.php?type=Images',
      filebrowserUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: 'upload.php?command=QuickUpload&type=Images',

      // The following options are not necessary and are used here for presentation purposes only.
      // They configure the Styles drop-down list and widgets to use classes.

      stylesSet: [{
          name: 'Narrow image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-narrow'
          }
        },
        {
          name: 'Wide image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-wide'
          }
        }
      ],

      // Load the default contents.css file plus customizations for this sample.
      contentsCss: [
        'http://cdn.ckeditor.com/4.11.3/full-all/contents.css',
        'assets/css/widgetstyles.css'
      ],

      // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
      // resizer (because image size is controlled by widget styles or the image takes maximum
      // 100% of the editor width).
      image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
      image2_disableResizer: true
    }); 

			CKEDITOR.replace( 'fullsol',{
      extraPlugins: 'uploadimage',
      height: 300,

      // Upload images to a CKFinder connector (note that the response type is set to JSON).
      uploadUrl: 'upload.php?command=QuickUpload&type=Files&responseType=json',

      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      filebrowserBrowseUrl: 'browse.php',
      filebrowserImageBrowseUrl: 'browse.php?type=Images',
      filebrowserUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: 'upload.php?command=QuickUpload&type=Images',

      // The following options are not necessary and are used here for presentation purposes only.
      // They configure the Styles drop-down list and widgets to use classes.

      stylesSet: [{
          name: 'Narrow image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-narrow'
          }
        },
        {
          name: 'Wide image',
          type: 'widget',
          widget: 'image',
          attributes: {
            'class': 'image-wide'
          }
        }
      ],

      // Load the default contents.css file plus customizations for this sample.
      contentsCss: [
        'http://cdn.ckeditor.com/4.11.3/full-all/contents.css',
        'assets/css/widgetstyles.css'
      ],

      // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
      // resizer (because image size is controlled by widget styles or the image takes maximum
      // 100% of the editor width).
      image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
      image2_disableResizer: true
    } );



		</script>

   

  </body>

</html>

