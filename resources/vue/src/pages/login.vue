<template>
    <v-container>
        <v-row justify="center">
            <v-card width="400">
                <v-row>
                    <v-col cols="12">
                        <label for="login">Username:</label>
                    </v-col>
                    <v-col cols="12">
                        <input type="text" name="login" v-model="login" style="outline: auto;">
                    </v-col>
                    <v-col cols="12">
                        <label for="password">Password:</label>
                    </v-col>
                    <v-col cols="12">
                        <input type="password" name="password" v-model="password" style="outline: auto;">
                    </v-col>
                    <v-col cols="12">
                        <button style="outline: auto;" @click="doLogin">Login</button>
                    </v-col>
                    <v-col cols="12">
                        {{ error }}
                    </v-col>
                </v-row>
            </v-card>
        </v-row>
    </v-container>
</template>

<script lang="ts" setup>
    import { ref } from "vue";
    import { useRouter } from "vue-router";
    import { get, post } from '../plugins/fetch';
    import { useAuth } from '../compositions/auth';

    type LoginResponse = {
        url: string;
    };

    const login = ref('');
    const password = ref('');
    const error = ref('');

    const { push } = useRouter();

    const doLogin = async () => {
        try {
            // Adds csrf cookie to subsequent requests.
            await get('/async/csrf');

            const data = await post<LoginResponse>('/async/login', {
                login: login.value,
                password: password.value,
            });

            push(data.url);
        } catch (fetch_error) {
            error.value = fetch_error;
        }
    }

    const checkAuth = async (): Promise<void> => {
        const { getUser } = useAuth();

        try {
            await getUser();

            push('/');
        } catch (error) {
            // Nothing
        }
    }

    void checkAuth();
</script>