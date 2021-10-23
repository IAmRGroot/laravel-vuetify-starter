import Vue from 'vue';
import VueRouter, { Route } from 'vue-router';

// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import routes from 'virtual:generated-pages';
import { useAuth } from '../compositions/auth';
import { getCurrentInstance } from '@vue/composition-api';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes,
});

router.beforeEach(async (to, from, next): Promise<void> => {
    if (!to.meta || !to.meta.auth) {
        next();
        return;
    }

    const {
        first_check_done,
        is_authenticated,
        next_route,
        fetchUser,
        user,
    } = useAuth();

    if (!first_check_done.value) {
        try {
            await fetchUser();
        } catch (error) {
            // Nothing
        }
    }

    if (!is_authenticated.value) {
        next_route.value = to.fullPath;

        next('/login');
        return;
    }

    if (
        Array.isArray(to.meta.permissions) &&
        !to.meta.permissions.every(permission => user.value?.permissions.includes(permission))
    ){
        next('/forbidden');
        return;
    }

    next_route.value = null;
    next();
});

export default router;

export const useRoute = (): Route =>  {
    const vm = getCurrentInstance();
    if (!vm) throw new Error('must be called in setup');

    return vm.proxy.$route;
};

export const useRouter = (): VueRouter => {
    const vm = getCurrentInstance();
    if (!vm) throw new Error('must be called in setup');

    return vm.proxy.$router;
};