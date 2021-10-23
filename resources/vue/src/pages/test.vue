<template>
    <div>{{ user.name }}</div>
</template>

<script lang="ts">
import { defineComponent } from '@vue/runtime-core';
import { useAuth } from '../compositions/auth';

export default defineComponent({
    setup() {
        const { user } = useAuth();

        return { user };
    },
});
</script>