<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Reset password</title>
</head>

<body class="d-flex" style="min-height: 100vh">
    <div class="container d-flex flex-column align-items-center m-auto">
        <div class="errores">
            <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "</div>" : '' ?>
            <?php echo $parametros['exito'] != '' ? "<div class='alert alert-success' role='danger'>" . $parametros['exito'] . "</div>" : '' ?>
        </div>
        <h2>Reset your password</h2>
        <form action="index.php?action=resetPassword&token=<?php echo $parametros['token'] ?>" method="POST" class="d-flex flex-column align-items-center w-100">
            <div class="form-group col-md-4">
                <label for="password" class="form-text text-muted">Enter your new password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group col-md-4">
                <label for="passwordRepeat" class="form-text text-muted">Confirm your new password</label>
                <input type="password" class="form-control" id="passwordRepeat" name="passwordRepeat">
            </div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success w-25" name="reset">Reset</button>
            </div>
        </form>
    </div>
</body>

</html>