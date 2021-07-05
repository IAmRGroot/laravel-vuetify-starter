import { computed, reactive, Ref, toRefs } from "vue";
import { put as fetchPut, patch as fetchPatch } from "../../plugins/fetch";
import { Row, Table } from "../../types/maintenance";
import { useMaintenance } from "./maintenance";

const state = reactive({
    current_row_index: -1,
});

const {
    current_table,
    rows,
    getKey,
} = useMaintenance();

const current_row = computed((): Row|undefined => rows.value[state.current_row_index]);

const put = async (row: Row): Promise<void> => {
    const new_row = await fetchPut<Row>(`/async/maintenance/${current_table.value?.table}`, row);

    rows.value.push(new_row);
    state.current_row_index = -1;
}

const patch = async (row: Row): Promise<void> => {
    const updated_row =  await fetchPatch<Row>(`/async/maintenance/${current_table.value?.table}/${getKey(row)}`, row);

    rows.value.splice(state.current_row_index, 1, updated_row);
    state.current_row_index = -1;
};

const use_maintenance_edit = {
    ...toRefs(state),
    current_row,
    put,
    patch,
};

export const useMaintenanceEdit = (): typeof use_maintenance_edit => {
    return use_maintenance_edit;
};