<template>
    <Transition>
        <div class="w-full h-full top-0 left-0 flex place-content-center bg-white relative" v-show="loading">
            <div class="flex items-center gap-2 text-primary place-content-center">
                <span class="h-14 w-14 block rounded-full border-2 border-t-white animate-spin">
                </span>
            </div>
            <Icon name="logo-icon" class="c-loading__icon"/>
        </div>
    </Transition>
</template>

<script>
import Icon from "@/Components/Icon/Icon.vue";

export default {
    name: "LoadingScreen",
    components: {Icon},
    props: {
        loading: Boolean
    }
}
</script>

<style scoped>
.v-enter-active{
    transition: opacity 0s ease;
}
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.c-loading__icon{
    width: 1.725rem;
    height: 1.725rem;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
