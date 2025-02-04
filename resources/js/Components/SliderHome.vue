<template>
    <swiper
      :modules="[Autoplay]"
      :slides-per-view="5"
      :space-between="64"
      :loop="true"
      :autoplay="{
        delay: 2000, 
        disableOnInteraction: false
      }"
      @swiper="onSwiper"
      @slideChange="onSlideChange"
      class="!pt-16"
    >
      <swiper-slide v-for="(slide, index) in slides" :key="index">
        <img class="h-12 object-contain object-center m-auto" src="/storage/photos/logo-wit-vol-nieuwpoort.svg"/>
      </swiper-slide>
    </swiper>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay } from 'swiper/modules';
import 'swiper/css';
import { ref } from 'vue';

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    const slides = ref(new Array(8).fill(null)); // Dummy array for 8 slides
    const activeIndexes = ref([1, 2, 3]); // Default active slides

    const onSwiper = (swiper) => {
      console.log(swiper);
    };

    const onSlideChange = (swiper) => {
      const centerIndex = swiper.realIndex + 2; // Adjust center position
      activeIndexes.value = [
        centerIndex - 1, 
        centerIndex, 
        centerIndex + 1
      ];
    };

    return {
      onSwiper,
      onSlideChange,
      slides,
      activeIndexes,
      Autoplay,
    };
  },
};
</script>

<style>
.swiper-slide {
    border: 1px solid white;
    padding-top: 40px;
    padding-bottom: 40px;
    border-radius: 12px;
    opacity: 0.4;
    transition: all 0.4S ease-in-out;
}
.swiper-slide:hover{
    @apply opacity-100;
} 
</style>