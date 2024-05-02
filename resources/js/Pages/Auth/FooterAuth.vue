<template>
    <div class="w-full p-5">
        <div class="flex items-center mb-2">
            <div class="px-2 py-1 mr-4 bg-gray-100 rounded-lg md:mr-6">
                <IconsSvg name="logo-rifa8"  class="w-8 h-8 fill-primary" />
            </div>

            <nav class="flex gap-4 md:gap-6">
                <a

                target="_blank" class="text-sm underline ">Termos de uso</a>
                <a

                target="_blank" class="text-sm underline ">Política de privacidade</a>
            </nav>
        </div>

        <div class="flex flex-col gap-2 md:flex-row md:items-center md:gap-4">
            <p class="text-xs">Todos os direitos reservados. @rifa8 {{ new Date().getFullYear() }}</p>
        </div>
    </div>
</template>

<script>
import IconsSvg from "@/Components/IconsSvg/IconsSvg.vue";

export default {
    name: "FooterAuth",
    components: {
        IconsSvg
    }
}
</script>
