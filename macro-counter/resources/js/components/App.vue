<template>
    <div class="bg-[lightgreen] p-[1rem] rounded-[2rem]">
        <router-link to="/" class="m-[2rem] p-[1rem]"> Home </router-link>
        <router-link to="/tasks" class="m-[2rem] p-[1rem]"> Tasks </router-link>
    </div>
    <div>
        <router-view></router-view>
    </div>
</template>

<style scoped>
</style>