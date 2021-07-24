<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('recursos')">Recursos</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> {{ form.nome }}
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="update">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.nome" :error="form.errors.nome" class="pr-6 pb-8 w-full lg:w-1/2" label="Nome" />
                    <select-input v-model="form.jogo_id" :error="form.errors.jogo_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Jogo">
                        <option :value="null" />
                        <option v-for="jogo in jogos" :key="jogo.id" :value="jogo.id">{{ jogo.nome }}</option>
                    </select-input>
                    <select-input v-model="form.tipo_recurso_id" :error="form.errors.tipo_recurso_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Tipo">
                        <option :value="null" />
                        <option v-for="tipo in tiposRecursos" :key="tipo.id" :value="tipo.id">{{ tipo.nome }}</option>
                    </select-input>
                    <text-input v-model="form.link" :error="form.errors.link" class="pr-6 pb-8 w-full lg:w-1/2" label="Link" />
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Excluir Recurso</button>
                    <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Atualizar Recurso</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from "../../Shared/SelectInput";
export default {
    metaInfo() {
        return {
            title: `${this.form.nome}`
        }
    },
    components: {
        SelectInput,
        LoadingButton,
        TextInput,
    },
    layout: Layout,
    props: {
        recurso: Object,
        jogos: Array,
        tiposRecursos: Array,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                nome: this.recurso.nome,
                jogo_id: this.recurso.jogo_id,
                tipo_recurso_id: this.recurso.tipo_recurso_id,
                link: this.recurso.link
            }),
        }
    },
    methods: {
        update() {
            this.form.put(this.route('recursos.update', this.recurso.id))
        },
        destroy() {
            if (confirm('Deseja realmente excluir este recurso?')) {
                this.$inertia.delete(this.route('recursos.destroy', this.recurso.id))
            }
        }
    },
}
</script>