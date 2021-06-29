export type Field = {
    editable: boolean;
    text: string;
    value: string;
    visible: boolean;
    component: string;
};

export type Setup = {
    [table: string]: Field[];
}

export type Row = {
    [column: string]: unknown;
}