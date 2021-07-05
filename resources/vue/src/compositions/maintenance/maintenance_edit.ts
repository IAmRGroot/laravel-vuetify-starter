import { Ref } from "vue";
import { put as fetchPut, patch as fetchPatch } from "../../plugins/fetch";
import { Row } from "../../types/maintenance";

export const useMaintenanceEdit = (table: string, row: Ref<Row>) => {

    const put = async (): Promise<Row> => {
        return await fetchPut<Row>(`/async/maintenance/${table}`, row);
    }

    const patch = () => {
        state.rows = await fetchPatch<Row[]>(`/async/maintenance/${table}/`)
    };

    return {
        put,
        patch,
    };
};