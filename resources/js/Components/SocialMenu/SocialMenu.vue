<script>
import Icon from "@/Components/Icon/Icon.vue";

export default {
    name: "SocialMenu",
    components:{
        Icon
    },
    data() {
        return {
            basic: this.$inertia.page.props.siteconfig,
        }
    }
}
</script>

<template>
    <ul class="flex items-center gap-2">
        <li v-if="basic.whatsapp">
            <a :href="basic.whatsapp" target="_blank" class="c-social" aria-label="WhatsApp">
                <Icon name="icon-whatsapp-round" class="fill-[#21bd5b]"/></a>
        </li>

        <li v-if="basic.telegram">
            <a :href="basic.telegram" target="_blank" class="c-social" aria-label="Telegram">
                <Icon name="icon-telegram-round" class="fill-[#0088cc]"/></a>
        </li>

        <li v-if="basic.instagram">
            <a :href="basic.instagram" target="_blank" class="c-social" aria-label="Instagram">
                <Icon name="icon-instagram-round" class="fill-[#d300c5]"/></a>
        </li>

        <li v-if="basic.facebook">
            <a :href="basic.facebook" target="_blank" class="c-social" aria-label="Facebook">
                <Icon name="icon-facebook-round" class="fill-[#4267B2]"/></a>
        </li>
    </ul>
</template>

<style src="./style.scss" lang="scss" scoped/>


