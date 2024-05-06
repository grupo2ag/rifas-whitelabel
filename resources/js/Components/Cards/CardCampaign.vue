<script setup>
defineProps({
    title: String,
    image: String,
    description: String
});
</script>

<script>
    export default {
    name: "CardCampaign"
}
</script>

<template>

    <div class="card bg-[#dedede]">
        <div class="flex flex-row mb-2">
            <div class="w-full">
                <!-- adicionar image dinamica -->
                <figure><img src="https://mundoemrevista.com.br/wp-content/uploads/2024/01/trevo-de-quatro-folhas.webp" alt="" />
                </figure>
            </div>
        </div>
        <div class="flex flex-row flex-row-reverse flex-wrap px-2">
            <div class="gap-2 py-2 badge badge-success">
                Ativo
            </div>
        </div>
        <div class="flex flex-row flex-wrap px-2">
            <div class="w-full mb-2">
                <div class="text-primary card-title">{{ title }}</div>
            </div>
            <div class="justify-start w-full text-black max-h-24 min-h-24">
                <p>{{ description }}</p>
            </div>
        </div>
        <div class="flex flex-row items-center mb-4">
            <div class="justify-start w-6/12 px-3">
                <div class="radial-progress text-primary" style="--value:70;" role="progressbar">70%</div>
            </div>
            <div class="justify-end w-6/12 px-3 card-actions">
                <button class="text-white btn btn-primary">+ Detalhes</button>
            </div>
        </div>
    </div>

</template>
