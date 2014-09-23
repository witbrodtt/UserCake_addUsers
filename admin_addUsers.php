<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
require_once("generateUsersTest.php"); //Creates an array of sample users
require_once("generateStrongPassword.php");

if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
//if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$valid = array(' ', '.');
	$j = 1;
	
	end($_POST);
	$last = key($_POST);
	$max = substr($last, -1);
	reset($_POST);

	for ($i=0; $i < $max; $i++) { 

		$email = trim($_POST["email".$j]);
		$username = trim($_POST["username".$j]);
		$displayname = trim($_POST["displayname".$j]);
		$password = trim($_POST["password".$j]);
		
		$j++;
			
		if(minMaxRange(5,25,$username))
		{
			$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
		}
		if(!ctype_alnum(str_replace($valid, '', $username))){
			$errors[] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
		}
		if(minMaxRange(5,25,$displayname))
		{
			$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
		}
		if(!ctype_alnum(str_replace($valid, '', $displayname))){
			$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
		}
		if(minMaxRange(8,50,$password))
		{
			$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
		}
		if(!isValidEmail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		//End data validation
		if(count($errors) == 0)
		{	
			//Construct a user object
			$user = new User($username,$displayname,$password,$email);
			
			//Checking this flag tells us whether there were any errors such as possible data duplication occured
			if(!$user->status)
			{
				if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
				if($user->displayname_taken) $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
				if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
			}
			else
			{
				//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
				if(!$user->userCakeAddUser())
				{
					if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
					if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
				}
			}
		}
		if(count($errors) == 0) {
			$successes[] = $user->success;
		}
	}
	
}

require_once("models/header.php");
echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<h1>UserCake</h1>
<h2>Add Users</h2>

<div id='left-nav'>";
include("left-nav.php");
echo "
</div>

<div id='main'>";

echo resultBlock($errors,$successes);

echo "
<p>
<label>Number of users:</label>
<input type='text' id='user' name='user' value=''>
<input type='button' id='createFields' onclick='addFields();' value='Create Fields' />
</p>
<p>
<input type='button' id='generateUsers' onclick='generateUsers();' value='Generate' />
<input type='checkbox' name='generateUsers' value='Users' /> Users
<input type='checkbox' name='generatePasswords' value='Passwords' /> Passwords
</p>

<div id='usersbox'>
<form id='newUsers' name='newUser' action='".$_SERVER['PHP_SELF']."' method='post'></form>
</div>";

echo "
</div>
<div id='bottom'></div>
</div>
<script src='models/generatePassword.js' type='text/javascript'></script>
<script type='text/javascript'>

	function generateUsers(generateUsers=false, generatePasswords=false) {

		usersChecked = document.getElementsByName('generateUsers')[0].checked;
		passwordsChecked = document.getElementsByName('generatePasswords')[0].checked;

		if (usersChecked) {
			var users = ".json_encode($usersArray).";
			populateFields(users);
		}
		if (passwordsChecked) {
			var number = document.getElementById('user').value;
			var passwords = [];
			for(i=0; i < number; i++) { 
				passwords[i] = generatePassword();
				document.getElementsByName('password' + (i+1))[0].value = passwords[i];
			}
		}
	}
</script>
<script src='models/addFields.js' type='text/javascript'></script>
<script src='models/populateFields.js' type='text/javascript'></script>
</body>
</html>";
