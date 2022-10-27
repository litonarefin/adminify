// JS codes by WP Adminify

jQuery(function( $ ) {
    'use strict';

    var MenuEditonIconsLibrary = {
        "Simple Line Icons":{
            "":{
                "prefix": "icon-",
                "list-icon":"icon-heart",
                "icon-style":"simple-line-icons",
                "icons": [
                    "icon-user", "icon-people", "icon-user-female", "icon-user-follow", "icon-user-following", "icon-user-unfollow", "icon-login", "icon-logout", "icon-emotsmile", "icon-phone", "icon-call-end", "icon-call-in", "icon-call-out", "icon-map", "icon-location-pin", "icon-direction", "icon-directions", "icon-compass", "icon-layers", "icon-menu", "icon-list", "icon-options-vertical", "icon-options", "icon-arrow-down", "icon-arrow-left", "icon-arrow-right", "icon-arrow-up", "icon-arrow-up-circle", "icon-arrow-left-circle", "icon-arrow-right-circle", "icon-arrow-down-circle", "icon-check", "icon-clock", "icon-plus", "icon-minus", "icon-close", "icon-event", "icon-exclamation", "icon-organization", "icon-trophy", "icon-screen-smartphone", "icon-screen-desktop", "icon-plane", "icon-notebook", "icon-mustache", "icon-mouse", "icon-magnet", "icon-energy", "icon-disc", "icon-cursor", "icon-cursor-move", "icon-crop", "icon-chemistry", "icon-speedometer", "icon-shield", "icon-screen-tablet", "icon-magic-wand", "icon-hourglass", "icon-graduation", "icon-ghost", "icon-game-controller", "icon-fire", "icon-eyeglass", "icon-envelope-open", "icon-envelope-letter", "icon-bell", "icon-badge", "icon-anchor", "icon-wallet", "icon-vector", "icon-speech", "icon-puzzle", "icon-printer", "icon-present", "icon-playlist", "icon-pin", "icon-picture", "icon-handbag", "icon-globe-alt", "icon-globe", "icon-folder-alt", "icon-folder", "icon-film", "icon-feed", "icon-drop", "icon-drawer", "icon-docs", "icon-doc", "icon-diamond", "icon-cup", "icon-calculator", "icon-bubbles", "icon-briefcase", "icon-book-open", "icon-basket-loaded", "icon-basket", "icon-bag", "icon-action-undo", "icon-action-redo", "icon-wrench", "icon-umbrella", "icon-trash", "icon-tag", "icon-support", "icon-frame", "icon-size-fullscreen", "icon-size-actual", "icon-shuffle", "icon-share-alt", "icon-share", "icon-rocket", "icon-question", "icon-pie-chart", "icon-pencil", "icon-note", "icon-loop", "icon-home", "icon-grid", "icon-graph", "icon-microphone", "icon-music-tone-alt", "icon-music-tone", "icon-earphones-alt", "icon-earphones", "icon-equalizer", "icon-like", "icon-dislike", "icon-control-start", "icon-control-rewind", "icon-control-play", "icon-control-pause", "icon-control-forward", "icon-control-end", "icon-volume-1", "icon-volume-2", "icon-volume-off", "icon-calendar", "icon-bulb", "icon-chart", "icon-ban", "icon-bubble", "icon-camrecorder", "icon-camera", "icon-cloud-download", "icon-cloud-upload", "icon-envelope", "icon-eye", "icon-flag", "icon-heart", "icon-info", "icon-key", "icon-link", "icon-lock", "icon-lock-open", "icon-magnifier", "icon-magnifier-add", "icon-magnifier-remove", "icon-paper-clip", "icon-paper-plane", "icon-power", "icon-refresh", "icon-reload", "icon-settings", "icon-star", "icon-symbol-female", "icon-symbol-male", "icon-target", "icon-credit-card", "icon-paypal", "icon-social-tumblr", "icon-social-twitter", "icon-social-facebook", "icon-social-instagram", "icon-social-linkedin", "icon-social-pinterest", "icon-social-github", "icon-social-google", "icon-social-reddit", "icon-social-skype", "icon-social-dribbble", "icon-social-behance", "icon-social-foursqare", "icon-social-soundcloud", "icon-social-spotify", "icon-social-stumbleupon", "icon-social-youtube", "icon-social-dropbox", "icon-social-vkontakte", "icon-social-steam"
                ]
            }
        },

        "Themify Icons":{
            "":{
                "prefix": "ti-",
                "list-icon":"ti-themify-favicon",
                "icon-style":"themify-icons",
                "icons": [
                    "ti-wand", "ti-volume", "ti-user", "ti-unlock", "ti-unlink", "ti-trash", "ti-thought", "ti-target", "ti-tag", "ti-tablet", "ti-star", "ti-spray", "ti-signal", "ti-shopping-cart", "ti-shopping-cart-full", "ti-settings", "ti-search", "ti-zoom-in", "ti-zoom-out", "ti-cut", "ti-ruler", "ti-ruler-pencil", "ti-ruler-alt", "ti-bookmark", "ti-bookmark-alt", "ti-reload", "ti-plus", "ti-pin", "ti-pencil", "ti-pencil-alt", "ti-paint-roller", "ti-paint-bucket", "ti-na", "ti-mobile", "ti-minus", "ti-medall", "ti-medall-alt", "ti-marker", "ti-marker-alt", "ti-arrow-up", "ti-arrow-right", "ti-arrow-left", "ti-arrow-down", "ti-lock", "ti-location-arrow", "ti-link", "ti-layout", "ti-layers", "ti-layers-alt", "ti-key", "ti-import", "ti-image", "ti-heart", "ti-heart-broken", "ti-hand-stop", "ti-hand-open", "ti-hand-drag", "ti-folder", "ti-flag", "ti-flag-alt", "ti-flag-alt-2", "ti-eye", "ti-export", "ti-exchange-vertical", "ti-desktop", "ti-cup", "ti-crown", "ti-comments", "ti-comment", "ti-comment-alt", "ti-close", "ti-clip", "ti-angle-up", "ti-angle-right", "ti-angle-left", "ti-angle-down", "ti-check", "ti-check-box", "ti-camera", "ti-announcement", "ti-brush", "ti-briefcase", "ti-bolt", "ti-bolt-alt", "ti-blackboard", "ti-bag", "ti-move", "ti-arrows-vertical", "ti-arrows-horizontal", "ti-fullscreen", "ti-arrow-top-right", "ti-arrow-top-left", "ti-arrow-circle-up", "ti-arrow-circle-right", "ti-arrow-circle-left", "ti-arrow-circle-down", "ti-angle-double-up", "ti-angle-double-right", "ti-angle-double-left", "ti-angle-double-down", "ti-zip", "ti-world", "ti-wheelchair", "ti-view-list", "ti-view-list-alt", "ti-view-grid", "ti-uppercase", "ti-upload", "ti-underline", "ti-truck", "ti-timer", "ti-ticket", "ti-thumb-up", "ti-thumb-down", "ti-text", "ti-stats-up", "ti-stats-down", "ti-split-v", "ti-split-h", "ti-smallcap", "ti-shine", "ti-shift-right", "ti-shift-left", "ti-shield", "ti-notepad", "ti-server", "ti-quote-right", "ti-quote-left", "ti-pulse", "ti-printer", "ti-power-off", "ti-plug", "ti-pie-chart", "ti-paragraph", "ti-panel", "ti-package", "ti-music", "ti-music-alt", "ti-mouse", "ti-mouse-alt", "ti-money", "ti-microphone", "ti-menu", "ti-menu-alt", "ti-map", "ti-map-alt", "ti-loop", "ti-location-pin", "ti-list", "ti-light-bulb", "ti-Italic", "ti-info", "ti-infinite", "ti-id-badge", "ti-hummer", "ti-home", "ti-help", "ti-headphone", "ti-harddrives", "ti-harddrive", "ti-gift", "ti-game", "ti-filter", "ti-files", "ti-file", "ti-eraser", "ti-envelope", "ti-download", "ti-direction", "ti-direction-alt", "ti-dashboard", "ti-control-stop", "ti-control-shuffle", "ti-control-play", "ti-control-pause", "ti-control-forward", "ti-control-backward", "ti-cloud", "ti-cloud-up", "ti-cloud-down", "ti-clipboard", "ti-car", "ti-calendar", "ti-book", "ti-bell", "ti-basketball", "ti-bar-chart", "ti-bar-chart-alt", "ti-back-right", "ti-back-left", "ti-arrows-corner", "ti-archive", "ti-anchor", "ti-align-right", "ti-align-left", "ti-align-justify", "ti-align-center", "ti-alert", "ti-alarm-clock", "ti-agenda", "ti-write", "ti-window", "ti-widgetized", "ti-widget", "ti-widget-alt", "ti-wallet", "ti-video-clapper", "ti-video-camera", "ti-vector", "ti-themify-logo", "ti-themify-favicon", "ti-themify-favicon-alt", "ti-support", "ti-stamp", "ti-split-v-alt", "ti-slice", "ti-shortcode", "ti-shift-right-alt", "ti-shift-left-alt", "ti-ruler-alt-2", "ti-receipt", "ti-pin2", "ti-pin-alt", "ti-pencil-alt2", "ti-palette", "ti-more", "ti-more-alt", "ti-microphone-alt", "ti-magnet", "ti-line-double", "ti-line-dotted", "ti-line-dashed", "ti-layout-width-full", "ti-layout-width-default", "ti-layout-width-default-alt", "ti-layout-tab", "ti-layout-tab-window", "ti-layout-tab-v", "ti-layout-tab-min", "ti-layout-slider", "ti-layout-slider-alt", "ti-layout-sidebar-right", "ti-layout-sidebar-none", "ti-layout-sidebar-left", "ti-layout-placeholder", "ti-layout-menu", "ti-layout-menu-v", "ti-layout-menu-separated", "ti-layout-menu-full", "ti-layout-media-right-alt", "ti-layout-media-right", "ti-layout-media-overlay", "ti-layout-media-overlay-alt", "ti-layout-media-overlay-alt-2", "ti-layout-media-left-alt", "ti-layout-media-left", "ti-layout-media-center-alt", "ti-layout-media-center", "ti-layout-list-thumb", "ti-layout-list-thumb-alt", "ti-layout-list-post", "ti-layout-list-large-image", "ti-layout-line-solid", "ti-layout-grid4", "ti-layout-grid3", "ti-layout-grid2", "ti-layout-grid2-thumb", "ti-layout-cta-right", "ti-layout-cta-left", "ti-layout-cta-center", "ti-layout-cta-btn-right", "ti-layout-cta-btn-left", "ti-layout-column4", "ti-layout-column3", "ti-layout-column2", "ti-layout-accordion-separated", "ti-layout-accordion-merged", "ti-layout-accordion-list", "ti-ink-pen", "ti-info-alt", "ti-help-alt", "ti-headphone-alt", "ti-hand-point-up", "ti-hand-point-right", "ti-hand-point-left", "ti-hand-point-down", "ti-gallery", "ti-face-smile", "ti-face-sad", "ti-credit-card", "ti-control-skip-forward", "ti-control-skip-backward", "ti-control-record", "ti-control-eject", "ti-comments-smiley", "ti-brush-alt", "ti-youtube", "ti-vimeo", "ti-twitter", "ti-time", "ti-tumblr", "ti-skype", "ti-share", "ti-share-alt", "ti-rocket", "ti-pinterest", "ti-new-window", "ti-microsoft", "ti-list-ol", "ti-linkedin", "ti-layout-sidebar-2", "ti-layout-grid4-alt", "ti-layout-grid3-alt", "ti-layout-grid2-alt", "ti-layout-column4-alt", "ti-layout-column3-alt", "ti-layout-column2-alt", "ti-instagram", "ti-google", "ti-github", "ti-flickr", "ti-facebook", "ti-dropbox", "ti-dribbble", "ti-apple", "ti-android", "ti-save", "ti-save-alt", "ti-yahoo", "ti-wordpress", "ti-vimeo-alt", "ti-twitter-alt", "ti-tumblr-alt", "ti-trello", "ti-stack-overflow", "ti-soundcloud", "ti-sharethis", "ti-sharethis-alt", "ti-reddit", "ti-pinterest-alt", "ti-microsoft-alt", "ti-linux", "ti-jsfiddle", "ti-joomla", "ti-html5", "ti-flickr-alt", "ti-email", "ti-drupal", "ti-dropbox-alt", "ti-css3", "ti-rss", "ti-rss-alt"
                ]
            }
        },

        "Elementor Icons":{
            "":{
                "prefix": "eicon-",
                "list-icon":"eicon-elementor-circle",
                "icon-style":"Elementor Icons",
                "icons": [
                    "eicon-editor-link", "eicon-editor-unlink", "eicon-editor-external-link", "eicon-editor-close", "eicon-editor-list-ol", "eicon-editor-list-ul", "eicon-editor-bold", "eicon-editor-italic", "eicon-editor-underline", "eicon-editor-paragraph", "eicon-editor-h1", "eicon-editor-h2", "eicon-editor-h3", "eicon-editor-h4", "eicon-editor-h5", "eicon-editor-h6", "eicon-editor-quote", "eicon-editor-code", "eicon-elementor", "eicon-elementor-circle", "eicon-pojome", "eicon-plus", "eicon-menu-bar", "eicon-apps", "eicon-accordion", "eicon-alert", "eicon-animation-text", "eicon-animation", "eicon-banner", "eicon-blockquote", "eicon-button", "eicon-call-to-action", "eicon-captcha", "eicon-carousel", "eicon-checkbox", "eicon-columns", "eicon-countdown", "eicon-counter", "eicon-date", "eicon-divider-shape", "eicon-divider", "eicon-download-button", "eicon-dual-button", "eicon-email-field", "eicon-facebook-comments", "eicon-facebook-like-box", "eicon-form-horizontal", "eicon-form-vertical", "eicon-gallery-grid", "eicon-gallery-group", "eicon-gallery-justified", "eicon-gallery-masonry", "eicon-icon-box", "eicon-image-before-after", "eicon-image-box", "eicon-image-hotspot", "eicon-image-rollover", "eicon-info-box", "eicon-inner-section", "eicon-mailchimp", "eicon-menu-card", "eicon-navigation-horizontal", "eicon-nav-menu", "eicon-navigation-vertical", "eicon-number-field", "eicon-parallax", "eicon-php7", "eicon-post-list", "eicon-post-slider", "eicon-post", "eicon-posts-carousel", "eicon-posts-grid", "eicon-posts-group", "eicon-posts-justified", "eicon-posts-masonry", "eicon-posts-ticker", "eicon-price-list", "eicon-price-table", "eicon-radio", "eicon-rtl", "eicon-scroll", "eicon-search", "eicon-select", "eicon-share", "eicon-sidebar", "eicon-skill-bar", "eicon-slider-3d", "eicon-slider-album", "eicon-slider-device", "eicon-slider-full-screen", "eicon-slider-push", "eicon-slider-vertical", "eicon-slider-video", "eicon-slides", "eicon-social-icons", "eicon-spacer", "eicon-table", "eicon-tabs", "eicon-tel-field", "eicon-text-area", "eicon-text-field", "eicon-thumbnails-down", "eicon-thumbnails-half", "eicon-thumbnails-right", "eicon-time-line", "eicon-toggle", "eicon-url", "eicon-t-letter", "eicon-wordpress", "eicon-text", "eicon-anchor", "eicon-bullet-list", "eicon-code", "eicon-favorite", "eicon-google-maps", "eicon-image", "eicon-photo-library", "eicon-woocommerce", "eicon-youtube", "eicon-flip-box", "eicon-settings", "eicon-headphones", "eicon-testimonial", "eicon-counter-circle", "eicon-person", "eicon-chevron-right", "eicon-chevron-left", "eicon-close", "eicon-file-download", "eicon-save", "eicon-zoom-in", "eicon-shortcode", "eicon-nerd", "eicon-device-desktop", "eicon-device-tablet", "eicon-device-mobile", "eicon-document-file", "eicon-folder-o", "eicon-hypster", "eicon-h-align-left", "eicon-h-align-right", "eicon-h-align-center", "eicon-h-align-stretch", "eicon-v-align-top", "eicon-v-align-bottom", "eicon-v-align-middle", "eicon-v-align-stretch", "eicon-pro-icon", "eicon-mail", "eicon-lock-user", "eicon-testimonial-carousel", "eicon-media-carousel", "eicon-section", "eicon-column", "eicon-edit", "eicon-clone", "eicon-trash", "eicon-play", "eicon-angle-right", "eicon-angle-left", "eicon-animated-headline", "eicon-menu-toggle", "eicon-fb-embed", "eicon-fb-feed", "eicon-twitter-embed", "eicon-twitter-feed", "eicon-sync", "eicon-import-export", "eicon-check-circle", "eicon-library-save", "eicon-library-download", "eicon-insert", "eicon-preview-medium", "eicon-sort-down", "eicon-sort-up", "eicon-heading", "eicon-logo", "eicon-meta-data", "eicon-post-content", "eicon-post-excerpt", "eicon-post-navigation", "eicon-yoast", "eicon-nerd-chuckle", "eicon-nerd-wink", "eicon-comments", "eicon-download-circle-o", "eicon-library-upload", "eicon-save-o", "eicon-upload-circle-o", "eicon-ellipsis-h", "eicon-ellipsis-v", "eicon-arrow-left", "eicon-arrow-right", "eicon-arrow-up", "eicon-arrow-down", "eicon-play-o", "eicon-archive-posts", "eicon-archive-title", "eicon-featured-image", "eicon-post-info", "eicon-post-title", "eicon-site-logo", "eicon-site-search", "eicon-site-title", "eicon-plus-square", "eicon-minus-square", "eicon-cloud-check", "eicon-drag-n-drop", "eicon-welcome", "eicon-handle", "eicon-cart", "eicon-product-add-to-cart", "eicon-product-breadcrumbs", "eicon-product-categories", "eicon-product-description", "eicon-product-images", "eicon-product-info", "eicon-product-meta", "eicon-product-pages", "eicon-product-price", "eicon-product-rating", "eicon-product-related", "eicon-product-stock", "eicon-product-tabs", "eicon-product-title", "eicon-product-upsell", "eicon-products", "eicon-bag-light", "eicon-bag-medium", "eicon-bag-solid", "eicon-basket-light", "eicon-basket-medium", "eicon-basket-solid", "eicon-cart-light", "eicon-cart-medium", "eicon-cart-solid", "eicon-exchange", "eicon-preview-thin", "eicon-device-laptop", "eicon-collapse", "eicon-expand", "eicon-navigator", "eicon-plug", "eicon-dashboard", "eicon-typography", "eicon-info-circle-o", "eicon-integration", "eicon-plus-circle-o", "eicon-rating", "eicon-review", "eicon-tools", "eicon-loading", "eicon-sitemap", "eicon-click", "eicon-clock", "eicon-library-open", "eicon-warning", "eicon-flow", "eicon-cursor-move", "eicon-arrow-circle-left", "eicon-flash", "eicon-redo", "eicon-ban", "eicon-barcode", "eicon-calendar", "eicon-caret-left", "eicon-caret-right", "eicon-caret-up", "eicon-chain-broken", "eicon-check-circle-o", "eicon-check", "eicon-chevron-double-left", "eicon-chevron-double-right", "eicon-undo", "eicon-filter", "eicon-circle-o", "eicon-circle", "eicon-clock-o", "eicon-cog", "eicon-cogs", "eicon-commenting-o", "eicon-copy", "eicon-database", "eicon-dot-circle-o", "eicon-envelope", "eicon-external-link-square", "eicon-eyedropper", "eicon-folder", "eicon-font", "eicon-adjust", "eicon-lightbox", "eicon-heart-o", "eicon-history", "eicon-image-bold", "eicon-info-circle", "eicon-link", "eicon-long-arrow-left", "eicon-long-arrow-right", "eicon-caret-down", "eicon-paint-brush", "eicon-pencil", "eicon-plus-circle", "eicon-zoom-in-bold", "eicon-sort-amount-desc", "eicon-sign-out", "eicon-spinner", "eicon-square", "eicon-star-o", "eicon-star", "eicon-text-align-justify", "eicon-text-align-center", "eicon-tags", "eicon-text-align-left", "eicon-text-align-right", "eicon-close-circle", "eicon-trash-o", "eicon-font-awesome", "eicon-user-circle-o", "eicon-video-camera", "eicon-heart", "eicon-wrench", "eicon-help", "eicon-help-o", "eicon-zoom-out-bold", "eicon-plus-square-o", "eicon-minus-square-o", "eicon-minus-circle", "eicon-minus-circle-o", "eicon-code-bold", "eicon-cloud-upload", "eicon-search-bold", "eicon-map-pin", "eicon-meetup", "eicon-slideshow", "eicon-t-letter-bold", "eicon-preferences", "eicon-table-of-contents", "eicon-tv", "eicon-upload", "eicon-instagram-comments", "eicon-instagram-nested-gallery", "eicon-instagram-post", "eicon-instagram-video", "eicon-instagram-gallery", "eicon-instagram-likes", "eicon-facebook", "eicon-twitter", "eicon-pinterest", "eicon-frame-expand", "eicon-frame-minimize", "eicon-archive", "eicon-colors-typography", "eicon-custom", "eicon-footer", "eicon-header", "eicon-layout-settings", "eicon-lightbox-expand", "eicon-error-404", "eicon-theme-style", "eicon-search-results", "eicon-single-post", "eicon-site-identity", "eicon-theme-builder", "eicon-download-bold", "eicon-share-arrow", "eicon-global-settings", "eicon-user-preferences", "eicon-lock", "eicon-export-kit", "eicon-import-kit", "eicon-lottie", "eicon-products-archive", "eicon-single-product", "eicon-disable-trash-o", "eicon-single-page", "eicon-wordpress-light", "eicon-cogs-check", "eicon-custom-css", "eicon-global-colors", "eicon-globe", "eicon-typography-1", "eicon-background", "eicon-device-responsive", "eicon-device-wide", "eicon-code-highlight", "eicon-video-playlist", "eicon-download-kit", "eicon-kit-details", "eicon-kit-parts", "eicon-kit-upload", "eicon-kit-plugins", "eicon-kit-upload-alt", "eicon-hotspot", "eicon-paypal-button", "eicon-shape", "eicon-wordart", "eicon-eye", "eicon-elementor-square"
                ]
            }
        },

        "Icomoon Icons":{
            "":{
                "prefix": "icomoon-",
                "list-icon":"icomoon-IcoMoon",
                "icon-style":"icomoon-icons",
                "icons": [
                    "icomoon-home", "icomoon-home2", "icomoon-home3", "icomoon-office", "icomoon-newspaper", "icomoon-pencil", "icomoon-pencil2", "icomoon-quill", "icomoon-pen", "icomoon-blog", "icomoon-droplet", "icomoon-paint-format", "icomoon-image", "icomoon-image2", "icomoon-images", "icomoon-camera", "icomoon-music", "icomoon-headphones", "icomoon-play", "icomoon-film", "icomoon-camera2", "icomoon-dice", "icomoon-pacman", "icomoon-spades", "icomoon-clubs", "icomoon-diamonds", "icomoon-pawn", "icomoon-bullhorn", "icomoon-connection", "icomoon-podcast", "icomoon-feed", "icomoon-book", "icomoon-books", "icomoon-library", "icomoon-file", "icomoon-profile", "icomoon-file2", "icomoon-file3", "icomoon-file4", "icomoon-copy", "icomoon-copy2", "icomoon-copy3", "icomoon-paste", "icomoon-paste2", "icomoon-paste3", "icomoon-stack", "icomoon-folder", "icomoon-folder-open", "icomoon-tag", "icomoon-tags", "icomoon-barcode", "icomoon-qrcode", "icomoon-ticket", "icomoon-cart", "icomoon-cart2", "icomoon-cart3", "icomoon-coin", "icomoon-credit", "icomoon-calculate", "icomoon-support", "icomoon-phone", "icomoon-phone-hang-up", "icomoon-address-book", "icomoon-notebook", "icomoon-envelope", "icomoon-pushpin", "icomoon-location", "icomoon-location2", "icomoon-compass", "icomoon-map", "icomoon-map2", "icomoon-history", "icomoon-clock", "icomoon-clock2", "icomoon-alarm", "icomoon-alarm2", "icomoon-bell", "icomoon-stopwatch", "icomoon-calendar", "icomoon-calendar2", "icomoon-print", "icomoon-keyboard", "icomoon-screen", "icomoon-laptop", "icomoon-mobile", "icomoon-mobile2", "icomoon-tablet", "icomoon-tv", "icomoon-cabinet", "icomoon-drawer", "icomoon-drawer2", "icomoon-drawer3", "icomoon-box-add", "icomoon-box-remove", "icomoon-download", "icomoon-upload", "icomoon-disk", "icomoon-storage", "icomoon-undo", "icomoon-redo", "icomoon-flip", "icomoon-flip2", "icomoon-undo2", "icomoon-redo2", "icomoon-forward", "icomoon-reply", "icomoon-bubble", "icomoon-bubbles", "icomoon-bubbles2", "icomoon-bubble2", "icomoon-bubbles3", "icomoon-bubbles4", "icomoon-user", "icomoon-users", "icomoon-user2", "icomoon-users2", "icomoon-user3", "icomoon-user4", "icomoon-quotes-left", "icomoon-busy", "icomoon-spinner", "icomoon-spinner2", "icomoon-spinner3", "icomoon-spinner4", "icomoon-spinner5", "icomoon-spinner6", "icomoon-binoculars", "icomoon-search", "icomoon-zoomin", "icomoon-zoomout", "icomoon-expand", "icomoon-contract", "icomoon-expand2", "icomoon-contract2", "icomoon-key", "icomoon-key2", "icomoon-lock", "icomoon-lock2", "icomoon-unlocked", "icomoon-wrench", "icomoon-settings", "icomoon-equalizer", "icomoon-cog", "icomoon-cogs", "icomoon-cog2", "icomoon-hammer", "icomoon-wand", "icomoon-aid", "icomoon-bug", "icomoon-pie", "icomoon-stats", "icomoon-bars", "icomoon-bars2", "icomoon-gift", "icomoon-trophy", "icomoon-glass", "icomoon-mug", "icomoon-food", "icomoon-leaf", "icomoon-rocket", "icomoon-meter", "icomoon-meter2", "icomoon-dashboard", "icomoon-hammer2", "icomoon-fire", "icomoon-lab", "icomoon-magnet", "icomoon-remove", "icomoon-remove2", "icomoon-briefcase", "icomoon-airplane", "icomoon-truck", "icomoon-road", "icomoon-accessibility", "icomoon-target", "icomoon-shield", "icomoon-lightning", "icomoon-switch", "icomoon-powercord", "icomoon-signup", "icomoon-list", "icomoon-list2", "icomoon-numbered-list", "icomoon-menu", "icomoon-menu2", "icomoon-tree", "icomoon-cloud", "icomoon-cloud-download", "icomoon-cloud-upload", "icomoon-download2", "icomoon-upload2", "icomoon-download3", "icomoon-upload3", "icomoon-globe", "icomoon-earth", "icomoon-link", "icomoon-flag", "icomoon-attachment", "icomoon-eye", "icomoon-eye-blocked", "icomoon-eye2", "icomoon-bookmark", "icomoon-bookmarks", "icomoon-brightness-medium", "icomoon-brightness-contrast", "icomoon-contrast", "icomoon-star", "icomoon-star2", "icomoon-star3", "icomoon-heart", "icomoon-heart2", "icomoon-heart-broken", "icomoon-thumbs-up", "icomoon-thumbs-up2", "icomoon-happy", "icomoon-happy2", "icomoon-smiley", "icomoon-smiley2", "icomoon-tongue", "icomoon-tongue2", "icomoon-sad", "icomoon-sad2", "icomoon-wink", "icomoon-wink2", "icomoon-grin", "icomoon-grin2", "icomoon-cool", "icomoon-cool2", "icomoon-angry", "icomoon-angry2", "icomoon-evil", "icomoon-evil2", "icomoon-shocked", "icomoon-shocked2", "icomoon-confused", "icomoon-confused2", "icomoon-neutral", "icomoon-neutral2", "icomoon-wondering", "icomoon-wondering2", "icomoon-point-up", "icomoon-point-right", "icomoon-point-down", "icomoon-point-left", "icomoon-warning", "icomoon-notification", "icomoon-question", "icomoon-info", "icomoon-info2", "icomoon-blocked", "icomoon-cancel-circle", "icomoon-checkmark-circle", "icomoon-spam", "icomoon-close", "icomoon-checkmark", "icomoon-checkmark2", "icomoon-spell-check", "icomoon-minus", "icomoon-plus", "icomoon-enter", "icomoon-exit", "icomoon-play2", "icomoon-pause", "icomoon-stop", "icomoon-backward", "icomoon-forward2", "icomoon-play3", "icomoon-pause2", "icomoon-stop2", "icomoon-backward2", "icomoon-forward3", "icomoon-first", "icomoon-last", "icomoon-previous", "icomoon-next", "icomoon-eject", "icomoon-volume-high", "icomoon-volume-medium", "icomoon-volume-low", "icomoon-volume-mute", "icomoon-volume-mute2", "icomoon-volume-increase", "icomoon-volume-decrease", "icomoon-loop", "icomoon-loop2", "icomoon-loop3", "icomoon-shuffle", "icomoon-arrow-up-left", "icomoon-arrow-up", "icomoon-arrow-up-right", "icomoon-arrow-right", "icomoon-arrow-down-right", "icomoon-arrow-down", "icomoon-arrow-down-left", "icomoon-arrow-left", "icomoon-arrow-up-left2", "icomoon-arrow-up2", "icomoon-arrow-up-right2", "icomoon-arrow-right2", "icomoon-arrow-down-right2", "icomoon-arrow-down2", "icomoon-arrow-down-left2", "icomoon-arrow-left2", "icomoon-arrow-up-left3", "icomoon-arrow-up3", "icomoon-arrow-up-right3", "icomoon-arrow-right3", "icomoon-arrow-down-right3", "icomoon-arrow-down3", "icomoon-arrow-down-left3", "icomoon-arrow-left3", "icomoon-tab", "icomoon-checkbox-checked", "icomoon-checkbox-unchecked", "icomoon-checkbox-partial", "icomoon-radio-checked", "icomoon-radio-unchecked", "icomoon-crop", "icomoon-scissors", "icomoon-filter", "icomoon-filter2", "icomoon-font", "icomoon-text-height", "icomoon-text-width", "icomoon-bold", "icomoon-underline", "icomoon-italic", "icomoon-strikethrough", "icomoon-omega", "icomoon-sigma", "icomoon-table", "icomoon-table2", "icomoon-insert-template", "icomoon-pilcrow", "icomoon-lefttoright", "icomoon-righttoleft", "icomoon-paragraph-left", "icomoon-paragraph-center", "icomoon-paragraph-right", "icomoon-paragraph-justify", "icomoon-paragraph-left2", "icomoon-paragraph-center2", "icomoon-paragraph-right2", "icomoon-paragraph-justify2", "icomoon-indent-increase", "icomoon-indent-decrease", "icomoon-newtab", "icomoon-embed", "icomoon-code", "icomoon-console", "icomoon-share", "icomoon-mail", "icomoon-mail2", "icomoon-mail3", "icomoon-mail4", "icomoon-google", "icomoon-googleplus", "icomoon-googleplus2", "icomoon-googleplus3", "icomoon-googleplus4", "icomoon-google-drive", "icomoon-facebook", "icomoon-facebook2", "icomoon-facebook3", "icomoon-instagram", "icomoon-twitter", "icomoon-twitter2", "icomoon-twitter3", "icomoon-feed2", "icomoon-feed3", "icomoon-feed4", "icomoon-youtube", "icomoon-youtube2", "icomoon-vimeo", "icomoon-vimeo2", "icomoon-vimeo3", "icomoon-lanyrd", "icomoon-flickr", "icomoon-flickr2", "icomoon-flickr3", "icomoon-flickr4", "icomoon-picassa", "icomoon-picassa2", "icomoon-dribbble", "icomoon-dribbble2", "icomoon-dribbble3", "icomoon-forrst", "icomoon-forrst2", "icomoon-deviantart", "icomoon-deviantart2", "icomoon-steam", "icomoon-steam2", "icomoon-github", "icomoon-github2", "icomoon-github3", "icomoon-github4", "icomoon-github5", "icomoon-wordpress", "icomoon-wordpress2", "icomoon-joomla", "icomoon-blogger", "icomoon-blogger2", "icomoon-tumblr", "icomoon-tumblr2", "icomoon-yahoo", "icomoon-tux", "icomoon-apple", "icomoon-finder", "icomoon-android", "icomoon-windows", "icomoon-windows8", "icomoon-soundcloud", "icomoon-soundcloud2", "icomoon-skype", "icomoon-reddit", "icomoon-linkedin", "icomoon-lastfm", "icomoon-lastfm2", "icomoon-delicious", "icomoon-stumbleupon", "icomoon-stumbleupon2", "icomoon-stackoverflow", "icomoon-pinterest", "icomoon-pinterest2", "icomoon-xing", "icomoon-xing2", "icomoon-flattr", "icomoon-foursquare", "icomoon-foursquare2", "icomoon-paypal", "icomoon-paypal2", "icomoon-paypal3", "icomoon-yelp", "icomoon-libreoffice", "icomoon-file-pdf", "icomoon-file-openoffice", "icomoon-file-word", "icomoon-file-excel", "icomoon-file-zip", "icomoon-file-powerpoint", "icomoon-file-xml", "icomoon-file-css", "icomoon-html5", "icomoon-html52", "icomoon-css3", "icomoon-chrome", "icomoon-firefox", "icomoon-IE", "icomoon-opera", "icomoon-safari", "icomoon-IcoMoon"
                ]
            }
        }
    }


    var icons_libraries = {
        'elementor-icons': 'Elementor Icons',
        'wp-adminify-simple-line-icons': 'Simple Line Icons',
        'wp-adminify-icomoon': 'Icomoon Icons',
        'wp-adminify-themify-icons': 'Themify Icons'
    };

    Object.entries(icons_libraries).forEach(([key, value]) => {
        if( WPAdminifyMenuEditor.assets_manager.includes( key )){
            delete MenuEditonIconsLibrary[value];
        }
    });


    $('.icon-picker-wrap').ai_icon_picker({
        'iconLibrary': MenuEditonIconsLibrary,
    });


    // Reset Menu Settings
    $('.adminify_reset_menu_settings').on('click', function(e){
        e.preventDefault();
        $.ajax({
            url: WPAdminifyMenuEditor.ajax_url,
            type: "post",
            data: {
            action: "adminify_reset_menu_settings",
            security: WPAdminifyMenuEditor.security,
            },
            success: function (response) {
                if (response) {
                    var data = JSON.parse(response);
                    if (data.error) {
                        $('#adminify-data-saved-message').addClass('notification is-warning');
                        $('#adminify-data-saved-message').css('display','block');
                        $('#adminify-data-saved-message').text(data.message);

                        setTimeout(function () {
                            $('#adminify-data-saved-message').fadeOut('fast');
                            $('#adminify-data-saved-message').removeClass('notification is-warning');
                            $('#adminify-data-saved-message').css('display','none');
                        }, 1500);
                    } else {
                        $('#adminify-data-saved-message').addClass('notification is-primary');
                        $('#adminify-data-saved-message').css('display','block');
                        $('#adminify-data-saved-message').text(data.message);

                        setTimeout(function () {
                            $('#adminify-data-saved-message').fadeOut('fast');
                            $('#adminify-data-saved-message').removeClass('notification is-primary');
                            $('#adminify-data-saved-message').css('display','none');
                            location.reload();
                        }, 1500);
                    }
                }
            },
        });
    });


    // Export Menu Settings
    $('.adminify_export_menu_settings').on('click', function(e){
        $.ajax({
            url: WPAdminifyMenuEditor.ajax_url,
            type: "post",
            data: {
                action: "adminify_export_menu_settings",
                security: WPAdminifyMenuEditor.security,
            },
            success: function (response) {
                var data = response;
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, "0");
                var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
                var yyyy = today.getFullYear();

                var date_today = mm + "_" + dd + "_" + yyyy;
                var filename = "wpadminify_menu_settings_" + date_today + ".json";

                var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(data);
                var dlAnchorElem = document.getElementById("adminify_download_settings");
                dlAnchorElem.setAttribute("href", dataStr);
                dlAnchorElem.setAttribute("download", filename);
                dlAnchorElem.click();
            },
        });
    });

    $(".adminify_import_menu_settings").on('click', function(e){
        e.preventDefault();
        $("#adminify_import_menu").trigger('click');
    });

    // Import Menu Settings
    $('#adminify_import_menu').on('change', function(e){
        e.preventDefault();

        var thefile = $("#adminify_import_menu")[0].files[0];

        if (thefile.type != "application/json") {
            window.alert("Please select a valid JSON file.");
            return;
        }

        if (thefile.size > 100000) {
            window.alert("File is to big.");
            return;
        }

        var file = document.getElementById("adminify_import_menu").files[0];
        var reader = new FileReader();
        reader.readAsText(file, "UTF-8");

        reader.onload = function (evt) {
            var json_settings = evt.target.result,
                parsed = JSON.parse(json_settings);

            if (parsed != null) {
            $.ajax({
                url: WPAdminifyMenuEditor.ajax_url,
                type: "post",
                data: {
                    action: "adminify_import_menu_settings",
                    security: WPAdminifyMenuEditor.security,
                    settings: parsed,
                },
                success: function (response) {
                    // var message = response;
                    // console.log(response);
                    if (response) {
                        var data = JSON.parse(response);
                        if (data.error) {
                            $('#adminify-data-saved-message').addClass('notification is-warning');
                            $('#adminify-data-saved-message').css('display','block');
                            $('#adminify-data-saved-message').text(data.message);

                            setTimeout(function () {
                                $('#adminify-data-saved-message').fadeOut('fast');
                                $('#adminify-data-saved-message').removeClass('notification is-warning');
                                $('#adminify-data-saved-message').css('display','none');
                            }, 1500);
                        } else {
                            $('#adminify-data-saved-message').addClass('notification is-primary');
                            $('#adminify-data-saved-message').css('display','block');
                            $('#adminify-data-saved-message').text(data.message);

                            setTimeout(function () {
                                $('#adminify-data-saved-message').fadeOut('fast');
                                $('#adminify-data-saved-message').removeClass('notification is-primary');
                                $('#adminify-data-saved-message').css('display','none');
                                location.reload();
                            }, 1500);
                        }
                    }
                },
            });
            }
        };
    });

    // menu editor accordin title design conflict by third plugin (instagram-feed)) issue fixed
    $(".adminify_menu_item, .adminify_sub_menu_item").each(function (index, element) {
        if (!$(element).find('> a').is('.menu-editor-title, .accordion-button, .p-4')) {
            $(element).find('> a').attr({'class':'menu-editor-title accordion-button p-4'})
        }
    });

    var menuSettings = {};
    var removed_items = [];

    function adminify_menu_items_object(){
        // Menu Items
        $(".adminify_menu_item").each(function (index, element) {
            var menu_name = $(element).attr("name");
            var menu_object = menuSettings[menu_name] = {};
            menuSettings[menu_name]["order"] = $(element).index();
            // menu_object["order"] = $(element).index();
            $(element)
                .find(".adminify_top_level_settings .menu_setting")
                .each(function (index, item) {
                    var setting_name = $(item).attr("name"),value = '';
                    if(setting_name === 'separator'){
                        if($(item).prop("checked") == true){
                            value = 1;
                        }else{
                            value = 0;
                        }
                    }else{
                        value = $(item).val();
                    }
                    menu_object[setting_name] = value;
                });

            if( menu_name.includes('adminify-custom-menu-') ){
                if( menu_object.link === '' ){
                    menu_object.link = `#${menu_name}`;
                }
            }

            /* <fs_premium_only> */
            // Top Level Live Text Changes
            var menu_id = $(element).attr("id");
            $("#" + menu_id +' input[name="name"]').on("keyup", function(){
                var data_menu_id = $(this).data("top-menu-id");
                $("#adminify-main-topmenu-" + data_menu_id).text($(this).val());
            });
            /* </fs_premium_only> */



            // Sub Level Menu Items
            if ($(element).find(".adminify_sub_menu_item").length > 0) {
                var submenu_object = menu_object["submenu"] = {};
                $(element)
                    .find(".adminify_sub_menu_item")
                    .each(function (index, subitem) {
                        var sub_menu_name = $(subitem).attr("name");
                        var submenu_item = submenu_object[sub_menu_name] = {};
                        submenu_item["order"] = $(subitem).index();

                        $(subitem)
                            .find(".sub_menu_setting")
                            .each(function (index, subsubitem) {
                            var sub_setting_name = $(subsubitem).attr("name");
                                var sub_value = $(subsubitem).val();
                                submenu_item[sub_setting_name] = sub_value;
                            });

                        if( sub_menu_name.includes('adminify-custom-submenu-') ){
                            if( submenu_item.link === '' ){
                                submenu_item.link = `#${sub_menu_name}`;
                            }
                        }
                    });


                    /* <fs_premium_only> */
                    // Sub Menu Level Live Text Changes
                    var sub_menu_id = $(element).attr("id");
                    $("#" + sub_menu_id +' input[name="name"]').on("keyup", function(){
                        var data_sub_menu_id = $(this).data("sub-menu-id");
                        $("#adminify-main-submenu-" + data_sub_menu_id).text($(this).val());
                    });
                    /* </fs_premium_only> */
            }


        });

        // removed parent menu items, `parent.remove()` actually doesn't remove item from this menuSettings object.
        if( removed_items.length ){
            removed_items.forEach(item => {
                if (item in menuSettings){
                    delete menuSettings[item];
                }
            });
        }
    }

    // Live Changes
    adminify_menu_items_object();

    // Save Settings
    $('.adminify_menu_save_settings').on('click', function(e){
        e.preventDefault();

        adminify_menu_items_object();

        $.ajax({
            url: WPAdminifyMenuEditor.ajax_url,
            type: "post",
            dataType: "json",
            data: {
                action: "adminify_save_menu_settings",
                security: WPAdminifyMenuEditor.security,
                options: menuSettings
            },
            success: function (response) {
                if (response) {
                    var data = response;
                    if (data.error) {
                        $('#adminify-data-saved-message').addClass('notification is-warning');
                        $('#adminify-data-saved-message').css('display','block');
                        $('#adminify-data-saved-message').text(data.message);

                        setTimeout(function () {
                            $('#adminify-data-saved-message').fadeOut('fast');
                            $('#adminify-data-saved-message').removeClass('notification is-warning');
                            $('#adminify-data-saved-message').css('display','none');
                        }, 1500);
                    } else {
                        $('#adminify-data-saved-message').addClass('notification is-primary');
                        $('#adminify-data-saved-message').css('display','block');
                        $('#adminify-data-saved-message').text(data.message);

                        setTimeout(function () {
                            $('#adminify-data-saved-message').fadeOut('fast');
                            $('#adminify-data-saved-message').removeClass('notification is-primary');
                            $('#adminify-data-saved-message').css('display','none');
                        }, 1500);
                    }
                }
            },
        });
    });

    // Menu Item Sort
    $(".wp-adminify--menu--editor--settings").sortable({
        handle: ".menu-editor-title svg"
    });

    // Menu Item Submenu Sort
    $(".wp-adminify--menu--editor--settings > .adminify_menu_item > .accordion-body > .tab-content > .tab-pane--submenu").sortable({
        handle: ".menu-editor-title svg"
    });

    // Submenu Item Tabs
    $('.tab-content > div:not(.wp-adminify-page-speed-wrapper > div,.remove-add-new-menu)').hide();
    $('.tab-content > div:first-of-type').show();

    $('body').on( 'click', '.nav-tabs a:not(.wp-adminify-page-speed-wrapper a)', function(e)
    // $('.nav-tabs a:not(.wp-adminify-page-speed-wrapper a)').click(function (e)
    {
        e.preventDefault();
        var $this = $(this),
            tabgroup = '#' + $this.parents('.nav-tabs').data('tab-content'),
            others = $this.closest('li').siblings().children('a'),
            target = $this.attr('href');
        others.removeClass('active');
        $this.addClass('active');
        $(tabgroup).children('div').hide();
        $(target).show();
        $(target).siblings().hide();
    });

    /**
     * Add New Menu Item to Menu Editor
     */
    if( WPAdminifyMenuEditor.can_use_premium ){
        $('.wp-adminify--menu--editor--settings').on('click', '.add-new-menu-editor-item', function(e) {
            e.preventDefault();

            var $this = $(this),
                $submenu = $(this).hasClass('submenu') || false,
                $repeater = $this.closest('.wp-adminify--menu--editor--settings').find('.adminify_menu_item'),
                count = $repeater.length,
                $clone = $repeater.first().clone();

            // var randomNumber = Math.floor(Math.random() * 26) + Date.now();
            var randomNumber = Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(2);

            // Set name, id attribute for newly created custom menu item
            var uniqueId = 'adminify-custom-menu-' + randomNumber;

            var menuNewId = $clone.attr('id').slice(0,25) + uniqueId;

            if( $submenu ){
                $clone.attr('class','accordion adminify_sub_menu_item');
                $clone.find('.accordion-body').attr('class','accordion-body');
                $clone.find('.menu_setting').attr('class','sub_menu_setting');
                $clone.find('.tabs.tabbable,.tab-pane--submenu').remove();
                $clone.find('.tab-content .tab-pane:nth-child(1)').show();
                $clone.find('select.sub_menu_setting').addClass('adminify-menu-settings');
                $clone.find('.icon-picker-wrap').siblings('label').html('Set Custom Icon <i>(Not available for Submenu.)</i>');
                $clone.find('.icon-picker-wrap').removeClass('is-clickable').addClass('is-clickable-no');
                $clone.find('.menu-editor-form .columns:nth-child(3)').remove();
                // console.log($clone)
                count += $(this).siblings().length + 2;
                uniqueId = 'adminify-custom-submenu-' + randomNumber;
                menuNewId = 'wp-adminify-sub-menu-menu' + uniqueId;
            }

            $this.siblings().find('.menu-editor-title').removeClass('show');
            $this.siblings().find('.accordion-body').removeClass('show').hide();

            var newTitle = 'Custom Menu';
            $clone.attr({'id':menuNewId,'name':uniqueId});
            var svg_drag_icon = `<svg class="drag-icon is-pulled-left mr-2 ui-sortable-handle" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" fill="#4E4B66" fill-opacity="0.72"></path>
                <path d="M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z" fill="#4E4B66" fill-opacity="0.72"></path>
                <path d="M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z" fill="#4E4B66" fill-opacity="0.72"></path>
                <path d="M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z" fill="#4E4B66" fill-opacity="0.72"></path>
                <path d="M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z" fill="#4E4B66" fill-opacity="0.72"></path>
                <path d="M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z" fill="#4E4B66" fill-opacity="0.72"></path>
                <path d="M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z" fill="#4E4B66" fill-opacity="0.72"></path>
                <path d="M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z" fill="#4E4B66" fill-opacity="0.72"></path>
                <path d="M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z" fill="#4E4B66" fill-opacity="0.72"></path>
            </svg>`; 
            $clone.find('> .menu-editor-title').html(svg_drag_icon + newTitle);

            $clone.find('.nav-tabs li').each(function(index) {
                var id = '#tab-' + uniqueId + '-' + index;
                $(this).find('.nav-link').attr('href',id);
            });

            let default_icon = $(`<img src="${WPAdminifyMenuEditor.icon_picker_logo}"/>`);
            $clone.find('.icon-picker .select-icon').addClass('custom-icon');
            $clone.find('.icon-picker .select-icon i').attr('class','').html(default_icon);

            $clone.find('.tab-content .tab-pane').each(function(index) {
                if($(this).attr('id') !== undefined ){
                    var id = 'tab-' + uniqueId + '-' + index;
                    $(this).attr('id',id);
                }
                if( $(this).hasClass('tab-pane--submenu') == true ) {
                    $(this).find('.adminify_sub_menu_item').each(function(){
                        $(this).remove();
                    });
                    $(this).prepend($(`<span>No submenu items are left.</span>`));
                }
            });

            $clone.find('.menu-editor-form .column').each(function() {
                $(this).find('label').attr('for',uniqueId);
                $(this).find('[name="name"]').attr({'data-top-menu-id':uniqueId,'placeholder':newTitle,'value':newTitle});
                $(this).find('[name="separator"]').attr({'id':uniqueId});
            });

            $clone.find('.tokenize').remove();
            var token_selector = $clone.find('.adminify-menu-settings');

            $clone.find('[name="separator"]').prop( "checked", false ).val(0);

            $(token_selector).tokenize2({
                placeholder: 'Select roles or users'
            });

            $(token_selector).on('tokenize:select', function() {
                $(this).tokenize2().trigger('tokenize:search', [$(this).tokenize2().input.val()]);
            });

            var remove_icon = $(`<div class="remove-add-new-menu"><span data-id="${uniqueId}"><i class="icon-close"></i> Delete</span></div>`);
            $clone.find('.tab-content .tab-pane:nth-child(1)').append(remove_icon);
            $clone.find('.menu-editor-title').addClass('show');
            $clone.find('.accordion-body').addClass('show').css('display','block');

            $this.prev('span').remove();
            $clone.insertBefore($this);
        });

        // remove add new icon
        $('body').on('click', '.remove-add-new-menu span', function(e) {
            var $this = $(this);
            let id = $this.data('id');
            let parent = $this.parent('.remove-add-new-menu').parent('.tab-pane').parent('.tab-content').parent('.accordion-body').parent('.accordion');
            if( parent.hasClass('adminify_sub_menu_item') ){
                let num_of_element = parent.siblings('.adminify_sub_menu_item').length;
                if( num_of_element < 1 ){
                    parent.parent('.tab-pane--submenu').prepend($(`<span>No submenu items are left.</span>`));
                }
            }
            if(parent.attr('name') === id){
                parent.remove(); // this doesn't atually remove the items from menuSettings object  L276
                removed_items = [...removed_items,id];
            }
        });
    }


    /**
     * Drag & Drop Custom Icon Uploader for Menu Editor START
     */

    var displayIconsWrapper = $('#display-custom-icons ul');
    
    // Click functionality START
    $('body').on( 'click', '#adminify-browse-button', function(e){
        e.preventDefault();
        $('#file').trigger('click');
    });

    $('body').on('change', '#file', function(e) {
        var $this = $(this);
        // var file_obj = $this.prop('files');
        var file_obj = e.target.files;
        var form_data = new FormData();
        for(var i=0; i<file_obj.length; i++) {
            form_data.append('my_file_upload[]', file_obj[i]);
        }
        form_data.append('action', 'adminify_file_upload');
        form_data.append('security', WPAdminifyMenuEditor.security);

        uploadImage(form_data, WPAdminifyMenuEditor.ajax_url, $this);
    });


    // Drag & Drop functinality START
    $("#adminify-drag-drop-area").on("dragover", function(e) { // preventing page from redirecting
        e.preventDefault();
        e.stopPropagation();
        $(this).css('border-color','#0347ff');
    });
    
    $('#adminify-drag-drop-area').on("dragleave", function(e) {
        $(this).css('border-color','#c3c4c7');
    });

    $('#adminify-drag-drop-area').on('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).css('border-color','#0347ff');
        e.stopPropagation();
        e.preventDefault();
        var $this = $(this).find('#file');
        var file_obj = e.originalEvent.dataTransfer.files;
        
        var form_data = new FormData();

        for(var i=0; i<file_obj.length; i++) {
            form_data.append('my_file_upload[]', file_obj[i]);
        }
        
        form_data.append('action', 'adminify_file_upload');
        form_data.append('security', WPAdminifyMenuEditor.security);
  
        uploadImage(form_data,WPAdminifyMenuEditor.ajax_url, $this);
    });

    function uploadImage(form_data, ajax_url, _this) {
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = parseInt((evt.loaded / evt.total) * 100);
                        $("#icon-upload-bar").addClass('show').width(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            url: ajax_url,
            type: 'POST',
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                _this.val('');
                let data = JSON.parse(response);
                if( data.status != false ){
                    let images = data.images;
                    for(var key in images){
                        if (images.hasOwnProperty(key)) {
                            let basename = images[key].split('/').reverse()[0];
                            let image_url = WPAdminifyMenuEditor.baseurl+'/adminify-custom-icons/'+basename;
                            let item = `<li data-id="${key}"><img src="${image_url}"/></li>`;
                            displayIconsWrapper.prepend(item);
                        }
                    }
                    setTimeout(()=>{
                        $("#icon-upload-bar").width(0).removeClass('show');
                        $('#adminify-drag-drop-area').css('border-color','#c3c4c7');
                    },100);
                }
            }
        });
    }
    /**
     * Drag & Drop Custom Icon Uploader for Menu Editor END
     */

});
