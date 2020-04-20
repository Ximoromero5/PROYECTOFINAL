<title>Profile</title>
<?php ob_start() ?>
<?php foreach ($_SESSION['datos'] as $row) { ?>
    <div class="errores">
        <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "</div>" : '' ?>
        <?php echo $parametros['exito'] != '' ? "<div class='alert alert-success' id='success'>" . $parametros['exito'] . "</div>" : '' ?>
    </div>
    <div class="container d-flex flex-column align-items-center mt-5">
        <div class="row">
            <div class="col-md-4 mb-5">
                <div class="card">
                    <div class="card-header text-center" style="background: url('<?php echo $row['coverPhoto'] ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;">
                        <div>
                            <img src="<?php echo $row['photo'] ?>" alt="" class="rounded-circle" width="110" height="110" style="opacity: .75; border: 3px solid #444; cursor: pointer;" data-toggle="modal" data-target="#modalProfile">
                            <div style="position: absolute; bottom: 70%; left: 50%; transform: translate(-50%, -50%);" title="Upload your profile photo">
                                <i class="fas fa-camera text-light" data-toggle="modal" data-target="#modalProfile" style="font-size: 25px; cursor: pointer;"></i>
                            </div>
                        </div>

                        <!-- Modal Foto de perfil-->
                        <div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h5 class="modal-title" id="exampleModalLabel">Select profile photo</h5>
                                        <form action="index.php?action=profilePhoto" method="POST" enctype="multipart/form-data" id="photoForm">
                                            <div class="custom-file my-4">
                                                <input type="file" class="custom-file-input" id="customFile" name="photo">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            <div class="text-right">
                                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                                <button type="submit" class="btn btn-primary" name="upload">Update photo</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Foto de perfil-->

                        <!--  Modal foto de fondo -->
                        <input type="button" value="Change cover photo" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalCover">
                        <div class="modal fade" id="modalCover" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h5 class="modal-title" id="exampleModalLabel">Select cover photo</h5>
                                        <form action="index.php?action=profilePhoto" method="POST" enctype="multipart/form-data" id="photoForm">
                                            <div class="custom-file my-4">
                                                <input type="file" class="custom-file-input" id="customFile" name="cover">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            <div class="text-right">
                                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                                <button type="submit" class="btn btn-primary" name="uploadCover">Update photo</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  Modal foto de fondo -->
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" id="names"><?php echo $row['firstName'] . " " . $row['lastName'] ?></h5>
                        <p class="card-text" id="parrafoDescripcion"><?php echo $row['description'] ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <span class="mr-3"><b></b> Following</span>
                        <span><b></b> Followers</span>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6>Account Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" id="formulario">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="<?php echo $row['email'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="<?php echo $row['username'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCity">City</label>
                                    <input type="text" class="form-control" id="inputCity" placeholder="City" name="city" value="<?php echo $row['city'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="gender">Gender</label>
                                    <select class="custom-select mr-sm-2" name="gender" id="gender">
                                        <option value="<?php echo $row['gender'] ?>" selected><?php echo $row['gender'] ?></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="datepicker">Birthday</label>
                                    <input id="datepicker" name="birthday" value="<?php echo $row['birthday'] ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName" value="<?php echo $row['firstName'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Last Name" name="lastName" value="<?php echo $row['lastName'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Describe yourself..."><?php echo $row['description'] ?></textarea>
                            </div>
                            <input type="hidden" name="id" id="id" value="<?php echo $row['id'] ?>">
                            <button type="submit" class="btn btn-primary" title="Update" name="update">Update profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php $contenido = ob_get_clean(); ?>
<?php include 'header.php' ?>