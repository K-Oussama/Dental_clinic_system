<?php
// Include config file
require_once "../db.php";
 
// Define variables and initialize with empty values
$IDappoint = $dateAppoint  = $patient =  $TimeAppoint =  $Traitement = $dob = $description ="";
$IDappoint_err = $dateAppoint_err = $address_err = $patient_err =  $Traitement_err  =  $dob_err  = "";
  
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
  /*  $input_IDappoint = trim($_POST["id"]);
    if(empty($input_IDappoint)){
        $IDappoint_err = "Veuillez entrer un IDappoint";
    } elseif(!filter_var($input_IDappoint, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $IDappoint_err = "Veuillez entrer un IDappoint valide.";
    } else{
        $IDappoint = $input_IDappoint;
    }
    */
        // Validate dateAppoint
        $input_dateAppoint = trim($_POST["dateAppoint"]);
        if(empty($input_dateAppoint)){
            $dateAppoint_err = "Veuillez entrer un dateAppoint";
        } else{
            $dateAppoint = $input_dateAppoint;
        }
         // Validate patient
         $input_patient = trim($_POST["patient"]);
         if(empty($input_patient)){
             $patient_err = "Veuillez entrer un numero de patient.";     
         } else{
             $patient = $input_patient;
         }
        // Validate address
        $input_address = trim($_POST["TimeAppoint"]);
        if(empty($input_address)){
            $address_err = "Veuillez entrer un TimeAppoint.";     
        } else{
            $TimeAppoint = $input_address;
        }
        
        // Validate Traitement
        $input_Traitement = trim($_POST["Traitement"]);
        if(empty($input_Traitement)){
            $Traitement_err = "Veuillez entrer un Traitement.";     
        } else{
            $Traitement = $input_Traitement;
        }
    
    // Check input errors before inserting in database
    if(empty($IDappoint_err) && empty($dateAppoint_err) && empty($TimeAppoint_err)){
        // Prepare an update statement
        $sql = "UPDATE appointment SET dateAppoint=?, patient=?, TimeAppoint=?, Traitement=?  WHERE IDappoint=$id";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters $param_IDappoint,
            mysqli_stmt_bind_param($stmt, "ssss", $param_dateAppoint, $param_patient, $param_TimeAppoint, $param_Traitement);
            
            // Set parameters
            //$param_id = $id;
           // $param_IDappoint = $IDappoint;
            $param_dateAppoint = $dateAppoint;   
            $param_patient = $patient; 
            $param_TimeAppoint= $TimeAppoint;   
            $param_Traitement = $Traitement; 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: /gestion%20dentaire/RendezVous/RendezVous.php");
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
        $sql = "SELECT * FROM appointment WHERE IDappoint = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_IDappoint);
            
            // Set parameters
            $param_IDappoint = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    // $IDappoint = $row["IDappoint"];
                    $dateAppoint= $row["dateAppoint"];
                    $TimeAppoint= $row["TimeAppoint"];
                    $patient= $row["patient"];
                    $Traitement= $row["Traitement"];
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
                            <label>dateAppoint</label>
                            <input type="date" name="dateAppoint" class="form-control <?php echo (!empty($dateAppoint_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dateAppoint; ?>">
                            <span class="invalid-feedback"><?php echo $dateAppoint_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>patient</label>
                            <input type="text" name="patient" class="form-control <?php echo (!empty($patient_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $patient; ?>">
                            <span class="invalid-feedback"><?php echo $patient_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>TimeAppoint</label>
                            <textarea name="TimeAppoint" class="form-control <?php echo (!empty($TimeAppoint_err)) ? 'is-invalid' : ''; ?>"><?php echo $TimeAppoint; ?></textarea>
                            <span class="invalid-feedback"><?php echo $TimeAppoint_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Traitement</label>
                            <input name="Traitement" class="form-control <?php echo (!empty($Traitement_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Traitement; ?>"/>
                            <span class="invalid-feedback"><?php echo $Traitement_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="/gestion%20dentaire/RendezVous/RendezVous.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>