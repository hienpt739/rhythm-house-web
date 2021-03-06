<?php 
  require_once('../database/config.php');
  require_once('../database/functions.php');
  $email = $password = $name = $errMess = '';
  if(!empty($_POST)) {
    $name = htmlspecialchars($_POST['name']);
    $email = $_POST['email'];
    $password = htmlspecialchars($_POST['password']);
    $passwordMD5 = md5($password);
    $sql = "SELECT * FROM users WHERE email='$email';";
    $result = dbSelect($sql);
    if(count($result) <= 0) {
      $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$passwordMD5')";
      dbManipulation($sql);
      header("Location: welcome.php?name=$name");
    } else {
      $errMess = 'This email has already been registered <span id="closeErrMess" style="cursor: pointer;">&times;</span>';
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Sign up</title>
    <link rel="shortut icon" href="images/favicon.ico"/>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- css -->
    <link rel="stylesheet" href="css/styles-bs.css">
  </head>
  <body>
     <!-- main -->
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="row w-100">
        <div class="d-none d-md-block col-md-6">
          <div class="h-100 d-flex align-items-center justify-content-center">
            <div>
              <div class="text-center"><a href="index.php"><img src="images/favicon-32x32.png" alt="icon"></a></div>
              <h1 class="display-4 text-center">Rhythm House</h1>
              <p class="lead text-center">your music store!</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="col-12"><h3><a class="d-inline d-md-none" href="index.php"><img src="images/favicon-32x32.png" alt="icon"></a> Sign up</h3></div>
          <small id="errMessage" class="form-text text-danger"><?=$errMess?></small>
          <form id="form-signin" class="col-md-10 col-lg-8 rounded p-4 mt-3 border" method="post">
            <div class="form-group">
              <label for="name">Name</label>
              <input value="<?=$name?>" type="text"
                class="form-control" name="name" id="name">
              <small id="nameHelp" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input value="<?=$email?>" type="text"
                class="form-control" name="email" id="email">
              <small id="emailHelp" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input value="<?=$password?>" type="password"
                class="form-control" name="password" id="password">
              <small id="passwordHelp" class="form-text text-danger"></small>
            </div>
            already have account? <a href="signin.php">Sign in</a> </br>
            <button class="btn btn-primary mt-3" id="btn-signin">Sign up</button>
            
          </form>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      // validate sign in  
      const validate = {
        name: {
          err: {
            notMatchPartern: 'name is required'
          }
        },
        email: {
          partern: /\S+@\S+\.\S+/,
          err: {
            notMatchPartern: "email is required, must contains @."
          }
        },
        password: {
          length: {
            min: 6,
            max: 16
          },
          err: {
            notMatchPartern: 'password length: 6 and 16 characters.'
          }
        }
      };

      $(document).ready(function() {
        // sign in validation
        $('#form-signin').submit(function() {
          if (
            $("#name").val() == '' ||
            !validate.email.partern.test($("#email").val()) ||
            $("#password").val().length < validate.password.length.min ||
            $("#password").val().length > validate.password.length.max
          ) {
            if ($("#name").val() == '') {
              $("#nameHelp").text(validate.name.err.notMatchPartern);
            }
            if (!validate.email.partern.test($("#email").val())) {
              $("#emailHelp").text(validate.email.err.notMatchPartern);
            }
            if (
              $("#password").val().length < validate.password.length.min ||
              $("#password").val().length > validate.password.length.max
            ) {
                $("#passwordHelp").text(validate.password.err.notMatchPartern);
            }
            return false;
          } 
          return true;
        });
        $("#name").change(function() {
          if ($("#name").val() == '') {
            $("#nameHelp").text(validate.name.err.notMatchPartern);
          } else {
            $("#nameHelp").text("");
          }
        });
        $("#email").change(function() {
            if (!validate.email.partern.test($("#email").val())) {
              $("#emailHelp").text(validate.email.err.notMatchPartern);
            } else {
              $("#emailHelp").text("");
            }
        });
        $("#password").change(function () {
          if (
            $("#password").val().length < validate.password.length.min ||
            $("#password").val().length > validate.password.length.max
          ) {
            $("#passwordHelp").text(validate.password.err.notMatchPartern);
          } else {
            $("#passwordHelp").text("");
          }
        });
        $('#closeErrMess').click(function() {
          $(this).parent().empty();
        });
      });
    </script>
  </body>
</html>