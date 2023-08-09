<?php
//how to access from views
include "../classes/user.php";

//create a new obj/instance
$user = new User;

//call the method    from register in views
$user->store($_POST);

?>