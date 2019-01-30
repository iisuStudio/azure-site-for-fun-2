<template lang="html">
    <div class="chat_log">
        <div class="chat_list" v-for="(message, index) in messages">
            <div class="chat_ib" :message="message">
                <h5>{{ message.user }} <span class="chat_date">Dec 25</span></h5>
                <p>{{ message.message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['messages']
    }
</script>

<style lang="css">
    .chat-message {
        padding: 1rem;
    }

    .chat-message > p {
        margin-bottom: .5rem;
    }

    .chat-log .chat-message:nth-child(even) {
        background-color: #ccc;
    }
</style>