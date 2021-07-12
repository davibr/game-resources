<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('recursos')">Recursos</inertia-link>
            <span class="text-indigo-400 font-medium">/</span> Novo
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
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
                    <checkbox-input v-model="form.marcar_posicao" :error="form.errors.marcar_posicao" class="pr-6 pb-8 w-full lg:w-1/2" label="Marcar Posição" />
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-indigo" type="submit">Adicionar Recurso</loading-button>
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
import CheckboxInput from "../../Shared/CheckboxInput";
export default {
    metaInfo: { title: 'Novo Recurso' },
    components: {
        SelectInput,
        LoadingButton,
        TextInput,
        CheckboxInput,
    },
    props: {
        jogos: Array,
        tiposRecursos: Array,
    },
    layout: Layout,
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                nome: null,
                jogo_id: null,
            }),
        }
    },
    methods: {
        store() {
            this.form.post(this.route('recursos.store'))
        },
    },
}
</script>