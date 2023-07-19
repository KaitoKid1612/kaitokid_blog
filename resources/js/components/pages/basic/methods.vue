<template lang="">
    <div>
        <h1>{{ number }}</h1>
        <button @click.prevent="countNumber">Count</button>
        <br />
        <br />
        <div v-for="(item, index) in blogs" :key="index" v-if="blogs.length">
            <ul>
                <li>{{ item.title }}</li>
                <li>{{ item.post }}</li>
                <li>{{ item.id }}</li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            number: 0,
            blogs: [],
        };
    },
    methods: {
        countNumber() {
            this.number++;
        },
    },
    created() {
        this.number = 100;
        let posts = [
            {
                title: "this is blog title",
                post: "this is blog post",
                id: 1,
            },
            {
                title: "this is blog title",
                post: "this is blog post",
                id: 2,
            },
            {
                title: "this is blog title",
                post: "this is blog post",
                id: 3,
            },
            {
                title: "this is blog title",
                post: "this is blog post",
                id: 4,
            },
        ];
        this.blogs = posts;
    },
};
</script>
<style lang=""></style>
