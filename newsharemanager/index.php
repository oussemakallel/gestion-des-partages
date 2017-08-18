<!DOCTYPE html>
<?php
//chdir('../.') ;
require getcwd() . '/Models/Autoloader.php';
Autoloader::register();
session_start();
//remote-user matricule
//$matricule = filter_input(INPUT_SERVER, 'REMOTE_USER');
$matricule = "matricule3";
//
$u = new Personnel();
$user = $u->getActiveUser($matricule);
//$_SESSION['matricule'] = $user->getMatricule();
$_SESSION['matricule'] = $matricule;
$droit = $user->getDroit();
unset($techactive);
unset($adminactive);
unset($useractive);
if ($droit == 'Admin')
    $adminactive = 'active';
if ($droit == 'Utilisateur')
    $useractive = 'active';
if ($droit == 'Technicien')
    $techactive = 'active';
?>

<?php include "Vues/modal.html" ?>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>
            Tableau de board <?= $droit ?>
        </title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="assets/css/app.v1.css">
        <link rel="stylesheet" href="assets/css/bootstrap-glyphicons.css">
        <link rel="stylesheet" href="assets/font.css" cache="false">
        <link rel="stylesheet" href="assets/css/toastr.min.css">
        <link rel="stylesheet" href="assets/css/jquery-confirm.css">
        <link rel="stylesheet" href="assets/css/material.min.css">
        <link rel="stylesheet" href="assets/datatables/css/responsive.bootstrap.min.css">
        <link rel="stylesheet" href="assets/datatables/css/dataTables.material.min.css">

        <!--[if lt IE 9]>
                                        <script src="js/ie/respond.min.js" cache="false">
                                        </script>
                                        <script src="js/ie/html5.js" cache="false">
                                        </script>
                                        <script src="js/ie/fix.js" cache="false">
                                        </script>
                                <![endif]-->
    </head>
    <body>
        <!-- -->
        <section class="hbox stretch">
            <!-- .aside -->
            <aside class="bg-dark nav-vertical aside-sm only-icon" id="nav">
                <section class="vbox">


                    <section>
                        <!-- user -->
                        <div class="bg-dark nav-user hidden-xs pos-rlt">
                            <div class="nav-avatar pos-rlt">
                                <a  class="thumb-sm avatar animated rollIn" > 
                                    <img src="assets/images/user.jpg" alt="" class=""> <span class="caret caret-white"></span> 
                                </a>
                            </div>
                            <!---<font color="white" style="width:1px">
                        <?= $user->getPrenom()?>
                            <?= $user->getNom()?>
                               </font> -->
                        </div>
                        <!-- / user -->
                        <!-- nav -->

                        <!-- / nav -->
                        <!-- note -->
                        <!-- / note -->
                    </section>
                </section>
            </aside>
            <!-- /.aside -->
            <!-- .vbox -->
            <section id="content">
                <section class="vbox">
                    <header class="header bg-dark bg-gradient">
                        <ul class="nav nav-tabs">
<?php if (isset($adminactive)) { ?>
                                <li class="<?= $adminactive ?>">
                                    <a href="#adminrequest" data-toggle="tab">Demandes Utilisateurs</a>
                                </li>
                                <li class="">
                                    <a href="#adminshare" data-toggle="tab">Partages Actifs</a>
                                </li>
                                <li class="">
                                    <a href="#servers" data-toggle="tab">Serveurs</a>
                                </li>
                                <li class="">
                                    <a href="#tasks" data-toggle="tab">Taches</a>
                                </li>
                        <?php } elseif (isset($useractive) or isset($techactive)) { ?>
                                
                            <?php if (isset($techactive)){ ?>
                            <li class="<?= $techactive ?>">
                                    <a href="#techshare" data-toggle="tab">Partages des Personnels</a>
                                </li>
                            <?php } ?>
                                <li class="<?php if(isset($useractive)) echo $useractive;  ?>">
                                    <a href="#userrequest" data-toggle="tab">Mes Demandes</a>
                                </li>
                                <li class="">
                                    <a href="#usershare" data-toggle="tab">Mes Partages</a>
                                </li>
                            <?php }?>
                            <div class="pull-right"  style="margin:9px;">
                            <?php if (isset($adminactive)){ ?>
                                <button onclick="exectasks();" class="btn btn-primary btn-success btn-sm" style=""><span class="glyphicon glyphicon-list"></span> Execute tasks</button>
<button onclick="scandrives();" class="btn btn-primary btn-success btn-sm" style="margin-left:5px;"><span class="glyphicon glyphicon-hdd"></span>  Scan drives</button>
<button onclick="scanshares();" class="btn btn-primary btn-success btn-sm" style="margin-left:5px;margin-right:10px;"><span class="glyphicon glyphicon-folder-close"></span> Scan Shares</button>
                                <?php } ?>
                            <font color="white" class="margin-right:25px"><i class="glyphicon glyphicon-user" aria-hidden="true" style="margin-right:7px"></i>Bonjour, 
                            <?= $user->getPrenom() ?> <?= $user->getNom() ?></font>
                        </div>
                                </ul>
                            
                        
                    </header>
                    <section class="scrollable wrapper">
                        <div class="tab-content">
                            <?php
                            if (isset($adminactive)) {
                                include "Vues/admin.php";
                            } elseif (isset($useractive)) {
                                include "Vues/user.php";
                            } else {
                                include "Vues/tech.php";
                                include "Vues/user.php";
                            }
                            ?>
                        </div>
                    </section>
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="body"></a>
            </section>
            <!-- /.vbox -->
        </section>
        <script src="assets/css/app.v1.js"></script>
        <script src="assets/js/toastr.min.js"></script>
        <script src="assets/js/jquery.form.js"></script>
        <script src="assets/js/jquery-confirm.js"></script>
        <script src="assets/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/js/dataTables.material.min.js"></script>
        <script src="assets/datatables/js/dataTables.responsive.min.js"></script>
        <script src="assets/js/script.js"></script>
        <!-- Bootstrap -->
        <!-- Sparkline Chart -->
        <!-- App -->
    </body>

</html>