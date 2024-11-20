<template>
    <div class="alert alert-danger error" role="alert">
        {{ props.error }}
    </div>

</template>

<script setup>
    const props = defineProps(['error'])
</script>