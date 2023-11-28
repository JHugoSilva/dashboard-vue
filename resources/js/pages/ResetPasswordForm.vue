<script setup>

import { useRoute } from 'vue-router'

const router = useRoute()

localStorage.setItem('token', router.query.token)
window.location.href = '/reset-password-form-sent'
</script>

<template>
    
</template>