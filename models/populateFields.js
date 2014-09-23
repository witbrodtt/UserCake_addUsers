function populateFields(users) {
	var number = document.getElementById("user").value;
	for (i=0;i<number;i++){
		document.getElementsByName("username" + (i+1))[0].value = users[i].username;
		document.getElementsByName("displayname" + (i+1))[0].value = users[i].displayname;
		document.getElementsByName("email" + (i+1))[0].value = users[i].email;
	}
}