<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Forgot password</title>
</head>

<body class="d-flex" style="min-height: 100vh">

    <div class="container d-flex flex-column align-items-center m-auto">
        <div class="errores">
            <?php echo $parametros['mensaje'] != '' ? $parametros['mensaje'] : '' ?>
        </div>
        <h2>Reset your password</h2>
        <form method="POST" action="forgotPassword" class="d-flex flex-column align-items-center w-100">
            <div class="form-group col-md-4">
                <label for="field1">Email address</label>
                <input type="email" class="form-control" id="field1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                <small id="emailHelp" class="form-text text-muted">Enter your email to reset the password.</small>
            </div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-primary w-25" name="send">Send</button>
            </div>
        </form>
    </div>
</body>

</html>