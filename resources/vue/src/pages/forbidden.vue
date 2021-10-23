<template>
    <div>
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
            <v-btn @click="router.push('/')">
                Home
            </v-btn>
        </v-row>
    </div>
</template>

<script lang="ts" setup>
import { useRouter } from '../plugins/router';

const router = useRouter();
</script>