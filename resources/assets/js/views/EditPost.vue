<template>
    <div class="col-md-10">
        <div class="row py-3">
            <h1>Edit Post</h1>
            <!-- TODO -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "edit-post",

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
                        this.post = response.data;
                    })
                    .catch(error => {
                        console.log(error, 'ERROR');
                    });
            }
        }
    }
</script>
