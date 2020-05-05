/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

const app = new Vue({
    el: '#app',
    data: {
        check: true,
        teachers: [],
        fakeList: [],
        currentTeacher: null,
        currentEmail: null,
        buttonOk: false,
        dropzoneOptions: {
            url: '/csv',
            thumbnailWidth: 150,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            acceptedFiles: "text/csv",
            init: function () {
                this.on('complete', function () {
                    location.reload();
                });
            }
        },
        dropzoneButton: false,
        errorEmail: "",
        errorTeacher: ""
    },
    components: {
        vueDropzone: vue2Dropzone
    },
    computed: {
        fakelistStyle() {
            return this.fakeList ? { 'display': 'table-row' } : {}
        }
    },
    methods: {
        choice(type) {
            if (type === 'teacher') {
                const found = this.teachers.find(element => element.name.toLowerCase() === this.currentTeacher.toLowerCase());
                if (found) {
                    this.currentEmail = found.email;
                    this.currentTeacher = found.name;
                }
            } else {
                const found = this.teachers.find(element => element.email.toLowerCase() === this.currentEmail.toLowerCase());
                if (found) {
                    this.currentEmail = found.email;
                    this.currentTeacher = found.name;
                }
            }
        },
        addTeacher(e) {
            window.axios.post('/storeTeacher', { name: this.currentTeacher, email: this.currentEmail })
                .then(response => {
                    this.teachers = response.data.teachers;
                    if (response.data.newTeacher) {
                        this.fakeList.push(response.data.newTeacher);
                    }
                    this.currentEmail = '';
                    this.currentTeacher = '';
                })
        },
        refreshPage(e) {
            e.preventDefault();
            e.stopPropagation();
            location.reload();
        }
    },
    computed: {
    },
    mounted() {
        //console.log(csrf);
        //this.$refs.fakelist.classList.remove('fakelist');

        window.axios.get('/getTeachers')
            .then(response => {
                this.teachers = response.data;
            })
    },
    beforeMount() {
        //document.querySelector('.fakelist').classList.remove('fakelist');
    }
});
