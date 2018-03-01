<template>
    <div class="container">
        <div v-if="error" class="alert alert-danger">
            {{ error }}
        </div>

        <div v-if="success" class="alert alert-success">
            {{ success }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "alert-message",
        props: ['error', 'success']
    }
</script>

<style scoped>

</style>