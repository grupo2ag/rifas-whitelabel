<script setup>
import SidebarAdmin from "./SidebarAdmin.vue";
import SidebarSeller from "./SidebarSeller.vue";
</script>


<template>
    <nav class="px-3 py-4 sidebar bg-primary rounded-xl">
        <div class="flex flex-col justify-between h-full">
            <div class="flex flex-col h-full">
                <!-- <SidebarAdmin  /> -->
                <SidebarSeller />
            </div>
        </div>
    </nav>
</template>

<style src="./style.scss" lang="scss" scoped />

<style lang="scss">
</style>
