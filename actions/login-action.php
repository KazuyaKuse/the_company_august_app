<?php
    include "../classes/user.php"; //include the user.php class file

    #inst/crea the object
    $user = new User; // $user->is an obj

    #call the method
    $user->login($_POST); //we will create this mathod in User.php

?>