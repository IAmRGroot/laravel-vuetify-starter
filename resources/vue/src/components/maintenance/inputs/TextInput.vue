<template>
    <v-text-field
        v-if="current_row"
        v-model="current_row[field.value]"
        dense
        hide-details="auto"
    />
</template>

<script lang="ts" setup>
import { useMaintenanceEdit } from '../../../compositions/maintenance/maintenance_edit';
import type { Field } from '../../../types/maintenance';

defineProps<{
    field: Field,
}>();

const { current_row } = useMaintenanceEdit();
</script>