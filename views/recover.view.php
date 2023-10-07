<?php

require('partials/header.php');
$userIP = getUserIP()->ip;

?>
    <div class="flex items-center justify-center bg-almost-black text-white justify-center h-screen">
        <div class="p-4 font-popins">
            <div class="mb-6 bg-clip-text text-transparent font-comfortaa text-3xl font-bold tracking-widest text-center bg-gradient-to-tr from-purple-700 via-purple-700 to-blue-500 drop-shadow-glow">
                Recover you password
            </div>
            <?php
                if (!empty($errors)) {
                    echo "<div class='bg-red-500 text-white p-4 rounded-lg mb-4'>"; 
                    foreach ($errors as $error) {
                        echo "- ".$error[0]."<br>";
                    }
                    echo "</div><br>";
                }
            ?>
            <form action="recover" method="POST">

                <input type="hidden" name="sender-ip" value="<?=$userIP?>">
                <div class="mb-6">
                    <label for="email" class="font-medium">Email</label>
                    <input type="email" name="email" id="email" required class="p-4 text-base w-full text-black rounded-lg font-normal font-popins">
                </div>

                <input type="submit" value="Submit" class="w-full text-white font-semibold text-lg p-4 bg-gradient-to-tr from-purple-700 via-purple-600 to-blue-600 rounded-lg cursor-pointer">
            </form>
            
            <div class="mt-4 relative text-center">
                <a class="text-gray-500" href="login"> Remembered you password? </a>
            </div>
        </div>
    </div>
    
    <a href="/hakkie" class="text-white font-popins">
        <div id="switch-form-btn" class="bottom-0 left-0 absolute md:fixed text-center bg-blue-500 text-white font-medium p-5 md:pt-6 md:pt-7 md:pb-2.5 md:pl-3.5 md:rounded-tr-large cursor-pointer w-full md:max-w-fit ">
            I still don't have an account
        </div>
    </a>
    <div>
        <img src="<?= $GLOBALS['base_url'] ?>public/images/loading-buffering.gif" alt="loading" class="hidden">
    </div>
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
<?php

include('partials/footer.php');

?>