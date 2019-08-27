<template>
    <div class="col-md-10">
        <div class="row py-3">
            <post-item v-for="(post, index) in posts" :key="index" :post="post" :user="user" @refreshPosts="fetch"></post-item>
        </div>

        <div class="row">
            <paginator-buttons :resource-response="resourceResponse" @changePage="fetch($event)"></paginator-buttons>
        </div>
    </div>
</template>

<script>
    import PostItem from '../components/PostItem.vue';
    import PaginatorButtons from '../components/PaginatorButtons';

    export default {
        name: "post-list",

        components: {
            PaginatorButtons,
            PostItem
        },

        props: {
            user: {
                type: Object,
                required: false
            }
        },

        data() {
            return {
                resourceResponse: {},
                posts: []
            }
        },

        mounted() {
            this.fetch();
        },

        methods: {
            fetch(page) {
                if (!page) {
                    page = 1;
                }

                axios
                    .get(`/posts?page=${page}`)
                    .then(response => {
                        this.resourceResponse = response.data.posts;
                        this.posts = this.resourceResponse.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
</script>
