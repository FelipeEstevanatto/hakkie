<?php
    $data_login_uri = $_ENV['GOOGLE_LOGIN_URI']."/app/google/verifyIntegrity.php";
    require('partials/header.php');
?>
    <div class="flex items-center justify-center bg-almost-black text-white justify-center h-screen">
        <div class="w-screen p-12 block md:flex">
            <div class="p-4 font-popins md:w-3/5 max-w-[900px] flex flex-col items-left justify-center">
                <div class="mb-6 bg-clip-text text-transparent font-comfortaa text-3xl font-bold tracking-widest text-center bg-gradient-to-tr from-purple-700 via-purple-700 to-blue-500 drop-shadow-glow text-start">
                    Hakkie
                </div>

                <div class="content text-2xl tracking-widest max-w-4xl md:w-9/12 h-auto">
                A Social Media project in a Twitter like design, created just for fun and learning more. You can create you account with your Email or Google, and then go to your profile and post something nice, and share it with your friends!
                </div>
            </div>

            <div class="right md:w-2/5">
                <div class="mb-6 bg-clip-text text-transparent font-comfortaa text-3xl font-bold tracking-widest text-center bg-gradient-to-tr from-purple-700 via-purple-700 to-blue-500 drop-shadow-glow">
                    Create Account
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

                <form action="register" method="POST" class="text-lg font-semibold font-popins">
                    <div class="mb-6">
                        <label for="email" class="font-medium">Name</label>
                        <input type="text" name="name" id="name" required class="p-4 w-full text-black rounded-lg font-normal">
                    </div>
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
        </div>
    </div>

    <a href="login" class="text-white font-popins">
        <div id="switch-form-btn" class="bottom-0 left-0 absolute md:fixed text-center bg-blue-500 text-white font-medium p-5 md:pt-6 md:pt-7 md:pb-2.5 md:pl-3.5 md:rounded-tr-large cursor-pointer w-full md:max-w-fit ">
            I already have an account!
        </div>
    </a>
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
    <script src="js/showPassword.js"></script>
</body>
</html>