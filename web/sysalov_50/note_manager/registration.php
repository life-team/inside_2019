<?php
require_once ('header.php');
?>
    <style>
        .top_bar{
            margin-left: 10px;
            margin-top: 20px;
            /*width:100%;*/
            text-align:left;
        }
        .top_bar a{
            color:white;
            margin-left:20px;
            text-decoration: none;
            font-size:18px;
            padding:10px;
        }

        .top_bar a:hover{
            text-decoration: underline;
            color:black;
            padding:10px;
            background-color:lightblue;
            border-radius: 20px;
        }
    </style>
<?php
$message ='';
if(isset($_POST['name']) && isset($_POST['pass'])){
    if($_POST['name']!='' && $_POST['pass']!='' ){
        if(User::check_name_for_availability($Settings->myslqi(),$_POST['name'])) {
            User::create_user($Settings->myslqi(), $_POST['name'], $_POST['pass']);
            echo '<script>window.location.href = "add_note.php";</script>';
        }else{
            $message = 'this name is already taken';
        }
    }else{
        $message = 'the entered parameters are incorrect';
    }
}

?>
    <div class="login">
        <h1>Sign up</h1>
        <h2 style="color: red; text-align: center;">
            <?php echo $message;?>
        </h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Username" required="required" />
            <input type="password" name="pass" placeholder="Password" required="required" />
            <button type="submit" class="btn btn-primary btn-block btn-large">Sign up</button>
        </form>
    </div>
<?php

require_once ('footer.php');