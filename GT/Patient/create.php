<?php
// Include config file
require_once "../db.php";
 
// Define variables and initialize with empty values
$nom = $prenom  = $tel =  $adresse =  $sexe = $dob = $description ="";
$nom_err = $prenom_err = $address_err = $tel_err =  $sexe_err  =  $dob_err  = "";
 
// find next ID
        // vALIDATE id
        $ID = 0;
        $sql = "SELECT MAX(ID) from patient";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $ID = $row['MAX(ID)']+1;
        $ID = (int)$ID;
       // mysqli_free_result($result);
       // mysqli_close($link);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_nom = trim($_POST["nom"]);
    if(empty($input_nom)){
        $nom_err = "Veuillez entrer un nom";
    } elseif(!filter_var($input_nom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nom_err = "Veuillez entrer un nom valide.";
    } else{
        $nom = $input_nom;
    }
        // Validate prenom
    $input_prenom = trim($_POST["prenom"]);
    if(empty($input_prenom)){
        $prenom_err = "Veuillez entrer un prenom";
    } elseif(!filter_var($input_prenom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $prenom_err = "Veuillez entrer un prenom valide.";
    } else{
        $prenom = $input_prenom;
    }
     // Validate tel
     $input_tel = trim($_POST["tel"]);
     if(empty($input_tel)){
         $tel_err = "Veuillez entrer un numero de tel.";     
     } else{
         $tel = $input_tel;
     }
    // Validate address
    $input_address = trim($_POST["adresse"]);
    if(empty($input_address)){
        $address_err = "Veuillez entrer un adresse.";     
    } else{
        $adresse = $input_address;
    }
    
    // Validate sexe
    $input_sexe = trim($_POST["sexe"]);
    if(empty($input_sexe)){
        $sexe_err = "Veuillez entrer un sexe.";     
    } else{
        $sexe = $input_sexe;
    }
        // Validate dob
    $input_dob = trim($_POST["dob"]);
    //if(empty($input_dob)){
    //    $dob_err = "Veuillez entrer un dob.";     
    //} else{
        $dob = $input_dob;
    //}
        // Validate description
    $input_description = trim($_POST["description"]);
        $description = $input_description;
    
        

    // Check input errors before inserting in database
    if(empty($nom_err) && empty($prenom_err) && empty($sexe_err) && empty($address_err) && empty($tel_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO patient (ID, nom, prenom, tel, adresse, sexe, dob, description) VALUES (?,?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssssss", $param_ID, $param_nom, $param_prenom, $param_tel, $param_adresse, $param_sexe, $param_dob, $param_description);
            
            // Set parameters
            $param_ID = $ID;
            $param_nom = $nom;
            $param_prenom = $prenom;   
            $param_tel = $tel; 
            $param_adresse= $adresse;   
            $param_sexe = $sexe;
            $param_dob = $dob;
            $param_description = $description;    

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: /gestion%20dentaire/patient/patient.php");
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
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control <?php echo (!empty($nom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nom; ?>">
                            <span class="invalid-feedback"><?php echo $nom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>prenom</label>
                            <input type="text" name="prenom" class="form-control <?php echo (!empty($prenom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prenom; ?>">
                            <span class="invalid-feedback"><?php echo $prenom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>telephone</label>
                            <input type="text" name="tel" class="form-control <?php echo (!empty($tel_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tel; ?>">
                            <span class="invalid-feedback"><?php echo $tel_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>description</label>
                            <input type="text" name="description" class="form-control" value="<?php echo $description; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>adresse</label>
                            <textarea name="adresse" class="form-control <?php echo (!empty($adresse_err)) ? 'is-invalid' : ''; ?>"><?php echo $adresse; ?></textarea>
                            <span class="invalid-feedback"><?php echo $adresse_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>sexe</label>
                            <input name="sexe" class="form-control <?php echo (!empty($sexe_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sexe; ?>"/>
                            <span class="invalid-feedback"><?php echo $sexe_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>dob</label>
                            <input type="date" name="dob" class="form-control <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dob; ?>">
                            <span class="invalid-feedback"><?php echo $dob_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="patient.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    
</body>
</html>