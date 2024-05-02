<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import IconsSvg from "@/Components/IconsSvg/IconsSvg.vue";
import FooterAuth from "@/Pages/Auth/FooterAuth.vue";
</script>

<template>
    <div class="flex w-full h-screen">
        <div class="relative flex items-end justify-center hidden bg md:w-4/12 lg:w-4/12 md:flex bg-primary">
            <Link href="/" class="z-10">
                <IconsSvg name="logo-rifa8-icon" class="flex w-100 fill-white"></IconsSvg>
            </Link>
        </div>

        <div class="flex flex-col items-center justify-center w-full md:w-8/12 lg:w-8/12 bg-bgadm">
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
    </div>
</template>


<style>
.icon-absolute {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10px;
}
</style>
