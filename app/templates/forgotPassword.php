<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="web/css/styles.css">
    <title>Forgot password</title>
</head>

<body>
    <div class="contenedorForm">
        <div class="errores">
            <?php echo $parametros['mensaje'] != '' ? $parametros['mensaje'] : '' ?>
        </div>
        <h2>Reset your password</h2>
        <form method="POST" action="forgotPassword" id="forgotPasswordForm">
            <div class="form-group">
                <label for="field1">Email address</label>
                <input type="email" id="field1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                <small id="emailHelp">Enter your email to reset the password.</small>
            </div>
            <div class="form-group" id="submitButtonContainer">
                <button type="submit" name="send">SEND</button>
                <p>Already registered? <a href="login">Login here</a></p>
            </div>
        </form>
    </div>
</body>

</html>