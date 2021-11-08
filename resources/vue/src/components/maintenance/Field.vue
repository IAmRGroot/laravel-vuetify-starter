<template>
    <span v-if="field.type === FieldType.HAS_MANY || field.type === FieldType.BELONGS_TO_MANY">
        {{ getLength(row[field.value]) }}
    </span>
    <span v-else-if="field.type === FieldType.BELONGS_TO">
        <template v-if="field.relation">{{ getBelongsToText() }}</template>
    </span>
    <span v-else-if="field.type === FieldType.TIMESTAMP">
        <Timestamp :timestamp="row[field.value]" />
    </span>
    <span v-else>
        {{ row[field.value] }}
    </span>
</template>

<script lang="ts" setup>
import type { Field, Row } from '../../types/maintenance';
import { FieldType } from '../../enums/maintenance/FieldType';
import Timestamp from './outputs/Timestamp.vue';

const props = defineProps<{
    row: Row,
    field: Field,
}>();

const getBelongsToText = (): string => {
    const field = props.field;

    if (!field.relation || !field.relation_text) return '';

    const relation = props.row[field.relation];

    if (typeof relation !== 'object' || relation === null) return '';

    return String(relation[field.relation_text]);
};

const getLength = (relation: unknown|unknown[]): number => {
    if (Array.isArray(relation)){
        return relation.length;
    }

    return 0;
};
</script>