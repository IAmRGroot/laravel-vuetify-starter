<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <img
                    alt="Vue logo"
                    src="../assets/logo.png"
                    style="width: 200px; height: 200px;"
                >
            </v-col>
            <v-col cols="12">
                <HelloWorld msg="Hello Vue 3 + TypeScript + Vite" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts" setup>
    import HelloWorld from '../components/HelloWorld.vue';
</script>