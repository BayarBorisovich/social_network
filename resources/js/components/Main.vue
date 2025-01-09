<template>
    <div class="col-md-12" v-for="post in posts">
        <div class="card rounded">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img class="img-xs rounded-circle"
                             src="https://bootdey.com/img/Content/avatar/avatar6.png" alt>
                        <div class="ml-2">
                            <p>{{ post.name }}</p>
                            <p class="tx-11 text-muted">{{ post.created_at }}</p>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="dropdownMenuButton3"
                                data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-more-horizontal icon-lg pb-3px">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">

                            <a class="dropdown-item d-flex align-items-center">
                                <input @click.prevent="deletePosts(post.id)" type="submit"
                                       class="btn btn-danger"
                                       value="Delete Post">
                            </a>
                            <a class="dropdown-item d-flex align-items-center">
                                <input @click.prevent="changePostId(post.id, post.content)" type="submit"
                                       class="btn btn-success"
                                       value="Edit">
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p class="mb-3 tx-14">{{ post.content }}</p>
            </div>
            <div :class="isId(post.id) ? 'card-body' : 'd-none'">
                <input type="text" class="w-100 mb-3" v-model="content" name="content" value=""/>
                <input @click.prevent="updatePosts(post.id)" type="submit"
                       class="btn btn-sm btn-outline-primary"
                       value="Update Post">
            </div>
            <div class="card-footer">
                <div class="d-flex post-actions">
                    <a href="javascript:;" class="d-flex align-items-center text-muted mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-heart icon-md">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                        <p class="d-none d-md-block ml-2">Like</p>
                    </a>
                    <a href="javascript:;" class="d-flex align-items-center text-muted mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-message-square icon-md">
                            <path
                                d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <p class="d-none d-md-block ml-2">Comment</p>
                    </a>
                    <a href="javascript:;" class="d-flex align-items-center text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-share icon-md">
                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                            <polyline points="16 6 12 2 8 6"></polyline>
                            <line x1="12" y1="2" x2="12" y2="15"></line>
                        </svg>
                        <p class="d-none d-md-block ml-2">Share</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Main",

    data() {
        return {
            posts: null,
            content: null,
            post_id: null,
        }
    },

    mounted() {
        this.getMyPosts()
    },

    methods: {
        getMyPosts() {
            axios.get('/posts/my-posts')
                .then(result => {
                    this.posts = result.data.posts
                })
        },

        deletePosts(id) {
            axios.post(`/posts/delete/${id}`)
                .then(result => {
                    this.getMyPosts()
                    console.log(result.data.message)
                })
                .catch(error => {
                    console.error('Error deleting post:', error);
                });
        },

        updatePosts(id) {
            this.post_id = null
            axios.post(`/posts/update/${id}`, {content: this.content})
                .then(result => {
                    console.log(result.data.message)
                    this.getMyPosts()
                })
                .catch(error => {
                    console.error('Error updating post:', error);
                });
        },

        changePostId(id, content) {
            this.post_id = id
            this.content = content
        },

        isId(id) {
            return this.post_id === id
        },
    }
}
</script>
