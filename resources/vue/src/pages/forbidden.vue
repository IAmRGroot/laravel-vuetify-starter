<template>
    <v-row
        justify="center"
        class="mt-6"
    >
        Forbidden
    </v-row>
    <v-row
        justify="center"
        class="mt-6"
    >
        <v-btn @click="push('/')">
            Home
        </v-btn>
    </v-row>
</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router';

const { push } = useRouter();
</script>