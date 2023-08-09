<?php
    include '../classes/user.php';

    #instantiate an object
    $user = new User;

    #call an update method
    $user->update($_POST, $_FILES);
    //$_POST-->holds our data from the form
    //$_FILES-->holds an arrays of item uploaded via the HTTP Post method(it holds our image file)
?>