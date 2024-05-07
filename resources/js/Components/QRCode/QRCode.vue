<template>
    <vue-qrcode
        :value="value"
        @change="onDataUrlChange"
        :width="width"
    />
</template>

<script>
import VueQrcode from 'vue-qrcode'
export default {
    name: 'QRCode',
    props:{
        value: String,
        width: String
    },
    data() {
        return {
            dataUrl: null,
        }
    },
    components: {
        VueQrcode,
    },
    methods: {
        onDataUrlChange(dataUrl) {
            this.dataUrl = dataUrl
        },
    },
}
</script>

<style scoped>

</style>
