import Vue from 'vue';

jQuery( function($) {

    new Vue({

        el: '#wp-adminify--setup-wizard',

        data: () => ({
            ...adminify_setup_wizard_data,
            active_step: null
        }),

        mounted() {
            const params = new URLSearchParams( window.location.search );
            if ( params.has('step') ) this.active_step = params.get('step');
        },

        methods: {

            getMedia() {
                return this.media;
            },

            setMedia( media ) {
                this.media = media;
            },

            handle_media( media ) {

                this.setMedia( media );
                
                if ( this.frame ) {
                    this.frame.open();
                    return;
                }

                this.frame = wp.media({
                    title: 'Select or Upload Media',
                    button: {
                        text: 'Use this media'
                    },
                    multiple: false
                });
                
                this.frame.on( 'select', () => {
                    const attachment = this.frame.state().get('selection').first().toJSON();
                    attachment.thumbnail = attachment.sizes.thumbnail.url;
                    let _media = this.getMedia();
                    for ( let media_key in _media ) _media[media_key] = attachment[media_key];
                });

                this.frame.on( 'open', () => {
                    let selection = this.frame.state().get('selection');
                    let _media = this.getMedia();
                    if ( _media && _media.id ) {
                        let attachment = wp.media.attachment( _media.id );
                        attachment.fetch();
                        return selection.add( attachment ? [attachment] : [] );
                    }
                    return selection.add([]);
                });

                this.frame.open();

            },

            async handleSubmit() {
                const res = await wp.ajax.post( 'wpadminify_save_wizard_data', { settings: this.settings, active_step: this.active_step, _wpnonce: this.wpnonce } );
                if ( res && res.redirect ) window.location = res.redirect;
            }

        }

    });

});