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
        <h2 class="mt-12 font-bold text-2xl">Recursos</h2>
        <div class="mt-6 bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Nome</th>
                    <th class="px-6 pt-6 pb-4">Tipo</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Link</th>
                </tr>
                <tr v-for="recurso in jogo.recursos" :key="recurso.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('recurso.edit', recurso.id)">
                            {{ recurso.nome }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('recursos.edit', recurso.id)" tabindex="-1">
                            {{ recurso.tipo_recurso.nome }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('recursos.edit', recurso.id)" tabindex="-1">
                            {{ recurso.link }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('recursos.edit', recurso.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="jogo.recursos.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">Nenhum recurso encontrado.</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import Icon from '@/Shared/Icon'
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
        Icon
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