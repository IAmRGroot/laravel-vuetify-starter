import { computed, reactive, toRefs, watch } from 'vue';
import { get } from '../../plugins/fetch';
import type { Field, Row, Table } from '../../types/maintenance';

const state = reactive({
    tables: [] as Table[],
    current_table: null as Table|null,
    rows: [] as Row[],
    empty: null as Row|null,
});

const fetchSetup = async (): Promise<void> => {
    state.tables = await get<Table[]>('/async/maintenance');
};

const fetchRows = (): void => {
    get<Row[]>(`/async/maintenance/${state.current_table?.table}`).then(rows => {
        state.rows = rows;
    });
    get<Row>(`/async/maintenance/${state.current_table?.table}/empty`).then(empty => {
        state.empty = empty;
    });
};

watch(() => state.current_table, () => fetchRows());

const fields = computed((): Field[] => state.current_table !== null ? state.current_table.fields : []);
const visible_fields = computed((): Field[] => fields.value.filter(item => item.visible));
const editable_fields = computed((): Field[] => fields.value.filter(item => item.editable));

const getKey = (row: Row): unknown => {
    return row[state.current_table?.key_name || ''];
};

const use_maintenance = {
    ...toRefs(state),
    fields,
    visible_fields,
    editable_fields,
    fetchSetup,
    getKey,
};

export const useMaintenance = (): typeof use_maintenance => {
    return use_maintenance;
};