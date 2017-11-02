<?php	
	session_start();
	include('../data/dbfile.php');
    include('../utility.php');
	
	$retrieved = "";
	$warning="";
	
	if ( isset ($_SESSION['super_user']) )
	{
		$super_user_show = $_SESSION['super_user']; 
	}
	else
	{
		$super_user_show = "";
		
	}
	
	
	
	
	if(isset($_SESSION['userid']))
	{
		$role = $_SESSION['role'];
		if($role == 2)
		{
			// place all the code in this page
		$first_name = 	ucwords( $_SESSION['firstname'] );
		$last_name  =    ucwords( $_SESSION['lastname'] );
			
			 if ( check_warnings($_SESSION['userid']) )
			 {
				 $warning = "WARNING,You have been acting poorly please don't do it again!";
				 
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
		session_destroy();
		header('Location: ../index.php'); // redirect user if user not logged in
	}

////////////////
function check_warnings($user_id)
{
	global $retrieved;
	$utilities = new myfunctions;
	
	if ( $utilities ->check_warnings($user_id))
	{return 1;

	}
	else
	{
		
	 return 0;	
		
		
	}
	
	
	
}
 
?>