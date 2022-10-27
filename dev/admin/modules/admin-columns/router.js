import Vue from 'vue'
import VueRouter from 'vue-router'
import * as Pages from './pages';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: Pages.PostTypes,
    },
    {
        path: '/post-types',
        component: Pages.PostTypes,
        children: [
            {
                path: ':post_type',
                component: Pages.PostType
            },
        ]
    },
    {
        path: '/taxonomies',
        component: Pages.Taxonomies,
        children: [
            {
                path: ':taxonomy',
                component: Pages.Taxonomy
            },
        ]
    }
]

const router = new VueRouter({ routes })

export default router