<template>
    <div class="tab-pane fade in active show" id="profile-friends">
        <h4 class="m-t-0 m-b-20">Friend List ({{ quantity }})</h4>
        <div class="row row-space-2">
            <div class="col-md-6 m-b-2" v-for="friend in friends">
                <div class="p-10 bg-white" id="main">
                    <div class="media media-xs overflow-visible">
                        <a class="media-left" href="javascript:;">
                            <img
                                src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                alt
                                class="media-object img-circle">
                        </a>
                        {{ friend.id }}
                        <div class="media-body valign-middle">
                            <a @click.prevent="href(friend.id)" href="#"
                               class="btn btn-xs btn-yellow">{{ friend.name }}</a>
                        </div>

                        <div
                            class="media-body valign-middle text-right overflow-visible">
                            <div class="btn-group dropdown">
                                <div class="media-body valign-middle">
                                    <input @click.prevent="deleteFriend(friend.id)" type="submit"
                                           class="btn btn-danger"
                                           value="Delete">
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
    name: "Friends",

    data() {
        return {
            friends: null,
            quantity: 0
        }
    },

    mounted() {
        this.getFriends()
    },

    methods: {
        getFriends() {
            axios.get('/friends/json')
                .then(result => {
                    this.friends = result.data.friends
                    this.quantity = Object.keys(this.friends).length
                })
        },

        deleteFriend(id) {
            axios.post(`/friends/${id}`)
                .then(result => {
                    this.getFriends()
                    console.log(result)
                })
        },

        href(id) {
            window.location.replace(`http://localhost/mainUser/${id}`)
        }

    }
}
</script>
