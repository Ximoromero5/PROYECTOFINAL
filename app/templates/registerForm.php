<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Register</title>
</head>

<body class="d-flex" style="min-height: 100vh">
    <div class="container d-flex flex-column align-items-center m-auto">
        <div class="errores">
            <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "</div>" : '' ?>
            <?php echo $parametros['exito'] != '' ? "<div class='alert alert-success' role='danger'>" . $parametros['exito'] . "</div>" : '' ?>
        </div>
        <h2>Register your account</h2>
        <form action="index.php?action=register" method="POST" id="registerForm" class="d-flex flex-column align-items-center w-100">
            <div class="form-group col-md-4">
                <label for="username">Username</label>
                <input type="text" placeholder="Username" class="form-control" id="username" name="username">
            </div>
            <div class="form-group col-md-4">
                <label for="email">Email address</label>
                <input type="email" placeholder="Email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group col-md-4">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group col-md-4">
                <label for="gender">Gender</label>
                <select class="custom-select mr-sm-2" name="gender" id="gender">
                    <option selected>Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                Already registered? <a href="index.php?action=login">Login here</a>
            </div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-primary mt-3 w-25" name="registerButton">Register</button>
            </div>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/f32dfec8d8.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="web/js/validaForm.js"></script>
</body>

</html>