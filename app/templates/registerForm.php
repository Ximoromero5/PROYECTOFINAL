<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="web/css/styles.css">
    <title>Register</title>
</head>

<body>
    <div>
        <div class="errores">
            <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "</div>" : '' ?>
        </div>

        <h2>Register your account</h2>
        <form action="register" method="POST" id="registerForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" placeholder="Username" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" placeholder="Email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender">
                    <option selected disabled value="">Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                Already registered? <a href="login">Login here</a>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" name="registerButton">Register</button>
            </div>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/f32dfec8d8.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script src="web/js/validaForm.js"></script>
</body>

</html>