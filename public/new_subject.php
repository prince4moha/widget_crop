<?php session_start(); ?>
<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
if(empty($_SESSION['username'])) {
    redirect_to("login.php");
}
?>


<?php

    if(isset($_GET['subject'])) {
        $selected_subject_id = $_GET['subject'];
    }elseif (isset($_GET['page'])) {
        $selected_page_id = $_GET['page'];
    }else {
        $selected_subject_id = null;
        $selected_page_id = null;
    };

?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Widget Crop</title>
        <link rel="stylesheet" href="css/style.css">
        <style>
            .table table td,.table table th{
                padding: 5px;
            }
        </style>
    </head>
    
    <body>
    
    <div class="header">
        <h1>Widget Crop</h1>
    </div>
    
    <div class="main">
        <div class="nav">
            <ul class="navigation">
                <?php
                    $query = "SELECT * FROM subjects ORDER BY id ASC";
                    $subject = mysqli_query($connection,$query);
                    while ($subjects = mysqli_fetch_assoc($subject)) {
                ?>
                
                <li>
                    
                    <a href="content.php?subject=<?php echo $subjects['id']?>">
                        <?php echo $subjects['menu_name']." (".$subjects['id'].")";?> 
                    </a>
                    
                    <ul>
                        <?php
                            $query = "SELECT * FROM pages WHERE subject_id = {$subjects['id']} ";
                            $page = mysqli_query($connection,$query);
                            confirm_query($page);
                            while ($pages = mysqli_fetch_assoc($page)) {
                        ?>
                        <li>
                            <a href="content.php?page=<?php echo $pages['id']?>">
                                <?php echo $pages['menu_name'];?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul> 
                </li>
                <?php } ?>
            </ul>
        </div>
        
        <div class="page">
            <h1>Create New Subject</h1>
            
            <form action="create_subject.php" method="post">
                <p>
                    Subject Name : <input type="text" name="menu_name">
                </p>
                <p>
                    Position :
                    <select name="position">
                        <?php
                        $query = "SELECT * FROM subjects ORDER BY id ASC";
                        $subject = mysqli_query($connection,$query);
                        $count = mysqli_num_rows($subject);
                        for ($var = 1 ; $var <= ($count+1) ; $var++) {
                            echo "<option value=\"$var\">$var</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>
                    Visible :
                    <input type="radio" name="visible" value="0"> No
                    <input type="radio" name="visible" value="1"> Yes
                    
                </p>
                <p>
                    <input type="submit" value="Create Subject" name="submit">
                        <br><br>
                    <a href="content.php">Cancel</a>
                </p>
            </form>
            
            <h1>&raquo;&raquo; Edit & Delete Subjects</h1>
            
            <div class="table">
                
                <table border="1" style="width: 50%;text-align: center">
                    <tr>
                        <th>Subject Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    
                    <?php
                        $query = "SELECT * FROM subjects";
                        $select_query = mysqli_query($connection,$query);
                        while ($subjects = mysqli_fetch_assoc($select_query)) {
                    ?>
                    
                    <tr>
                        <td><?php echo $subjects['menu_name'] ?></td>
                        <td><a href="edit_subject.php?subject=<?php echo $subjects['id']?>">Edit</a></td>
                        <td><a href="delete_subject.php?subject=<?php echo $subjects['id']?>">Delete</a></td>
                    </tr>
                    <?php } ?>
                </table>
                
            </div>
            
        </div>
        <?php
            mysqli_close($connection);
        ?>
    
    <script src="js/jquery.js"></script>
    <script src="js/plugins.js"></script>
    </body>
</html>


