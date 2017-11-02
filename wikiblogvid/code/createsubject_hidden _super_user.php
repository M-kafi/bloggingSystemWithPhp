<?php	
session_start();

if ( isset($_SESSION['userid']) ){
	
	
	
	$super = $_SESSION['super_user'];
		if($super == 1)
		{
			
	
	
	

include('../data/dbfile.php');
include('../utility.php');
$utilities = new myfunctions;
$subjects_rows = "";
$subject_selected ="";
$retrieved = "";
$subject_title = "";
$subjects_data ="";
$status ="";
$show= 0;
$msg = "";
$new_subject ="";



if ( isset ($_SESSION['super_user']) )
	{
		$super_user_show = $_SESSION['super_user']; 
	}
	else
	{
		$super_user_show = "";
		
	}

$utilities->load_subjects();

if ( isset ( $_POST['subject'] ) && $_POST['subject'] !== "" )
{
	
	$subject_selected = $_POST['subject'];
	load_subject_data();
	
	
	
	
}
if ( isset ( $_POST['update'] ) && !empty( $_POST['subject_title'] ) )
{


$subject_selected = $_POST['subject'];
$subject_title = $_POST['subject_title'];
$status = $_POST['status_selected'];

update_subject();
load_subject_data();
$utilities->load_subjects();
	
}

if ( isset( $_POST['show_add_new'] ) || isset( $_POST['add_subject'] ) )
{
	
$show= 1;	



  if ( isset( $_POST['add_subject'] ) )
  {
		 $new_subject = $_POST['new_subject'];

			add_new_subject();
			$show= 0;	
	  
  }
  else
  {
	  $msg = "Please enter the title for your new subject!";
  }





	
}
	


	 }
		else
		{
			session_destroy();
			header('Location: ../index.php'); // redirect user if not role 1
		}
		




 
}
else
{
	
	 header ("Location: ../index.php");	
}



//////////////////////////////////

function load_subject_data()
{
	global $utilities, $connection, $subjects_rows, $subject_title, $subjects_data,
	$subject_selected, $status, $retrieved;
	
	
	$utilities->load_subject_data();
	
}

function update_subject()
{
	
	global $subject_selected, $subject_title,  $status, $utilities, $connection,
            $retrieved;	
	
	$utilities->update_subject();
	
	
	
	
}




function add_new_subject()
{
   global $new_subject,	$utilities, $connection, $retrieved;	
	
	
	
	$utilities->add_new_subject();
	$utilities->load_subjects();
	
	
}








?>