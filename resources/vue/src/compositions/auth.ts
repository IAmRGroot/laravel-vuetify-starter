import { computed, reactive, toRefs } from '@vue/composition-api';
import { get, post } from '../plugins/fetch';
import { UserData } from '../types/generated';

const state = reactive({
    user: null as UserData|null,
    first_check_done: false,
    next_route: null as null|string,
});

const is_authenticated = computed((): boolean => state.user !== null);

const fetchUser = async (): Promise<void> => {
    state.user = await get<UserData>('/async/user');
};

const logout = async (): Promise<void> => {
    await post('/async/logout');

    window.location.href = '/login';
};

const use_auth = {
    ...toRefs(state),
    is_authenticated,
    fetchUser,
    logout,
};

export const useAuth = (): typeof use_auth => {
    return use_auth;
};