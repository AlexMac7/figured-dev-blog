<template>
    <div class="col-md-10">
        <post-form :heading="'Create A New Post'" :errors="errors" @submit="submit($event)"></post-form>
    </div>
</template>

<script>
    import PostForm from '../components/PostForm';

    export default {
        name: "create-post",

        data() {
            return {
                errors: null
            }
        },

        components: { PostForm },

        methods: {
            submit(data) {
                axios
                    .post('/posts', {
                        title: data.title,
                        description: data.description
                    })
                    .then(response => {
                        this.$router.push({ name: 'postList' });
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            }
        }
    }
</script>
