<template>
    <tr>
        <td
            v-for="field in visible_fields"
            :key="field.text"
        >
            <Field
                :row="row"
                :field="field"
            />
        </td>

        <td>
            <v-btn @click="setRowIndex(index)">
                Edit
            </v-btn>
        </td>
    </tr>
</template>


<script lang="ts" setup>
import { useMaintenance } from '../../compositions/maintenance/maintenance';
import { useMaintenanceEdit } from '../../compositions/maintenance/maintenance_edit';
import type { Row } from '../../types/maintenance';
import Field from './Field.vue';

defineProps<{
    row: Row,
    index: number,
}>();

const { visible_fields } = useMaintenance();
const { current_row_index } = useMaintenanceEdit();

const setRowIndex = (index: number) => {
    current_row_index.value = index;
};
</script>