<?php
    require('partials/header.php');

    $userIP = getUserIP();

?>
    <div class="flex items-center justify-center bg-almost-black text-white justify-center h-screen">
        <div class="p-4 font-popins">
        <div class="mb-6 bg-clip-text text-transparent font-comfortaa text-3xl font-bold tracking-widest text-center bg-gradient-to-tr from-purple-700 via-purple-700 to-blue-500 drop-shadow-glow">
                New password
            </div>
            <?php
                if(!empty($message))
                    echo"<div class='feedback error'>$message</div><br>";
                if($valid) {
            ?>
            <form action="changePasswordDB" method="POST" class="text-lg font-semibold font-popins">
                
                <input type="hidden" name="selector" value="<?php echo$_GET['selector']; ?>">
                <input type="hidden" name="validator" value="<?php echo$_GET['validator']; ?>">

                <div class="mb-8">
                    <label for="password" class="font-medium">New Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required class="w-full p-4 rounded-lg text-black font-normal">
                        <i class="text-gray-300 fas fa-eye-slash absolute top-0 right-0 p-4 cursor-pointer text-xl" id="show-password-btn"></i>
                    </div>
                </div>
                <div class="mb-8">
                    <label for="password" class="font-medium">Repeat New Password</label>
                    <div class="relative">
                        <input type="password" name="password-repeat" id="password-repeat" required class="w-full p-4 rounded-lg text-black font-normal">
                    </div>
                </div>

                <div class="mt-4 relative text-center">
                    <a class="text-gray-500" href="login"> Remembered you password? </a>
                </div>
                <input type="submit" value="Submit" class="w-full text-white font-semibold text-lg p-4 bg-gradient-to-tr from-purple-700 via-purple-600 to-blue-600 rounded-lg cursor-pointer">
            </form>
            <?php
                }
            ?>
        </div>
    </div>
    
    <a href="/hakkie" class="text-white font-popins">
        <div id="switch-form-btn" class="bottom-0 left-0 absolute md:fixed text-center bg-blue-500 text-white font-medium p-5 md:pt-6 md:pt-7 md:pb-2.5 md:pl-3.5 md:rounded-tr-large cursor-pointer w-full md:max-w-fit ">
            I still don't have an account
        </div>
    </a>
    <style>
    body .container .right form input {
        outline: none;
        padding: 1em;
        border-radius: 0.5em;
        font-size: 1em;
        font-weight: 500;
    }
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
<?php

include('partials/footer.php');

?>