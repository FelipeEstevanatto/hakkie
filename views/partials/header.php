<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $heading ?? "Documento"?></title>

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/home/grid/grid.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/style.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/home/feed/feed.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/forms/forms.css"> -->
    <!-- Font Awesome-->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="<?= $GLOBALS['base_url'] ?>public/tailwind.js"></script>

    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!--API Google login-->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= $GLOBALS['base_url'] ?>public/images/favicon.png" type="image/x-icon">

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
            console.log('dark mode')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

</head>
<body>
    
