<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="web/css/styles.css">
    <title>Reset password</title>
</head>

<body>
    <div class="contenedorForm">
        <div class="errores">
            <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "</div>" : '' ?>
        </div>
        <h2>Reset your password</h2>
        <form action="index.php?action=resetPassword&token=<?php echo $parametros['token'] ?>" method="POST" id="formResetPassword">
            <div class="form-group">
                <label for="password">Enter your new password</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="passwordRepeat">Confirm your new password</label>
                <input type="password" id="passwordRepeat" name="passwordRepeat">
            </div>
            <div class="form-group">
                <button type="submit" name="reset">RESET PASSWORD</button>
            </div>
        </form>
    </div>
</body>

</html>