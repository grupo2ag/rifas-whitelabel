<script setup>
import {loadScript} from "vue-plugin-load-script";
// import { computed } from 'vue';
// import {usePage} from '@inertiajs/inertia-vue3';
import {onMounted} from "vue";

import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const config = computed(() => page.props)

const analytics = config.value.siteconfig.google_analytics
const facebookPixel = config.value.siteconfig.facebook_pixel

onMounted(() => {
    setTimeout(() => {
        if (analytics) {
            loadScript("https://www.googletagmanager.com/gtag/js?id=" + analytics)
                .then(() => {
                    window.dataLayer = window.dataLayer || [];

                    function gtag() {
                        dataLayer.push(arguments);
                    }

                    gtag('js', new Date());
                    gtag('config', analytics);
                })
                .catch(() => {
                    // Failed to fetch script
                });
        }
    }, 3000)
})
</script>

<template></template>
