<?php
// Include config file
require_once "../db.php";
 
// Define variables and initialize with empty values
$MedPres = $PatieentPres  = $PrixPres =  $QtePres =  $TraitPres = "";
$MedPres_err = $PatieentPres_err = $PrixPres_err =  $TraitPres_err  =  $QtePres_err = "";
 
// find next ID
        // vALIDATE id
        $ID = 0;
        $sql = "SELECT MAX(IDpres) from prescription";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $ID = $row['MAX(IDpres)']+1;
        $ID = (int)$ID;
       // mysqli_free_result($result);
       // mysqli_close($link);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_MedPres = trim($_POST["MedPres"]);
    if(empty($input_MedPres)){
        $MedPres_err = "Veuillez entrer un MedPres";
    } elseif(!filter_var($input_MedPres, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $MedPres_err = "Veuillez entrer un MedPres valide.";
    } else{
        $MedPres = $input_MedPres;
    }
        // Validate PatieentPres
    $input_PatieentPres = trim($_POST["PatieentPres"]);
    if(empty($input_PatieentPres)){
        $PatieentPres_err = "Veuillez entrer un PatieentPres";
    } elseif(!filter_var($input_PatieentPres, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $PatieentPres_err = "Veuillez entrer un PatieentPres valide.";
    } else{
        $PatieentPres = $input_PatieentPres;
    }
     // Validate PrixPres
     $input_PrixPres = trim($_POST["PrixPres"]);
     if(empty($input_PrixPres)){
         $PrixPres_err = "Veuillez entrer un numero de PrixPres.";     
     } else{
         $PrixPres = $input_PrixPres;
     }
    // Validate QtePres
    $input_QtePres = trim($_POST["QtePres"]);
    if(empty($input_QtePres)){
        $QtePres_err = "Veuillez entrer un QtePres.";     
    } else{
        $QtePres = $input_QtePres;
    }
    
    // Validate TraitPres
    $input_TraitPres = trim($_POST["TraitPres"]);
    if(empty($input_TraitPres)){
        $TraitPres_err = "Veuillez entrer un TraitPres.";     
    } else{
        $TraitPres = $input_TraitPres;
    }
     

    // Check input errors before inserting in database
    if(empty($MedPres_err) && empty($PatieentPres_err) && empty($PrixPres_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO prescription (IDpres, MedPres, PatieentPres, PrixPres, QtePres, TraitPres) VALUES ( ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssss", $param_ID, $param_MedPres, $param_PatieentPres, $param_PrixPres, $param_QtePres, $param_TraitPres);
            
            // Set parameters
            $param_ID = $ID;
            $param_MedPres = $MedPres;
            $param_PatieentPres = $PatieentPres;   
            $param_PrixPres = $PrixPres; 
            $param_QtePres= $QtePres;   
            $param_TraitPres = $TraitPres;
            //$param_dob = $dob;
            //$param_description = $description;    

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: /gestion%20dentaire/Prescription/Prescription.php");
                exit();
            } else{
                echo "Quelque chose s'est mal passé. Veuillez réessayer plus tard";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        body {background: #fff !important;}
        #sidebarCollapse{display: none;}
    </style>
</head>
<body>
<?php include('../Composants/menu.php'); ?>

        <div id="content" class="wrapper page-content-crud">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Créer un enregistrement</h2>
                    <?php // echo $ID; ?>
                    <p>Veuillez remplir ce formulaire et le soumettre pour ajouter un dossier d'employé à la base de données.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>prescription</label>
                            <textarea type="text" name="MedPres" class="form-control <?php echo (!empty($MedPres_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MedPres; ?>"></textarea>
                            <span class="invalid-feedback"><?php echo $MedPres_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Patient</label>
                            <input type="text" name="PatieentPres" class="form-control <?php echo (!empty($PatieentPres_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $PatieentPres; ?>">
                            <span class="invalid-feedback"><?php echo $PatieentPres_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Prix</label>
                            <input type="text" name="PrixPres" class="form-control <?php echo (!empty($PrixPres_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $PrixPres; ?>">
                            <span class="invalid-feedback"><?php echo $PrixPres_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Quantite</label>
                            <input name="QtePres" class="form-control <?php echo (!empty($QtePres_err)) ? 'is-invalid' : ''; ?>"><?php echo $QtePres; ?></input>
                            <span class="invalid-feedback"><?php echo $QtePres_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Traitement</label>
                            <input name="TraitPres" class="form-control <?php echo (!empty($TraitPres_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $TraitPres; ?>"/>
                            <span class="invalid-feedback"><?php echo $TraitPres_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="Prescription.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    
</body>
</html>