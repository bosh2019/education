<?php
ob_start();
session_start();
include_once('db_class/dbconfig.php');
include_once('db_class/hr_functions.php');
if(isset($_GET['id']))
{
	$encoded=$_GET['id'];
	
	
		$decoded=base64_decode($_GET['id']);
$tbname="schools";
$school_details=getTableDetailsById($conn,$tbname,$decoded);
$compid=$school_details['competitiveness'];
$studenttype=$school_details['studenttype'];
$admissiontype=$school_details['admissiontype'];
$locationid=$school_details['locationid'];
$nametb="competitiveness";
$compt_details=getTableDetailsById($conn,$nametb,$compid);

$st_details=getTableDetailsById($conn,"studenttype",$studenttype);

$location_details=getTableDetailsById($conn,"location",$studenttype);

$admission_details=getTableDetailsById($conn,"admissiontype",$admissiontype);

}
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->


<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home</title>
    <!-- Standard Favicon -->
<?php include_once("header.php");?>

 
<section class="main-container">
    <!--get plan-->
    <section class="get_plan_sec notop">
        <div class="container">
            <div class="card">
               <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="schoolname"><h1><?php echo $school_details['name'];?></h1><div><?php echo $location_details['name'];?></div></div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                            <div class="sc-box">
                                <div class="icon"><img src="https://iseepracticetest.com/web-app/images/icons/medium.svg" alt="" width="40"></div>
                                <div class="detail"><div class="dg1">COMPETITIVENESS</div><div class="dg2"><?php echo $compt_details['name'];?></div></div>
                            </div>
                                
                            </div>
                            
                             <div class="col-md-4">
                            <div class="sc-box">
                                <div class="icon"><img src="https://iseepracticetest.com/web-app/images/icons/group.svg" alt="" width="40"></div>
                                <div class="detail"><div  class="dg1">GRADE LEVELS</div><div  class="dg2"><?php echo $school_details['gradelevel'];?></div></div>
                            </div>
                                
                            </div>
                            
                             <div class="col-md-4">
                            <div class="sc-box">
                                <div class="icon"><img src="https://iseepracticetest.com/web-app/images/icons/pencil.svg" alt="" width="40"></div>
                                <div class="detail"><div  class="dg1">ADMISSION TESTS</div><div  class="dg2"><?php echo $admission_details['name'];?></div></div>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            
            <div class="row"><div class="col-md-3"><img src="<?php echo $baseurl;?>/docs/<?php echo $school_details['logo'];?>" alt=""></div></div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="school-info card">
                        <div class="info-head card-header">Information</div>
                        <div class="card-body">
                           <div class="school-detail">
                            <strong>WEBSITE</strong>: <br>
<a href="<?php echo $school_details['website'];?>"><?php echo $school_details['website'];?> <br><br></a>

<strong>ADDRESS:</strong><br>
<?php echo $school_details['address'];?><br>
<strong>PHONE:</strong><br>
<?php echo $school_details['primarycontact'];?><br>
<br>
<strong>ADMISSIONS CONTACT:</strong><br>
<?php echo $school_details['email'];?>
                        </div>
                        </div>
                    </div>
                </div>
                
                  <div class="col-md-4">
                    <div class="school-info card">
                        <div class="info-head card-header">Profile</div>
                        <div class="card-body">
                           <div class="school-detail">
                           <strong>SCHOOL TYPE:</strong> <br>
<?php echo $school_details['schooltype'];?> <br>

<strong>STUDENT BODY:</strong> <br>
<?php echo $st_details['name'];?> <br>

<strong>REGION </strong><br>
<?php echo $location_details['name'];?>
                        </div>
                        </div>
                    </div>
                </div>
                
                  <div class="col-md-4">
                    <div class="school-info card">
                        <div class="info-head card-header">Admission</div>
                        <div class="card-body">
                           <div class="school-detail">
                           <strong>COMPETITIVENESS:</strong> <br>
<?php echo $compt_details['name'];?> <br>
<strong>GRADUATES:</strong> <br>
<?php echo $school_details['graduates'];?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section>
    
</section>    
    <!--get plan-->

    <!--recent-blog-->
    <section class="blog_sec" style="display: none">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title text-center">
                        <h3>Our Latest News</h3>
                    </div><!--/.title-->
                </div>
                <div class="w-100"></div>
                <div class="col-md-12">
                    <div class="owl-carousel" id="blog_slider_owl">
                        <div>
                            <div class="single_blog_in">
                                <div class="card">
                                    <div class="images">
                                        <img src="img/blog1.jpg" alt=""/>
                                        <div class="dates">
                                            <p>Sep 2018</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h2><a href="#">We design platform for all global customers</a></h2>
                                        <p>Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore.</p>
                                        <ul>
                                            <li>
                                                <p><img src="img/client2.jpg" alt=""/>by <a href="#">Tonmoy Khan</a></p>
                                            </li>
                                            <li><a href="#"><i class="fas fa-bell"></i> 15</a></li>
                                            <li>
                                                <a href="#"><i class="fas fa-comment-alt"></i> 30</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!--/.single_blog_in-->
                        </div>
                        <div>
                            <div class="single_blog_in">
                                <div class="card">
                                    <div class="images">
                                        <img src="img/blog2.jpg" alt=""/>
                                        <div class="dates">
                                            <p>Sep 2018</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h2><a href="#">Far far away,behind the word mountains, far from</a></h2>
                                        <p>Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore.</p>
                                        <ul>
                                            <li>
                                                <p><img src="img/client2.jpg" alt=""/>by <a href="#">Tonmoy Khan</a></p>
                                            </li>
                                            <li><a href="#"><i class="fas fa-bell"></i> 15</a></li>
                                            <li>
                                                <a href="#"><i class="fas fa-comment-alt"></i> 30</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!--/.single_blog_in-->
                        </div>
                        <div>
                            <div class="single_blog_in">
                                <div class="card">
                                    <div class="images">
                                        <img src="img/blog3.jpg" alt=""/>
                                        <div class="dates">
                                            <p>Sep 2018</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h2><a href="#">We design platform for all global customers</a></h2>
                                        <p>Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore.</p>
                                        <ul>
                                            <li>
                                                <p><img src="img/client2.jpg" alt=""/>by <a href="#">Tonmoy Khan</a></p>
                                            </li>
                                            <li><a href="#"><i class="fas fa-bell"></i> 15</a></li>
                                            <li>
                                                <a href="#"><i class="fas fa-comment-alt"></i> 30</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!--/.single_blog_in-->
                        </div>
                        <div>
                            <div class="single_blog_in">
                                <div class="card">
                                    <div class="images">
                                        <img src="img/blog2.jpg" alt=""/>
                                        <div class="dates">
                                            <p>Sep 2018</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h2><a href="#">Far far away,behind the word mountains, far from</a></h2>
                                        <p>Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore.</p>
                                        <ul>
                                            <li>
                                                <p><img src="img/client2.jpg" alt=""/>by <a href="#">Tonmoy Khan</a></p>
                                            </li>
                                            <li><a href="#"><i class="fas fa-bell"></i> 15</a></li>
                                            <li>
                                                <a href="#"><i class="fas fa-comment-alt"></i> 30</a>
                                            </li>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div><!--/.single_blog_in-->
                        </div>

                    </div><!--/.blog_slider_owl-->
                </div>
            </div>
        </div><!--/.container-->
    </section>
    <!--recent-blog-->

    <!--footer widget-->
<?php include_once("footer.php");?>