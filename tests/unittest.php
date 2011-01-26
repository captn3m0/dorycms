<?php
/**
 *	unittest.php - Unit tests for all basic CRUD operations, in DORY CMS. If there's some other u want to test just add it here.
 *	@author Ashwanth Kumar
 */
 
require_once("Dory.php");
require_once("pork/class.dbobject.php");
require_once("pork/class.postfilter.php");
require_once("pork/class.dbconnection.php");
require_once("pork/class.settings.php");
require_once("pork/class.logger.php");


$tests = $_GET['test'];

switch($tests) {

	case 0:
		// Pre-populating User Roles
		$ur = new UserRole();
		$ur -> Role = 'Admin';
	
		$ur2 = new UserRole();
		$ur2 -> Role = 'Mod';

		$ur -> Save();
		echo "Created User Role: ".$ur -> Role;

		$ur2 -> Save();
		echo "Created User Role: ".$ur2 -> Role;
	
		break;

	case 1:	// New User Test
		$user = new Users(false);
		$user->Email = $_GET['email'];
		$user->Username = $_GET['uname'];
		$user->Password = md5($_GET['password']);

		// Finding a new User Role
		$user_role = $user -> Find('UserRole',array("Role"=>"Admin"),array());

		$user->Connect($user_role[0]);
		echo "User Created with ID: ".($user -> ID);
		break;

	case 11: // New User with unique EMail Id
		$user = new Users();
		$users = $user -> Find('Users',array("Email = '".$_GET['email']."' OR Username = '".$_GET['uname']."'"),array());
		if((sizeof($users) < 1)) {	// User musn't exist
			$user->Email = $_GET['email'];
			$user->Username = $_GET['uname'];
			$user->Password = md5($_GET['password']);

			// Finding a new User Role
			$user_role = $user -> Find('UserRole',array("Role"=>"Mod"),array());

			$user->Connect($user_role[0]);
			echo ($user -> ID);
		} else { // User already exist
			echo "User Already Exist! <br />";
		}
		break;
	

	case 2:	// Existing user with a new Post
		$post = new Posts();
		$users = $post -> Find('Users',array("Email"=>$_GET['email']),array());	// Find the user by email ID
		if(sizeof($users) > 0) {
			$post -> File = 'file1';
			$post -> Created = date('Y-m-d');
			// $post -> UserRole = 2; 
			$post -> Modified = date('Y-m-d');
			$post -> isPublished = true;
			$post -> ViewCount = 0;
			$post -> Title = $_GET['title'];

			$user_role = $post -> Find('UserRole',array("Role"=>"Mod"),array());

			$post -> Connect($users[0]);
			$post -> Connect($user_role[0]);

			echo "POST ID: ".$post -> ID;
		} else {
			echo "User Not found!";
		}
		break;

	case 3: // Fetching Users' Posts
		$user = new Users();
		$users = $user -> Find('Users',array("Email"=>$_GET['email']),array());	// Find the user by email ID
		if(sizeof($users) > 0) {
			$posts = $user -> Find('Posts',array("Author"=>$users[0] -> ID),array()); // Find the list of all posts by the user
			foreach( $posts as $post) {
				echo "POST TITLE: ".$post -> Title."<br/>";
			}
			echo "<br><br>Total Post Count: ".sizeof($posts);
		} else { // User not found
			echo "User not found! Check the EMail ID";
		}
		break;

	case 4: // Creating a comment for a post 
		// Create a new Post, find a user, add 2 comments to it!
		$user = new Users();
		$users = $user -> Find('Users',array("Email"=>$_GET['email']),array());	// Find the user by email ID
		if(sizeof($users) > 0) {
			$post =  new Posts();
			$post -> File = 'file1';
			$post -> Created = date('Y-m-d');
			// $post -> UserRole = 2; 
			$post -> Modified = date('Y-m-d');
			$post -> isPublished = true;
			$post -> ViewCount = 0;
			$post -> Title = $_GET['title'];

			$user_role = $post -> Find('UserRole',array("Role"=>"Mod"),array());

			$post -> Connect($users[0]);
			$post -> Connect($user_role[0]);

			$comment = new Comments();
			$comment -> Poster = $users[0] -> Username;
			$comment -> PosterEmail = $users[0] -> Email;
			$comment -> Comment = $_GET['comment'];
			$comment -> Connect($post);

			echo "Comment Added to the Post!";
		} else { // User not found
			echo "User not found!";
		}

	case 5: // Pre-populating some default categories
		if(!isset($_GET['custom'])) {
			$cat = new Category();
			$cat -> Name = 'Travel';
			$cat -> Save();
			echo "Added a Category: ".$cat -> Name.time(). "<br />";
	
			$cat = new Category();
			$cat -> Name = 'Technology';
			$cat -> Save();
			echo "Added a Category: ".$cat -> Name.time(). "<br />";
		} else {
			$cat = new Category();
		
			$cats = $cat -> Find('Category',array("Name"=>$_GET['cat']),array());
			if(sizeof($cats) < 1) { // Category already exist, Use the existing one
				$cat -> Name = $_GET['cat'];
				$cat -> Save();
				echo "Added a new Category: ".$cat -> Name;
			} else {
				echo "I'm sorry, but the category '".$_GET['cat']."' already seems to be present!";
			}
		}
		break;
	
	case 6: // Creating a new Post, and adding a category
		$user = new Users();
		$users = $user -> Find('Users',array("Email"=>$_GET['email']),array());	// Find the user by email ID
		if(sizeof($users) > 0) {
			$post =  new Posts();
			$post -> File = 'file1';
			$post -> Created = date('Y-m-d');
			$post -> Modified = date('Y-m-d');
			$post -> isPublished = true;
			$post -> ViewCount = 0;
			$post -> Title = $_GET['title'];

			$user_role = $post -> Find('UserRole',array("Role"=>"Mod"),array());

			$post -> Connect($users[0]);
			$post -> Connect($user_role[0]);
	
			$cat = new Category();
			$cats = $cat -> Find('Category',array("Name"=>$_GET['cat']),array());
	
			echo "Category Find() status: ".sizeof($cats)."<br><br>";
		
			if(sizeof($cats) > 0) { // Category already exist, Use the existing one
				$post -> Connect($cats[0]);
				echo "Using the existing Category: ".$cats[0] -> Name;
			} else {
				$cat -> Name = $_GET['cat'];
				$post -> Connect($cat);
				echo "Created a new Category: ".$cat -> Name." with ID: ".$cat -> ID.", also used by Post ID: ".$post -> ID;
			}
		} else { // User not found
			echo "User not found!";
		}

	
} // End of switch
?>
