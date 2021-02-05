<?php 
    //include database
    include("config/db_connect.php");

    //DETECT FORM to delete 
    if(isset($_POST['delete'])){
        $id_to_delete = mysqli_real_escape_string($connection, $_POST['id_to_delete']);
        $sql = "DELETE FROM pizzas WHERE id= $id_to_delete";
        
        if(mysqli_query($connection, $sql)){
            //succues
            header('Location: index.php');
        } {
            //failure
            echo 'query erroe :' . mysqli_error($connection);
        }
    }




    //check GET request id ptramaeter
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($connection, $_GET['id']);

        //make sql
        $sql = "SELECT * FROM pizzas WHERE id = $id";

        //get query resluts 
        $result = mysqli_query($connection, $sql);

        //fetch results in array format (assosiative)
        $pizza = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($connection);
    }
?>


<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php'); ?>
    
    <!-- if details are pressed "more info" show the following information -->
    <div class="container center grey-text">
        <?php if ($pizza): ?>
            <!-- output templates -->
            <h4> <?php echo htmlspecialchars($pizza["title"]); ?></h4>
                <p> Created by: <?php echo htmlspecialchars($pizza["email"]); ?> </p>
                <p> <?php echo  htmlspecialchars($pizza["created_at"]);?> </p>
            <h5>Ingredients</h5>
                <p> <?php echo  htmlspecialchars($pizza["ingredients"]);?> </p>


            <!-- delete form -->
            <form action="details.php" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $pizza["id"] ?>">
            <input type="submit" name="delete" value="delete" class="btn brand z-depth-0">
            </form>
        <?php else: ?>
            <!-- if no information -->
            <h5>No such pizza exists!</h5>

        <?php endif; ?>
    </div>


    <?php include('templates/footer.php'); ?>
</html>