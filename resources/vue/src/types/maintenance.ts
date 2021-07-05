export type Field = {
    editable: boolean;
    text: string;
    value: string;
    visible: boolean;
    component: string;
};

export type TableSetup = {
    table: string,
    key_name: string,
    fields: Field[],
};

export type Setup = {
    [table: string]: TableSetup;
}

export type Row = {
    [column: string]: unknown;
}