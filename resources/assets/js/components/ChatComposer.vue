<template lang="html">
    <div class="type_msg">
        <div class="input_msg_write">
            <input type="text" class="write_msg user" placeholder="暱稱" v-model="userName" @keyup.enter="sendMessage"/>
            <input type="text" class="write_msg message" placeholder="請輸入文字..." v-model="messageText" @keyup.enter="sendMessage"/>
            <button class="msg_send_btn" type="button" @click="sendMessage"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
        </div>
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