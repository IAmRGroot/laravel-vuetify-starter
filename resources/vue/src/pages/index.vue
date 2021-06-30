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
        class="mt-6"
    >
        <v-btn @click="logout">
            Logout
        </v-btn>
    </v-row>
</template>

<script lang="ts" setup>
import { useAuth } from "../compositions/auth";

const { logout } = useAuth();
</script>
