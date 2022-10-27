<template>
    <div class="tab-pane" id="post-types">
        <div class="columns">
            
            <div class="column is-4">
                <div class="tabs is-boxed">
                    <ul class="nav-tabs is-flex is-flex-direction-column is-align-items-flex-start">

                        <router-link v-for="(post_type_data) in post_types" :key="post_type_data.name" :to='"/post-types/" + post_type_data.name' v-slot="{ navigate, isActive }" custom exact>
                            <li class="nav-item" @click="navigate" @keypress.enter="navigate" role="link" :class="[isActive && 'router-link-active']">
                                <a class="nav-link is-clickable" :class="[post_type == post_type_data.name && 'active']" href="javascript:void(0);">
                                    <span class="icon is-small"><i class="dashicons dashicons-edit-page"></i></span>
                                    <span>{{post_type_data.title}}</span>
                                    <span v-if="! isPro() && post_type_data.is_pro" class="adminify-column-post--pro" style="margin-left: 4px;">- (Pro)</span>
                                </a>
                            </li>
                        </router-link>

                    </ul>
                </div>
            </div>

            <div class="column">
                <div class="tab-content tab-panel pane">
                    <router-view :key="$route.fullPath" v-if="post_types.length"></router-view>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {

    data: () => ({
        loading: false,
        post_types: [],
        post_type: null
    }),

    async mounted() {

        this.post_type = this.$route.params.post_type;

        await this.load_post_type_data();

        if ( ! this.post_type && this.post_types.length ) {
            this.$router.push( `/post-types/${this.post_types[0].name}` );
        }

    },

    methods: {

        async load_post_type_data() {
            this.post_types = await this.$store.dispatch( 'get_post_types' );
        },

        set_parent_data() {
            this.$parent.post_types = this.post_types;
        }

    },

    watch: {
        post_types: {
            deep: true,
            handler() {
                this.set_parent_data()
            }
        }
    }

}
</script>