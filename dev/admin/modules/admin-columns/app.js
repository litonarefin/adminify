import Vue      from 'vue'
import router   from './router'
import store    from './store'
import helpers  from './helpers'

Window.Events = new Vue;

Vue.mixin({
	methods: helpers
});

Vue.component( 'admin-columns-app', require('./app.vue').default )
Vue.component( 'post-types-sidebar', require('./components/post-types-sidebar.vue').default )

jQuery( function( $ ) {
    
    if ( $('#wpadminify-admin-columns').length ) {

        new Vue({
            el: '#wpadminify-admin-columns',
            template: '<admin-columns-app></admin-columns-app>',
            router,
            store
        })
        
    }

});