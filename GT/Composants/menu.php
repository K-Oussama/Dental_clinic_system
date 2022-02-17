<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: Auth.php");
    exit;
}
?>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="/gestion%20dentaire/css/Style.css"/>
  <link rel="stylesheet" href="font-awesome.min.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="/gestion%20dentaire/js/menu.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
<!-- Vertical navbar -->
<div class="vertical-nav bg-white" id="sidebar">
<button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4" style="left: 350px;width: 130px;"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Toggle</small></button>
  <div class="py-4 px-3 mb-4 bg-light">
    <div class="media d-flex align-items-center"><img src="/gestion%20dentaire/img/64logo.png" alt="PHP-Examen" width="74" style="border-radius: 30%!important;" class="mr-3 rounded-circle img-thumbnail shadow-sm">
      <div class="media-body">
        <h4 class="m-0"><?php echo htmlspecialchars($_SESSION["username"]); ?></h4>
        <p class="font-weight-light text-muted mb-0">Utilisateur</p>
      </div>
    </div>
  </div>
  <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Services</p>

  <ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
      <a href="/gestion%20dentaire/index.php" class="nav-link text-dark font-italic bg-light">
                <i class="fa fa-th-large mr-3 text-primary fa-fw"></i>
                Acceuil
            </a></li>
    <li class="nav-item">
      <a href="/gestion%20dentaire/Patient/Patient.php" class="nav-link text-dark font-italic">
                <i class="fa fa-address-card mr-3 text-primary fa-fw"></i>
                Patients
            </a></li>
    <li class="nav-item">
      <a href="/gestion%20dentaire/Traitement/Traitement.php" class="nav-link text-dark font-italic">
                <i class="fa fa-cubes mr-3 text-primary fa-fw"></i>
                Traitement
            </a></li>
    <li class="nav-item">
      <a href="/gestion%20dentaire/RendezVous/RendezVous.php" class="nav-link text-dark font-italic">
                <i class="fa fa-picture-o mr-3 text-primary fa-fw"></i>
                Rendez-vous
            </a></li>
    <li class="nav-item">
      <a href="/gestion%20dentaire/Prescription/Prescription.php" class="nav-link text-dark font-italic">
                <i class="fa fa-picture-o mr-3 text-primary fa-fw"></i>
                Prescription
            </a></li>
  </ul>

  <p class="text-gray font-weight-bold text-uppercase px-3 small py-4 mb-0">Compte</p>

  <ul class="nav flex-column bg-white mb-0">
    <li class="nav-item" style="display: none;">
      <a href="/gestion%20dentaire/reset.php" class="nav-link text-dark font-italic">
                <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
                réinitialiser le mot de passe
            </a></li>
    <li class="nav-item">
      <a href="/gestion%20dentaire/deconnecter.php" class="nav-link text-dark font-italic">
                <i class="fa fa-bar-chart mr-3 text-primary fa-fw"></i>
                Deconnecter
            </a></li>
  </ul>
</div>
<!-- End vertical navbar -->