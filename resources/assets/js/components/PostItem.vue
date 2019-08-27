<template>
    <div class="col-lg-12 p-3 mb-3 border rounded border">
        <div>
            <h3>{{ post.title }}</h3>
            <h4>By {{ post.user.name }}</h4>
            <p>{{ post.description }}</p>
        </div>

        <div v-if="canEditAndDelete">
            <router-link :to="{ name: 'editPost', params: { id: post._id } }">
                <button type="submit" class="btn btn-primary">Edit Post</button>
            </router-link>

            <button type="submit" class="btn btn-danger" @click="deletePost(post._id)">Delete Post</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "post-item",

        props: {
            post: {
                type: Object,
                required: false
            },
            user: {
                type: Object,
                required: false
            }
        },

        computed: {
            canEditAndDelete() {
                return this.user && this.user.id == this.post.user_id;
            }
        },

        methods: {
            deletePost(postId) {
                axios
                    .delete(`/posts/${postId}`)
                    .then(response => {
                        this.$emit('refreshPosts');
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            }
        }
    }
</script>
