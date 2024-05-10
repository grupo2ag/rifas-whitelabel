<script>
// import {PencilIcon, UploadIcon, UserCircleIcon} from '@heroicons/vue/outline'
// import Input from '@/Components/Input.vue'
import { CloudArrowUpIcon } from '@heroicons/vue/24/outline'

export default {
    name: "ImageUpload",
    components: {CloudArrowUpIcon},
    props: ['modelValue', 'error', 'size', 'recommended', 'formats', 'filesize', 'name', 'imgCurrent', 'label'],
    emits: ['update:modelValue'],
    data() {
        return {
            image: '',
            preview: this.modelValue ? this.modelValue : '',
        }
    },
    methods: {
        fileupload(event) {
            this.image = event.target.files[0]
            this.preview = URL.createObjectURL(this.image)
            this.$emit('update:modelValue', event.target.files[0])
        }
    },
    mounted() {
        this.preview = this.imgCurrent
    }
}
</script>

<template>
    <div class=" mx-auto flex relative">
        <input type="file" :id="name" class="hidden" v-on:change="fileupload"/>

        <label :for="name" class="px-2 block text-neutral/70 text-[13px] font-semibold absolute top-[3px] left-1 z-10 bg-content">
            {{ label }}
        </label>

        <div class="c-filepond flex flex-col mt-3 items-center">
            <label :for="name" class="c-filepond__preview"
                   v-bind:class="[preview ? 'active' : '', 'c-filepond__preview--'+size]"
                   v-bind:style="{ background: 'url(' +  preview  + ')' }">
                <div class="absolute top-[45%] flex flex-col items-center">
                    <CloudArrowUpIcon class="w-6 stroke-success "/>
                    <p class="text-sm text-neutral/70 text-center">Faça o upload</p>
                </div>
            </label>

            <p class="text-neutral/70 text-xs mt-3">Obs: A dimensão ideal é
                <strong>768x580</strong>, JPEG, PNG, WEBP de no máximo de <strong>2 MB.</strong></p>

            <div class="hidden w-full md:w-7/12 border border-success mt-3 md:mt-0 p-3 rounded-md md:ml-6 min-h-[95px]">
                <p class="text-white-dark font-normal text-sm py-1 leading-tight">
                    Imagens com dimensões diferentes serão redimensionadas.
                </p>

                <p v-if="recommended" class="text-white-dark font-normal text-sm py-1 leading-tight">
                    A dimensão recomendada é de <strong class=" text-white">{{ recommended }}</strong>
                </p>

                <p v-if="filesize" class="text-white-dark font-normal text-sm py-1 leading-tight">
                    Formato <strong class="text-white">{{ formats }}</strong> de no máximo
                    {{ filesize }}.
                </p>
            </div>
        </div>
    </div>

</template>

<style src="./style.scss" lang="scss" scoped/>

