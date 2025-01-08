<template>
    <div class="tab-pane fade in active show" id="profile-friends">
        <h4 class="m-t-0 m-b-20">Users List ({{ quantity }})</h4>

        <div class="row row-space-2">
            <div class="col-md-6 m-b-2" v-for="user in users" :key="user.id">
                <div class="p-10 bg-white">
                    <div class="media media-xs overflow-visible">
                        <a class="media-left" href="javascript:;">
                            <img
                                src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                alt=""
                                class="media-object img-circle">
                        </a>
                        <div class="media-body valign-middle">
                            <a @click.prevent="href(user.id)" href="#"
                               class="btn btn-xs btn-yellow">{{ user.name }}</a>
                        </div>

                        <div class="media-body valign-middle text-right overflow-visible">
                            <div class="btn-group dropdown">
                                <div class="media-body valign-middle">
                                    <div>
                                        <button
                                            v-if="!isFriend(user.id)"
                                            @click="addFriend(user.id)"
                                            class="btn btn-primary">
                                            Add to friends
                                        </button>
                                        <button
                                            v-else
                                            class="btn btn-success"
                                            disabled>
                                            Friend
                                        </button>
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
            users: [],
            friendIds: [],
            quantity: 0
        }
    },

    created() {
        this.getUsers();
    },

    methods: {
        async getUsers() {
            try {
                const { data } = await axios.get('/users');
                this.users = data.users;
                this.friendIds = data.friendIds;
                this.quantity = this.users.length;
            } catch (error) {
                console.error('Failed to fetch users:', error);
            }
        },

        async addFriend(id) {
            try {
                await axios.post(`/friends/add/${id}`);
                await this.getUsers();
            } catch (error) {
                console.error('Failed to add friend:', error);
            }
        },

        isFriend(id) {
            return this.friendIds.includes(id);
        },

        href(id) {
            window.location.href = `/user-profile/${id}`;
        }
    }
}
</script>
