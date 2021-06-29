import { createRouter, createWebHistory } from 'vue-router';
import routes from 'virtual:generated-pages';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next): void => {
    // TODO check logged in 
    // const logged_in = false;

    // if (to.meta.auth === true && ! logged_in) {
    //     next('/login');
    // }

    next();
});

export default router;