<div class="grid h-full w-full place-items-center bg-base-100">
    @auth
        <h1>Logged in Home Dashboard</h1>
    @else
        <h1 class="py-4 text-2xl font-bold"> WELCOME </h1>
        <div class="ml-6 grid h-full w-10/12 place-items-center md:ml-0 md:w-full">
            <div class="aspect-square w-full bg-splash01 bg-cover md:w-96" id="splash01"></div>
            <h2 class="py-4 text-center text-xl md:text-2xl">Login to start working with handwritten notes 🚀🚀🚀</h1>
        </div>
    @endauth
</div>
