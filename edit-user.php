<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>User Details</title>
</head>

<body>
    <main class="container">
        <div class="pt-3 mt-5 mb-4">
            <h2 class="mb-3 pb-3 border-bottom">View Record</h2>
        </div>

        <?php
        $server = 'localhost';
        $username = 'root';
        $password = '';
        $db = 'php_lab4';

        $conn = mysqli_connect($server, $username, $password, $db);
        
        $sql = "SELECT * FROM users where user_id=$_GET[id]";
        $run = mysqli_query($conn, $sql);

        $rows = mysqli_fetch_assoc($run);

        // var_dump($rows);
        if(!isset($rows)) {
            echo "
                <div>
                    <h5 class='text-danger'>User not found!</h5>
                </div>
                <div class='mt-4'>
                    <button class='btn btn-primary'>
                        <a href='./index.php' class='text-white'>Back</a>
                    </button>
                </div>
            ";
        } else {
        ?>

        <form method='post'>
            <div class='form-group row'>
                <label for='inputName' class='col-sm-3 col-form-label'>Name</label>
                <div class='col-sm-9'>
                    <input type='text' name='name' value='<?php echo $rows['name'];?>' class='form-control'
                        id='inputName' placeholder='Name'>
                </div>
            </div>
            <div class='form-group row'>
                <label for='inputEmail' class='col-sm-3 col-form-label'>Email</label>
                <div class='col-sm-9'>
                    <input type='email' name='email' value='<?php echo $rows['email'];?>' class='form-control'
                        id='inputEmail' placeholder='Email'>
                </div>
            </div>
            <fieldset class='form-group'>
                <div class='row'>
                    <legend class='col-form-label col-sm-3 pt-0'>Gender</legend>
                    <div class='col-sm-9'>
                        <div class='form-check'>
                            <input class='form-check-input' type='radio' name='gender' id='gridRadios1' value='F'
                                <?php echo $rows['gender'] === 'F'? 'checked' : ''; ?> />
                            <label class='form-check-label' for='gridRadios1'>
                                Female
                            </label>
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type='radio' name='gender' id='gridRadios2' value='M'
                                <?php echo $rows['gender'] === 'M'? 'checked' : ''; ?> />
                            <label class='form-check-label' for='gridRadios2'>
                                Male
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class='form-group row'>
                <div class='col-sm-3'>Receive emails from us.</div>
                <div class='col-sm-9'>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='send_emails' value='yes' id='gridCheck1'
                            <?php echo $rows['send_emails'] === 'yes'? 'checked' : ''; ?> />
                        <label class='form-check-label' for='gridCheck1'>
                            I Agree
                        </label>
                    </div>
                </div>
            </div>
            <div class='form-group row mt-4'>
                <div class='col-sm-9 offset-sm-3'>
                    <button type='submit' name='save_user' class='btn btn-primary'>Save</button>
                    <button type='button' class='btn btn-outline'>
                        <a href='./index.php' class='text-dark'>Cancel</a>
                    </button>
                </div>
            </div>
        </form>
        <?php 
        }

        if(isset($_POST['save_user'])) {
            $name = mysqli_real_escape_string($conn, strip_tags($_POST['name']));
            $email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
            $gender = htmlspecialchars($_POST['gender']);
            $send_emails = isset($_POST['send_emails']) ? 'yes' : 'no';
        
            $ins_sql = "UPDATE users SET name='$name', email='$email', gender='$gender', send_emails='$send_emails' WHERE user_id = $_GET[id]";
            $run = mysqli_query($conn, $ins_sql);

            mysqli_close($conn);

            header("Location: ./index.php");
            exit;
        }

        mysqli_close($conn);
        ?>
    </main>

</body>

</html>