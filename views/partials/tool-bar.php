
<div class="flex lg:hidden border-b-2 border-slate-500 bg-gray-200 dark:bg-almost-black justify-between">
    <div class="logo pl-6">Hakkie</div>
    <i id="sandwich-menu-button" class="fa-solid fa-bars text-black dark:text-white text-4xl p-6 cursor-pointer"></i>
</div>

<div id="sandwich-menu" class="flex min-h-screen w-screen bg-gray-200 dark:bg-almost-black pl-8 md:pl-8 lg:w-3/12 hidden lg:block lg:fixed lg:pt-8 text-black dark:text-white border-r-2 border-slate-500 z-50 drop-shadow-xl">
    <div>
        <div class="logo hidden lg:block">Hakkie</div>
        <div class="buttons text-3xl lg:text-2xl">
            <a href="home" class="btn md:pl-8 py-2 py-2 block font-semibold">
                <i class="fas fa-home mr-2"></i>
                <span>Home</span>
            </a>
            <?php if (!empty($_SESSION['user'])) {?>
            <a href="notifications" class="btn h-auto md:pl-8 py-2 block font-semibold">
                <i class="fas fa-bell mr-2"></i>
                <span>Notifications</span>
            </a>
        
            <a href="user?user=<?= $_SESSION['user']['id'] ?>" class="btn md:pl-8 py-2 block font-semibold">
                <i class="fas fa-user mr-2"></i>
                <span>Profile</span>
            </a>
    
            <a href="settings" class="btn md:pl-8 py-2 block font-semibold">
                <i class="fas fa-cog mr-2"></i>
                <span>Settings</span>
            </a>
            <?php } ?>
        </div>  
    </div>
</div>

<script>
    const sandwichMenu = document.getElementById('sandwich-menu');
    const sandwichMenuButton = document.getElementById('sandwich-menu-button');

    sandwichMenuButton.addEventListener('click', () => {
        sandwichMenu.classList.toggle('hidden');
    });
</script>