<template lang="">
    <div>
        <h1>This is hooks</h1>
    </div>
</template>
<script>
export default {
    data() {
        return {};
    },
    beforeCreate() {
        console.log("beforeCreate");
    },
    created() {
        console.log("hihi");
    },
    mounted() {
        console.log("mounted");
    },
};
</script>
<style lang=""></style>
