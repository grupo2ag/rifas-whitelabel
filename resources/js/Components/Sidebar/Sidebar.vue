<script setup>
import SidebarAdmin from "./SidebarAdmin.vue";
import SidebarSeller from "./SidebarSeller.vue";
</script>


<template>
    <nav class="hidden px-3 py-4 sidebar bg-primary rounded-xl md:block lg:block ">
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
