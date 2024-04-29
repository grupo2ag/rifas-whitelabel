<script>
import Icon from "@/Components/Icon/Icon.vue";

export default {
    name: "SocialMenu",
    components:{
        Icon
    },
    data() {
        return {
           // basic: this.$inertia.page.props.siteConfig.basic_configurations[0],
        }
    }
}
</script>

<template>
    <ul class="flex items-center gap-2">

        <li>
            <a href="" target="_blank" class="block" aria-label="Facebook">
                <Icon name="icon-whatsapp-round" class="w-8 h-8 fill-[#21bd5b]"/></a>
        </li>

        <li>
            <a href="" target="_blank" class="block" aria-label="Linkedin">
                <Icon name="icon-telegram-round" class="w-8 h-8 fill-[#0088cc]"/></a>
        </li>

        <li>
            <a href="" target="_blank" class="block" aria-label="Instagram">
                <Icon name="icon-instagram-round" class="w-8 h-8 fill-[#d300c5]"/></a>
        </li>

        <li>
            <a href="" target="_blank" class="block" aria-label="Facebook">
                <Icon name="icon-facebook-round" class="w-8 h-8 fill-[#4267B2]"/></a>
        </li>
<!--
        <li v-if="basic.instagram">
            <button type="button" class="block" @click="socialClick(basic.instagram,'instagram')" aria-label="Instagram">
                <Icon name="icon-instagram-round" class="w-7 h-7 fill-black md:hidden"/>
                <Icon name="icon-instagram-square" class="w-6 h-6 fill-black hover:opacity-70 hidden md:block"/>
            </button>
        </li>

        <li v-if="basic.twitter">
            <button type="button" class="block" @click="socialClick(basic.twitter,'twitter')" aria-label="Twitter">
                <Icon name="icon-x-round" class="w-7 h-7 fill-black md:hidden"/>
                <Icon name="icon-x-square" class="w-6 h-6 fill-black hover:opacity-70 hidden md:block"/>
            </button>
        </li>

        <li v-if="basic.youtube">
            <button type="button" class="block" @click="socialClick(basic.youtube,'youtube')" aria-label="Youtube">
                <Icon name="icon-youtube-round" class="w-7 h-7 fill-black md:hidden"/>
                <Icon name="icon-youtube-square" class="w-6 h-6 fill-black hover:opacity-70 hidden md:block"/>
            </button>
        </li>

        <li v-if="basic.tiktok">
            <button type="button" class="block" @click="socialClick(basic.tiktok,'tiktok')" aria-label="Tiktok">
                <Icon name="icon-tiktok-round" class="w-7 h-7 fill-black md:hidden"/>
                <Icon name="icon-tiktok-square" class="w-6 h-6 fill-black hover:opacity-70 hidden md:block"/>
            </button>
        </li>-->
    </ul>
</template>

