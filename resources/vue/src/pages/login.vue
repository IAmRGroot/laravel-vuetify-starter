<template>
    <v-container>
        <v-row justify="center">
            <v-card width="400">
                <v-card-text>
                    <v-row>
                        <v-col cols="12">
                            <label for="login">Username:</label>
                        </v-col>
                        <v-col cols="12">
                            <input
                                v-model="email"
                                type="text"
                                name="login"
                                style="outline: auto;"
                            >
                        </v-col>
                        <v-col cols="12">
                            <label for="password">Password:</label>
                        </v-col>
                        <v-col cols="12">
                            <input
                                v-model="password"
                                type="password"
                                name="password"
                                style="outline: auto;"
                            >
                        </v-col>
                        <v-col cols="12">
                            <button
                                style="outline: auto;"
                                @click="doLogin"
                            >
                                Login
                            </button>
                        </v-col>
                        <v-col cols="12">
                            {{ error }}
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-row>
    </v-container>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { get, post } from '../plugins/fetch';
import { useAuth } from '../compositions/auth';
import type { LoginResponse } from '../types/user';

const email = ref('');
const password = ref('');
const error = ref('');

const { push } = useRouter();
const { is_authenticated, next_route } = useAuth();

const doLogin = async () => {
    try {
        // Adds csrf cookie to subsequent requests.
        await get('/async/csrf');

        await post<LoginResponse>('/async/login', {
            email: email.value,
            password: password.value,
        });

        push(next_route.value ?? '/');
    } catch (fetch_error) {
        error.value = fetch_error;
    }
};

const checkAuth = async () => {
    if (is_authenticated.value) {
        push({ name: 'index' });
    }
};

void checkAuth();
</script>