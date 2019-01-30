
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-log', require('./components/ChatLog.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));

import io from 'socket.io-client';

const app = new Vue({
    el: '#app',
    data: {
        messages: [],
        socket : io('https://iisustudio-socket-io-node.azurewebsites.net')
    },
    methods: {
        addMessage(message) {
            axios.post('/chat_message', message).then(response => {
                this.socket.emit('chat_message', message);
                $('.inbox_chat').animate({
                    scrollTop: $('.chat_log').height()
                }, 2000);
            });
        },
        getMessage() {
            let self = this;
            axios.get('/chat_log').then(response => {
                console.log(response);
                self.messages = response.data;
                $('.inbox_chat').animate({
                    scrollTop: $('.chat_log').height()
                }, 2000);
            });
        }
    },
    created() {
        this.getMessage();
    },
    mounted() {
        let self = this;
        this.socket.on('chat_message', (data) => {
            console.log(data);
            self.messages = [...self.messages, data];
            // you can also do this.messages.push(data)
            $('.inbox_chat').animate({
                scrollTop: $('.chat_log').height()
            }, 2000);
        });
    }
});
