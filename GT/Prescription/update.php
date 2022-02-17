<?php
// Include config file
require_once "../db.php";
 
// Define variables and initialize with empty values
$MedPres = $PatieentPres  = $PrixPres =  $QtePres =  $TraitPres = $dob = $description ="";
$MedPres_err = $PatieentPres_err = $address_err = $PrixPres_err =  $TraitPres_err  =  $dob_err  = "";
  
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_MedPres = trim($_POST["MedPres"]);
    if(empty($input_MedPres)){
        $MedPres_err = "Veuillez entrer un MedPres";
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
        // Validate address
        $input_address = trim($_POST["QtePres"]);
        if(empty($input_address)){
            $address_err = "Veuillez entrer un QtePres.";     
        } else{
            $QtePres = $input_address;
        }
        
        // Validate TraitPres
        $input_TraitPres = trim($_POST["TraitPres"]);
        if(empty($input_TraitPres)){
            $TraitPres_err = "Veuillez entrer un TraitPres.";     
        } else{
            $TraitPres = $input_TraitPres;
        }
    
    // Check input errors before inserting in database
    if(empty($MedPres_err) && empty($PatieentPres_err) && empty($QtePres_err)){
        // Prepare an update statement
        $sql = "UPDATE prescription SET MedPres=?, PatieentPres=?, PrixPres=?, QtePres=?, TraitPres=?  WHERE IDpres=$id";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_MedPres, $param_PatieentPres, $param_PrixPres, $param_QtePres, $param_TraitPres);
            
            // Set parameters
            //$param_id = $id;
            $param_MedPres = $MedPres;
            $param_PatieentPres = $PatieentPres;   
            $param_PrixPres = $PrixPres; 
            $param_QtePres= $QtePres;   
            $param_TraitPres = $TraitPres; 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: /gestion%20dentaire/prescription/prescription.php");
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
        $sql = "SELECT * FROM prescription WHERE IDpres = ?";
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
                    $MedPres = $row["MedPres"];
                    $PatieentPres= $row["PatieentPres"];
                    $QtePres= $row["QtePres"];
                    $PrixPres= $row["PrixPres"];
                    $TraitPres= $row["TraitPres"];
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
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>MedPres</label>
                            <input type="text" name="MedPres" class="form-control <?php echo (!empty($MedPres_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MedPres; ?>">
                            <span class="invalid-feedback"><?php echo $MedPres_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>PatieentPres</label>
                            <input type="text" name="PatieentPres" class="form-control <?php echo (!empty($PatieentPres_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $PatieentPres; ?>">
                            <span class="invalid-feedback"><?php echo $PatieentPres_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>PrixPresephone</label>
                            <input type="text" name="PrixPres" class="form-control <?php echo (!empty($PrixPres_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $PrixPres; ?>">
                            <span class="invalid-feedback"><?php echo $PrixPres_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>QtePres</label>
                            <textarea name="QtePres" class="form-control <?php echo (!empty($QtePres_err)) ? 'is-invalid' : ''; ?>"><?php echo $QtePres; ?></textarea>
                            <span class="invalid-feedback"><?php echo $QtePres_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>TraitPres</label>
                            <input name="TraitPres" class="form-control <?php echo (!empty($TraitPres_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $TraitPres; ?>"/>
                            <span class="invalid-feedback"><?php echo $TraitPres_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="/gestion%20dentaire/prescription/prescription.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>