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
    <div id="mainRegisterPage">
        <div id="left" class="d-none d-xl-block">
            <div id="imageContainer">
                <img src="web/images/right2.jpg" alt="">
            </div>
        </div>
        <div id="right">
            <div class="errores">
                <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "<i class='fas fa-times' id='closeAlertServer'></i></div>" : '' ?>
            </div>
            <h2 class="mb-2">Create a free account</h2>
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
                    <select name="gender" id="gender" class="browser-default custom-select">
                        <option selected disabled value="">Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="registerButton">REGISTER</button>
                </div>
                <div class="form-group" id="loginPart">
                    <p>Already registered? <a href="login">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/f32dfec8d8.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script src="web/js/validaForm.js"></script>
</body>

</html>