<!-- PHP THAT HANDLES REQUEST FROM FORM -->
    <?php 

        // CONNECT TO DATABASE
        include("config/db_connect.php");

        //intialize input feilds to empty
        $email = $title = $ingredients = "";
        $errors = array('email'=>"", "title" => "", "ingredients" => "");
            

        // CHECK IF THERE IS DATA USING GLOBAL VARAIABLE $_GET ASSOCIATIVE ARRAY = GET METHOD
                // if (isset($_GET['submit'])){
                //     // EXRATCT FORM DATA
                //     echo $_GET['email'];
                //     echo $_GET['title'];
                //     echo $_GET['ingredients'];
                // }
            
            
        // CHECK IF THERE IS DATA USING GLOBAL VARAIABLE $_GET ASSOCIATIVE ARRAY = POST METHOD (HIDDIN data method)
            if (isset($_POST['submit'])){ // SERVER-SIDE VALIDATION 
                // EXRATCT FORM DATA
                // htmlspecialchars is used to portect form feilds from outside script (function) turning it into letters
                    
                //check email
                if (empty($_POST['email'])){
                    $errors["email"] = "An email is reqired <br />";
                } else {
                    $email = $_POST['email'];
                    // PHP has a built in validating system for emails, no need for hand written
                    // using ! reverses anything after it therefore it returns false and code does not pass the echo will happen
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        //if false show error in form buy adding errors to error array to output later
                        $errors["email"] = 'Email must be a valid email adress';
                    };
                }

                //check title
                if (empty($_POST['title'])){
                    $errors["title"] = "An title is reqired <br />";
                } else {
                    $title = $_POST['title'];
                        
                    // ^[a-zA-Z\s]+$ is an expression to clear characters that are not numbers or spaces
                    if(!preg_match("/^[a-zA-Z\s]+$/", $title)){
                        //if false show error in form buy adding errors to error array to output later
                        $errors["title"] = 'Title must be letter and spaces only';
                    }
                }

                //check ingredients 
                if (empty($_POST['ingredients'])){
                    $errors["ingredients"] = "At least one ingredient is reqired <br />";
                } else {
                    $ingredients = $_POST["ingredients"];
                    // LOOKS FOR A COMMENTS SEPERATED LIST
                    if(!preg_match("/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/", $ingredients)){
                        //if false show error in form buy adding errors to error array to output later
                        $errors["ingredients"] = 'Ingredients must be a comma seperated list';
                    }
                }

                //check for errors in $error array and save to data base
                if (array_filter($errors)){
                    echo "errors present";
                } else {
                    $email = mysqli_real_escape_string($connection, $_POST['email']);
                    $title = mysqli_real_escape_string($connection, $_POST['title']);
                    $ingredients = mysqli_real_escape_string($connection, $_POST['ingredients']);

                    //create sql string inserting into pizzas table 
                    $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title', '$email', '$ingredients')";

                    //save sql to database and check
                    if(mysqli_query($connection, $sql)){
                        //sucsess and redirect to home
                        header("Location: index.php");
                    } else{ 
                        //error
                        echo "query error :" .mysqli_error($connection);
                    }                    
                }
            } 
        //end of POST check      
    ?>

<!-- PAGE CODE -->
    <!DOCTYPE html>
    <html lang="en">

        <!-- HEADER TAG IN ALL PAGES (starting body included), CSS Included-->
        <?php include('templates/header.php'); ?>


        <section class="container grey-text">
            <h4 class="center">Add a Pizza</h4>

            <!-- FORM -->
            <!--  DO IT USING SUPERGLOBALS like below ORRR normal like action="add.php" -->
            <form class="white" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <label>Your Email:</label>
                    <input type="text" name="email" value= "<?php echo htmlspecialchars($email) ?>">
                    <div class="red-text">
                        <?php echo $errors['email']; ?>
                    </div>
                
                <label>Pizza Title:</label>
                    <input type="text" name="title" value= "<?php echo htmlspecialchars($title) ?>">
                    <div class="red-text">
                        <?php echo $errors['title']; ?>
                    </div>

                <label>Ingredients (comma seperated):</label>
                    <input type="text" name="ingredients" value= "<?php echo htmlspecialchars($ingredients) ?>">
                    <div class="red-text">
                        <?php echo $errors['ingredients']; ?>
                    </div>

                <!-- submit button -->
                <div class="center">
                    <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
                </div>
            </form>


        </section>


        <!-- FOOTER TAG IN ALL PAGES (/body included)-->
        <?php include('templates/footer.php'); ?>

    </html>