import VueI18n, { DateTimeFormats, NumberFormats, Path, TranslateResult, Values } from 'vue-i18n';
import { createI18n, useI18n as originalUseI18n } from 'vue-i18n-composable';
import DateTimeFormat from './../assets/i18n/date-time-formats.json';
import NumberFormat from './../assets/i18n/number-formats.json';
import Messages from './../assets/i18n/messages.generated.json';
import { WritableComputedRef } from '@vue/composition-api';

export default createI18n({
    locale: 'en',
    messages: Messages,
    dateTimeFormats: DateTimeFormat as DateTimeFormats,
    numberFormats: NumberFormat as NumberFormats,
});


export const capitalize = (text: string|TranslateResult): TranslateResult => {
    if (text.length === 0) {
        return text;
    }

    return String(text).replace(/^\w/, c => c.toUpperCase());
};

interface CustomComposer {
    locale: WritableComputedRef<string>;
    t: typeof VueI18n.prototype.t;
    T: (key: Path, values?: Values) => TranslateResult;
    tc: typeof VueI18n.prototype.tc;
    te: typeof VueI18n.prototype.te;
    d: typeof VueI18n.prototype.d;
    n: typeof VueI18n.prototype.n;
}

export const useI18n = (): CustomComposer => {
    const original = originalUseI18n();

    return {
        ...original,
        T: (key: Path, values?: Values): TranslateResult => capitalize(original.t(key, values)),
    };
};