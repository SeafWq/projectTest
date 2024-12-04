<template>
    <HeaderComponent/>
    <router-view></router-view>
</template>

<script>
    import HeaderComponent from "./PageComponent/HeaderComponent.vue";

    export default {
        components: {
            HeaderComponent
        }
    }
</script>

<style>

</style>
