<template lang="html">
    <div class="chat-log">
        <div class="chat-message" v-for="(message, index) in messages" :message="message">
            <p>{{ message.message }}</p>
            <small>{{ message.user }}</small>
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