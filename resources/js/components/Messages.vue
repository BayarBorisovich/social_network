<template>
    <div class="row g-0">
        <div class="col-12 col-lg-7 col-xl-9">
            <div class="py-2 px-4 border-bottom d-none d-lg-block">
                <div class="d-flex align-items-center py-1">
                    <div class="position-relative">
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                             class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                    </div>
                    <div class="flex-grow-1 pl-3">
                        <strong>{{ receiver.name }}</strong>
                        <div class="text-muted small"><em> </em></div>
                    </div>
                </div>
            </div>
            <div class="position-relative">
                <div class="chat-messages p-4" v-for="message in isMessages()">
                    <div class="chat-message-right pb-4" v-if="message.sender_id === sender.id">
                        <div>
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                 class="rounded-circle mr-1" alt="Chris Wood" width="40"
                                 height="40">
                            <div
                                class="text-muted small text-nowrap mt-2">{{ message.created_at }}
                            </div>
                        </div>
                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                            <div class="font-weight-bold mb-1">{{ message.author.name }}</div>
                            {{ message.content }}
                        </div>
                    </div>
                    <!--                    @else-->
                    <div class="chat-message-left pb-4" v-else>
                        <div>
                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                 class="rounded-circle mr-1" alt="Sharon Lessman" width="40"
                                 height="40">
                            <div
                                class="text-muted small text-nowrap mt-2">{{ message ? message.created_at : '' }}
                            </div>
                        </div>
                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                            <div
                                class="font-weight-bold mb-1">{{ message.author.name }}
                            </div>
                            {{ message.content }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-grow-0 py-3 px-4 border-top">
                <div class="form-group">
                    <span class="error" v-if="errors?.textMessage">{{ errors.textMessage[0] }}</span>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" v-model="textMessage" name="textMessage"
                           placeholder="Type your message" value="">
                    <input @click.prevent="createMessages(receiver.id)" type="submit"
                           class="btn btn-primary"
                           value="Send">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Messages",

    props: {
        messages: null,
        sender: null,
        receiver: null,
    },

    data() {
        return {
            textMessage: null,
            errors: {},
        }
    },

    mounted() {
        this.isMessages()
        console.log(this.messages)
    },

    methods: {
        createMessages(id) {
            axios.post(`/messages/create/${id}`, {textMessage: this.textMessage})
                .then(result => {
                    console.log(id)
                    window.location.reload()

                    this.isMessages()
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                        console.log(this.errors)
                    }
                });
        },
        isMessages() {
            return this.messages.sort(function (a, b) {
                if (a['created_at'] < b['created_at']) return -1
            })

        },
    },

    computed: {},
}
</script>
