<template>

    <li v-for="post in posts">
        <div class="timeline-time">
            <span
                class="date">{{ post.created_at }}</span>
        </div>
        <div class="timeline-icon">
            <a href="javascript:;">&nbsp;</a>
        </div>
        <div class="timeline-body">
            <div class="timeline-header">
                <span class="userimage"><img
                    src="https://bootdey.com/img/Content/avatar/avatar3.png"
                    alt>
                </span>
                <span class="username">{{ post.author.name }}</span>
                {{ 'id ' + post.id }}
            </div>
            <div class="timeline-content">
                <p>{{ post.content }}</p>
            </div>
            <div class="timeline-footer">
                <div>
                    {{ post.like_count }}
                    <a href="javascript:;"
                       class="m-r-15 text-inverse-lighter">
<!--                        <button type="submit" @click.prevent="changeId(post.id)" v-model="isLiked" class="border-0 bg-transparent mb-3">-->
<!--                            <i :class="isId(post.id) ? 'd-none': 'fa fa-heart-o'" aria-hidden="true"></i>-->
<!--                        </button>-->
                        <button @click.prevent="addLike(post.id)" type="submit"
                                class="border-0 bg-transparent mb-3">
                                <i :class="isThereALike(post.id) ? 'fa fa-heart' : 'fa fa-heart-o' " aria-hidden="true"></i>

                        </button>
                    </a>
                </div>
                <div v-if="post.comment" class="chat-messages p-8 mb-3">
                    <div class="chat-message-left" v-for="comment in post.comment">
                        <div>
                            <img
                                src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                class="rounded-circle mr-1"
                                alt="Sharon Lessman" width="25"
                                height="25">
                            <div
                                class="text-muted small text-nowrap mt-2">

                            </div>
                        </div>
                        <div
                            class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3 ">
                            <div
                                class="font-weight-bold mb-1">
                                {{ comment.author.name }}
                            </div>
                            {{ comment.comment }}
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" @click.prevent="changePostId(post.id)" class="border-0 bg-transparent mb-3">
                        {{ post.comment_count }}
                        <i class="fa fa-comment-o fa-2x" aria-hidden="true"></i>
                    </button>
                    <div :class="isId(post.id) ? 'form-floating' : 'd-none' ">
                        <input type="text" class="form-control mb-3" v-model="comment" name="comment"
                               placeholder="Leave a comment here">
                        <label for="floatingTextarea">Comments</label>
                        <input @click.prevent="addComment(post.id)" type="submit"
                               class="btn btn-sm btn-outline-primary md-3"
                               value="send">
                    </div>
                    <!--                    form-floating-->
                </div>
            </div>
        </div>
    </li>
</template>

<script>
import axios from "axios";
import {comment} from "postcss";

export default {
    name: "Posts",

    data() {
        return {
            posts: null,
            like: null,
            post_id: null,
            comment: null,
        }
    },

    mounted() {
        this.getFriendPosts()
    },

    methods: {
        getFriendPosts() {
            axios.get('/post/json')
                .then(result => {
                    this.posts = result.data.posts
                    this.like = result.data.like
                })
        },

        changePostId(id) {
            this.post_id = id
        },

        addLike(id) {
            axios.post(`/post/like/${id}`)
                .then(result => {
                    this.getFriendPosts()
                })
        },

        addComment(id) {
            this.post_id = null
            axios.post(`/post/comment/${id}`, {comment: this.comment})
                .then(result => {
                    this.comment = null
                    this.getFriendPosts()
                })
        },

        isThereALike(id) {
            let like = this.like
            for (let key in like) {
                if (like[key].post_id === id) {
                    return true
                }
            }
        },

        isId(id) {
            return this.post_id === id
        },
    }
}
</script>
