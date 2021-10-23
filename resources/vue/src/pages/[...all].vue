<template>
    <span>404 😢</span>

    <v-btn @click="router.push('/')">
        Home
    </v-btn>
</template>

<script lang="ts" setup>
import { useRouter } from '../plugins/router';

const router = useRouter();
</script>