<template>
    <div>
        <input :id="id" ref="input" v-bind="$attrs" :class="{ error: error }" :type="type" :value="value" @input="$emit('input', $event.target.value)" />
        <label v-if="label" :for="id">{{ label }}</label>
        <div v-if="error" class="form-error">{{ error }}</div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `checkbox-input-${this._uid}`
            },
        },
        type: {
            type: String,
            default: 'checkbox',
        },
        value: {
            type: Number,
            default: 1,
        },
        label: String,
        error: String,
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        // select() {
        //     this.$refs.input.select()
        // },
        // setSelectionRange(start, end) {
        //     this.$refs.input.setSelectionRange(start, end)
        // },
    },
}
</script>