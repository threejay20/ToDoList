<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadata for the document -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do list</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Main container for the To-Do list -->
    <div class="main-section">
        <!-- Section for adding new To-Do items -->
        <div class="add-section">
            <!-- Form for adding a new To-Do item, submits to add.php -->
            <form action="app/add.php" method="POST" autocomplete="off">
                <!-- Check if there is an error message passed in the URL -->
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                    <!-- Input field with red border indicating an error, if the error is present -->
                    <input type="text" 
                        name="title" 
                        style="border-color: #ff6666" 
                        placeholder="This field is required" />
                    <!-- Submit button with "+" sign -->
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>

                <?php } else { ?>
                    <!-- Normal input field for adding a To-Do item -->
                    <input type="text" name="title" placeholder="What do you need to do?" />
                    <!-- Submit button with "+" sign -->
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php } ?>
            </form> 
        </div>

        <!-- PHP code to fetch all To-Do items from the database -->
        <?php 
        $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>

        <!-- Section to display the list of To-Do items -->
        <div class="show-todo-section">
            <!-- Check if there are any To-Do items in the database -->
            <?php if($todos->rowCount() > 0){ ?>
                <!-- Display an image if there are no To-Do items -->
                <div class="todo-item">
                    <div class="empty">
                        <img src="img\jess-bailey-94Ld_MtIUf0-unsplash.jpg" width="100%" />
                    </div>
                </div>
            <?php } ?>

            <!-- Loop through each To-Do item and display it -->
            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <!-- Button to remove a To-Do item, passing its ID -->
                    <span id="<?php echo $todo['id']; ?>" class="remove-to-do">x</span>
                    <!-- Checkbox to mark a To-Do item as done -->
                    <?php if($todo['checked']){ ?>
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id="<?php echo $todo['id']; ?>"
                               checked />
                        <!-- Title of the To-Do item, with a strikethrough if checked -->
                        <h2 class="checked"><?php echo $todo['title']; ?> </h2>
                    <?php } else { ?>
                        <input type="checkbox"
                               data-todo-id="<?php echo $todo['id']; ?>"
                               class="check-box"/>
                        <!-- Title of the To-Do item -->
                        <h2><?php echo $todo['title']; ?> </h2>
                    <?php } ?>
                    <!-- Display the creation date of the To-Do item -->
                    <br>
                    <small>created: <?php echo $todo['date_time']; ?></small>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- jQuery library -->
    <script src="js\jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function(){
            // Function to handle the removal of a To-Do item
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');

                $.post("app/remove.php", 
                {
                    id: id
                },
                (data) => {
                    if(data){
                        // Hide the parent element of the clicked remove button
                        $(this).parent().hide(600);
                    }
                });
            });

            // Function to handle the checking/unchecking of a To-Do item
            $('.check-box').click(function(e){
                const id = $(this).attr('data-todo-id');

                $.post('app/check.php', 
                {
                    id: id
                },
                (data) => {
                    if(data != 'error'){
                        const h2 = $(this).next();
                        // Toggle the checked class based on the response
                        if(data === '1'){
                            h2.removeClass('checked');
                        } else {
                            h2.addClass('checked');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
