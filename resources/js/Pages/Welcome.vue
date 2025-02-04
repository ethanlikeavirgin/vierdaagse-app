<script>
    import Container from '@/Components/Container.vue';
    import Logo from '@/Components/LogoMain.vue';
    import Sliderhome from '@/Components/SliderHome.vue';
    import Edition from '@/Components/Edition.vue';
    import Reviews from '@/Components/Reviews.vue';
    export default {
        components: {
            Container,
            Logo,
            Sliderhome,
            Edition,
            Reviews,
        }
    };
</script>

<template>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">
    <div class="relative z-0 bg-cover bg-center" style="background-image: url('/storage/photos/Hero_Home_Vierdaagse.png')">
        <a class="absolute -left-10 bottom-0 h-[400px]">
            <Logo></Logo>
        </a>
        <Container>
            <div class="v-hero">
                <h1 class="text-white uppercase tracking-tight relative z-20 pl-10 pb-24">Vierdaagse<br>van de ijzer</h1>
            </div>
        </Container>
    </div>
    <Sliderhome></Sliderhome>
    <Container>
        <!-- Main Container -->
        <div class="flex lg:flex-row flex-col pt-16 gap-20 lg:items-center font-afacad text-white">
            <!-- Left Section -->
            <div class="mb-8 lg:mb-0 w-5/12">
                <h2 class="text-6xl font-bold mb-4">Over ons</h2>
                <p class="text-lg pb-10">
                    De 51ste editie van de Vierdaagse is achter de rug en dankzij jullie talrijke opkomst is het met 11.405 individuele deelnemers die elk 1 of meerdere dagen hebben deelgenomen een recordeditie geworden. Ruim 300 wandelaars meer dan tijdens de honderdjarige herdenkingseditie van WO I in 2014.
                </p>
                <a href="#" class="btn btn--primary">
                    Lees meer →
                </a>
                <div class="pt-16">
                    <h2 class="text-4xl font-bold">11,405+</h2>
                    <p class="text-lg">Deelnemers</p>
                    <hr class="opacity-10 my-5"/>
                </div>
                <div class="mb-6 lg:mb-0">
                    <h2 class="text-4xl font-bold">7,000+</h2>
                    <p class="text-lg">Wandelaars op dag 3</p>
                    <hr class="opacity-10 my-5"/>
                </div>
                <div>
                    <h2 class="text-4xl font-bold">6,000+</h2>
                    <p class="text-lg">Wandelaars per dag</p>
                    <hr class="opacity-10 my-5"/>
                </div>
            </div>
            
            <!-- Right Section -->
            <div class="flex flex-wrap justify-center w-7/12 relative min-h-600px">
                <div class="w-1/2 absolute left-0 top-4 z-10">
                    <img class="rounded-lg shadow-lg object-cover object-center min-h-600px" src="https://images.unsplash.com/photo-1737071371043-761e02b1ef95?q=80&w=2166&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Person 1"/>
                </div>
                <div class="w-2/3 absolute right-0 top-4">
                    <img class="rounded-lg shadow-l object-cover object-center min-h-600px" src="https://images.unsplash.com/photo-1737111869094-80ed40daca91?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHw2fHx8ZW58MHx8fHx8" alt="Person 2"/>
                </div>
            </div>
        </div>
        <Edition></Edition>
        <Reviews></Reviews>
        <!-- BULB -->
        <div class="v-bulb z-[-1]"></div>
    </Container>
</template>