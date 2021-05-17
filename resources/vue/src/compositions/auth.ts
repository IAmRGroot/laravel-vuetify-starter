import { computed, reactive, toRefs } from "vue";
import { useRouter } from "vue-router";
import { get } from "../plugins/fetch";

type User = {};

const state = reactive({
    user: null as User|null
});

const is_authenticated = computed((): boolean => state.user !== null);

const getUser = async (): Promise<void> => {
    state.user = await get<User>('/async/user');
}

const use_auth = {
    ...toRefs(state),
    is_authenticated,
    getUser,
};

export const useAuth = (): typeof use_auth => {
    return use_auth;
}