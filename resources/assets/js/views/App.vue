<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 px-0">
                <div v-if="user">
                    <router-link :to="{ name: 'postList' }">
                        <button type="submit" class="btn btn-secondary">View All Posts</button>
                    </router-link>

                    <router-link :to="{ name: 'createPost' }">
                        <button type="submit" class="btn btn-primary">New Post</button>
                    </router-link>
                </div>
            </div>

            <router-view :user="user"></router-view>
        </div>
    </div>
</template>

<script>
    import PostList from './PostList';

    export default {
        name: "app",

        components: { PostList },

        data() {
            return {
                user: null
            }
        },

        mounted() {
            this.getCurrentUser();
        },

        methods: {
            getCurrentUser() {
                axios
                    .get('/users/current')
                    .then(response => {
                        this.user = response.data.user;
                    })
                    .catch(error => {
                        console.log(error, 'ERROR');
                    });
            }
        }
    }
</script>
