<!DOCTYPE html>
<?php
// Use config/session to persist settings
require_once 'config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// save settings from POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $lang = in_array($_POST['language'] ?? '', ['en','tl']) ? $_POST['language'] : 'en';
    $_SESSION['lang'] = $lang;
    $_SESSION['theme'] = ($_POST['theme'] ?? '') === 'dark' ? 'dark' : 'light';
    // redirect to avoid resubmission
    header('Location: settings.php');
    exit;
}

// read current
$currentLang = $_SESSION['lang'] ?? 'en';
$currentTheme = $_SESSION['theme'] ?? 'light';

?>
<html lang="<?php echo htmlspecialchars($currentLang); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health App - Settings & Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.5;
        }
        
                body.set-body{
    background: 
        linear-gradient(rgba(0, 0, 0, 0.727), rgba(0, 0, 0, 0.705)),  /* dark overlay */
        url('chujjrch.jpeg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    filter: blur();
}

.sidebar {

    position: fixed;
    top: 0;
    left: 0;
    width: 260px;
    height: 900vh;
    overflow-y: auto;
    background: linear-gradient(to right, #980718, #6d0010);
    z-index: 1 1; 
    }

    .sidebar-header {
      padding: 80px 20px 10px; 
      text-align: center;
    }

    .sidebar-header-icon {
      font-size: 40px;
      margin-bottom: 10px;
    }

    .sidebar-header h3 {
      font-size: 14px;
      font-weight: 500;
      text-transform: uppercase;
      margin-top: 5px;
      color: rgba(255, 255, 255, 0.7);
      padding-bottom: 10px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .sidebar-nav {
      padding: 0 0 20px 0;
    }

    .sidebar-nav a.nav-item {
      display: block;
      padding: 10px 20px;
      color: rgba(255, 255, 255, 0.85);
      text-decoration: none;
      font-size: 15px;
      transition: background-color 0.2s;
      border-left: 3px solid transparent;
      margin-bottom: 2px;
    }

    .sidebar-nav a.nav-item:hover {
      background-color: rgba(0, 0, 0, 0.1);
    }

    .sidebar-nav a.nav-item.active {
      background-color: #C41E3A;
      color: white;
      border-left: 3px solid #FFD700;
      font-weight: 600;
    }
    
    .nav-section {
      padding-top: 15px;
    }

    .nav-section h4 {
      font-size: 14px;
      font-weight: 500;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.7);
      padding: 10px 20px 5px;
      margin-top: 10px;
    }


        .app-container {
            display: flex;
            min-height: 100vh;
        }
        
        .main-content {
            padding: 40px 50px;
            border-radius: 3%;
            margin-top: 3%;
            margin-left: 280px;    
            margin-right: 0;
            padding-top: 30px;    
            height: 60%;
            width:70%;
            background-color: whitesmoke

        }
        
        .page-title {
            margin-bottom: 25px;
        }
        
        .page-title h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .page-title p {
            color: #6c757d;
        }

        .card {
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .section {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .section-title {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .option:last-child {
            margin-bottom: 0;
        }
        
        .option-info h3 {
            font-size: 16px;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .option-info p {
            color: #6c757d;
            font-size: 14px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .3s;
            border-radius: 24px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: #2c80ff;
        }
        
        input:checked + .slider:before {
            transform: translateX(24px);
        }
        
        .select-wrapper {
            position: relative;
            width: 180px;
        }
        
        .select-wrapper select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            background-color: white;
            appearance: none;
            font-size: 14px;
        }
        
        .select-wrapper::after {
            content: "▼";
            font-size: 12px;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .btn-primary {
            background-color: #004e15ff;
;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1a6fe0;
        }
        

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #002e8bff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            margin-right: 20px;
        }
        
        .profile-info h2 {
            font-size: 22px;
            margin-bottom: 5px;
        }
        
        .profile-info p {
            color: #6c757d;
        }
        
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .field {
            margin-bottom: 15px;
        }
        
        .field label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #6c757d;
            font-size: 14px;
        }
        
        .field p {
            font-size: 16px;
        }
        
        .divider {
            height: 1px;
            background-color: #dee2e6;
            margin: 25px 0;
        }
        
        .tools-section {
            margin-bottom: 30px;
        }
        
        .tools-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .tool-card {
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 20px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        
        .tool-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .tool-icon {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .tool-card h3 {
            font-size: 16px;
            font-weight: 500;
        }
        
        .explore-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .explore-item {
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 15px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        
        .explore-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .explore-icon {
            font-size: 22px;
            margin-bottom: 10px;
        }
        
        .explore-item h3 {
            font-size: 14px;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .app-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
            }
            
            .option {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .option-control {
                margin-top: 10px;
                width: 100%;
            }
            
            .select-wrapper {
                width: 100%;
            }
            
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .tools-grid, .explore-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .tools-grid, .explore-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .tab-container {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .tab {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 500;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }
        
        .tab.active {
            border-bottom-color: #900303ff;
            color: #900303ff;
;
        }
        
        .page {
            display: none;
        }
        
        .page.active {
            display: block;
        }
    </style>
</head>
        <body class="set-body <?php echo function_exists('body_theme_class') ? body_theme_class() : ($currentTheme === 'dark' ? 'theme-dark' : ''); ?>">
        <?php include 'header.php'; ?>
        <div class="app-container">
  <!--          
        <div class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-header-icon">🏛️</div>
        <h3>OFFICIAL TOOLS</h3>
    </div>

    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-item">Analytics Dashboard</a>
        <a href="submit-report.php" class="nav-item">Submit Report</a>
        <a href="hotlines.php" class="nav-item">Hotlines</a>

        <div class="nav-section">
            <h4>EXPLORE</h4>
            <a href="heatmap.php" class="nav-item">Heatmap</a>
            <a href="announcements.php" class="nav-item active">Announcements</a>
            <a href="firstaid.php" class="nav-item">First Aid Resources</a>
            <a href="settings.php" class="nav-item">Settings</a>
        </div>
        
        <div class="nav-section">
            <a href="logout.php" class="nav-item" style="margin-top: 15px;">Log Out</a>
        </div>
    </nav>
</div>  
    -->

        <div class="main-content">
            <div class="tab-container">
                <div class="tab active" data-page="profile">Profile</div>
                <div class="tab" data-page="settings">Settings</div>
            </div>

            <div id="profile-page" class="page active">
                <div class="page-title">
                    <h1>User Profile</h1>
                    <p>View and manage your personal information</p>
                </div>

                <div class="card">
                    <div class="profile-header">
                        <div class="avatar">EV</div>
                        <div class="profile-info">
                            <h2>Elara Vance</h2>
                            <p>Registered User</p>
                        </div>
                    </div>

                    <div class="profile-grid">
                        <div class="field">
                            <label>Full Name</label>
                            <p>Mary Jasmine Manalo</p>
                        </div>
                        <div class="field">
                            <label>Email</label>
                            <p>majayjay0123.com</p>
                        </div>
                        <div class="field">
                            <label>Contact Number</label>
                            <p>+6391778928</p>
                        </div>
                        <div class="field">
                            <label>Barangay</label>
                            <p>Barangay Pinagdanlayan</p>
                        </div>
                        <div class="field">
                            <label>Age</label>
                            <p>21</p>
                        </div>
                        <div class="field">
                            <label>Sex</label>
                            <p>Female</p>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <button class="btn btn-primary" id="edit-profile-btn">Edit Profile</button>
                </div>

            </div>
            <div id="settings-page" class="page">
                <div class="page-title">
                    <h1>Settings</h1>
                    <p>Customize your application experience</p>
                </div>

                <div class="card">
                    <div class="section">
                        <h2 class="section-title">Interface Mode</h2>
                        <div class="option">
                            <div class="option-info">
                                <h3>Theme</h3>
                                <p>Adjust the application's visual theme (Light / Dark)</p>
                            </div>
                            <div class="option-control">
                                <form method="POST" id="settings-form">
                                    <input type="hidden" name="save_settings" value="1">
                                    <label class="switch">
                                        <input type="checkbox" id="theme-toggle" name="theme" value="dark" <?php echo $currentTheme === 'dark' ? 'checked' : ''; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h2 class="section-title">Text Size</h2>
                        <div class="option">
                            <div class="option-info">
                                <h3>Display Font Size</h3>
                                <p>Control the size of text elements across the application</p>
                            </div>
                            <div class="option-control">
                                <div class="select-wrapper">
                                    <select id="font-size">
                                        <option value="small">Small</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="large">Large</option>
                                        <option value="x-large">Extra Large</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section">
                        <h2 class="section-title">Language</h2>
                        <div class="option">
                            <div class="option-info">
                                <h3>Application Language</h3>
                                <p>Choose your preferred language for the interface</p>
                            </div>
                            <div class="option-control">
                                <div class="select-wrapper">
                                    <select id="language" name="language" form="settings-form">
                                        <option value="en" <?php echo $currentLang === 'en' ? 'selected' : ''; ?>>English</option>
                                        <option value="tl" <?php echo $currentLang === 'tl' ? 'selected' : ''; ?>>Tagalog</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:18px">
                        <button class="btn btn-primary" type="submit" form="settings-form">Save Settings</button>
                        <button class="btn btn-danger" id="logout-btn">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab, .nav-link').forEach(element => {
            element.addEventListener('click', function() {
                const pageId = this.getAttribute('data-page');
  
                document.querySelectorAll('.tab').forEach(tab => {
                    tab.classList.remove('active');
                });
                document.querySelector(`.tab[data-page="${pageId}"]`).classList.add('active');

                document.querySelectorAll('.page').forEach(page => {
                    page.classList.remove('active');
                });
                document.getElementById(`${pageId}-page`).classList.add('active');

                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.body.style.backgroundColor = '#1a1a1a';
                document.body.style.color = '#f0f0f0';
                document.querySelectorAll('.card, .tool-card, .explore-item').forEach(card => {
                    card.style.backgroundColor = '#2d2d2d';
                    card.style.color = '#f0f0f0';
                });
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.style.backgroundColor = '#f5f7fa';
                document.body.style.color = '#333';
                document.querySelectorAll('.card, .tool-card, .explore-item').forEach(card => {
                    card.style.backgroundColor = 'white';
                    card.style.color = '#333';
                });
                localStorage.setItem('theme', 'light');
            }
        });
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            themeToggle.checked = true;
            themeToggle.dispatchEvent(new Event('change'));
        }

        const fontSizeSelect = document.getElementById('font-size');
        fontSizeSelect.addEventListener('change', function() {
            document.body.style.fontSize = this.value === 'small' ? '14px' : 
                                          this.value === 'medium' ? '16px' : 
                                          this.value === 'large' ? '18px' : '20px';
            localStorage.setItem('fontSize', this.value);
        });

        const savedFontSize = localStorage.getItem('fontSize');
        if (savedFontSize) {
            fontSizeSelect.value = savedFontSize;
            document.body.style.fontSize = savedFontSize === 'small' ? '14px' : 
                                          savedFontSize === 'medium' ? '16px' : 
                                          savedFontSize === 'large' ? '18px' : '20px';
        }

        const languageSelect = document.getElementById('language');
        languageSelect.addEventListener('change', function() {
            localStorage.setItem('language', this.value);
            alert(`Language changed to ${this.options[this.selectedIndex].text}. Page refresh required to apply changes.`);
        });

        const savedLanguage = localStorage.getItem('language');
        if (savedLanguage) {
            languageSelect.value = savedLanguage;
        }

        document.getElementById('logout-btn').addEventListener('click', function() {
            if (confirm('Are you sure you want to logout?')) {
                alert('Logging out...');
            }
        });

        document.getElementById('edit-profile-btn').addEventListener('click', function() {
            alert('Edit Profile feature would open here in a real application');
        });

        document.getElementById('analytics-dashboard').addEventListener('click', function() {
            alert('Opening Analytics Dashboard...');
        });

        document.getElementById('submit-report').addEventListener('click', function() {
            alert('Opening Report Submission Form...');
        });

        document.getElementById('hotlines').addEventListener('click', function() {
            alert('Displaying Emergency Hotlines...');
        });

        document.getElementById('heatmap').addEventListener('click', function() {
            alert('Opening Health Heatmap...');
        });

        document.getElementById('announcements').addEventListener('click', function() {
            alert('Opening Announcements...');
        });

        document.getElementById('first-aid').addEventListener('click', function() {
            alert('Opening First Aid Resources...');
        });
    </script>
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