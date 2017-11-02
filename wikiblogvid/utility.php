<?php
	include('../data/dbfile.php');
	
	class myfunctions
	{
		
		
	
		
		
		
		
		
		
		
		
		public function validate_input($string)
		{			
			$string = trim($string);
			if(empty($string))			
			{
				return 0;
			}	
			else
			{
				return 1;
			}
			
		}
		public function verify_login($username,$password)
		{
			global $connection;
			$sql ="call users_verify_login('$username','$password')";			
			$connection->next_result();
			if($retrieved = $connection->query($sql))
			{
				
				echo $retrieved->num_rows;
				if($retrieved->num_rows)
				{
					echo "num rows";
					$row = $retrieved->fetch_row();
					return $row;
				}
				else
				{
					return 0;
				}
			}
		}
		// will check to see if email exists
		public function Check_Email_Exists($email)
		{
			global $connection;
			$sql = "call users_email_check('$email')";					
			$connection->next_result();
			if($retrieved = $connection->query($sql))
			{			
				if($retrieved->num_rows)
				{
					return 0 ; // email in use
				}
				else
				{
					return 1; // email not found
				}
			}
			else
			{	
			
				return 1 ; 
			}
		}
		// will check to see if user name exists
		public function Check_UserName($uname)
		{
			global $connection;
			$sql = "call users_check_username('$uname')";
			$connection->next_result();
			if($retrieved = $connection->query($sql))
			{
				if($retrieved->num_rows)
				{
					return 0;
				}
				else
				{
					return 1;
				}
			}
			else
			{
				return 0;
			}
		}
		
		// will save user (still need to save secret question)
		public function User_Insert($fname,$lname,$uname,$email,$pswd)
		{
			global $connection,$user_id, $secrect_question, $secrect_answer;
			$sql = "call users_insert('$fname','$lname','$uname','$email','$pswd')";
			$connection->next_result();
			if($retrieved = $connection->query($sql))
			{
				$sql = " call get_user_inserted_id( '$fname','$lname','$uname' )";
				$connection->next_result();
				$retrieved = $connection->query($sql);
				$user_id = $retrieved ->fetch_row();
				$user_id = $user_id[0];
				$user_id;
				$sql = " call user_question_answer_insert( $user_id, '$secrect_question','$secrect_answer' ); ";
				$connection->next_result();
				$retrieved = $connection->query($sql);
				
				
				
				
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		// add a new blog
		public function add_blog($subject_selected, $title, $blog, $user_id)
		{
			global $connection, $retreived;
			$sql = "call add_blog($subject_selected, '$title', '$blog', $user_id)";
			$connection ->next_result();
			 if ( $retreived = $connection->query($sql) )
			 {
				 return  1;
			 }
			 else
			 {
				 return 0;
				 
			 }
			
			
			
		}
		
		
		
		// will load the subject in the select input 
		public	function load_subjects()
		{
			global $connection, $subjects_rows, $retrieved;
			
			$sql = "call load_subjects()";
			$connection->next_result();
			$retrieved = $connection -> query( $sql );
			
			if ( $retrieved ->num_rows )
			{
				$subjects_rows = $retrieved -> fetch_all( MYSQLI_ASSOC );
				return 1;
			}
			else
			{
				die('Database Query Failed loading subjects');
			}
			
			
			
			
		}
		
		public function load_subject_data()
		{
			global $connection, $subjects_rows, $subjects_data, $subject_title,
			$subject_selected, $status, $retrieved;
			
			$sql = "call load_subject_data( $subject_selected )";
			$connection->next_result();
			$retrieved = $connection -> query( $sql );
			
			if ( $retrieved ->num_rows )
			{
				$subjects_data = $retrieved -> fetch_all( MYSQLI_ASSOC );
				
				$subject_title = $subjects_data[0]['title'];
				$status = $subjects_data[0]['status'];
				
				
				
				
				return 1;
			}
			else
			{
				die('Database Query Failed loading subjects');
			}
			
			
			
		}
		
		
		public function add_new_subject()
		{
			   global $new_subject,	$utilities, $connection, $retrieved;	
			   
			   $sql=" call add_new_subject( '$new_subject' ) ";
			   $connection->next_result();
			  if (  $retrieved =  $connection-> query( $sql ))
			  {
				  return 1;
				  
			  }
			  else
			  {
				  return 0;
			  }
			   
			
		}
		
		
		public function update_subject()
		{
			
			
	     global $subject_selected, $subject_title,  $status, $utilities, $connection,
            $retrieved;	
					
					$sql=" call update_subject( $subject_selected, '$subject_title', $status )   ";
		
				$connection ->next_result();
			 if ( $retreived = $connection->query($sql) )
			 {
				 return  1;
				 
			 }
			 else
			 {
				 return 0;
				 
			 }



		
		}
		
		public function clear_username_email($user_id)
		{
			global $connection, $retrieved;
			$sql = "call clear_username_email($user_id)";
			$connection->next_result();
			$retrieved = $connection->query($sql);
			
		}
		
		public function update_user($fname,$lname,$uname,$email,$secrect_question, $secrect_answer, $user_id )
		{
			global $connection, $retrieved;
			$sql = "call update_user('$fname','$lname','$uname','$email', $user_id)";
			$connection->next_result();
			
		  if (	$retrieved = $connection->query($sql) )
		  {  
		  $sql = " call update_question_answer($user_id, $secrect_question, '$secrect_answer' )	";
			$connection->next_result();
			if ($retrieved = $connection->query($sql)) 
			{
			
			
				
				return 1;
			}
		  }
		
			else
			{
					return 0;
			}
			
			
		}
		
		public function load_titles()
		{
			global $connection, $titles_rows, $subject_selected, $retrieved;
			
			$sql =" call load_titles_by_subject( $subject_selected ) ";
			
			$connection->next_result();
			$retrieved = $connection -> query ( $sql );
			
			if ( $retrieved -> num_rows )
			{
				$titles_rows = $retrieved -> fetch_all( MYSQLI_ASSOC );
				return 1;
				
			}
			else
			{
				return 0;
			}
		

			
			
			
		}
		
		
		
		public function load_users()
		{
			global $connection, $retrieved, $users_rows ;
			$sql =" call load_users() ";
			$connection->next_result();
			$retrieved = $connection->query($sql);
			if ( $retrieved->num_rows )
			{
				
				$users_rows = $retrieved -> fetch_all(MYSQLI_ASSOC);
				
				
				
				
				
				return 1;
			}
			else
			{
				return 0;
			}
			
			
			
			
			
		}
		
		
		
		public function load_user_data()
		{
			global $connection, $retrieved, $user_selected, $first_name, $last_name, $user_id,
					$status;
			$sql =" call load_user_data( $user_selected ) ";
			$connection->next_result();
			$retrieved = $connection->query($sql);
			if ( $retrieved->num_rows )
			{
				
				$user_data = $retrieved -> fetch_row();
				
				$first_name = $user_data[0] ;
				$last_name  = $user_data[1] ;
				$user_id    = $user_data[2] ;
				$status     = $user_data[3] ; 
				
				
				return 1;
			}
			else
			{
				return 0;
			}
			
			
			
			
			
		}
		
		public function update_user_status()
		{
			global $connection, $retrieved, $user_selected, $status;
			$sql =" call update_user_status( $user_selected, $status ) ";
			
			
			$connection->next_result();
		 if (	$retrieved = $connection -> query ( $sql ) )
		 {
		    return 1;	 
		 }
		 else
		 {
			 return 0;
		 }	 
			
			
			
			
		}
		
		
		public function change_password()
		{
			global $connection, $retrieved, $user_selected, $new_password;
			$sql =" call change_password( $user_selected,'$new_password' ) ";
			
			
			$connection->next_result();
		 if (	$retrieved = $connection -> query ( $sql ) )
		 {
		    return 1;	 
		 }
		 else
		 {
			 return 0;
		 }	 
			
			
			
			
		}
		
		
		
		public function load_titles_admin()
		{
			global $connection, $titles_rows, $subject_selected, $retrieved;
			
			$sql =" call load_titles_by_subject_admin( $subject_selected ) ";
			
			$connection->next_result();
			$retrieved = $connection -> query ( $sql );
			
			if ( $retrieved -> num_rows )
			{
				$titles_rows = $retrieved -> fetch_all( MYSQLI_ASSOC );
				return 1;
				
			}
			else
			{
				return 0;
			}
		

			
			
			
		}
		
		
		
		
		
		
		
		
		
		public function verify_correct_email( $email )
		{
			global $connection, $retrieved, $userid ,$email_row ;
			
			$sql = " call verify_correct_email('$email') ";
			$connection->next_result();
			$retrieved = $connection -> query( $sql );
			
			if ( $retrieved -> num_rows )
			{
			
			$email_row = $retrieved -> fetch_row();
			
			 $userid =  $email_row[0] ; 
			return 1;
			
			}
			else
			{
				return 0;
				
			}
			
			
			
		}
		
		
			public function load_info()
		{
			global $connection, $fname, $lname, $username, $email, $pswd, $msg,
			$confirm, $secrect_question, $secrect_answer,
			$retrieved, $questions_rows, $user_id;
			
			$sql =" call load_info_by_user_id($user_id) ";
			
			$connection->next_result();
			$retrieved = $connection -> query ( $sql );
			
			if ( $retrieved -> num_rows )
			{
				$info_row = $retrieved -> fetch_row();
				
				$fname = $info_row[0];
				$lname = $info_row[1];
				$username = $info_row[2];
				$email = $info_row[3];
				$secrect_question = $info_row[4];
				$secrect_answer = $info_row[5];
				
				return 1;
				
			}
			else
			{
				return 0;
			}
		

			
			
			
		}
		
		
		
		
		
		public function display_comment_user( $user_id_comment )
		{
			global $connection, $fname, $lname, $username, $email, $pswd, $msg,
			$confirm, $secrect_question, $secrect_answer,
			$retrieved, $questions_rows, $super, $expert;
			
			$sql =" call display_comment_user($user_id_comment) ";
			
			$connection->next_result();
			$retrieved = $connection -> query ( $sql );
			
			if ( $retrieved -> num_rows )
			{
				$info_row = $retrieved -> fetch_row();
				
				$fname  = $info_row[0];
				$lname  = $info_row[1];
				$super  = $info_row[2];
				$expert = $info_row[3];
				
				
				return 1;
				
			}
			else
			{
				return 0;
			}
		

			
			
			
		}
		
		
		
		public function verify_correct_answer($theuser,$thequestion,$theanswer)
		{
			global $connection ,$retrieved ; 
			
			$sql =" call verify_correct_answer($theuser,$thequestion,'$theanswer') ";
			$connection->next_result();
			$retrieved = $connection -> query ( $sql );
			
			if ( $retrieved -> num_rows )
			{
				
				return 1 ;
				
			}
			else
			{
				return 0;
				
				
			}
			
			
			
			
		}
		
		public function Update_Password($password,$user)
{
	global $connection, $retrieved;
	$encryppassword = md5($password);
	$sql = "call user_update_password('$encryppassword',$user)";
	
	$connection->next_result();
	if($retrieved = $connection->query($sql))
	{
		
		return 1;
	}
	else
	{
		return 0;
	}
}
		
		
		
		
		
		public function load_content()
		{
			global $connection,$display_comments, $comments_rows, $user, $blog, $date,
			$content_row,$super_user,$expert ,$title_selected, $posted_user, $posted_date, $retrieved;
			
			if ( $title_selected )
			{
			
				$sql =" call load_blog_content( $title_selected ) ";
				
				$connection->next_result();
				$retrieved = $connection -> query ( $sql );
				
				if ( $retrieved -> num_rows )
				{
					$content_row = $retrieved -> fetch_row();
					
					$blog = $content_row[0];
					$date = $content_row[1];
					$user = $content_row[4]." ".$content_row[5];
					$super_user = $content_row[7];
					$expert = $content_row[8];
					
					$sql = " call load_comments( $title_selected ) ";
					$connection -> next_result();
					
					$retrieved = $connection -> query( $sql );
					
					if( $retrieved ->num_rows )
					{
						$comments_rows = $retrieved -> fetch_all();
						
						 $display_comments = 1;
						
						
						
					}
					
				}
			
			}
			
		}
		
		
				public function load_content_admin()
		{
			global $connection,$display_comments, $comments_rows, $user, $blog, $date,
			$content_row, $title_selected, $posted_user, $posted_date, $retrieved;
			
			if ( $title_selected )
			{
			
				$sql =" call load_blog_content_admin( $title_selected ) ";
				
				$connection->next_result();
				$retrieved = $connection -> query ( $sql );
				
				if ( $retrieved -> num_rows )
				{
					$content_row = $retrieved -> fetch_row();
					
					$blog = $content_row[0];
					$date = $content_row[1];
					$user = $content_row[4]." ".$content_row[5];
					
					$sql = " call load_comments( $title_selected ) ";
					$connection -> next_result();
					
					$retrieved = $connection -> query( $sql );
					
					if( $retrieved ->num_rows )
					{
						$comments_rows = $retrieved -> fetch_all();
						
						 $display_comments = 1;
						
						
						
					}
					
				}
			
			}
			
		}
		
		
		
		
		
		public function load_status()
		{
			
		global  $status, $connection, $retrieved, $title_selected, $status_row ,$status ;
		 
		 $sql =" call load_status( $title_selected ) ";
		 $connection -> next_result();
		 $retrieved = $connection -> query( $sql );
					if ( $retrieved ->num_rows )
					{
						$status_row = $retrieved -> fetch_row();
						   $status = $status_row[0];
						return 1;
						
					}
					else
					{
						
						return 0;
					}
					
		 
		 
		  
		
		
			
		}
		
		
		
		public function update_status()
		{
			
			global $utilities, $status, $connection, $retrieved, $status_selected,$title_selected ;
			
			
			
			$sql =" call update_status(  $status_selected, $title_selected ) ";
			$connection -> next_result();
			
			if ( $retrieved = $connection -> query( $sql ) )
			{
				
				return 1;
			}
			else
			{
				
				return 0;
			}
			
			
			
			
			
			
		}
		
		
		public function add_new_comment()
		{
			global $utilities, $comment, $user, $blog_id, $subject_id, $connection, $retreived ,$content ;
			
			$sql =" call add_new_comment( $user, '$comment', $blog_id ) ";
			$connection -> next_result();
			
			if ( $retrieved = $connection -> query( $sql ) )
			{
				
				return 1;
			}
			else
			{
				
				return 0;
			}
			
			
			
			
		}
		
		
		public function load_content_for_comment()
		{
			
			global $user, $blog_id, $subject_id, $connection, $retreived ,$content,
			$user_name,$subject, $title, $blog, $date;
			
			$sql = "call  load_content_for_comment( $user, $blog_id, $subject_id )";
			$connection -> next_result();
			
			$retrieved = $connection -> query( $sql );
			
			if( $retrieved ->num_rows )
					{
						$content = $retrieved -> fetch_all();
						
						
						
					 $user_name = $content[0][0]." ".$content[0][1];
					 $subject = $content[0][4];
					 $title = $content[0][2];
					 $blog  = $content[0][3];
					 
					 return 1;
						
					}
					else
					{
						return 0;
					}
			
			
			
			
		}
		
		
		
		
		
		
		
		
		
		
		public function load_questions()
		{
			global $connection, $questions_rows, $retrieved;
			
			$sql = " call load_questions() ";
			$connection->next_result();
			$retrieved = $connection -> query ( $sql );
			
			if ( $retrieved ->num_rows )
			{
				$questions_rows = $retrieved ->fetch_all( MYSQLI_ASSOC );
				return 1;
				
			}
			else
			{
				return 0 ;
				
			}
			
			
			
			
			
		}
		
		
		
		 public function check_warnings( $user_id )
		 {
			 global $connection, $retrieved;
			 $sql = " call check_warnings( $user_id ) ";
			 $connection->next_result();
			 $retrieved = $connection ->query($sql);
			 
			 if( $retrieved ->num_rows )
			 {
				 
				return 1;
			 }
			 else
			 {
				 return 0;
				 
			 }
			 
			 
			 
		 }
		
		
		
		
		
		
		
	} // end of class
?>