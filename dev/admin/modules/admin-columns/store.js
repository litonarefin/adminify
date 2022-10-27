import Vue from 'vue'
import Vuex from 'vuex'

import Helpers  from './helpers'

Vue.use(Vuex)

const state = {
    post_types: [],
    taxonomies: []
}

const mutations = {

    set_post_types( state, { post_types } ) {
        state.post_types = post_types
    },

    set_taxonomies( state, { taxonomies } ) {
        state.taxonomies = taxonomies
    },

}

const getters = {

    post_types: state => {
        
        if ( ! Array.isArray(state.post_types) || ! state.post_types.length ) return [];

        return state.post_types.map( item => {
            if ( ! item.display_columns ) item.display_columns = [];
            item.display_columns = item.display_columns.map( d_col => {
                delete d_col.forceOpen;
                return d_col;
            })
            return item;
        });

    },

    taxonomies: state => {
        
        if ( ! Array.isArray(state.taxonomies) || ! state.taxonomies.length ) return [];

        return state.taxonomies.map( item => {
            if ( ! item.display_columns ) item.display_columns = [];
            item.display_columns = item.display_columns.map( d_col => {
                delete d_col.forceOpen;
                return d_col;
            })
            return item;
        });

    },

    post_type_by_name: (state, getters) => (name) => {
        return getters.post_types.find( post_type => post_type.name === name);
    },

    taxonomy_by_name: (state, getters) => (name) => {
        return getters.taxonomies.find( taxonomy => taxonomy.name === name);
    },

}

const actions = {

    async get_post_types( { getters, commit } ) {

        if ( getters.post_types.length ) return getters.post_types;

        Helpers.triggerLoader();
        let response = await Helpers.ajax( 'get_post_type_data' );
        Helpers.triggerLoader( false );

        if ( response && response.data && response.success ) {
            commit( 'set_post_types', { post_types: response.data } );
            return getters.post_types;
        }

    },

    async get_taxonomies( { getters, commit } ) {

        if ( getters.taxonomies.length ) return getters.taxonomies;
        
        Helpers.triggerLoader();
        let response = await Helpers.ajax( 'get_taxonomy_data' );
        Helpers.triggerLoader( false );

        if ( response && response.data && response.success ) {
            commit( 'set_taxonomies', { taxonomies: response.data } );
            return getters.taxonomies;
        }

    },

    async save_store( { commit }, data ) {
        
        Helpers.triggerLoader();
        let response = await Helpers.ajax( 'save_columns_data', data );
        Helpers.triggerLoader( false );

        if ( response && response.data && response.success ) {
            commit( 'set_post_types', { post_types: response.data.post_types } );
            commit( 'set_taxonomies', { taxonomies: response.data.taxonomies } );
        }

    },
    
}

export default new Vuex.Store({ state, mutations, getters, actions })