<?php
// Include config file
require_once "../db.php";
 
// Define variables and initialize with empty values
$nom = $Medicament  = $prix = "";
$nom_err = $Medicament_err = $prix_err = "";
 
// find next ID
        // vALIDATE id
        $ID = 0;
        $sql = "SELECT MAX(IDtraite) from traitement";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $ID = $row['MAX(IDtraite)']+1;
        $ID = (int)$ID;
       // mysqli_free_result($result);
       // mysqli_close($link);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
    if(empty($nom_err) && empty($Medicament_err) && empty($prix_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO traitement (IDtraite, nom, Medicament, prix) VALUES (? ,?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isss", $param_ID, $param_nom, $param_Medicament, $param_prix);
            
            // Set parameters
            $param_ID = $ID;
            $param_nom = $nom;
            $param_Medicament = $Medicament;   
            $param_prix = $prix;    

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: /gestion%20dentaire/Traitement/Traitement.php");
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
    <title>Creer enregistrement</title>
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
                    <?php echo $ID; ?>
                    <p>Veuillez remplir ce formulaire et le soumettre pour ajouter un dossier d'employé à la base de données.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nom Traitement</label>
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="/gestion%20dentaire/Traitement/Traitement.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    
</body>
</html>