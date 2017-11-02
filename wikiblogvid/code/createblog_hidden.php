<?php	
session_start();



	if ( isset( $_SESSION['userid'] ) )
	{
		


include('../data/dbfile.php');
include('../utility.php');
$utilities = new myfunctions;

	$subjects_rows = "";
	$retrieved = "";
	$subject_selected = "";
	$super_user = $_SESSION['super_user'];
	$user_id = $_SESSION['userid'];
	$fname="";
	$lname="";
	$user          = $_SESSION['firstname']." ".$_SESSION['lastname'];
	$user = ucwords ( $user );
	$date          = date("Y/m/d");
	$blog          = "";
	$posted_user   = "";
	$posted_date   = "";
	$content_row   = "";
	$comments_rows = "";
	$title = "";
	$errors = array();
	
	
	if ( isset ($_SESSION['super_user']) )
	{
		$super_user_show = $_SESSION['super_user']; 
	}
	else
	{
		$super_user_show = "";
		
	}
	
	
   $utilities->load_subjects();
   $utilities->load_info();

   

	
	
	
	
	if ( isset ( $_POST['save'] ) )
	{
		get_data();
		if ( validate_data() )
		{
			
			
			if( add_blog( $subject_selected, $title, $blog, $user_id ))
			{
				
				clear_page();
				
				$msg = "New blog added successfully!";
			}
			else
			{
				$msg = "couldn't add your new blog!";
				
			}
			
			
			
			
		}
		else
		{
			$msg = "Please enter all the required fields!";
			
		}
		
		
		
		
		
		
	}
	elseif ( isset ( $_POST['cancel'] ) )
	{
		
		header ( "Location: ./landing.php " );
		
	}
	
	

	}
	else 
	{
	  header ("Location: ../index.php");	
	}

	
	
	///////////////////////////////////////
	
	
	function clear_page()
	{
		global $subject_selected, $title, $blog  ; 
		
		$subject_selected ="";
		$title  ="";
		$blog = "";
		
		
	}
	
	
	
	
	function add_blog( $subject_selected, $title, $blog, $user_id )
	{
		
		$utilities = new myfunctions; 
		
		if( $utilities->add_blog( $subject_selected, $title, $blog, $user_id ) )
		{
			
			
			return 1;
			
		}
		else
		{
			return 0;
			
		}
		
		
		
		
	}
	
	
	
	function get_data()
	{
		global $subject_selected, $title, $blog;
		
		$subject_selected = $_POST['subject'];
		$title            = $_POST ['title'];
		$blog             = $_POST['blog']; 
	}
	
	
	
	
	function validate_data()
	{
		global  $errors,$fname,$lname,$username,$email,$pswd,$secrect_question,
		$secrect_answer, $confirm, $user, $date, $blog , $title, $subject_selected ;		
		$utils = new myfunctions();
		if($utils->validate_input($subject_selected) == 0)
		{
			$errors['subject'] = "*";
		}
		if(!$utils->validate_input($title))
		{
			$errors['title'] = "*";
		}
		
		
		if(!$utils->validate_input($blog))
		{
			$errors['blog'] = "*";
		}
		
        /*		
        if(!$utils->validate_input($secrect_question))
		{
			$errors['secrect_question'] = "*";
		}		
        if(!$utils->validate_input($secrect_answer))
		{
			$errors['secrect_answer'] = "*";
		}
        */		
		if(count($errors))
		{
			return 0;
		}
		else
		{
			return 1;
		}
		
	} 
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
 
?>
	

	
 
