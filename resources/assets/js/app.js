
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
Vue.use(VueResource);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('body-seguro', require('./components/seguro-auto/BodySeguroResearch.vue').default);
Vue.component('body-carsystem', require('./components/carsystem/BodyCarsystemResearch.vue').default);
Vue.component('body-ead', require('./components/ead/BodyEadResearch.vue').default);
Vue.component('body-greenpeace-oceanos', require('./components/greenpeace-oceanos/BodyGreenpeaceOceanosResearch.vue').default);
Vue.component('body-alfacon', require('./components/alfacon/BodyAlfaconResearch.vue').default);
Vue.component('body-quiz', require('./components/quiz/BodyQuizResearch.vue').default);
Vue.component('body-quiz2', require('./components/quiz/BodyQuizResearch2.vue').default);
Vue.component('body-quiz3', require('./components/quiz/BodyQuizResearch3.vue').default);

const app = new Vue({
    el: '#app'
});
