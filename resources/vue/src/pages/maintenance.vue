<template>
    <v-row>
        <v-col
            v-for="table in tables"
            :key="table.table"
            no-gutters
        >
            <v-btn @click="current_table = table">
                {{ table.table }}
            </v-btn>
        </v-col>
    </v-row>

    <table v-if="!current_row">
        <thead>
            <tr>
                <th
                    v-for="field in visible_fields"
                    :key="field.text"
                    no-gutters
                >
                    {{ field.text }}
                </th>
            </tr>
        </thead>
        <tbody>
            <Row
                v-for="(row, index) in rows"
                :key="index"
                :row="row"
                :index="index"
            />
        </tbody>
    </table>

    <template v-else>
        <v-row>
            <v-btn @click="current_row_index = -1">
                Back
            </v-btn>
        </v-row>
        <v-row
            v-for="field in editable_fields"
            :key="`edit-${field.text}`"
        >
            <v-col>{{ field.text }}</v-col>
            <v-col>{{ current_row[field.value] }}</v-col>
            <v-col>{{ field.component }}</v-col>
        </v-row>
    </template>
</template>

<script lang="ts" setup>
import { useMaintenance } from '../compositions/maintenance/maintenance';
import { useMaintenanceEdit } from '../compositions/maintenance/maintenance_edit';
import Row from '../components/maintenance/Row.vue';

const {
    current_table,
    tables,
    visible_fields,
    editable_fields,
    rows,
    fetchSetup,
} = useMaintenance();

const { current_row, current_row_index } = useMaintenanceEdit();

void fetchSetup();
</script>
