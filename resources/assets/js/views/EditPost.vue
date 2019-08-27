<template>
    <div class="col-md-10">
        <post-form :heading="'Edit Post'" :post="post" @submit="submit($event)"></post-form>
    </div>
</template>

<script>
    import PostForm from '../components/PostForm';

    export default {
        name: "edit-post",

        components: { PostForm },

        data() {
            return {
                post: null
            }
        },

        mounted() {
            this.fetch();
        },

        methods: {
            fetch() {
                axios
                    .get(`/posts/${this.$route.params.id}`)
                    .then(response => {
                        this.post = response.data.post;
                    })
                    .catch(error => {
                        console.log(error, 'ERROR');
                    });
            },

            submit(data) {
                axios
                    .patch(`/posts/${this.$route.params.id}`, {
                        title: data.title,
                        description: data.description
                    })
                    .then(response => {
                        this.$router.push({ name: 'postList' });
                    })
                    .catch(error => {
                        console.log(error, 'ERROR');
                    });
            }
        }
    }
</script>
