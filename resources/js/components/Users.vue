<template>
    <div class="tab-pane fade in active show" id="profile-friends">
        <h4 class="m-t-0 m-b-20">Users List ({{ quantity }})</h4>

        <div class="row row-space-2">
            <div class="col-md-6 m-b-2" v-for="user in users">
                <div class="p-10 bg-white">
                    <div class="media media-xs overflow-visible">

                        <a class="media-left" href="javascript:;">
                            <img
                                src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                alt
                                class="media-object img-circle">
                        </a>
                        {{ user.id }}
                        <div class="media-body valign-middle">
                            <a @click.prevent="href(user.id)" href="#"
                               class="btn btn-xs btn-yellow">{{ user.name }}</a>
                        </div>

                        <div
                            class="media-body valign-middle text-right overflow-visible">
                            <div class="btn-group dropdown">
                                <div class="media-body valign-middle">
                                    <div>
                                        <input v-if="!isFriend(user.id)"
                                               @click.prevent="addFriend(user.id)" type="submit"
                                               class="btn btn-primary"
                                               name="submit_form"
                                               value="Add to friends">
                                        <input v-else type="button"
                                               class="btn btn-success"
                                               value="Friend" id="friend">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Users",

    data() {
        return {
            users: null,
            friendIds: null,
            quantity: 0
        }
    },

    mounted() {
        this.getUsers()
        this.isFriend()
    },

    methods: {
        getUsers() {
            axios.get('/allUser/json')
                .then(result => {
                    this.users = result.data.users
                    this.friendIds = result.data.friendIds
                    this.quantity = Object.keys(this.users).length
                })
        },

        addFriend(id) {
            axios.post(`/allUser/${id}`)
                .then(result => {
                    this.getUsers()
                    console.log(result)
                })
        },

        isFriend(id) {
            let ids = this.friendIds
            for (let idsKey in ids) {
                if (ids[idsKey] === id) {
                    return true
                }
            }
        },

        href(id) {
            window.location.replace(`http://localhost/mainUser/${id}`)
        }
    }
}
</script>
