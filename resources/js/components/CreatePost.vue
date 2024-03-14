<template>
    <div :class="errors ? 'd-none' : 'alert alert-primary'" role="alert">
        The post was created successfully!
    </div>
    <hr class="border-light m-0">
    <div class="card-body">
        <div class="form-group">
            <span :class="errors ? 'error': 'd-none'" v-if="errors?.content">{{ errors.content[0] }}</span>
        </div>
        <input type="text" v-model="content" id="content" class="form-control mb-1"
               name="content"
               placeholder="content"
               value="">
        <div class="text-right mt-3">
            <input @click.prevent="createPost" type="submit" class="btn btn-primary"
                   value="Creat">
        </div>
    </div>


</template>

<script>
import axios from "axios";
export default {
    name: "CreatePost",

    data() {
        return {
            content: null,
            errors: {},
        }
    },

    methods: {
        createPost() {
            axios.post('/post/create', {content: this.content})
                .then(result => {
                    this.content = null
                    this.errors = null
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
    }
}
</script>
