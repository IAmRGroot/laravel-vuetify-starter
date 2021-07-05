export type Field = {
    editable: boolean;
    text: string;
    value: string;
    visible: boolean;
    component: string;
};

export type Table = {
    table: string,
    key_name: string,
    fields: Field[],
};

export type Row = {
    [column: string]: unknown;
}