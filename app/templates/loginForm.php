<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Login</title>
</head>

<body class="d-flex" style="min-height: 100vh">
    <div class="container d-flex flex-column align-items-center m-auto">
        <div class="errores">
            <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "</div>" : '' ?>
        </div>
        <h2>Login</h2>
        <form action="index.php?action=login" method="POST" id="loginForm" class="d-flex flex-column align-items-center w-100">
            <div class="form-group col-md-4">
                <label for="username">Username</label>
                <input type="text" placeholder="Username" class="form-control" id="usernameLogin" name="username">
            </div>
            <div class="form-group col-md-4">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" class="form-control" id="passwordLogin" name="password">
            </div>

            <div class="row">
                <div class="col">
                    <a href="index.php?action=forgotPassword">Forgot password?</a>
                </div>
                <div class="col">
                    <a href="index.php?action=register">Create account</a>
                </div>
            </div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-primary mt-3 w-25" name="loginButton">Login</button>
            </div>
        </form>
        <div class="container d-flex flex-column align-items-center m-auto">
            <h3>Or login with</h3>
            <?php
            echo $parametros['loginButton'];
            ?>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/f32dfec8d8.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="web/js/validaForm.js"></script>
    <script src="web/js/app.js"></script>
</body>

</html>