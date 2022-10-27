import Vue from 'vue';
import VueRouter from 'vue-router';
import helpers from './helpers'
Vue.mixin({ methods: helpers });

Vue.use(VueRouter);

Vue.component( 'page-speed-app', require('./page-speed-app.vue').default );
Vue.component( 'history-single', require('./components/history-single.vue').default );

import Analyze from './pages/analyze.vue';
import Report from './pages/report.vue';
import History from './pages/history.vue';

jQuery( function( $ ) {

	if ( $('#wp-adminify--page-speed-app').length ) {

        const routes = [
			{ path: '/', 			    component: Analyze },
			{ path: '/history',         component: History },
			{ path: '/history/:page',   component: History },
			{ path: '/report/:id', 	    component: Report, name: 'report' },
		];

        const router = new VueRouter({ routes });

        router.beforeEach((to, from, next) => {
            if ( to.path == '/history' ) next({ path: '/history/1' });
            next();
        });

        new Vue({
            el: '#wp-adminify--page-speed-app',
            template: '<page-speed-app></page-speed-app>',
            router
        });

    }

});
