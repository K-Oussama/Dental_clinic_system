<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "../db.php";
    
    $id = $_POST["id"];

    // Prepare a delete statement
    $sql = "DELETE FROM patient WHERE ID = $id";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
       // mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters

       // $id =  trim($_GET["id"]);
     //   $param_id = $id;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: /gestion%20dentaire/patient/patient.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
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
    <title>Delete Record</title>
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
                    <h2 class="mt-5 mb-3">Supprimer Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Êtes-vous sûr de vouloir supprimer cette fiche de patient?</p>
                            <p>
                                <input type="submit" value="Oui" class="btn btn-danger">
                                <a href="/gestion%20dentaire/patient/patient.php" class="btn btn-secondary">Non</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>