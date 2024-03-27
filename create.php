<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$artwork_title = $artist_name = $date_of_creation = $materials = "";
$artwork_title_err = $artist_name_err = $date_of_creation_err = $materials_err = "";

// Processing form data when form is submitted  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Validate artwork_title
    $input_artwork_title = trim($_POST["artwork_title"]);
    if (empty($input_artwork_title)) {
        $artwork_title_err = "Please enter Artwork Title.";
    } else {
        $artwork_title = $input_artwork_title;
    }

    // Validate Artist name
    $input_artist_name = trim($_POST["artistname"]);
    if (empty($input_artist_name)) {
        $artist_name_err = "Please enter Artist name.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $input_artist_name)) {
        $artist_name_err = "Please enter a valid Artist name.";
    } else {
        $artist_name = $input_artist_name; // Fixed variable assignment
    }

    // Validate date of creation
    $input_date_of_creation = trim($_POST["date_of_creation"]); // Corrected form field name
    if (empty($input_date_of_creation)) {
        $date_of_creation_err = "Please enter date of creation.";
    } else {
        $date_of_creation = $input_date_of_creation;
    }

    // Validate materials
    $input_materials = trim($_POST["materials"]);
    if (empty($input_materials)) {
        $materials_err = "Please enter the materials used.";
    } else {
        $materials = $input_materials;
    }

    // Check input errors before inserting in database
    if (empty($artwork_title_err) && empty($artist_name_err) && empty($date_of_creation_err) && empty($materials_err)) { // Fixed condition
        // Prepare an insert statement
        $sql = "INSERT INTO art_museum (artwork_title, artist_name, date_of_creation, materials) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_artwork_title, $param_artist_name, $param_date_of_creation, $param_materials); // Fixed parameter types

            // Set parameters
            $param_artwork_title = $artwork_title;
            $param_artist_name = $artist_name;
            $param_date_of_creation = $date_of_creation;
            $param_materials = $materials;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
            h2 {
              font-weight: bold;
              font-family: georgia;
              color:#df0c0c; 
              font-size: 36px;
                }
            p{
                font-weight: bold; 
                font-family: serif;
                font-size: 20px; 
            }
            label{
                font-weight: bold;
                font-family: serif;  
                font-size: 20px; 
            }
            .btn-primary {
    background-color: #df0c0c; 
    color: black; 
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.btn-secondary {
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.btnprimary:hover {
    background-color: #c2735e; 
}
img {
	display: block;
	margin: auto;
	width: 30%;
    border-radius: 90%;
  border: 3px solid black;
}   
   </style>
      <img src="Images/artifacts.jpeg" alt="museum",</img>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add Art museum record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Artwork Title</label>
                            <input type="text" name="artwork_title" class="form-control <?php echo (!empty($artwork_title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $artwork_title; ?>">
                            <span class="invalid-feedback"><?php echo $artwork_title_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Artist Name</label>
                            <input type="text" name="artistname" class="form-control <?php echo (!empty($artist_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $artist_name; ?>">
                            <span class="invalid-feedback"><?php echo $artist_name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Date of creation</label>
                            <input type="text" name="date_of_creation" class="form-control <?php echo (!empty($date_of_creation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_of_creation; ?>">
                            <span class="invalid-feedback"><?php echo $date_of_creation_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Materials</label>
                            <input type="text" name="materials" class="form-control <?php echo (!empty($materials_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $materials; ?>">
                            <span class="invalid-feedback"><?php echo $materials_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
 <!-- Footer Section -->
 <footer>
     <p>&copy; 2023 Historical Art Museum. All Rights Reserved by Navneet Kaur 202107781.</p>
</html>