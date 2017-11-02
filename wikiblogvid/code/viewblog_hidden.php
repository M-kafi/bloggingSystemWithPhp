<?php	
session_start();
include('../data/dbfile.php');
include('../utility.php');
$utilities = new myfunctions;

	$subjects_rows = "";
	$retrieved = "";
	$subject_selected = "";
	$titles_rows = "" ;
	$title_selected = "";
	
	$user          = "";
	$date          = "";
	$blog          = "";
	$posted_user   = "";
	$posted_date   = "";
	$content_row   = "";
	$comments_rows = "";
	$display_comments = 0;
	$show_add_comment = 0;
	$super_user = 0;
	$expert     = 0 ;
	$fname = "";
	$lname = "";
	$user_id = "";
	$super  = "";
	$expert ="";
	if ( isset ($_SESSION['super_user']) )
	{
		$super_user_show = $_SESSION['super_user']; 
	}
	else
	{
		$super_user_show = "";
		
	}
	
	if ( isset ( $_POST['subject'] ) )
	{
		$subject_selected = $_POST['subject'] ;
		
		if( $subject_selected > 0 )
		{
		
		if ($utilities -> load_titles() )
		{
		
		if ( isset( $_POST['view'] ) )
		{
			$subject_selected = $_POST['subject'] ;
			$title_selected =  $_POST['titles'] ;
			
			
			
			$utilities -> load_content();
			
			if ( $user )
			{
			
			$show_add_comment = 1;
			
			$blog_id = $_POST['titles'];
			
			
			$_SESSION['blog_id'] = $blog_id ;
			$_SESSION['subject_id'] = $subject_selected;
			
			
			
			
			
			
			}
			
			
			
			
		}
		}
		
		}
		
		
		
		
		
	}
	
	
$utilities->load_subjects();

//////////////////
function display_comment_user( $user_id_comment )
{
	global $fname, $lname, $user_id, $utilities;
	$user_id = $user_id_comment;
	
	
	
	$utilities->display_comment_user($user_id_comment);
	
	
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if(isset($_POST['create']))
	{	    
	}	
	elseif (isset($_POST['clear']))
	{
	
	}

	
	
	
	
 
?>