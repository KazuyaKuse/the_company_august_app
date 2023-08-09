<?php
    //multiple distination

    require_once 'database.php';

    class User extends Database{
        //from register in actions
        # method-1
        public function store($request){
            $firstname = $request['first_name'];
            $lastname = $request['last_name'];
            $username = $request['username'];
            $password = $request['password'];

            //echo "$firstname , $lastname , $username , $password ";
            $password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (`first_name` , `last_name` , `username` , `password` ) VALUES('$firstname' , '$lastname' , '$username' , '$password' )";
            
            //print_r($this->conn);
            #execute the query string
            if($this->conn->query($sql)){
                echo "you have successfully registered";
                exit;
            }else{
                die("unable to register" . $this->conn->error);
            }
        
        
        
        
        }

        #login(other method) from login of index in views
        public function login($request){
            $username = $request['username'];
            $password = $request['password'];
            #query string
            $sql = "SELECT * FROM users WHERE username = '$username'";

            #excute the query string
            $result = $this->conn->query($sql);

            if($result->num_rows == 1){//check if the username exists

                $user = $result->fetch_assoc(); //retrieve the users
                //Ex. $user = ['id' => 1, 'first_name' => 'John', 'last_name' =>Smith'...]

                #check if the password supplied by the user matched with the password in the db
                if(password_verify($password, $user['password'])){
                    #if the password is matched, then create session variables for later use
                    session_start();//start the session

                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['fullname'] = $user['first_name'] . "" . $user['last_name'];

                    #redirect the user to the dashboard
                    header("location: ../views/dashboard.php"); //we'll create dashboard.php later on
                    exit;

                }else{
                    die("password is incorrect.");
                }
            }else{
                die("Username not found.");
            }
        }

        #logout method-3
        public function logout(){
            session_start(); //start the session
            session_unset();//free's all the sessions
            session_destroy(); //delete

            header("location: ../views/index.php"); //redirect to log page
            exit; //same as die() function
        }

        #this method is going to retrieve all the users
        #from the database
        public function getAllUsers(){
            $sql = "SELECT id, first_name, last_name, username, photo FROM users";

            if($result = $this->conn->query($sql)){
                return $result;
            }else{
                die("Error in retrieving users.");
            }
        }

        #This method is going to retrieve 1 user only
        public function getUser(){
            #start the session
            session_start();
            $id = $_SESSION['id'];//coming from the session variable in yhe login method

            #query string
            $sql = "SELECT first_name, last_name, username, photo FROM users WHERE id = $id";

            #execute the query string above
            if($result = $this->conn->query($sql)){
                return $result->fetch_assoc(); //retrieve the result in an associative array
            }else{
                die("Error in retrieving user detail.");//display error message if there is an error
            }

        }

        public function update($request, $files){
            session_start();
            $id = $_SESSION['id'];
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];
            $photo = $files['photo']['name'];
            $tmp_photo = $files['photo']['tmp_name'];//tmp_name -->temporary storage in our computer where our image is being saved temporarily

            #query string
            $sql = "UPDATE users SET first_name = '$first_name' , last_name = '$last_name', username = '$username' WHERE id = $id";

            if($this->conn->query($sql)){ //execute the query above
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = "$first_name $last_name";

                #check it there is an image uploaded, if there is, save it to the database
                #and move the actual image into the images folder
                if($photo){ //check if $photo has an image
                    $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";
                    $destination = "../assets/images/$photo";

                    #save the image to the database
                    if($this->conn->query($sql)){
                        #save the file to the image folder
                        if(move_uploaded_file($tmp_photo, $destination)){
                            header("location: ../views/dashboard.php");
                            exit;
                        }else{
                            die("Error in moving the file." . $this->conn->error);
                        }
                    }else{
                        die("Error in uploading the photo." . $this->conn->error);
                    }
                }
                header("location: ../views/dashboard.php");
                exit;
            }else{
                die("Error in updating the user details." . $this->conn->error);
            }


        }
        

        public function delete(){
            session_start();
            $id = $_SESSION['id'];

            $sql = "DELETE FROM users WHERE id = $id";

            if($this->conn->query($sql)){
                $this->logout(); //call the logout method
            }else{
                die("There is an error deleting your account." . $this->conn->error);
            }
        }
    }


?>