<?php ob_start();
if (count($parametros['datos']) == 1) {
    foreach ($parametros['datos'] as $datos) {
    }
    if ($datos['username'] != $_SESSION['username']) { ?>
        <div class="container border" style="max-width: 600px; max-height: 600px;">
            <div class="row" style="height: 250px; position:relative">
                <img src="<?php echo $datos['coverPhoto'] ?>" alt="" class="w-100 h-100" data-toggle="modal" data-target=".modalCover" style="cursor: pointer; ">
                <div class="modal fade modalCover" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="height: 750px">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <img src="<?php echo $datos['coverPhoto'] ?>" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
                <img src="<?php echo $datos['photo'] ?>" alt="" width="120px" height="120px" style="position: absolute; bottom: 0; margin: 0 0 10px 10px; border: 3px solid #fff; border-radius: 50%; cursor: pointer;">
            </div>

            <div class="row p-3" style="min-height: 200px">
                <div class="w-100 d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <h4 class="mt-2">
                            <b><?php echo $datos['firstName'];
                                if ($datos['verified'] == 'yes') {
                                    echo "<img src='web/img/check.png' width='18px' height='18px' class='ml-1'>";
                                } ?></b>
                        </h4>
                        <p>
                            @<?php echo $datos['username'] ?>
                        </p>
                    </div>
                    <div>
                        <?php echo $parametros['botonFollow']; ?>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <div>
                        <p><?php echo $datos['description'] ?></p>
                    </div>
                    <div class="d-flex">
                        <?php echo $datos['city'] != '' ? "<span><i class='fas fa-map-marker-alt mr-2'></i>" . $datos['city'] . "</span>" : '' ?></span>
                        <span class="ml-2"><i class="fas fa-calendar-alt mr-2"></i>Joined <?php $date = new DateTime($datos['joinDate']);
                                                                                            echo $date->format('M Y') ?></span>
                    </div>
                    <div class="d-flex mt-3">
                        <span class="mr-3"><b><?php echo $datos['numberFollowing'] ?></b> Following</span>
                        <span><b id="followers"><?php echo $datos['numberFollowers'] ?></b> Followers</span>
                    </div>
                </div>
            </div>
        </div>

        <!--   Recogemos contenido para mostrarlo con el header -->
<?php } else {
        header('Location: index.php?action=profile');
    }
} else {
    echo "<div class='text-center mt-4'><h3>The user doesn't exists!</h3><p>Try to search another...</p></div>";
}
$contenido = ob_get_clean(); ?>
<?php include 'header.php' ?>