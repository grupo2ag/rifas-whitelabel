<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import IconsSvg from "@/Components/IconsSvg/IconsSvg.vue";
import FooterAuth from "@/Pages/Auth/FooterAuth.vue";
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <IconsSvg name="icon-rifa8" class="w-30 fill-primary"></IconsSvg>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>


<!-- <div class="flex w-full h-screen">
    <div class="relative flex items-end justify-center hidden bg md:w-4/12 lg:w-4/12 md:flex bg-primary">
        <Link href="/" class="z-10">
            <IconsSvg name="logo-rifa8-icon" class="flex w-100 fill-white"></IconsSvg>
        </Link>
    </div>

    <div class="flex flex-col items-center justify-center w-full md:w-8/12 lg:w-8/12 bg-root">
        <div class="flex items-center justify-center flex-1 w-full mt-10 md:mt-20">
            <div class="flex flex-col w-10/12 gap-6 md:w-80 md:gap-8">
                <Link href="/" class="">
                    <IconsSvg name="icon-rifa8" class="w-30 fill-primary"></IconsSvg>
                </Link>

                <slot />
            </div>
        </div>

        <FooterAuth />
    </div>
</div> -->