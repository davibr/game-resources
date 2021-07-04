<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('jogos')">Jogos</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> {{ form.nome }}
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="update">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.nome" :error="form.errors.nome" class="pr-6 pb-8 w-full lg:w-1/2" label="Nome" />
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Excluir Jogo</button>
                    <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Atualizar Jogo</loading-button>
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
    metaInfo() {
        return {
            title: `${this.form.nome}`
        }
    },
    components: {
        LoadingButton,
        TextInput,
    },
    layout: Layout,
    props: {
        jogo: Object
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                nome: this.jogo.nome,
            }),
        }
    },
    methods: {
        update() {
            this.form.put(this.route('jogos.update', this.jogo.id))
        },
        destroy() {
            if (confirm('Deseja realmente excluir este jogo?')) {
                this.$inertia.delete(this.route('jogos.destroy', this.jogo.id))
            }
        }
    },
}
</script>