<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $heading ?? "Hakkie"?></title>

    <!-- Styles -->
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&display=swap");
    </style>
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
            // add the class to the body
            document.documentElement.classList.add('dark')
            console.log('dark mode')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

</head>
<body>
    
