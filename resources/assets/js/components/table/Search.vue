<template>
    <div>
        <input 
            type="text"
            class="form-control fuse-search"
            placeholder="بحث"
            ref="search"
            v-model="query"
            @keyup="performSearch"
            @keydown="performSearch">
        <i class="voyager-search fuse-icon"></i>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data() {
            return {
                query: '',
                searchResults: [],
                options: {
                    shouldSort: true,
                    threshold: 0.5,
                    location: 0,
                    distance: 500,
                    maxPatternLength: 32,
                    minMatchCharLength: 1,
                    keys: ['users.name', 'users.last_name', 'name', 'last_name']
                },
            }
        },
        mounted() {
        },
        methods: {
            performSearch() {
                this.$search(this.query, this.items, this.options)
                    .then(results => {
                        this.searchResults = results
                        this.$emit('performSearch', results, this.query)
                    })
            }
        }
    }

</script>

<style>
    .fuse-search {
        direction: rtl;
        width: 300px;
        padding-right: 34px;
        float: right;
        border-radius: 0px;
        height: 40px;
        font-size: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06) !important;
        border: none;
    }

    .fuse-search:focus {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06) !important;
        border: none;
        /* border-bottom: 2px solid #22a7f0; */
    }

    .fuse-icon {
        position: absolute;
        right: 24px;
        top: 12px;
        color: #718096;
        font-size: 100%;
    }

</style>
