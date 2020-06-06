import Vue from 'vue';
import axios from 'axios';
import EventBus from "./core/EventBus";

window.Vue = Vue;
window.axios = axios;
window.EventBus = new EventBus;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


Vue.component('form-wrapper', require('./components/Form/Wraper').default);
Vue.component('text-input', require('./components/Form/Inputs/Input/Text').default);
Vue.component('validation', require('./components/Form/Validator/Validation').default);
Vue.component('top-dialog', require('./components/Dialogs/TopDialog').default);

const app = new Vue({
    el: '#app',
});
