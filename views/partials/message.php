<?php

$chats = [
    [
        'name' => 'Gabriel',
        'img' => 'https://avatars.githubusercontent.com/u/69210720?s=400&u=e29d62deef9aa07ca86119bb288840449b81a57b&v=4',
    ],
    [
        'name' => 'Felipe',
        'img' => 'https://avatars.githubusercontent.com/u/69355764?v=4',
    ],
    [
        'name' => 'Duque',
        'img' => 'https://avatars.githubusercontent.com/u/68524267?v=4',
    ],
]

?>


<div id="message-section" class="border-x-2 border-slate-500 bg-almost-black fixed w-screen lg:w-1/4 h-screen right-0 bottom-0 transform translate-y-full transition duration-500 ease-in-out font-popins font-bold text-white divide-y divide-stone-700/50">
    <h2 class="text-2xl m-6">
        Chats
    </h2>
    <?php
        foreach ($chats as $chat) {
            echo '<div class="w-full items-center cursor-pointer p-3.5 flex hover:bg-indigo-900 transition duration-100">
                <img src="'.$chat['img'].'" class="w-16 rounded-full mx-4">
                <span class="">
                    '.$chat['name'].'
                </span>
            </div>';
        }
    ?>
</div>

<div id="message-btn" class="bg-gradient-to-r from-indigo-600 to-orange-700 rounded-t-lg p-4 shadow-xl fixed right-0 bottom-0 w-screen lg:w-1/4 text-center cursor-pointer text-white">
    <i class="fas fa-chevron-up duration-200"></i>
</div>

<script src="<?= $GLOBALS['base_url'] ?>/js/openMessages.js"></script>