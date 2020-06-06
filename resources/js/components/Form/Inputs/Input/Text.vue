<template>
<div v-show="show" :class="computedWrapperCssClass" :style="computedWrapperCssStyle">
    <slot>
         <validation
           :label="label"
           :id="identity"
           :name="name"
           :show="showValidation"
           :css-class="computedValidationCssClass"
           :validation="validation"
           :error="error"
         ></validation>
    </slot>
    <input
        type="text"
        :id="identity"
        :name="name"
        :value="value"
        :maxlength="maxlength"
        :placeholder="placeholder"
        :class="inputCssClass"
        v-on="inputListeners"
    >
</div>
</template>

<script>
    import Helper from "../../../../core/Helper";
    import Error from "../../Validator/Error";
    import Validation from "../../Validator/Validation";
    export default {
        components: {
            'validation': Validation
        },
        props: {
            group: {
                type: String,
                required: false
            },
            label: {
                type: String,
                required: false
            },
            name: {
                type: String,
                required: true
            },
            id: {
                type: String,
                required: false
            },
            value: {
                default: ''
            },
            currentValue: {
                default: ''
            },
            placeholder: {
                type: String,
                required: false
            },
            focus: {
                type: Boolean,
                default: false
            },
            maxlength: {
                type: String,
                required: false
            },
            autocomplete: {
                type: String,
                required: false
            },
            validation: {
                type: [Array, Object],
                default: () => []
            },
            error: {
                type: Object,
                default: () => new Error
            },
            visible: {
                type: Boolean,
                default: true
            },
            inputCssClass: {
                type: String,
                required: false
            },
            validationCssClass: {
                type: String,
                required: false
            },
            wrapperCssClass: {
                type: String,
                required: false
            },
            wrapperErrorCssClass: {
                type: String,
                default: 'invalid'
            },
            wrapperCssStyle: {
                type: String,
                default: 'invalid'
            },
            wrapperErrorCssStyle: {
                type: String,
                default: 'invalid'
            }
        },
        data() {
            return {
                identity: this.id ? this.id : this.name,
                displayValidation: false,
                show: this.visible
            }
        },
        computed: {
            inputListeners() {
                return Object.assign({}, this.$listeners, {
                    input: event => {
                        this.emit(event.target.value);
                    }
                })
            },
            isInvalid() {
                return this.error.has(this.name);
            },
            showValidation() {
                return this.isInvalid && this.displayValidation;
            },
            computedValidationCssClass() {
                return {
                    [this.validationCssClass]: this.isInvalid
                }
            },
            computedWrapperCssClass() {
                return [
                    {
                        [this.wrapperErrorCssClass]: this.isInvalid
                    },
                    this.wrapperCssClass
                ]
            },
            computedWrapperCssStyle() {
                return [
                    {
                        [this.wrapperErrorCssStyle]: this.isInvalid
                    },
                    this.wrapperCssStyle
                ]
            }
        },
        mounted() {
          this.emit(this.currentValue);
          this.initialize();
        },
        methods: {
            emit(value){
                this.$emit('input', value);
            },
            initialize() {
                if (Helper.isEmpty(this.validation)){
                    return;
                }
                let rules = this.validation;
                if (!Array.isArray(this.validation)){
                    this.displayValidation = true;
                    rules = Object.keys(this.validation);
                }
                EventBus.fire('initialize-' + this.group, {
                    field: this.name,
                    rules: rules
                });
            }
        }
    }
</script>

<style scoped>
.invalid {
    color: red;
}
</style>
