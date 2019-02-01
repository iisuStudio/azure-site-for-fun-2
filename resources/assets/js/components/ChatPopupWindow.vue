<template>
    <div>
        <beautiful-chat
                :participants="participants"
                :titleImageUrl="titleImageUrl"
                :onMessageWasSent="onMessageWasSent"
                :messageList="messageList"
                :newMessagesCount="newMessagesCount"
                :isOpen="isChatOpen"
                :close="closeChat"
                :open="openChat"
                :showEmoji="true"
                :showFile="true"
                :showTypingIndicator="showTypingIndicator"
                :colors="colors"
                :alwaysScrollToBottom="alwaysScrollToBottom"
                :messageStyling="messageStyling">
        </beautiful-chat>
    </div>
</template>

<script>
    import io from 'socket.io-client';
    export default {
        name: 'app',
        data() {
            return {
                participants: [
                    {
                        id: 'user1',
                        name: 'Matteo',
                        imageUrl: 'https://avatars3.githubusercontent.com/u/1915989?s=230&v=4'
                    },
                    {
                        id: 'user2',
                        name: 'Support',
                        imageUrl: 'https://avatars3.githubusercontent.com/u/37018832?s=200&v=4'
                    }
                ], // the list of all the participant of the conversation. `name` is the user name, `id` is used to establish the author of a message, `imageUrl` is supposed to be the user avatar.
                titleImageUrl: 'https://a.slack-edge.com/66f9/img/avatars-teams/ava_0001-34.png',
                messageList: [
                    { type: 'text', author: `me`, data: { text: `Say yes!` } },
                    { type: 'text', author: `user1`, data: { text: `No.` } }
                ], // the list of the messages to show, can be paginated and adjusted dynamically
                newMessagesCount: 0,
                isChatOpen: false, // to determine whether the chat window should be open or closed
                showTypingIndicator: '', // when set to a value matching the participant.id it shows the typing indicator for the specific user
                colors: {
                    header: {
                        bg: '#4e8cff',
                        text: '#ffffff'
                    },
                    launcher: {
                        bg: '#4e8cff'
                    },
                    messageList: {
                        bg: '#ffffff'
                    },
                    sentMessage: {
                        bg: '#4e8cff',
                        text: '#ffffff'
                    },
                    receivedMessage: {
                        bg: '#eaeaea',
                        text: '#222222'
                    },
                    userInput: {
                        bg: '#f4f7f9',
                        text: '#565867'
                    }
                }, // specifies the color scheme for the component
                alwaysScrollToBottom: false, // when set to true always scrolls the chat to the bottom when new events are in (new message, user starts typing...)
                messageStyling: true, // enables *bold* /emph/ _underline_ and such (more info at github.com/mattezza/msgdown)
                socket: io('https://iisustudio-socket-io-node.azurewebsites.net')
            }
        },
        created() {

        },
        mounted() {
            this.socket.on('chat_message', (message) => {
                this.addMessage(message);
            });
        },
        methods: {
            sendMessage (text) {
                if (text.length > 0) {
                    console.log(text);
                    this.newMessagesCount = this.isChatOpen ? this.newMessagesCount : this.newMessagesCount + 1;
                    this.onMessageWasSent({ author: 'support', type: 'text', data: { text } })
                }
            },
            addMessage (message) {
                this.messageList = [ ...this.messageList, message ];
            },
            onMessageWasSent (message) {
                let data = message;
                axios.post('/chat_message', message).then(response => {
                    if(response.data.status){
                        data.author = response.data.id;
                        this.socket.emit('chat_message', data);
                    }
                });
            },
            openChat () {
                // called when the user clicks on the fab button to open the chat
                this.isChatOpen = true;
                this.newMessagesCount = 0;
                //
                axios.get('/chat_log').then(response => {
                    console.log(response.data);
                    this.messageList = response.data.aaData;
                });
            },
            closeChat () {
                // called when the user clicks on the botton to close the chat
                this.isChatOpen = false
            }
        }
    }
</script>

