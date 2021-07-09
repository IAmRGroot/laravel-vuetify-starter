import { FieldType } from '../enums/maintenance/FieldType';

type GenericObject = {
    [column: string]: string|number|boolean|GenericObject;
};

export type Field = {
    editable: boolean;
    text: string;
    value: string;
    visible: boolean;
    type: FieldType;
    relation?: string;
    relation_key?: string;
    relation_text?: string;
    relation_value?: string;
};

export type Table = {
    table: string,
    key_name: string,
    fields: Field[],
};

export type Row = GenericObject;