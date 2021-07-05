<template>
    <div>
        <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
                <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
            </inertia-link>
        </div>
        <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('jogos')">
                <icon name="game" class="w-4 h-4 mr-2" :class="isUrl('jogos') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('jogos') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Jogos</div>
            </inertia-link>
        </div>
        <div class="mb-4">
            <inertia-link class="flex items-center group py-3" :href="route('recursos')">
                <icon name="game-resource" class="w-4 h-4 mr-2" :class="isUrl('recursos') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
                <div :class="isUrl('recursos') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Recursos</div>
            </inertia-link>
        </div>
<!--        <div class="mb-4">-->
<!--            <inertia-link class="flex items-center group py-3" :href="route('contacts')">-->
<!--                <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--                <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>-->
<!--            </inertia-link>-->
<!--        </div>-->
<!--        <div class="mb-4">-->
<!--            <inertia-link class="flex items-center group py-3" :href="route('reports')">-->
<!--                <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--                <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Reports</div>-->
<!--            </inertia-link>-->
<!--        </div>-->
    </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
    components: {
        Icon,
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter(url => currentUrl.startsWith(url)).length
        },
    },
    name: "MainMenu"
}
</script>

<style scoped>

</style>