<template>
    
    <div class="tab-pane fade show active" id="analyze" role="tabpanel" aria-labelledby="analyze-tab">
        <div class="wp-adminify-form-container is-flex is-align-items-center is-justify-content-center">
            <form action="#" class="wp-adminify-speed-analyze-form" @submit.prevent="alalyzeURL">
                <input type="text" name="url" class="url" inputmode="url" placeholder="Enter a web page URL" aria-label="Enter a web page URL" v-model="url">
                <input type="submit" class="is-clickable">
                <svg class="search-icon" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.1916 16.6076L9.47663 10.8916C6.9343 12.6991 3.43107 12.257 1.4175 9.87456C-0.596063 7.49214 -0.448212 3.96422 1.75763 1.75863C3.96289 -0.447923 7.49115 -0.596414 9.87402 1.41705C12.2569 3.4305 12.6992 6.93408 10.8916 9.47663L16.6066 15.1926L15.1916 16.6076ZM5.99963 2.00062C4.10333 2.00019 2.46732 3.33131 2.0821 5.18807C1.69689 7.04482 2.66834 8.9169 4.40831 9.67087C6.14827 10.4248 8.17853 9.85346 9.26987 8.30268C10.3612 6.7519 10.2137 4.64795 8.91663 3.26463L9.52163 3.86463L8.83963 3.18463L8.82763 3.17263C8.07942 2.41981 7.06102 1.99776 5.99963 2.00062Z" fill="#4E4B66" fill-opacity="0.54"/>
                </svg>

                <div class="bottom-wrapper">
                    <div class="progress-area" v-if="loading">
                        <div class="hr-progress"><div class="hr-progress-bar" :style="{width: loaded + '%'}">{{loaded}}%</div></div>
                        <div class="progress-hint">It takes about 1 minute on average.</div>
                    </div>
                    <span class="error" v-if="error">{{ error }}</span>
                    <div style="margin-top: 16px;" v-if="proNoticeShow" v-html="pro_notice"></div>
                </div>

            </form>
        </div>
    </div>

</template>

<script>

    export default {

        data() {
            return {
                url: '',
                error: '',
                loading: false,
                loaded: 0,
                limit: 2,
                proNoticeShow: false,
                is_pro: !! window.wp_adminify__pagespeed_data.is_pro,
                pro_notice: window.wp_adminify__pagespeed_data.pro_notice,
            }
        },

        mounted() {

            this.$ = jQuery;
            this.adminify_data = window.wp_adminify__pagespeed_data;

        },

        methods: {

            startProgress() {

                this.loading = true;

                let _this = this;
                let max = 90;

                (function loop() {
                    var rand = Math.floor(Math.random() * 5) + 1;
                    setTimeout(function() {

                        if ( _this.loaded < max ) {
                            _this.loaded += rand;
                            loop();
                        }

                    }, rand * 350 );
                }());

            },

            completeProgress() {

                this.loaded = 100;

            },

            checkLimit() {

                return this.$.ajax({
                    type: "POST",
                    url: this.adminify_data.ajaxurl,
                    data: {
                        url: this.url,
                        action: "adminify_page_speed",
                        route: "count_total",
                        _ajax_nonce: this.adminify_data.nonce,
                    }
                });

            },

            showProNotice() {

                this.proNoticeShow = true;
                this.error = 'Max limit 2 reached in Free version';

            },
            
            async alalyzeURL() {

                if ( this.loading ) return;

                if ( ! this.is_pro ) {
                    let response = await this.checkLimit();
                    if ( response.data >= 2 ) return this.showProNotice();
                }

                let _this = this;

                this.error = '';

                let isValid = this.$parent.isURL( this.url );

                if ( ! isValid ) {
                    return this.error = 'Enter a valid URL'
                }

                this.startProgress();

                this.$.ajax({
                    type: 'POST',
                    url: this.adminify_data.ajaxurl,
                    data: {
                        url: this.url,
                        action: 'adminify_page_speed',
                        route: 'new_analyze',
                        _ajax_nonce: this.adminify_data.nonce
                    }
                })
                .done(function (response) {
                    if ( response && response.data ) {
                        _this.completeProgress();
                        setTimeout( () => {
                            _this.$router.push({ path: `/report/${response.data}` });
                        }, 350 );
                    }
                })
                .fail(function(response) {
                    _this.loading = false;
                    if ( response && response.responseJSON && response.responseJSON.data.message ) {
                        return _this.error = response.responseJSON.data.message;
                    }
                    _this.error = 'Something is wrong, please try again later';
                });

            }

        },

        watch: {

            url() {
                this.error = '';
            }

        }

    }

</script>