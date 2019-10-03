<template>
    <div>
        <button @click="sort" type="submit">Sort</button>
        <ul>
            <li v-for="(item,key) in list" :key="key">{{item}}</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            list: [
                    { 'user': 'fred',   'age': 48 },
                    { 'user': 'barney', 'age': 36 },
                    { 'user': 'fred',   'age': 40 },
                    { 'user': 'barney', 'age': 34 }
                ]
        }
    },
    methods: {
        sort() {
        this.list = _.sortBy(this.list, ['user', 'age']);

        }
    }
}
</script>

<style>

</style>
