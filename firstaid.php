<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First Aid & Disaster Preparedness</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

                    body.first-body{
    background: 
        linear-gradient(rgba(0, 0, 0, 0.727), rgba(0, 0, 0, 0.705)), url('chujjrch.jpeg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        filter: blur();
}
        .main-wrapper {
            display: flex;
            flex: 1;
        }

 .sidebar {

    position: fixed;
    top: 0;
    left: 0;
    width: 260px;
    height: 900vh;
    overflow-y: auto;
    background-color: #8B0B0B;
    z-index: 1 1; 
    }

    .sidebar-header {
      padding: 50px 20px 10px; 
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
  
    .content {
        margin-top: 3%;
      margin-left: 260px;
      margin-right: 16px; 
      padding: 30px 40px;
      background-color: #f5f5f5;
      min-height: calc(100vh - 50px);
      padding-top: 100px;
      margin-bottom: 7%; 
    }

    .page-title {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 30px;
      color: #333;
    }

    .main-container {
      display: grid; 
      grid-template-columns: 1fr 300px;
      gap: 30px;
    }
        

        .content {
            flex: 1;
            padding: 30px 40px;
            background-color: #f5f5f5;
            overflow-y: auto;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .info-banner {
            background-color: #e8f5e9;
            border-left: 4px solid #2d7a3a;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 30px;
            display: flex;
            gap: 12px;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }

        .info-icon {
            width: 24px;
            height: 24px;
            background-color: #2d7a3a;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            margin-top: 30px;
            color: #333;
        }

        .section-description {
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }

        .guides-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .guide-card {
            background-color: white;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-image {
            width: 100%;
            height: 140px;
            background: linear-gradient(135deg, #e8e8e8 0%, #d0d0d0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-image-placeholder {
            width: 80px;
            height: 80px;
            background-color: #b8b8b8;
            border-radius: 50%;
        }

        .card-content {
            padding: 15px;
        }

        .card-badge {
            display: inline-block;
            background-color: #2d7a3a;
            color: white;
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            min-height: 20px;
            background-color: #e8e8e8;
            border-radius: 3px;
        }

        .card-description {
            font-size: 12px;
            color: #666;
            line-height: 1.4;
            margin-bottom: 12px;
            min-height: 50px;
            background-color: #f0f0f0;
            border-radius: 3px;
        }

        .read-guide-btn {
            width: 100%;
            padding: 10px;
            background-color: #1e5a96;
            color: white;
            border: none;
            border-radius: 3px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .read-guide-btn:hover {
            background-color: #164570;
        }

        .checklist-section {
            margin-top: 30px;
        }

        .checklist-item {
            background-color: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .checklist-item:hover {
            background-color: #f9f9f9;
        }

        .checklist-item.expanded {
            background-color: #f9f9f9;
        }

        .checklist-title {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #2d7a3a;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checklist-text {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .expand-icon {
            font-size: 18px;
            color: #999;
        }

        .checklist-description {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            line-height: 1.4;
        }

        .videos-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .video-card {
            background-color: white;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .video-thumbnail {
            width: 100%;
            height: 140px;
            background: linear-gradient(135deg, #e8e8e8 0%, #d0d0d0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .play-button {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #2d7a3a;
        }

        .video-content {
            padding: 15px;
        }

        .video-title {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            min-height: 18px;
            background-color: #e8e8e8;
            border-radius: 3px;
        }

        .video-description {
            font-size: 12px;
            color: #666;
            line-height: 1.4;
            margin-bottom: 12px;
            min-height: 40px;
            background-color: #f0f0f0;
            border-radius: 3px;
        }

        .watch-now-btn {
            width: 100%;
            padding: 10px;
            background-color: #1e5a96;
            color: white;
            border: none;
            border-radius: 3px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .watch-now-btn:hover {
            background-color: #164570;
        }

        .footer {
            background-color: #4caf50;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .footer-left {
            display: flex;
            gap: 30px;
            font-size: 13px;
        }

        .footer-link {
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .footer-right {
            display: flex;
            gap: 15px;
        }

        .footer-icon {
            width: 20px;
            height: 20px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            cursor: pointer;
        }

        .copyright {
            font-size: 12px;
            color: white;
        }
    </style>
</head>
<body class="first-body">
    <?php include 'header.php'; ?>
 
   <!-- <?php include 'sidebar.php'; ?> -->

       <div class="content" style="margin-right: 10%;">
            <h1 class="page-title">First Aid & Disaster Preparedness</h1>

            <div class="info-banner">
                <div class="info-icon"></div>
                <div>All information on this page is carefully curated and verified by municipal health and disaster preparedness officials to ensure accuracy and reliability.</div>
            </div>

            <h2 class="section-title">Offline-Ready Guides</h2>
            <p class="section-description">Access essential first aid guides, even without an internet connection, to be prepared for any situation.</p>

            <div class="guides-grid">
                <div class="guide-card">
                    <div class="card-image">
                        <div class="card-image-placeholder"></div>
                    </div>
                    <div class="card-content">
                        
                        <div class="card-badge">CPR</div>
                        <div class="card-title"></div>
                        <div class="card-description"></div>
                        <a href="HandsOnlyCPRsheet.pdf" target="_blank"><button class="read-guide-btn">Read Guide</button>
                                                                      
</a>
                        
                    </div>
                </div>

                <div class="guide-card">
                    <div class="card-image">
                        <div class="card-image-placeholder"></div>
                    </div>
                    <div class="card-content">
                        <div class="card-badge">Injuries</div>
                        <div class="card-title"></div>
                        <div class="card-description"></div>
                        <a href="INJURIES.pdf" target="_blank"><button class="read-guide-btn">Read Guide</button></a>
                    </div>
                </div>

                <div class="guide-card">
                    <div class="card-image">
                        <div class="card-image-placeholder"></div>
                    </div>
                    <div class="card-content">
                        <div class="card-badge">Emergencies</div>
                        <div class="card-title"></div>
                        <div class="card-description"></div>
                    <a href="EMERGENCIES.pdf" target="_blank"><button class="read-guide-btn">Read Guide</button></a>
                    </div>
                </div>

                <div class="guide-card">
                    <div class="card-image">
                        <div class="card-image-placeholder"></div>
                    </div>
                    <div class="card-content">
                        <div class="card-badge">Medical</div>
                        <div class="card-title"></div>
                        <div class="card-description"></div>
                        <button class="read-guide-btn">Read Guide</button>
                    </div>
                </div>

                <div class="guide-card">
                    <div class="card-image">
                        <div class="card-image-placeholder"></div>
                    </div>
                    <div class="card-content">
                        <div class="card-badge">Fractures</div>
                        <div class="card-title"></div>
                        <div class="card-description"></div>
                        <a href="FRACTURES.pdf" target="_blank"><button class="read-guide-btn">Read Guide</button></a>
                    </div>
                </div>

                <div class="guide-card">
                    <div class="card-image">
                        <div class="card-image-placeholder"></div>
                    </div>
                    <div class="card-content">
                        <div class="card-badge">Disasters</div>
                        <div class="card-title"></div>
                        <div class="card-description"></div>
                         <a href="DISASTERS.pdf" target="_blank"><button class="read-guide-btn">Read Guide</button></a>
                    </div>
                </div>
            </div>

 

            <h2 class="section-title">Video Tutorials</h2>
            <p class="section-description">Watch these informative videos for practical demonstrations on disaster preparedness and first aid techniques.</p>

            <div class="videos-grid">
                <div class="video-card">
                    <div class="video-thumbnail">
                 <iframe width="300" height="300" src="https://www.youtube.com/embed/2PngCv7NjaI" title="Chest Compressions (CPR Steps)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="video-content">
                        <div class="video-title"></div>
                        <div class="video-description"></div>
                        <button class="watch-now-btn">Watch Now</button>
                    </div>
                </div>

                <div class="video-card">
                    <div class="video-thumbnail">
                       <iframe width="300" height="300" src="https://www.youtube.com/embed/MKILThtPxQs" title="When The Earth Shakes - Animated Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="video-content">
                        <div class="video-title"></div>
                        <div class="video-description"></div>
                        <button class="watch-now-btn">Watch Now</button>
                    </div>
                </div>

                <div class="video-card">
                    <div class="video-thumbnail">
                        <iframe width="300" height="300" src="https://www.youtube.com/embed/2v8vlXgGXwE" title="How To Treat A Fracture &amp; Fracture Types - First Aid Training - St John Ambulance" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="video-content">
                        <div class="video-title"></div>
                        <div class="video-description"></div>
                        <button class="watch-now-btn">Watch Now</button>
                    </div>
                </div>

                <div class="video-card">
                    <div class="video-thumbnail">
                        
                   <iframe width="300" height="300" src="https://www.youtube.com/embed/a4cIFZx1f2E?list=PLvd0isBh6beQelNrtp9EdNhwobGV_Taiu" title="Head Injury Symptoms &amp; Advice - First Aid Training - St John Ambulance" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="video-content">
                        <div class="video-title"></div>
                        <div class="video-description"></div>
                        <button class="watch-now-btn">Watch Now</button>
                    </div>
                </div>
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
</html>
<?php include 'footer.html'; ?>