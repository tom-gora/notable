<nav id="secondary-nav"
    class="bg-base-100 z-30 shadow-base-200/75 absolute top-0 mt-8 flex h-20 w-screen flex-row-reverse items-center justify-end px-1 md:fixed md:mt-0 md:flex-row md:px-8 transition-all duration-300">
    <a href="/home" wire:navigate.hover
        class="z-50 w-fit md:clamped-logo sm-fixed-logo absolute -top-3 h-6 md:top-1/4 md:h-8 cursor-pointer">
        <x-app-logo />
    </a>
    <livewire:auth-nav-buttons />
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const topbar = document.querySelector("#secondary-nav");
            window.onscroll = function() {
                if (window.scrollY > 50) {
                    topbar.classList.add("shadow-md");
                } else {
                    topbar.classList.remove("shadow-md");
                }
            };
        });
    </script>

</nav>
