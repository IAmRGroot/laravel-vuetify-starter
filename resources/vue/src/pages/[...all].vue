<template>
    <span>404 😢</span>

    <v-btn @click="push('/')">
        Home
    </v-btn>
</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router';

const { push } = useRouter();
</script>