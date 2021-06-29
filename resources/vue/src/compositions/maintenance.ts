import { computed, reactive, toRefs, watch } from "vue";
import { get } from "../plugins/fetch";
import type { Field, Row, Setup } from "../types/maintenance";

const state = reactive({
    setup: {} as Setup,
    current_table: '',
    rows: [] as Row[],
});

const fetchSetup = async (): Promise<void> => {
    state.setup = await get<Setup>('/async/maintenance');
}

const has_selected_table = computed((): boolean => state.current_table !== '');
const tables = computed((): string[] => Object.keys(state.setup));
const fields = computed((): Field[] => has_selected_table.value ? state.setup[state.current_table] : []);
const visible_fields = computed((): Field[] => fields.value.filter(item => item.visible));
const editable_fields = computed((): Field[] => fields.value.filter(item => item.editable));

const fetchRows = async (): Promise<void> => {
    state.rows = await get<Row[]>(`/async/maintenance/${state.current_table}`)
};

watch(() => state.current_table, () => fetchRows());

const use_maintenance = {
    ...toRefs(state),
    tables,
    fields,
    visible_fields,
    editable_fields,
    fetchSetup,
};

export const useMaintenance = (): typeof use_maintenance => {
    return use_maintenance;
}