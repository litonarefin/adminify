<template>
    <div class="tab-pane" id="taxonomies">
        <div class="columns">
            
            <div class="column is-4">
                <div class="tabs is-boxed">
                    <ul class="nav-tabs is-flex is-flex-direction-column is-align-items-flex-start">

                        <router-link v-for="(taxonomy_data) in taxonomies" :key="taxonomy_data.name" :to='"/taxonomies/" + taxonomy_data.name' v-slot="{ navigate, isActive }" custom exact>
                            <li class="nav-item" @click="navigate" @keypress.enter="navigate" role="link" :class="[isActive && 'router-link-active']">
                                <a class="nav-link is-clickable" :class="[taxonomy == taxonomy_data.name && 'active']" href="javascript:void(0);">
                                    <span class="icon is-small"><i class="dashicons dashicons-edit-page"></i></span>
                                    <span>{{taxonomy_data.title}}</span>
                                    <span v-if="! isPro() && taxonomy_data.is_pro" class="adminify-column-post--pro" style="margin-left: 4px;">- (Pro)</span>
                                    <span class="taxonomy-post-type" v-if="taxonomy_data.object_type">[{{taxonomy_data.object_type}}]</span>
                                </a>
                            </li>
                        </router-link>

                    </ul>
                </div>
            </div>

            <div class="column">
                <div class="tab-content tab-panel pane">
                    <router-view :key="$route.fullPath" v-if="taxonomies.length"></router-view>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {

    data: () => ({
        loading: false,
        taxonomies: [],
        taxonomy: null
    }),

    async mounted() {

        this.taxonomy = this.$route.params.taxonomy;

        await this.load_taxonomy_data();

        if ( ! this.taxonomy && this.taxonomies.length ) {
            this.$router.push( `/taxonomies/${this.taxonomies[0].name}` );
        }

    },

    methods: {

        async load_taxonomy_data() {
            this.taxonomies = await this.$store.dispatch( 'get_taxonomies' );
        },

        set_parent_data() {
            this.$parent.taxonomies = this.taxonomies;
        }

    },

    watch: {
        taxonomies: {
            deep: true,
            handler() {
                this.set_parent_data()
            }
        }
    }

}
</script>

<style>
    .taxonomy-post-type {
        text-align: right;
        text-transform: capitalize;
        opacity: .5;
        font-size: .8em;
        letter-spacing: .3px;
        font-weight: bold;
        flex: auto;
    }
</style>