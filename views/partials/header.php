<!DOCTYPE html>
<html lang="pt-br"  class="<?=$_SESSION['user']['theme'] ? 'dark' : ''?>" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $heading ?? "Hakkie"?></title>

    <!-- Styles -->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/style.css">

    <!--API Google login-->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= $GLOBALS['base_url'] ?>public/images/favicon.png" type="image/x-icon">

</head>
<body>
<script>
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (window.document.body.classList.contains('dark')) {
        localStorage.theme = 'dark'
    } else {
        localStorage.theme = ''
    }
</script>
    
