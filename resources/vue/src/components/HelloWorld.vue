<template>
    <v-container>
        <v-card>
            <v-card-text>
                <v-row class="text-center">
                    <v-col cols="12">
                        <v-img
                            :src="logo"
                            class="my-3"
                            contain
                            height="200"
                        />
                    </v-col>

                    <v-col class="mb-4">
                        <h1 class="display-2 font-weight-bold mb-3">
                            <div>{{ msg }}</div>
                        </h1>

                        <small>Vite Preview</small>
                    </v-col>
                    
                    <v-col cols="12">
                        <button @click="count++">
                            Counter with value: {{ count }}
                        </button>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script lang="ts" setup>
import { defineProps, ref } from 'vue'

import logo from '../assets/logo.svg';

defineProps({
    msg: {
        type: String,
        default: '',
    }
})

const count = ref(0)
</script>

<style scoped>
a {
    color: #42b983;
}

label {
    margin: 0 0.5em;
    font-weight: bold;
}

code {
    background-color: #eee;
    padding: 2px 4px;
    border-radius: 4px;
    color: #304455;
}
</style>