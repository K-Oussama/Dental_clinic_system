<?php
// Include config file
require_once "../db.php";
 
// Define variables and initialize with empty values
$dateAppoint = $patient  = $TimeAppoint =  $Traitement =  $sexe = $dob = $description ="";
$dateAppoint_err = $patient_err = $address_err = $TimeAppoint_err =  $sexe_err  =  $dob_err  = "";
 
// find next ID
        // vALIDATE id
        $ID = 0;
        $sql = "SELECT MAX(IDappoint) from appointment";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $ID = $row['MAX(IDappoint)']+1;
        $ID = (int)$ID;
       // mysqli_free_result($result);
       // mysqli_close($link);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_dateAppoint = trim($_POST["dateAppoint"]);
    if(empty($input_dateAppoint)){
        $dateAppoint_err = "Veuillez entrer un dateAppoint";
    } else{
        $dateAppoint = $input_dateAppoint;
    }
        // Validate patient
    $input_patient = trim($_POST["patient"]);
    if(empty($input_patient)){
        $patient_err = "Veuillez entrer un patient";
    } elseif(!filter_var($input_patient, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $patient_err = "Veuillez entrer un patient valide.";
    } else{
        $patient = $input_patient;
    }
     // Validate TimeAppoint
     $input_TimeAppoint = trim($_POST["TimeAppoint"]);
     if(empty($input_TimeAppoint)){
         $TimeAppoint_err = "Veuillez entrer un numero de TimeAppoint.";     
     } else{
         $TimeAppoint = $input_TimeAppoint;
     }
    // Validate address
    $input_address = trim($_POST["Traitement"]);
    if(empty($input_address)){
        $address_err = "Veuillez entrer un Traitement.";     
    } else{
        $Traitement = $input_address;
    }
    
        

    // Check input errors before inserting in database
    if(empty($dateAppoint_err) && empty($patient_err) && empty($sexe_err) && empty($address_err) && empty($TimeAppoint_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO appointment (IDappoint, dateAppoint, patient, TimeAppoint, Traitement) VALUES ( ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issss", $param_ID, $param_dateAppoint, $param_patient, $param_TimeAppoint, $param_Traitement);
            
            // Set parameters
            $param_ID = $ID;
            $param_dateAppoint = $dateAppoint;
            $param_patient = $patient;   
            $param_TimeAppoint = $TimeAppoint; 
            $param_Traitement= $Traitement;      

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: /gestion%20dentaire/RendezVous/RendezVous.php");
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
                            <label>date</label> <!-- placeholder="dd-mm-yyyy" -->
                            <input type="date" name="dateAppoint" class="form-control <?php echo (!empty($dateAppoint_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dateAppoint; ?>">
                            <span class="invalid-feedback"><?php echo $dateAppoint_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>patient</label>
                            <input type="text" name="patient" class="form-control <?php echo (!empty($patient_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $patient; ?>">
                            <span class="invalid-feedback"><?php echo $patient_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Temps</label>
                            <input type="text" name="TimeAppoint" class="form-control <?php echo (!empty($TimeAppoint_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $TimeAppoint; ?>">
                            <span class="invalid-feedback"><?php echo $TimeAppoint_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Traitement</label>
                            <input name="Traitement" class="form-control <?php echo (!empty($Traitement_err)) ? 'is-invalid' : ''; ?>"><?php echo $Traitement; ?></input>
                            <span class="invalid-feedback"><?php echo $Traitement_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="/gestion%20dentaire/RendezVous/RendezVous.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    
</body>
</html>