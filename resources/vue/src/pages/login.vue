<template>
    <v-row style="height: 100vh;" justify="center" align="center">
        <v-card width="400">
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="email"
                            label="Username"
                            prepend-icon="mdi-account"
                            placeholder=" "
                        />
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            v-model="password"
                            type="password"
                            label="Password"
                            prepend-icon="mdi-key"
                            placeholder=" "
                        />
                    </v-col>
                    <v-col cols="12">
                        <v-btn @click="doLogin">
                            Login
                        </v-btn>
                    </v-col>
                    <v-col v-if="error" cols="12">
                        <v-alert>{{ error }}</v-alert>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-row>
</template>

<script lang="ts" setup>
import { ref  } from '@vue/composition-api';
import { useRouter } from '../plugins/router';
import { get, post } from '../plugins/fetch';
import { useAuth } from '../compositions/auth';
import { ResponseError } from '../types/fetch';

const email = ref('');
const password = ref('');
const error = ref('');

const router = useRouter();

const { is_authenticated, next_route } = useAuth();

type LoginResponse = {
    url: string;
};

const doLogin = async () => {
    try {
        // Adds csrf cookie to subsequent requests.
        await get('/async/csrf');

        await post<LoginResponse>('/async/login', {
            email: email.value,
            password: password.value,
        });

        router.push(next_route.value ?? '/');
    } catch (fetch_error) {
        const response_error = fetch_error as ResponseError;

        error.value = response_error.errors?.email[0] || response_error.message || 'Unknown error';
    }
};

const checkAuth = async () => {
    if (is_authenticated.value) {
        router.push({ name: 'index' });
    }
};

void checkAuth();
</script>