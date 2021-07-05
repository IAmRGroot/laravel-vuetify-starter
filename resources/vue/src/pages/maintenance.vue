<template>
    <v-row>
        <v-col
            v-for="table in tables"
            :key="table"
            no-gutters
        >
            <v-btn @click="current_table = table">
                {{ table }}
            </v-btn>
        </v-col>
    </v-row>

    <template v-if="!editing_row">
        <v-row>
            <v-col
                v-for="field in visible_fields"
                :key="field.text"
                no-gutters
            >
                {{ field.text }}
            </v-col>
        </v-row>
        <v-row
            v-for="(row, index) in rows"
            :key="index"
            no-gutters
        >
            <v-col
                v-for="field in visible_fields"
                :key="`${index}-${field.text}`"
            >
                {{ row[field.value] }}
            </v-col>

            <v-col>
                <v-btn @click="editing_row = { ...row }">
                    Edit
                </v-btn>
            </v-col>
        </v-row>
    </template>

    <template v-else>
        <v-row
            v-for="field in editable_fields"
            :key="`edit-${field.text}`"
        >
            <v-col>{{ field.text }}</v-col>
            <v-col>{{ editing_row[field.value] }}</v-col>
            <v-col>{{ field.component }}</v-col>
        </v-row>
    </template>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useMaintenance } from "../compositions/maintenance/maintenance";
import type { Row } from "../types/maintenance";

const {
    current_table,
    tables,
    visible_fields,
    editable_fields,
    rows,
    fetchSetup,
} = useMaintenance();

const editing_row = ref(null as Row|null);

void fetchSetup();
</script>
