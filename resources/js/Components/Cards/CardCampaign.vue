<script setup>
defineProps({
    title: String,
    image: String,
    description: String
});
</script>

<template>

    <div class="card bg-[#dedede]">
        <div class="flex flex-row mb-2">
            <div class="w-full">
                <!-- adicionar image dinamica -->
                <figure><img src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="" />
                </figure>
            </div>
        </div>
        <div class="flex flex-row flex-row-reverse flex-wrap px-2">
            <div class="gap-2 py-2 badge badge-info">
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
        <div class="flex flex-row mb-4">
            <div class="justify-end w-full px-2 card-actions">
                <button class="text-white btn btn-primary">+ Detalhes</button>
            </div>
        </div>
    </div>

</template>
