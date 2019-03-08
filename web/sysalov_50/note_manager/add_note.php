<?php
require_once "header.php";
$message = '';
if(isset($_POST['title']) && isset($_POST['desc'])){
    $desc = $_POST['desc'];
    $title = $_POST['title'];

    $Note->create($title, $desc);
    $message = 'success';

}
?>



    <div class="add_task">
        <h2 style="color: red; text-align: center;">
            <?php echo $message;?>
        </h2>
        <form method="post">

            <p><input type="text" name="title" placeholder="title" required="required"></p>
            <p><textarea type="text" name="desc" placeholder="description" required="required"></textarea></p>

            <button type="submit" class="btn btn-primary btn-block btn-large">Add new note</button>

        </form>
    </div>
<?php
require_once "footer.php";