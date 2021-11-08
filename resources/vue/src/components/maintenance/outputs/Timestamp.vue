<template>
    <span v-if="valid_type">{{ d(new Date(timestamp), 'long') }}</span>
</template>

<script lang="ts" setup>
import { computed } from '@vue/reactivity';
import { useI18n } from '../../../plugins/i18n';

const props = defineProps<{
    timestamp: unknown,
}>();

const valid_type = computed((): boolean => typeof props.timestamp === 'string' || typeof props.timestamp === 'number' || props.timestamp instanceof Date);

const { d } = useI18n();
</script>