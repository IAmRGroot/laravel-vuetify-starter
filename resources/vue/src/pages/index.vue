<template>
    <v-row
        justify="center"
        class="mt-6"
    >
        <img
            alt="Vue logo"
            src="../assets/logo.png"
            style="width: 200px; height: 200px;"
        >
    </v-row>
    <v-row
        justify="center"
        align="center"
        class="mt-6"
    >
        <v-btn
            v-for="route in ['maintenance']"
            :key="route"
            @click="push(route)"
        >
            {{ route }}
        </v-btn>
    </v-row>
    <v-row
        justify="center"
        class="mt-12"
    >
        <v-btn @click="logout">
            Logout
        </v-btn>
    </v-row>
</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router';
import { useAuth } from '../compositions/auth';

const { logout } = useAuth();
const { push } = useRouter();
</script>
