<template>
    <div class="row py-3">
        <h1>{{ heading }}</h1>

        <form class="w-100">
            <div class="alert alert-danger" v-if="errors">
                <p class="m-0" v-for="error in errors">
                    {{ error[0] }}
                </p>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" placeholder="Post Title" v-model="title">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" rows="5" placeholder="Post description" v-model="description"></textarea>
            </div>
        </form>

        <button type="submit" class="btn btn-primary mr-1" @click="submit">Submit</button>
        <button type="submit" class="btn btn-danger ml-1" @click="clear">Clear</button>
    </div>
</template>

<script>
    export default {
        name: "post-form",

        props: {
            heading: {
                type: String,
                required: true
            },
            post: {
                type: Object,
                required: false
            },
            errors: {
                type: Object,
                required: false
            }
        },

        data() {
            return {
                title: '',
                description: ''
            }
        },

        watch: {
            post() {
                if (this.post) {
                    this.initializeForm();
                }
            }
        },

        methods: {
            initializeForm() {
                this.title = this.post.title;
                this.description = this.post.description;
            },

            submit() {
                this.$emit('submit', {
                    title: this.title,
                    description: this.description
                });
            },

            clear() {
                this.title = '';
                this.description = '';
            }
        }
    }
</script>
