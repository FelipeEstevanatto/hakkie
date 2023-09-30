<?php

    require('partials/header.php');
?>
    <div class="flex items-center justify-center bg-almost-black text-white justify-center h-screen">
        <div class="p-4 font-popins">
            <div class="mb-6 bg-clip-text text-transparent font-comfortaa text-3xl font-bold tracking-widest text-center bg-gradient-to-tr from-purple-700 via-purple-700 to-blue-500 drop-shadow-glow">
                Log into your account
            </div>
            <?php
                if(!empty($errors)) {
                    echo "<div class='bg-red-500 text-white p-4 rounded-lg mb-4'>"; 
                    foreach ($errors as $error) {
                        echo $error[0]."<br>";
                    }
                    echo "</div><br>";
                }
            ?>
            <form action="session" method="POST" class="max-w-[600px] text-lg font-semibold font-popins">
                <div class="mb-6">
                    <label for="email" class="font-medium">Email</label>
                    <input type="email" name="email" id="email" required class="p-4 w-full text-black rounded-lg font-normal">
                </div>

                <div class="mb-8">
                    <label for="password" class="font-medium">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required class="w-full p-4 rounded-lg text-black font-normal">
                        <i class="text-gray-300 fas fa-eye-slash absolute top-0 right-0 p-4 cursor-pointer text-xl" id="show-password-btn"></i>
                    </div>
                </div>
                <input type="submit" value="Submit" class="w-full text-white font-semibold text-lg p-4 bg-gradient-to-tr from-purple-700 via-purple-600 to-blue-600 rounded-lg cursor-pointer">
            </form>
            <div class="mt-4 relative text-center">
                <a class="text-gray-500" href="recover"> Forgot your password? </a>
            </div>

            <div class="my-4 relative text-center w-full font-semibold">
                <span class="before:w-40 before:absolute before:bottom-4 before:bg-white before:rounded">OR</span>
            </div>
            <div class="flex align items-center justify-center">
                <div id="g_id_onload"
                    data-client_id="1014049574641-u1pcchh1thdc0futl5an649j2m85222a.apps.googleusercontent.com"
                    data-context="signin"
                    data-ux_mode="popup"
                    data-login_uri="<?=$data_login_uri?>"
                    data-auto_prompt="false"
                    style="transform: scale(1.25);">
                </div>

                <div class="g_id_signin"
                    data-type="standard"
                    data-shape="pill"
                    data-theme="outline"
                    data-text="signin_with"
                    data-size="large"
                    data-logo_alignment="left"
                    style="transform: scale(1.25);">
                </div>
            </div>
            
        </div>
    </div>
    
    <a href="/hakkie" class="text-white font-popins">
        <div id="switch-form-btn" class="bottom-0 left-0 absolute md:fixed text-center bg-blue-500 text-white font-medium p-5 md:pt-6 md:pt-7 md:pb-2.5 md:pl-3.5 md:rounded-tr-large cursor-pointer w-full md:max-w-fit ">
            I still don't have an account
        </div>
    </a>

    <script src="js/showPassword.js"></script>
    <style>
    @media screen and (max-width: 775px) {
    body #switch-form-btn {
        font-size: .9em;
    }
    }
    body #switch-form-btn {
        background: linear-gradient(35deg, #7700ff 40%, #0059ff);
        font-size: 1.2em;
    }
    </style>
</body>
</html>