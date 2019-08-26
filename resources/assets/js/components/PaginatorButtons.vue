<template>
    <div class="col-lg-12">
        <ul class="pagination" v-if="shouldPaginate">
            <li class="page-item" :class="{'disabled' : ! hasPreviousPage}">
                <a class="page-link" href="#" aria-label="Previous" rel="prev" @click.prevent="currentPage--">
                    <span aria-hidden="true">&laquo; Previous</span>
                </a>
            </li>

            <li class="page-item" :class="{'disabled' : ! hasNextPage}">
                <a class="page-link" href="#" aria-label="Next" rel="next" @click.prevent="currentPage++">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "paginator-buttons",

        props: {
            resourceResponse: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                currentPage: this.resourceResponse.current_page
            };
        },

        computed: {
            hasPreviousPage() {
                return this.resourceResponse && this.resourceResponse.prev_page_url;
            },

            hasNextPage() {
                return this.resourceResponse && this.resourceResponse.next_page_url;
            },

            shouldPaginate() {
                return this.hasPreviousPage || this.hasNextPage;
            },
        },

        watch: {
            resourceResponse() {
                this.currentPage = this.resourceResponse.current_page;
            },

            currentPage() {
                this.$emit('changePage', this.currentPage);
            }
        }
    };
</script>
