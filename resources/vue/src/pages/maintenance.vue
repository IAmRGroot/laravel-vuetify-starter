<template>
    <div>
        <v-row
            justify="center"
            class="my-6"
        >
            <v-btn @click="router.push('/')">
                Home
            </v-btn>
        </v-row>
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

        <v-row no-gutters>
            <v-simple-table
                v-if="current_table && !current_row"
                style="width: 100%;"
                class="mt-12"
            >
                <thead>
                    <tr>
                        <th
                            v-for="field in visible_fields"
                            :key="field.text"
                            no-gutters
                            style="text-align: left;"
                        >
                            {{ field.text }}
                        </th>
                        <th />
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
            </v-simple-table>

            <v-simple-table
                v-else
                style="width: 100%;"
                class="mt-12"
            >
                <thead>
                    <th colspan="2" class="text-left">
                        <v-btn @click="setRowIndex(-1)" class="ma-2">
                            Back
                        </v-btn>
                    </th>
                </thead>
                <tbody>
                    <tr
                        v-for="field in editable_fields"
                        :key="`edit-${field.text}`"
                    >
                        <td>{{ field.text }}</td>
                        <td>
                            <component
                                :is="getComponent(field.type)"
                                :field="field"
                            />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <th colspan="2" class="text-right">
                        <v-btn @click="checkAndPatch(current_row)"  class="ma-2">
                            Save
                        </v-btn>
                    </th>
                </tfoot>
            </v-simple-table>
        </v-row>
    </div>
</template>

<script lang="ts" setup>
import { useMaintenance } from '../compositions/maintenance/maintenance';
import { useMaintenanceEdit } from '../compositions/maintenance/maintenance_edit';
import Row from '../components/maintenance/Row.vue';
import TextInput from '../components/maintenance/inputs/TextInput.vue';
import { FieldType } from '../enums/maintenance/FieldType';
import type { Row as RowType } from '../types/maintenance';
import { useRouter } from '../plugins/router';
import BelongsToManyInput from '../components/maintenance/inputs/BelongsToManyInput.vue';

const router = useRouter();

const {
    current_table,
    tables,
    visible_fields,
    editable_fields,
    rows,
    fetchSetup,
} = useMaintenance();

const {
    current_row,
    setRowIndex,
    patch,
} = useMaintenanceEdit();

void fetchSetup();

const getComponent = (type: FieldType) => {
    switch (type) {
        case FieldType.TEXT:
        case FieldType.INTEGER:
        case FieldType.DECIMAL:
        case FieldType.PASSWORD:
            return TextInput;
        // case FieldType.BELONGS_TO:
        //     return TextInput;
        case FieldType.BELONGS_TO_MANY:
            return BelongsToManyInput;
        // case FieldType.HAS_MANY:
        //     return TextInput;
    }

    return null;
};

const checkAndPatch = (row: RowType|undefined) => {
    if (!row){
        return;
    }

    patch(row);
};
</script>
