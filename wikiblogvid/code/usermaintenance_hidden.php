<?php
session_start();

if ( isset( $_SESSION['userid'] ) )
{
	
	
	
	$role = $_SESSION['role'];
		if($role == 1)
		{
			
	
include('../data/dbfile.php');
include('../utility.php');


$retieved ="";
$users_rows = "";
$user_selected="";
$first_name ="" ;
$last_name = "";
$user_id = "";
$status = "";
$msg ="";
$new_password = "";

 if ( load_users() )
 {
 
		 if ( isset ( $_POST['user_selected'] ) && !empty ( $_POST['user_selected'] ) )
		 {
			$user_selected = $_POST['user_selected'];
			
			load_user_data();

			
			 
		 }
		
		if ( isset ( $_POST['update'] ) && !empty ( $_POST['user_selected']  )  )
		{
		  
		  $user_selected = $_POST['user_selected'];
		  $status        = $_POST['status_selected'];
		 if( update_user_status())
		 {
			 load_user_data();
			 
			 
			 
		 }
		  
			
			
			
			
		}
 
        if ( isset ( $_POST['save_password'] ) && !empty ( $_POST['user_selected']  )  )
		{
			
			if ( !empty( $_POST['new_password'] ) )
			{
				$user_selected = $_POST['user_selected'];
				$new_password = trim($_POST['new_password']);
				$new_password = md5($new_password);
				
				if ( change_password() )
				{
					 $user_selected = $_POST['user_selected'];
					 load_user_data();
					 
					$msg ="The password successfully changed";
				}
				else
				{
					$msg ="Sorry there was an error! ";
					
				}
				
				
				
			}
			else
			{
				
				$msg ="Please enter the new password!";
				
			}
				
				
				
		  
		  
		 
		  
			
			
			
			
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
////////////////////////

function load_users()
{
	
	
 	$utilities = new myfunctions;
	
	if ( $utilities -> load_users() )
	{
		return 1;
		
	}
	else
	{
		return 0;
		
	}
 	
	
}

function load_user_data()
{
	$utilities = new myfunctions();
	
	if ( $utilities -> load_user_data() )
	{
		return 1;
	}
	else
	{
		return 0;
	}
	
	
}

function update_user_status()
{
	
	$utilities = new myfunctions();
	
	if ( $utilities -> update_user_status() )
	{
		return 1;
	}
	else
	{
		return 0;
	}
	
	
	
}

function change_password()
{
	
	$utilities = new myfunctions();
	
	if ( $utilities -> change_password() )
	{
		return 1;
	}
	else
	{
		return 0;
	}
	
	
}

 
?>