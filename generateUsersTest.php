<?php
/*
To Generate a new list of names:
1. Go to http://listofrandomnames.com/
2. Select any settings you would like and click the 'Generate' button
3. Click the 'List in a text area' button below 'Export as:'
4. Select all names in the text area and copy them, then paste them into the value of the $names string
*/
$names = "
Toney Tousignant  
Marhta Monsen  
Bryan Bullock  
Gale Guo  
Sal Swint  
Trang Trevizo  
Angelo Angelo  
Verena Vanpelt  
Rick Rossin  
Karole Keough  
Ammie Aguas  
Garry Gullion  
Carlos Chiou  
Ettie Edgin  
Armanda Acord  
Fletcher Fouch  
Arlena Amon  
Leonie Landy  
Hortense Heesch  
Jonnie Jelley";

$namesArray = explode("  ", $names);

$displayName = '';
$userNames = '';
$userEmails = '';

foreach ($namesArray as $key => $value) {
	$name = explode(" ", $value);
	$firstName = strtolower($name[0]);
	$lastName = strtolower($name[1]);
	$firstLetter = $firstName[2];

	$usersArray[] = array(
		'email'    => $firstLetter.".".$lastName."@ILoveUserCake.com",
		'username' => $firstLetter.".".$lastName,
		'displayname' => $value
	);
}