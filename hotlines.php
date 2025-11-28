<?php
require_once 'config.php';
redirectIfNotLogged();

// Connect to database
$database = new Database();
$db = $database->getConnection();

// Fetch emergency contacts
$query = "SELECT * FROM hotlines  ORDER BY agency_name ASC";
$stmt = $db->prepare($query);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Hotlines</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body class="dashboard-page">
<?php include 'header.php'; ?>

<div class="dashboard-container">
    <div class="hot-content">

        <header class="page-header">
            <h1>Emergency Hotlines</h1>
<p class="page-subtitle">Your quick guide to essential emergency contacts in San Pablo City, Laguna. Find fast assistance from key agencies.</p> </header> 
<div class="search-section"> 
    <div class="search-box-large" style="max: width 150px;height 2%; margin-left: 29%;"> 
        <input type="text" id="hotlineSearch" placeholder="Search agencies or numbers..."> 
        <button class="search-btn" style="background-color:rgb(132, 4, 4); color: aliceblue">Search</button> 
    </div> 
</div>

        <div class="contacts-section">
            <div class="section-card">
                <h2>Emergency Contact List</h2>
                <p class="section-subtitle">Automatically fetched from database</p>

                <div class="contacts-table-container">
                    <table class="contacts-table">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Agency</th>
                                <th>Description</th>
                                <th>Phone Number</th>
                                <th>Landline Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                       
                            <tr>
                                <?php
                                    // Resolve logo URL: admin stores files under ADMinn/uploads/logos,
                                    // while public site expects uploads/logos under project root.
                                    $logoSrc = null;
                                    $logoVal = $row['logo_type'] ?? '';
                                    if (!empty($logoVal)) {
                                        // If stored as absolute URL, use it directly
                                        if (preg_match('#^https?://#', $logoVal)) {
                                            $logoSrc = $logoVal;
                                        } else {
                                            // Normalize candidate relative paths
                                            $candidate = ltrim($logoVal, '/');
                                            $candidates = [
                                                $candidate,
                                                'ADMinn/' . $candidate,
                                                'ADMinn/uploads/logos/' . basename($candidate),
                                                'uploads/logos/' . basename($candidate)
                                            ];
                                            foreach ($candidates as $c) {
                                                if (file_exists(__DIR__ . '/' . $c)) {
                                                    $logoSrc = $c;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    // fallback to admin default if exists, else project default
                                    if (!$logoSrc) {
                                        if (file_exists(__DIR__ . '/ADMinn/uploads/logos/default.png')) {
                                            $logoSrc = 'ADMinn/uploads/logos/default.png';
                                        } else {
                                            $logoSrc = 'uploads/logos/default.png';
                                        }
                                    }
                                ?>
                                <td class="col-logo">
                                    <img src="<?= htmlspecialchars($logoSrc) ?>" class="agency-logo-img" alt="<?= htmlspecialchars($row['agency_name']); ?>">
                                </td>

                                <td><strong><?= htmlspecialchars($row['agency_name']); ?></strong></td>

                                <td><?= htmlspecialchars($row['description']); ?></td>

                                <td><svg xmlns="http://www.w3.org/2000/svg" width="24" color="red" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
</svg>
<span class="phone-number"><?= htmlspecialchars($row['phone_number']); ?></span>
                            
                            </td>

                                <td><svg xmlns="http://www.w3.org/2000/svg" width="24"color=red height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <rect x="5" y="4" width="14" height="18" rx="2"></rect>
  <path d="M8 7h8"></path>
  <circle cx="9" cy="12" r="1"></circle>
  <circle cx="12" cy="12" r="1"></circle>
  <circle cx="15" cy="12" r="1"></circle>
  <circle cx="9" cy="15" r="1"></circle>
  <circle cx="12" cy="15" r="1"></circle>
  <circle cx="15" cy="15" r="1"></circle>
  <circle cx="9" cy="18" r="1"></circle>
  <circle cx="12" cy="18" r="1"></circle>
  <circle cx="15" cy="18" r="1"></circle>
</svg><span class="landline-number"><?= htmlspecialchars($row['landline_number']); ?></span></td>

                                <td>
                                    <button class="view-details-btn" 
                                            onclick="viewDetails(<?= $row['hotline_id']; ?>)">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<script>
document.getElementById('hotlineSearch').addEventListener('keyup', function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll(".contacts-table tbody tr");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>



<script>
function viewDetails(id) {
    window.location.href = "view_hotline.php?id=" + id;
}
</script>
    <script>
        window.addEventListener('scroll', function() {
            const footer = document.querySelector('.footer');
            const scrollPosition = window.scrollY + window.innerHeight;
            const documentHeight = document.body.scrollHeight;
            if (scrollPosition >= documentHeight - 100) {
                footer.classList.add('visible');
            } else {
                footer.classList.remove('visible');
            }
        });
    </script>
</body>
</html>
<?php include 'footer.html'; ?>
