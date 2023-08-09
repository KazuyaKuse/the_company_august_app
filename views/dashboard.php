<?php
    //echo "I am the dashboard, you have successfully logged-in.";
    session_start();
    require '../classes/user.php';

    #instantiate an object
    $user = new User; //$user-->is the object
    $all_users = $user->getAllUsers(); //call the method getAllUsers() from users.php
    //debug
    
    //print_r($all_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--style CSS  -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Dashboard</title>
</head>
<body>
   <?php
        include '../views/main-nav.php';
   ?>

    <main class="row justify-content-center gx-0">
        <div class="col-6">
            <h2 class="text-center">User List</h2>

            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>FIRSTNAME</th>
                        <th>LASTNAME</th>
                        <th>USERNAME</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($user = $all_users->fetch_assoc()){
                    ?>
                        <tr>
                            <td>
                                <?php
                                if($user['photo']){
                                ?>
                                    <img src="../assets/images/<?= $user['photo']?>" alt="<?= $user['photo']?>"
                                    class="d-block mx-auto dashboard-photo">
                                <?php
                                    }else{
                                    ?>    
                                    <i class="fa-solid fa-circle-user dashboard-icon"></i>
                                <?php
                                }
                                ?>    
                            </td>
                            
                            <td><?= $user['id'] ?></td> 
                            <td><?= $user['first_name'] ?></td> 
                            <td><?= $user['last_name'] ?></td> 
                            <td><?= $user['username'] ?></td> 
                            <td>
                                <?php
                                    if($_SESSION['id'] == $user['id']){
                                ?>
                                    <a href="edit-user.php" class="btn btn-outline-warning" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete-user.php" class="btn btn-outline-danger" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                <?php
                                    }
                                ?>
                            </td>       
                        </tr>
                    <?php            
                        }
                    ?>    
                </tbody>



            </table>
        </div>

    </main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>
</html>