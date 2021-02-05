<!-- connect to data base -->
<?php 
    include("config/db_connect.php");


    //write query for all pizzas, ordered by date
    $sql = "SELECT id, email, title, ingredients FROM pizzas ORDER BY created_at";
    
    //make qurey  and get resluts 
    $results = mysqli_query($connection, $sql);

    //fetch resulting rows (records) as an array in $pizzas variable
    $pizzas = mysqli_fetch_all($results, MYSQLI_ASSOC);

    //free Result from memory
    mysqli_free_result($results);

    //close connection
    mysqli_close($connection);

?>



<!DOCTYPE html>
<html lang="en">

    <!-- HEADER TAG IN ALL PAGES (starting body included), CSS Included-->
    <?php include('templates/header.php'); ?>

    <h4 class="center grey-text">Pizzas!</h4>
    <div class="container">
        <div class="row">
            <?php foreach($pizzas as $pizza): ?>
                <!-- assign colom system for cards -->
                <div class="col s6 md3">
                    <!-- make cards -->
                    <div class="card z-depth-0">
                        <!-- pizza image -->
                        <img src="img/pizza.svg" class="pizza">

                        <div class="card-content center">
                            <!-- check for bad code -->
                            <!-- output tilte -->
                            <h6> <?php echo htmlspecialchars($pizza["title"]);?> </h6>

                            <!-- output ingredients array -->
                            <ul>
                                <?php foreach(explode(",", $pizza["ingredients"]) as $ing): ?>
                                <li> <?php echo htmlspecialchars($ing); ?> </li>
                                <?php endforeach;?>
                            </ul>

                        </div>
                        <!-- add button for morwe information -->
                        <div class="card-action left-align">
                            <!-- send iformation of individual pizzas to linked page of details  -->
                            <a href="details.php?id= <?php echo $pizza['id'] ?>" class="brand-text">More Info</a>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        
        </div>
    </div>

    <!-- counting and diplaying number of pizzas using alternative syntax-->
    

    <!-- FOOTER TAG IN ALL PAGES (/body included)-->
    <?php include('templates/footer.php'); ?>

</html>