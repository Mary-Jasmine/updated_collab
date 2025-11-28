<?php
include "config.php";

// Connect using PDO
$db = new Database();
$conn = $db->getConnection();

if (!$conn) {
    die("Database connection failed.");
}

// Detect selected category from URL
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

// UI category → database column mapping
$categoryMap = [
    'Disaster Warnings'     => ['emergency'],
    'Public Works'          => ['announcement'],
    'Road Closures'         => ['maintenance'],
    'Health Advisories'     => ['announcement'],
    'Emergency Evacuation'  => ['emergency'],
    'Water Interruption'    => ['maintenance'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcements and Alerts</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
        body.ann-body{
    background: 
        linear-gradient(rgba(0, 0, 0, 0.727), rgba(0, 0, 0, 0.705)),  /* dark overlay */
        url('chujjrch.jpeg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    filter: blur();
}

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #eaeaea;
      min-height: 100vh;
    }

    .content {
      max-width: 1300px;
      margin: auto;
      padding: 40px 50px;
      background-color: white;
      margin-top: 5%;
      border-radius: 14px;
      margin-bottom: 7%
    }

    .page-title {
      margin-top: ;
      font-size: 28px;
      font-weight: 600;
      color: #333;
      margin-bottom: 35px;
    }

    .layout {
      display: grid;
      grid-template-columns: 3fr 1.2fr;
      gap: 30px;
    }

    /* LEFT SIDE */
    .section-title {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .announcements-grid {
      display: grid;
      grid-template-columns: repeat(2,1fr);
      gap: 20px;
    }

    .announcement-card {
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0,0,0,0.08);
      transition: 0.2s;
    }

    .announcement-card:hover {
      transform: translateY(-3px);
    }

    .card-image {
      width: 100%;
      height: 160px;
      background: #ddd;
    }

    .card-content {
      padding: 18px;
    }

    .card-type {
      font-size: 12px;
      text-transform: uppercase;
      font-weight: bold;
      color: #555;
      margin-bottom: 6px;
    }

    .card-title {
      font-size: 17px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .card-description {
      font-size: 14px;
      color: #666;
      line-height: 1.45;
      margin-bottom: 15px;
    }

    .card-date {
      font-size: 12px;
      color: #777;
      margin-bottom: 8px;
    }

    .read-more {
      font-size: 12px;
      font-weight: 600;
      color: #1565c0;
      text-decoration: none;
    }

    /* RIGHT SIDE */
    .right-panel {
      position: sticky;
      top: 20px;
    }

    .alert-category {
      display: inline-block;
      background-color: #c41e3a;
      color: white;
      padding: 6px 14px;
      border-radius: 18px;
      margin-bottom: 12px;
      font-size: 12px;
      font-weight: bold;
    }

    .category-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 20px;
    }

    .category-tag {
      background-color: #f4f4f4;
      padding: 6px 12px;
      border-radius: 4px;
      color: #555;
      font-size: 12px;
      text-decoration: none;
      display: inline-block;
      transition: 0.2s;
    }

    .category-tag:hover {
      background-color: #e0e0e0;
    }

    .alert-item {
      background-color: #fff;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 15px;
      box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    }

    .alert-urgent {
      background-color: #d32f2f;
      color: white;
      font-size: 10px;
      font-weight: bold;
      padding: 3px 8px;
      border-radius: 10px;
      margin-left: 6px;
    }
  </style>
</head>

<body class="ann-body">

<?php include 'header.php'; ?>

<div class="content">

  <h1 class="page-title">Announcements and Alerts</h1>

  <div class="layout">

    <!-- =========================
         LEFT SECTION – ANNOUNCEMENTS
    ========================== -->
    <div>
      <h2 class="section-title">Recent Municipal Announcements</h2>

      <div class="announcements-grid">
      <?php
      $stmt = $conn->prepare("
        SELECT * FROM announcements 
        WHERE status='published'
        ORDER BY published_at DESC
        LIMIT 6
      ");
      $stmt->execute();
      $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($announcements):
        foreach ($announcements as $row):
      ?>
        <div class="announcement-card">
          <div class="card-image"></div>
          <div class="card-content">
            <div class="card-type"><?= ucfirst($row['type']); ?></div>
            <div class="card-title"><?= htmlspecialchars($row['title']); ?></div>
            <div class="card-description"><?= htmlspecialchars(substr($row['content'], 0, 120)); ?>...</div>
            <div class="card-date"><?= date("F d, Y", strtotime($row['published_at'])); ?></div>
            <a href="#" class="read-more">Read More</a>
          </div>
        </div>
      <?php
        endforeach;
      else:
        echo "<p>No announcements found.</p>";
      endif;
      ?>
      </div>
    </div>

    <!-- =========================
         RIGHT SECTION – ALERTS
    ========================== -->
    <div class="right-panel">

      <h3 style="margin: 10px 0;">Browse Alert Categories</h3>

      <div class="alert-category">Sort by Category</div>

      <div class="category-tags">
        <a href="announcements.php?category=Disaster Warnings" class="category-tag">Disaster Warnings</a>
        <a href="announcements.php?category=Public Works" class="category-tag">Public Works</a>
        <a href="announcements.php?category=Road Closures" class="category-tag">Road Closures</a>
        <a href="announcements.php?category=Health Advisories" class="category-tag">Health Advisories</a>
        <a href="announcements.php?category=Emergency Evacuation" class="category-tag">Emergency Evacuation</a>
        <a href="announcements.php?category=Water Interruption" class="category-tag">Water Interruption</a>
      </div>

      <h3 style="margin: 20px 0 15px;">Active Safety Alerts</h3>

      <?php if ($selectedCategory): ?>
        <p style="margin-bottom: 10px;">
          Showing results for:
          <strong><?= htmlspecialchars($selectedCategory); ?></strong>
        </p>
      <?php endif; ?>

      <?php

      // If category selected, map it to real DB values
      if ($selectedCategory && isset($categoryMap[$selectedCategory])) {

          $mappedTypes = $categoryMap[$selectedCategory];

          // Prepare placeholders: ?, ?, ? depending on number of values
          $placeholders = implode(',', array_fill(0, count($mappedTypes), '?'));

          // Build query
          $stmt = $conn->prepare("
            SELECT * FROM announcements
            WHERE status='published'
            AND type IN ($placeholders)
            ORDER BY published_at DESC
          ");

          // Execute with mapped types
          $stmt->execute($mappedTypes);

      } else {

          // Default – show recent alerts
          $stmt = $conn->prepare("
            SELECT * FROM announcements 
            WHERE status='published'
            ORDER BY published_at DESC
            LIMIT 5
          ");
          $stmt->execute();
      }

      $alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($alerts):
        foreach ($alerts as $alert):
      ?>
      <div class="alert-item">
        <strong><?= htmlspecialchars($alert['title']); ?></strong>
        <?php if (strtolower($alert['priority']) == 'urgent'): ?>
            <span class="alert-urgent">Urgent</span>
        <?php endif; ?>
        <br><br>

        <?= htmlspecialchars($alert['content']); ?><br><br>

        <strong>Issued:</strong> <?= date("F d, Y", strtotime($alert['published_at'])); ?><br>
        <strong>Source:</strong> Local Government Office
      </div>
      <?php
        endforeach;
      else:
        echo "<p>No alerts found.</p>";
      endif;
      ?>

    </div>

  </div>

</div>
</body>
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
</html><br>
<?php include "footer.html"; ?>