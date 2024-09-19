<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
// Prevent direct access to this file
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.0 403 Forbidden');
    exit('Access Forbidden');
}

$error = null;  // Initialize $error to avoid warnings
$success = null;

// Database connection parameters
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'post_job_db';
$port = 3306;
$socket='/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port, $socket);

// Check connection
if ($conn->connect_error) {
    $error = "Connection failed: " . $conn->connect_error;
}
else{

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $post_applied_for = $_POST['post_applied_for'];
    $post_reference = $_POST['post_reference'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $home_address = $_POST['home_address'];
    $next_of_kin = $_POST['next_of_kin'];
    $date_of_birth = $_POST['date_of_birth'];
    $post_code = $_POST['post_code'];
    $home_telephone = $_POST['home_telephone'];
    $work_telephone = $_POST['work_telephone'];
    $mobile_number = $_POST['mobile_number'];
    $ring_at_work = ($_POST['ring_at_work']=== 'Yes') ? 1 : 0;
    $related_to_employee = ($_POST['related_to_employee'] === 'Yes') ? 1 : 0;
    $related_details = $_POST['related_details'];
    $employer = $_POST['employer'];
    $employment_from = $_POST['employment_from'];
    $employment_to = $_POST['employment_to'];
    $job_title_duties = $_POST['job_title_duties'];
    $salary = $_POST['salary'];
    $voluntary_work = $_POST['voluntary_work'];
    $health_mental = ($_POST['health_mental'] === 'Yes') ? 1 : 0;
    $reference_1 = $_POST['reference_1'];
    $reference_2 = $_POST['reference_2'];
    $health_absences = $_POST['health_absences'];
    $health_allergies = ($_POST['health_allergies']=== 'Yes') ? 1 : 0;
    $health_conditions = ($_POST['health_conditions']=== 'Yes') ? 1 : 0;
    $health_mental = ($_POST['health_mental']=== 'yes') ? 1 : 0;
    $health_back_problems = ($_POST['health_back_problems']=== 'Yes') ? 1 : 0;
    $health_stomach = ($_POST['health_stomach']=== 'Yes') ? 1 : 0;
    $additional_info = $_POST['additional_info'];
    $driving_licence = ($_POST['driving_licence']) ? 1 : 0;

    // Prepare SQL statement for main application data
    $sql = "INSERT INTO job_applications (post_applied_for, post_reference, first_name, last_name, home_address, next_of_kin, date_of_birth, post_code, home_telephone, work_telephone, mobile_number, ring_at_work, related_to_employee, related_details, employer, employment_from, employment_to, job_title_duties, salary, voluntary_work, reference_1, reference_2, health_absences, health_allergies, health_conditions, health_mental, health_back_problems, health_stomach, additional_info, driving_licence)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssssssssssssssss", 
        $post_applied_for, $post_reference, $first_name, $last_name, $home_address, 
        $next_of_kin, $date_of_birth, $post_code, $home_telephone, $work_telephone, 
        $mobile_number, $ring_at_work, $related_to_employee, $related_details, 
        $employer, $employment_from, $employment_to, $job_title_duties, $salary, 
        $voluntary_work, $reference_1, $reference_2, $health_absences, $health_allergies, 
        $health_conditions, $health_mental, $health_back_problems, $health_stomach, 
        $additional_info, $driving_licence
    );

    // Execute the statement
    if ($stmt->execute()) {
        $application_id = $stmt->insert_id;  // Get the ID of the inserted application

        // Handle multiple education entries
        if (isset($_POST['additional_education']) && is_array($_POST['additional_education'])) {
            $education_sql = "INSERT INTO education_details (application_id, education, from_date, to_date, qualification)
                              VALUES (?, ?, ?, ?, ?)";
            $education_stmt = $conn->prepare($education_sql);

            for ($i = 0; $i < count($_POST['additional_education']); $i++) {
                $education = $_POST['additional_education'][$i];
                $from_date = $_POST['education_from'][$i];
                $to_date = $_POST['education_to'][$i];
                $qualification = $_POST['education_qualification'][$i];

                $education_stmt->bind_param("issss", $application_id, $education, $from_date, $to_date, $qualification);
                $education_stmt->execute();
            }

            $education_stmt->close();
        }

        $success = 'Application submitted successfully';
    } else {
        $error = "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
</head>
<body>
    <?php if ($error): ?>
        <script>alert("<?php echo $error; ?>");</script>
    <?php elseif ($success): ?>
        <script>alert("<?php echo $success; ?>");</script>
    <?php endif; ?>

</body>
</html>