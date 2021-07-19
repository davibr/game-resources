<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Recursos</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
<!--                <label class="block text-gray-700">Excluídos:</label>-->
<!--                <select v-model="form.trashed" class="mt-1 w-full form-select">-->
<!--                    <option :value="null" />-->
<!--                    <option value="with">With Trashed</option>-->
<!--                    <option value="only">Only Trashed</option>-->
<!--                </select>-->
            </search-filter>
            <inertia-link class="btn-indigo" :href="route('recursos.create')">
                <span>Novo</span>
                <span class="hidden md:inline">Recurso</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Id</th>
                    <th class="px-6 pt-6 pb-4">Nome</th>
                    <th class="px-6 pt-6 pb-4">Jogo</th>
                    <th class="px-6 pt-6 pb-4">Tipo</th>
                </tr>
                <tr v-for="recurso in recursos.data" :key="recurso.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('recursos.edit', recurso.id)">
                            {{ recurso.id }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('recursos.edit', recurso.id)">
                            {{ recurso.nome }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('recursos.edit', recurso.id)">
                            {{ recurso.jogo }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('recursos.edit', recurso.id)">
                            {{ recurso.tipo }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('recursos.link', recurso.id)" tabindex="-1">
                            <icon name="printer" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('recursos.edit', recurso.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="recursos.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">Nenhum recurso encontrado.</td>
                </tr>
            </table>
        </div>
        <pagination class="mt-6" :links="recursos.links" />
    </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'
export default {
    metaInfo: { title: 'Recursos' },
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    layout: Layout,
    props: {
        filtros: Object,
        recursos: Object,
    },
    data() {
        return {
            form: {
                pesquisa: this.filtros.pesquisa,
            },
        }
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function() {
                this.$inertia.get(this.route('recursos'), pickBy(this.form), { preserveState: true })
            }, 150),
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },
}
</script>