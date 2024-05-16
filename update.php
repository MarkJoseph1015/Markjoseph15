<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Updating Student Information</title>
  <style>
    body {
      background-color: #D3E9D3;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }
    .container {
      width: 50%;
      margin: 50px auto;
    }
    h2 {
      text-align: center;
    }
    form {
      background-color: #76B773;
      padding: 20px;
      border-radius: 10px;
    }
    input[type="text"], input[type="submit"], input[type="reset"], input[type="button"] {
      width: calc(100% - 40px);
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid white;
      border-radius: 5px;
      color: black;
      font-weight: bolder;
      font-family: 'Poppins', sans-serif;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease, font-weight 0.3s ease, color 0.3s ease; /* Added transition for font-weight and color */
    }
    input[type="text"]:focus {
      outline: none;
    }
    input[type="submit"], input[type="reset"] {
      background-color: #09B502 ; /* Red for Add */
    }
    input[type="submit"]:hover, input[type="reset"]:hover {
      background-color: lightgreen; /* Lighter Red for Add hover */
    }
    input[type="button"] {
      background-color: #575F57; /* Light Gray for Back */
      color: white; /* Text color white for Back */
      font-weight: normal; /* Reset font weight */
    }
    input[type="button"]:hover {
      background-color: #254524 ; /* Lighter Gray for Back hover */
    }
    .button-container {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Update Information</h2>
    <form method="post">
      <h3>Name of Student</h3> <br>
      <div class="row">
        <?php
        // Include db.php for database connection
        include 'db.php';

        // Initialize variables to store student information
        $student_id = $firstname = $middlename = $lastname = $suffix = $course = $year_section = '';

        // Check if student ID is provided via GET request
        if(isset($_GET['student_id'])) {
            $id = $_GET['student_id'];

            // Execute SQL query to select user information
            $sql = "SELECT * FROM students WHERE student_id = $id";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    // Assign user information to variables
                    $student_id = $row["student_id"];
                    $firstname = $row["firstname"];
                    $middlename = $row["middlename"];
                    $lastname = $row["lastname"];
                    $suffix = $row["suffix"];
                    $course = $row["course"];
                    $year_section = $row["year_section"];
                } else {
                    echo "No student found with the given ID.";
                    exit(); // Stop script execution if ID not found
                }
            } else {
                echo "Error executing query: " . mysqli_error($conn); // Display error if query fails
                exit();
            }
        } else {
            echo "No ID provided.";
            exit();
        }

        // Close connection
        mysqli_close($conn);
        ?>
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        <div class="one">
          <label for="fname">First Name:</label> <br>
          <input type="text" name="firstname" value="<?php echo $firstname; ?>">
        </div>
        <div class="one">
          <label for="mname">Middle Name:</label> <br>
          <input type="text" name="middlename" value="<?php echo $middlename; ?>">
        </div>
        <div class="one">
          <label for="lname">Last Name:</label> <br>
          <input type="text" name="lastname" value="<?php echo $lastname; ?>">
        </div>
      </div>
      <div>
        <label for="suffix">Suffix:</label> <br>
        <input type="text" name="suffix" value="<?php echo $suffix; ?>">
      </div>
      <div class="row">
        <div class="one">
          <label for="course">Course:</label> <br>
          <input type="text" name="course" value="<?php echo $course; ?>">
        </div>
        <div class="one">
          <label for="year_section">Year And Section:</label> <br>
          <input type="text" name="year_section" value="<?php echo $year_section; ?>">
        </div>
      </div>

      <div class="button-container">
        <input type="submit" name="update" value="Update">
        <input type="reset" value="Clear">
        <a href="home.php"><input type="button" value="Back"></a>
      </div>
    </form>

    <?php
    // Check if the form is submitted for updating
    if(isset($_POST['update'])) {
        // Include dbstudents.php for database connection
        include 'db.php';

        // Collect form data
        $student_id = $_POST['student_id'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $suffix = $_POST['suffix'];
        $course = $_POST['course'];
        $year_section = $_POST['year_section'];

        // Prepare and execute SQL query for update
        $sql = "UPDATE students SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', course='$course', year_section='$year_section' WHERE student_id = '$student_id'";
        if (mysqli_query($conn, $sql)) {
          echo "<script>alert('Data updated successfully!');</script>";
          // Refresh the page to reflect updated data
          echo "<meta http-equiv='refresh' content='0'>";
        } else {
          echo "Error updating data: " . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
    ?>
  </div>
</body>
</html>
