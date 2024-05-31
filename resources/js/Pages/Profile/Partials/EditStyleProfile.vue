<script setup>
import ActionSection from '@/Components/ActionSection.vue';
import { ref } from "vue";

</script>

<script>
export default {
    data() {
        return {
            currentTheme: '',
            currentColor: ''
        };
    },
    mounted() {
        this.currentTheme = this.$page?.props?.siteconfig?.theme;
        this.currentColor = this.translateColorToRgba(this.$page?.props?.siteconfig?.primary_color);
    },
    methods: {
        changePrimaryColor(color) {
            document.documentElement.style.setProperty('--primary', this.translateColorRgbToDefaultType(color));
            this.setPrimaryBWColor(color);
            this.setConfigurationsDb({ 'primary_color': this.translateColorRgbToDefaultType(color) });
        },
        translateColorToRgba(color) {
            const colorArray = color.replace(/ /g, ', ');
            return `rgba(${colorArray}, 1)`
        },
        translateColorRgbToDefaultType(colorRgb) {
            if (colorRgb) {
                const rgbaValues = colorRgb.match(/\d+/g);
                return rgbaValues.slice(0, 3).join(' ');
            }
            return colorRgb;
        },
        setTheme() {
            document.documentElement.setAttribute('theme', this.currentTheme == 'light' ? 'dark' : 'light');
            this.currentTheme = this.currentTheme == 'light' ? 'dark' : 'light';
            this.setConfigurationsDb({ 'theme': this.currentTheme });
        },
        setConfigurationsDb(payload) {
            axios.put(route('user.userStore', payload)).then(res => {
                console.log(true);
            }).catch((err) => {
                console.log(false);
            });
        },
        ////////////////// metodos para calcular cor para constrastar com a primary \\\\\\\\\\\\\\\\\\\
        setPrimaryBWColor(rgbString) {
            const rgbArray = this.rgbStringToRgbArray(rgbString);
            if (rgbArray && rgbArray.length === 3) {
                const luminosity = this.getLuminosity(rgbArray[0], rgbArray[1], rgbArray[2]);
                const bwColor = luminosity > 0.5 ? '0 0 0' : '255 255 255'; // black if bright, white if dark

                document.documentElement.style.setProperty('--primary-bw', bwColor);
            }
        },
        rgbStringToRgbArray(rgbString) {
            const result = rgbString.match(/\d+/g);
            return result ? result.map(Number) : null;
        },
        getLuminosity(r, g, b) {
            const [h, s, l] = this.rgbToHsl(r, g, b);
            return l;
        },
        rgbToHsl(r, g, b) {
            r /= 255;
            g /= 255;
            b /= 255;
            let max = Math.max(r, g, b), min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;

            if (max == min) {
                h = s = 0; // achromatic
            } else {
                let d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                switch (max) {
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    case b: h = (r - g) / d + 4; break;
                }
                h /= 6;
            }
            return [h, s, l];
        }
        //////////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    }
}
</script>

<template>
    <ActionSection>
        <template #content>
            <div class="flex flex-row w-full mb-4">
                <div class="flex justify-start w-6/12">
                    <div class="text-primary card-title">Configurações Visuais</div>
                </div>
                <div class="flex justify-end w-6/12">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="5" />
                            <path
                                d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
                        </svg>
                        <input type="checkbox" @input="() => setTheme()" id="hs-basic-usage"
                            :checked="$page?.props?.siteconfig?.theme == 'dark' ? true : false"
                            class="relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 disabled:opacity-50 disabled:pointer-events-none checked:bg-none   dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600
before:inline-block before:size-6 before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-200">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </label>
                </div>
            </div>
            <div class="flex flex-row w-full">
                <div class="flex justify-start w-full">
                    <div class="flex flex-row items-center">
                        <h1 class="mr-2 font-sans text-lg">Cor Primária</h1>
                        <color-picker @pureColorChange="(color) => changePrimaryColor(color)"
                            :theme="this.currentTheme == 'dark' ? 'black' : 'white'" :shape="'circle'"
                            v-model:pureColor="this.currentColor"></color-picker>
                    </div>
                </div>
            </div>
        </template>
    </ActionSection>
</template>
