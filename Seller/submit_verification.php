<?php
include '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $disability_type = $_POST['disability_type'];
    $user_id = $_SESSION['user_id'];
    $bank_name = $_POST['bank_name'];
    $bank_account_number = $_POST['bank_account_number'];

    // File Upload Handling
    $target_dir = "uploads/"; // Directory where documents will be stored
    $target_file = $target_dir . basename($_FILES["document"]["name"]);

    if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
        // Store the file path in the database
        $query = "INSERT INTO user_details (user_id, name, dob,gender, address, disability_type, document,bank_name,bank_account_number) VALUES (?, ?,?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssssss", $user_id, $name, $dob,$gender, $address, $disability_type, $target_file, $bank_name, $bank_account_number);

        if ($stmt->execute()) {
            $conn->query("UPDATE users SET status='submitted' WHERE id=$user_id");
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error submitting details: " . $stmt->error;
        }
    } else {
        echo "File upload failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }
        h2 {
            margin-bottom: 15px;
            color: #333;
        }
        input, button {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="file"] {
            border: none;
        }
        button {
            background-color: #00437a;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Submit Verification Details</h2>
    <form method="POST" action="submit_verification.php" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name" required>
        <input type="date" name="dob" required>
        <input type="text" name="gender" placeholder="Gender" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="disability_type" placeholder="Disability Type" required>
        <input type="file" name="document" required>
        <input type="text" name="bank_name" placeholder="Bank Name" required>
        <input type="text" name="bank_account_number" placeholder="Bank Account No." required>
        <button type="submit">Submit</button>
    </form>
    <a href="../index.php">Go to Home</a>
</div>

</body>
</html>
