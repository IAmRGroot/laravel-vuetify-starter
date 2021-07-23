import { createRouter, createWebHistory } from 'vue-router';

// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import routes from 'virtual:generated-pages';
import { useAuth } from '../compositions/auth';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next): Promise<void> => {
    if (!to.meta.auth) {
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
