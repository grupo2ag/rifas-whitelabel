<script>
import {defineAsyncComponent, defineComponent} from "vue";
import Header from "@/Components/Header/Header.vue";
// import FooterSing from "@/Components/FooterSing/FooterSing.vue";
// import AdsScript from "@/Components/AdsScript/AdsScript.vue";
const FooterSing = defineAsyncComponent(() => import('@/Components/FooterSing/FooterSing.vue'))
const AdsScript = defineAsyncComponent(() => import('@/Components/AdsScript/AdsScript.vue'))

export default defineComponent(  {
    name: "AppSite",
    components: {
        Header,
        AdsScript,
        FooterSing
    },
});
</script>

<template>
    <Header/>

    <main>
        <slot/>
    </main>

    <FooterSing v-if="route().current('pay') === false"/>

    <AdsScript/>
</template>


