<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('jogos')">Jogos</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Novo
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.nome" :error="form.errors.nome" class="pr-6 pb-8 w-full lg:w-1/2" label="Nome" />
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-indigo" type="submit">Adicionar Jogo</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
export default {
    metaInfo: { title: 'Novo Jogo' },
    components: {
        LoadingButton,
        TextInput,
    },
    layout: Layout,
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                nome: null,
            }),
        }
    },
    methods: {
        store() {
            this.form.post(this.route('jogos.store'))
        },
    },
}
</script>