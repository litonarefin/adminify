jQuery(function($) {

    class Adminify_Theme_Presetter {

        constructor() {
            this.themes = this.get_themes();
            this.$dom = $('body.wp-adminify');
            this.set_events();
            this.set_custom_theme();
        }

        get_themes() {
            return adminify_preset_themes;
        }

        set_theme( theme ) {
            const _theme = this.themes[theme];
            this.set_colors( _theme );
        }

        set_colors( colors ) {
            for ( let color in colors ) this.set_color( color, colors[color] );
        }

        set_custom_theme(){

            if($('input[data-depend-id="adminify_theme"]:checked').val() != 'custom') return;

            var $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-preset-background]"]')
            this.set_color( '--adminify-preset-background', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-menu-bg]"]')
            this.set_color( '--adminify-menu-bg', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-menu-text-color]"]')
            this.set_color( '--adminify-menu-text-color', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-admin-bar-bg]"]')
            this.set_color( '--adminify-admin-bar-bg', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-admin-bar-icon]"]')
            this.set_color( '--adminify-admin-bar-icon', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-admin-bar-input-bg]"]')
            this.set_color( '--adminify-admin-bar-input-bg', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-admin-bar-input-text]"]')
            this.set_color( '--adminify-admin-bar-input-text', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-notif-bg-color]"]')
            this.set_color( '--adminify-notif-bg-color', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-text-color]"]')
            this.set_color( '--adminify-text-color', $customPallete.val() );


            $customPallete = $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-btn-bg]"]')
            this.set_color( '--adminify-btn-bg', $customPallete.val() );

        }

        set_color( prop, val ) {
            this.$dom.css( prop, val );
        }

        set_events() {

            const that = this;

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-preset-background]"]').on( 'change', function() {
                that.set_color( '--adminify-preset-background', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-menu-bg]"]').on( 'change', function() {
                that.set_color( '--adminify-menu-bg', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-menu-text-color]"]').on( 'change', function() {
                that.set_color( '--adminify-menu-text-color', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-admin-bar-bg]"]').on( 'change', function() {
                that.set_color( '--adminify-admin-bar-bg', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-admin-bar-icon]"]').on( 'change', function() {
                that.set_color( '--adminify-admin-bar-icon', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-admin-bar-input-bg]"]').on( 'change', function() {
                that.set_color( '--adminify-admin-bar-input-bg', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-admin-bar-input-text]"]').on( 'change', function() {
                that.set_color( '--adminify-admin-bar-input-text', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-notif-bg-color]"]').on( 'change', function() {
                that.set_color( '--adminify-notif-bg-color', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-text-color]"]').on( 'change', function() {
                that.set_color( '--adminify-text-color', $(this).val() );
            });

            $('input[name="_wpadminify[adminify_theme_custom_colors][--adminify-btn-bg]"]').on( 'change', function() {
                that.set_color( '--adminify-btn-bg', $(this).val() );
            });


            $('input[data-depend-id="adminify_theme"]').on( 'change', function() {

                var selected_preset = $(this).filter(':checked').val();
                if(selected_preset=='custom') {
                    that.set_custom_theme();
                }else{
                    that.set_theme( selected_preset );
                }

            });

        }

    }

    new Adminify_Theme_Presetter();

});
