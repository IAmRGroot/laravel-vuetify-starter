<template>
    <v-container>
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
                <input type="password" name="password" v-model="login" style="outline: auto;">
            </v-col>
            <v-col cols="12">
                <button style="outline: auto;" @click="doLogin">Login</button>
            </v-col>
            <v-col cols="12">
                {{ error }}
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts" setup>
    import { ref } from "vue";
    import { useRouter } from "vue-router";
    import { post } from '../plugins/fetch';
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
            const data = await post<LoginResponse>('/login', {
                login: login,
                password: password,
            });

            push(data.url);
        } catch (error) {
            error.value = error;
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