<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <link rel="stylesheet" href="web/css/styles.css">
    <title>Login</title>
</head>

<body>
    <div id="mainLoginPage">
        <div id="left">
            <div id="titlePart">
                <h5>Welcome to </h5>
                <h1>Finterest</h1>
                <p>Log in with</p>
                <a href="<?php echo $parametros['loginButton']; ?>">
                    <button type="button" id="google-button" title="Google Log In">
                        <img src="web/images/google.png" alt="">
                        <p>Log in with Google</p>
                    </button>
                </a>
                <div id="separatorLine">
                    <hr>
                    Or
                    <hr>
                </div>
            </div>
            <div class="errores">
                <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "<i class='fas fa-times' id='closeAlertServer'></i></div>" : '' ?>
            </div>
            <form action="login" method="POST" id="loginForm" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="usernameLogin">Username</label>
                    <input type="text" placeholder="Enter your username" id="usernameLogin" name="username" value="<?php echo isset($_COOKIE['userCookie']) ? $_COOKIE['userCookie'] : '' ?>" required>
                    <div class="invalid-feedback">
                        The user field is required.
                    </div>
                </div>
                <div class="form-group">
                    <label for="passwordLogin">Password</label>
                    <input type="password" placeholder="Enter your password" id="passwordLogin" name="password" value="<?php echo isset($_COOKIE['passwordCookie']) ? $_COOKIE['passwordCookie'] : '' ?>" required>
                    <i class="fas fa-eye" id="passwordEye"></i>
                    <div class="invalid-feedback">
                        The user field is required.
                    </div>
                </div>
                <div class="forgot">
                    <div class="pretty p-default p-round">
                        <input type="checkbox" name="rememberButton" id="rememberButton" <?php echo isset($_COOKIE['userCookie']) ? 'checked' : '' ?>>
                        <div class="state">
                            <label>Remember me</label>
                        </div>
                    </div>
                    <a href="forgotPassword">Forgot password?</a>
                </div>

                <div class="form-group" id="submitButtonContainer">
                    <button type="submit" name="loginButton">LOGIN</button>
                    <p>Don't have an account? <a href="register">Sign Up here</a></p>
                </div>

            </form>
        </div>
        <div id="right" class="d-none d-xl-block">
            <div id="imageContainer">
                <img src="web/images/un1.svg" alt="">
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/f32dfec8d8.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script src="web/js/validaForm.js"></script>
    <script src="web/js/app.js"></script>
</body>

</html>