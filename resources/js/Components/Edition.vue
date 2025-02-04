<template>
    <section class="pt-40">
        <div class="flex flex-row pb-16">
            <h2 class="text-white">52e Editie</h2>
            <a href="#" class="btn btn--primary text-white !h-fit flex items-center justify-end ml-auto">Inschrijven</a>
        </div>
        <div>
            <!-- Event Item -->
            <div class="flex flex-col md:flex-row items-center gap-6">
                <!-- Container for all sections -->
                <div class="flex flex-col md:flex-row gap-6 h-full items-stretch">
                    <!-- Left Text -->
                    <div class="flex flex-col w-3/12">
                        <h3 class="text-2xl font-medium text-white">Dinsdag 19 Augustus 2025</h3>
                        <p class="main-text text-gray-400">Wandeldag 1</p>
                        <div class="main-text text-gray-400 mt-auto flex items-end justify-start">Prijs: €...</div>
                    </div>
                    <!-- Middle Image -->
                    <div class="flex-shrink-0 w-5/12">
                        <img
                        src="https://images.unsplash.com/photo-1737071371043-761e02b1ef95?q=80&w=2166&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Event Image"
                        class="h-[280px] w-full object-cover object-center rounded-lg"
                        />
                    </div>
                    <!-- Right Text -->
                    <div class="flex flex-col w-4/12 h-full">
                        <h2 class="text-4xl font-bold text-white pb-3.5">Dinsdag 19 Augustus 2025</h2>
                        <div class="text-gray-300 mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                            commodo consequat. Duis aute irure dolor in reprehenderit!
                        </div>
                    </div>
                </div>
            </div>
            <hr class="opacity-10 my-5"/>
        </div>
    </section>
</template>
<script>
    export default {
        name: "Edition"
    };
</script>