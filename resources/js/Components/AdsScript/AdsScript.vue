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

        if (facebookPixel) {
            //Meta Pixel Code
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', facebookPixel);
            fbq('track', 'PageView');

            // End Meta Pixel Code
        }

    }, 5000)
})
</script>

<template></template>
