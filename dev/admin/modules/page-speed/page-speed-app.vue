<template>
    
    <div id="wp-adminify--page-speed-app">

        <div class="wp-adminify-page-speed-wrapper tabbable mt-6 p-4">

            <ul class="nav nav-tabs speed-wrapper-tabs is-pulled-left m-0 p-0" role="tablist">

                <router-link :to='"/"' v-slot="{ navigate, isActive }" custom exact v-if="$route.name !== 'report'">
                    <li id="analyze-tab" class="nav-item" @click="navigate" @keypress.enter="navigate" role="link" :class="[isActive && 'router-link-active']">
                        <a class="nav-link is-clickable" href="javascript:void(0);">
                            <svg class="tab-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20ZM13.4252 7.06241L11.6073 11.6071L7.06264 13.4249C6.75652 13.5474 6.45274 13.2436 6.57519 12.9375L8.39306 8.39283L12.9377 6.57496C13.2438 6.45251 13.5476 6.7563 13.4252 7.06241Z" fill="#0347FF"/>
                            </svg>
                            Analyze
                        </a>
                    </li>
                </router-link>

                <li id="report-tab" class="nav-item router-link-active router-link-exact-active" role="presentation" v-if="$route.name == 'report' && $route.params.id">
                    <a class="nav-link is-clickable" href="javascript:void(0);">
                        <i class="tab-icon dashicons dashicons-list-view"></i>
                        Report
                    </a>
                </li>

                <router-link :to='"/history"' v-slot="{ navigate, isActive }" custom>
                    <li id="history-tab" class="nav-item" @click="navigate" @keypress.enter="navigate" role="link" :class="[isActive && 'router-link-active']">
                        <a class="nav-link is-clickable" href="javascript:void(0);">
                            <svg class="tab-icon" width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.1055 9H17.0585C17.6045 9 18.0465 9.448 18.0465 10C18.0465 10.552 17.6045 11 17.0585 11H12.1175C11.987 10.9992 11.8579 10.9727 11.7376 10.922C11.6173 10.8714 11.5082 10.7975 11.4164 10.7046C11.3247 10.6118 11.2521 10.5017 11.2029 10.3808C11.1537 10.2599 11.1287 10.1305 11.1295 10V4C11.1295 3.448 11.5715 3 12.1175 3C12.6635 3 13.1055 3.448 13.1055 4V9ZM19.1055 2.929C20.9654 4.81183 22.0056 7.35348 21.9995 10C21.9995 15.523 17.5755 20 12.1175 20V18C16.4835 18 20.0235 14.418 20.0235 10C20.0286 7.88253 19.196 5.84899 17.7075 4.343C16.9781 3.60074 16.1081 3.01126 15.1483 2.60898C14.1885 2.20669 13.1582 1.99967 12.1175 2C8.57353 2 5.57353 4.36 4.57053 7.612L5.92253 6.689C6.03 6.61562 6.15101 6.56436 6.27849 6.53821C6.40597 6.51205 6.53739 6.51153 6.66507 6.53665C6.79276 6.56178 6.91418 6.61206 7.02224 6.68457C7.13031 6.75708 7.22287 6.85037 7.29453 6.959C7.4412 7.17907 7.49542 7.44801 7.44546 7.70772C7.3955 7.96742 7.24538 8.19705 7.02753 8.347L3.75053 10.584C3.64305 10.6574 3.52204 10.7086 3.39456 10.7348C3.26708 10.7609 3.13567 10.7615 3.00798 10.7363C2.88029 10.7112 2.75888 10.6609 2.65081 10.5884C2.54275 10.5159 2.45019 10.4226 2.37853 10.314L0.169526 6.998C0.0225357 6.77785 -0.0318606 6.50868 0.0181082 6.24873C0.068077 5.98878 0.218392 5.75896 0.436526 5.609C0.544005 5.53562 0.665009 5.48436 0.792491 5.45821C0.919973 5.43205 1.05139 5.43153 1.17907 5.45665C1.30676 5.48178 1.42818 5.53206 1.53624 5.60457C1.64431 5.67708 1.73687 5.77037 1.80853 5.879L2.64753 7.138C3.86253 3.01 7.64253 0 12.1175 0C14.8465 0 17.3175 1.12 19.1055 2.929Z" fill="#9391A0"/>
                            </svg>
                            History
                        </a>
                    </li>
                </router-link>

            </ul>

            <router-link :to='"/"' v-slot="{ navigate }" custom>
                <button @click="navigate" @keypress.enter="navigate" role="link" class="wp-adminify-analyze-button is-clickable is-pulled-right">New Analyze</button>
            </router-link>

            <div class="tab-content">
                <router-view :key="$route.fullPath"></router-view>
            </div>

        </div>

    </div>

</template>

<script>

const $ = jQuery;

export default {

    data() {

        return {
            activeTab: 'analyze',
        }

    },

    mounted() {

    },

	methods: {

        isURL( url ) {

            return /^(ftp|http|https):\/\/[^ "]+$/.test( url );
            
        }

	},

    computed: {

    },

    watch: {

    }

}
</script>