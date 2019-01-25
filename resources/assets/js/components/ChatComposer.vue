<template lang="html">
    <div class="chat-composer">
        <input class='user' type="text" placeholder="暱稱" v-model="userName" @keyup.enter="sendMessage"/>
        <input class='message' type="text" placeholder="請輸入文字..." v-model="messageText" @keyup.enter="sendMessage"/>
        <button class="btn btn-primary" @click="sendMessage">Send</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messageText: '',
                userName: ''
            }
        },
        methods: {
            sendMessage() {
                console.log(this.messageText);
                this.$emit('messagesent', {
                    message: this.messageText,
                    user: this.userName
                });
                this.messageText = '';
            }
        }
    }
</script>

<style lang="css">
    .chat-composer {
        display: flex;
    }

    .chat-composer input {
        flex: 1 auto;
    }

    .chat-composer button {
        border-radius: 0;
    }
</style>