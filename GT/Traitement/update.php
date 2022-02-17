<?php
// Include config file
require_once "../db.php";
 
// Define variables and initialize with empty values
$nom = $Medicament  = $prix  ="";
$nom_err = $Medicament_err = $prix_err = "";
  
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_nom = trim($_POST["nom"]);
    if(empty($input_nom)){
        $nom_err = "Veuillez entrer un nom";
    } else{
        $nom = $input_nom;
    }
        // Validate Medicament
        $input_Medicament = trim($_POST["Medicament"]);
        if(empty($input_Medicament)){
            $Medicament_err = "Veuillez entrer un Medicament";
        } else{
            $Medicament = $input_Medicament;
        }
         // Validate prix
         $input_prix = trim($_POST["prix"]);
         if(empty($input_prix)){
             $prix_err = "Veuillez entrer un numero de prix.";     
         } else{
             $prix = $input_prix;
         }
        
    // Check input errors before inserting in database
    if(empty($nom_err) && empty($Medicament_err) && empty($adresse_err)){
        // Prepare an update statement
        $sql = "UPDATE traitement SET Nom=?, Medicament=?, prix=? WHERE IDtraite=$id";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_nom, $param_Medicament, $param_prix);
            
            // Set parameters
            //$param_id = $id;
            $param_nom = $nom;
            $param_Medicament = $Medicament;   
            $param_prix = $prix; 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: /gestion%20dentaire/Traitement/Traitement.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM traitement WHERE IDtraite = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $nom = $row["nom"];
                    $Medicament= $row["Medicament"];
                    $prix= $row["prix"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: /gestion%20dentaire/error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: /gestion%20dentaire/error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Veuillez modifier les valeurs d'entrée et soumettre pour mettre à jour l'enregistrement de l'employé.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control <?php echo (!empty($nom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nom; ?>">
                            <span class="invalid-feedback"><?php echo $nom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Medicament</label>
                            <input type="text" name="Medicament" class="form-control <?php echo (!empty($Medicament_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Medicament; ?>">
                            <span class="invalid-feedback"><?php echo $Medicament_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>prix</label>
                            <input type="text" name="prix" class="form-control <?php echo (!empty($prix_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prix; ?>">
                            <span class="invalid-feedback"><?php echo $prix_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="/gestion%20dentaire/traitement/traitement.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>