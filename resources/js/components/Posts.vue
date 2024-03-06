<template>
    <div>

    </div>
</template>

<script>
    import axios from "axios";

    export default {
       name: "Posts",

        data() {
           return {
               posts: null
           }
        },

        mounted() {
           this.getFriendPosts()
        },

        methods: {
           getFriendPosts() {
               axios.get('/post')
                   .then( result  => {
                       this.posts = result.data
                   })
           }
        }
    }
</script>
