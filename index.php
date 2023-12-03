<?php
include_once('db_functions.php');
include_once('routes.php');
session_start();
if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>INFO2180 PROJECT 2 | Login</title>
  <link rel="stylesheet" href="styles.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
</head>

<body>
  <header>
    <div class="header-content">
      <h3>&#x1F42C; Dolphin CRM</h3>
    </div>
  </header>

  <div class="container page-content">
    <div class="py-5">
      <div class="row justify-content-center">

        <div class="col-md-6">
          <div class="card p-4">
            <div class="card-body">
              <h2 class="text-center fw-bold mb-4">Login</h2>
              <form action="<?= base_url() ?>" method="post">
                <div class="row">
                  <div class="form-field mb-4">
                    <input class="form-control p-2" type="email" name="email" required placeholder="Email address">
                  </div>
                  <div class="form-field mb-4">
                    <input class="form-control" type="password" id="psw" placeholder="Password" name="psw" required>
                  </div>
                </div>
                <!-- icon button -->
                <button id="login-btn" type="submit" name="login" class="btn btn-primary w-100">
                  <span class="float-start">
                    <i class="fas fa-lock"></i>
                  </span>

                  <span class="fw-bold">Login</span>
                </button>
                <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
                  rel="stylesheet" />

              </form>
            </div>
          </div>
        </div>
        <!-- handle login -->
        <?php
        if (isset($_POST['login'])) {
          $email = $_POST['email'];
          $password = $_POST['psw'];

          $result = login($email, $password);
          if ($result) {
            header('Location: dashboard.php');
          } else {
            echo "<div class='alert alert-danger' role='alert'>
            Invalid email or password!  
          </div>";

          }




        }


        ?>


      </div>
    </div>

  </div>

  <div class="footer">
    <div class="footer-content">
      <p>Copyright &copy; 2022 Dolphin CRM</p>
    </div>
  </div>

  <script src="script.js"></script>

</body>


</html>