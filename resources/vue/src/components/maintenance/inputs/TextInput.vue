<template>
    <input
        v-if="current_row"
        v-model="current_row[field.value]"
        style="width: 100%;"
    >
</template>

<script lang="ts" setup>
import { defineProps } from 'vue';
import { useMaintenanceEdit } from '../../../compositions/maintenance/maintenance_edit';
import type { Field } from '../../../types/maintenance';

defineProps<{
    field: Field,
}>();

const { current_row } = useMaintenanceEdit();
</script>