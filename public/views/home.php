<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Styles -->
    <link rel="stylesheet" href="../css/home/grid/grid.css">
    <link rel="stylesheet" href="../css/style.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="dark">
    <div id="tool-bar">
        <div class="logo">
            Hakkie
        </div>

        <div class="buttons">
            <a href="home.php" class="btn">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            
            <a href="#" class="btn">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
        
            <a href="#" class="btn">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>

            <a href="settings.php" class="btn">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </div>  
    </div>

    <div id="feed">
        <?php
            for ($i = 0; $i<10; $i++) {
                echo"aaaaa".random_int(0,1000)."<br>";
            }
        ?>
    </div>


    <!-- Messages -->
    <div id="message-section" class="message-section-close">
        <h2>
            Chats
        </h2>

        <div class="talk">
            <img src="https://avatars.githubusercontent.com/u/69210720?s=400&u=e29d62deef9aa07ca86119bb288840449b81a57b&v=4">
            <span class="name">
                Gabriel
            </span>
        </div>

        <div class="talk">
            <img src="https://avatars.githubusercontent.com/u/69355764?v=4">
            <span class="name">
                Felipe
            </span>
        </div>

        <div class="talk">
            <img src="https://avatars.githubusercontent.com/u/68524267?v=4">
            <span class="name">
                Duque
            </span>
        </div>
    </div>

    <div id="message-btn" class="message-btn-close">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script src="../../js/switchTheme.js"></script>
    <script src="../../js/openMessages.js"></script>
</body>
</html>