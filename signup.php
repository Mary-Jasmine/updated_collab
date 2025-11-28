<?php
require_once 'config.php';

$SITE_KEY = "6LfgmRcsAAAAAJk-fO9sSGO-4uFJ8dOq2XzgstCj";
$SECRET_KEY = "6LfgmRcsAAAAAD4MR1htN3z3f9lypLB3Z7ctJI-M";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  
    $captcha = $_POST['g-recaptcha-response'] ?? '';
    if (!$captcha) {
        $error = "Please verify you are not a robot.";
    } else {
        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$SECRET_KEY&response=$captcha");
        $response = json_decode($verify);
        if (!$response->success) {
            $error = "Captcha verification failed!";
        }
    }

    if (!isset($error)) {
        $full_name = sanitizeInput($_POST['fullName']);
        $email = sanitizeInput($_POST['emailAddress']);
        $contact_number = sanitizeInput($_POST['contactNumber']);
        $barangay = sanitizeInput($_POST['barangay']);
        $sex = sanitizeInput($_POST['sex']);
        $age_group = sanitizeInput($_POST['age']);
        $password = password_hash($_POST['regPassword'], PASSWORD_DEFAULT);

        $idFile = $_FILES['validId'] ?? null;
        if ($idFile) {
            $allowed = ['image/jpeg', 'image/png'];
            if (!in_array($idFile['type'], $allowed)) {
                $error = "Invalid ID image format.";
            } elseif ($idFile['size'] > 5*1024*1024) {
                $error = "ID image too large (max 5MB).";
            } else {
                $upload_dir = "uploads/ids/";
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

                $uniqueName = uniqid() . "_" . basename($idFile['name']);
                move_uploaded_file($idFile['tmp_name'], $upload_dir . $uniqueName);
            }
        } else {
            $error = "Please upload a valid ID.";
        }
    }

    if (!isset($error)) {
        $database = new Database();
        $db = $database->getConnection();

        try {
            $query = "INSERT INTO users 
                (full_name, email, password, contact_number, barangay, sex, age_group, id_photo)
                VALUES 
                (:full_name, :email, :password, :contact_number, :barangay, :sex, :age_group, :id_photo)";

            $stmt = $db->prepare($query);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':contact_number', $contact_number);
            $stmt->bindParam(':barangay', $barangay);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':age_group', $age_group);
            $stmt->bindParam(':id_photo', $uniqueName);

            if ($stmt->execute()) {
                header("Location: index.php?registered=1");
                exit();
            }

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "Email already exists!";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Municipality Incident Reporting - Register</title>
<link rel="stylesheet" href="style.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<style>
    /* Hide the real file input */
#validId {
    opacity: 0;
    position: absolute;
    z-index: -1;
}

/* Wrapper for layout */
.file-upload-wrapper {
    position: relative;
    margin-bottom: 15px;
}

/* Custom black upload button */
.custom-file-btn {
    display: inline-block;
    background-color: whitesmoke;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: 0.2s ease;
    margin-top: 5px;
    border-color: #1e1a1aff;
}

.custom-file-btn:hover {
    background: #cccbcbff;
}

/* Optional: show file name */
.file-selected-name {
    margin-left: 10px;
    font-size: 14px;
    color: #444;
}

</style>
<body class="register-page">
<div class="register-container">
    <div class="register-card">
        <div class="app-header">
            <h1 class="app-title">Municipality Incident Reporting</h1>
            <p class="app-subtitle">Web-App</p>
            <div class="app-logo"><img src="logowo.png" alt=""></div>
        </div>
        
        <h2 class="register-title">Create Your Account</h2>
        <p class="register-subtitle">Join us to report incidents and help build a safer, more responsive community.</p>
        
        <?php if (isset($error)): ?>
            <div class="error-message" style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form class="register-form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullName" required>
            </div>
            
            <div class="form-group">
                <label for="emailAddress">Email Address</label>
                <input type="email" id="emailAddress" name="emailAddress" required>
            </div>
            
            <div class="form-group">
                <label for="contactNumber">Contact Number</label>
                <input type="tel" id="contactNumber" name="contactNumber" required>
            </div>
            
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <input type="text" id="barangay" name="barangay" required>
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="sex">Sex</label>
                    <select id="sex" name="sex" required>
                        <option value="">Choose</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group half">
                    <label for="age">Age</label>
                    <select id="age" name="age" required>
                        <option value="">Choose</option>
                        <option value="18-25">18-25</option>
                        <option value="26-35">26-35</option>
                        <option value="36-45">36-45</option>
                        <option value="46-55">46-55</option>
                        <option value="56+">56+</option>
                    </select>
                </div>
            </div>

            
            <div class="form-group file-upload-wrapper">
                <label for="validId">Upload Valid ID</label>

                <label for="validId" class="custom-file-btn">Choose File</label>
                <span class="file-selected-name">No file chosen</span>

                <input type="file" id="validId" name="validId" accept="image/*" required>
            </div>


            <div class="captcha-group" style="margin-left: 10%;">
            <div class="g-recaptcha" data-sitekey="<?php echo $SITE_KEY; ?>"></div>
            </div>

            <div class="form-group">
                <label for="regPassword">Password</label>
                <input type="password" id="regPassword" name="regPassword" placeholder="Create a strong password" required>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter your password" required>
            </div>
            
            <button type="submit" class="signup-btn">Sign Up</button>
            <p class="login-link">Already have an account? <a href="index.php">Login</a></p>
        </form>
    </div>
</div>

<script>
document.getElementById('regPassword').addEventListener('input', validatePassword);
document.getElementById('confirmPassword').addEventListener('input', validatePassword);

function validatePassword() {
    const password = document.getElementById('regPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    if (password !== confirmPassword) {
        document.getElementById('confirmPassword').style.borderColor = 'red';
    } else {
        document.getElementById('confirmPassword').style.borderColor = '#ddd';
    }

    document.getElementById("validId").addEventListener("change", function() {
    const fileName = this.files[0]?.name || "No file chosen";
    document.querySelector(".file-selected-name").textContent = fileName;
});

}
</script>
</body>
</html>