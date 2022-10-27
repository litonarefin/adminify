(function($) {
	"use strict";

	function debounce(func, wait, immediate) {
		var timeout;
		return function () {
			var context = this,
				args = arguments;
			var later = function () {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	}

	var iconLibrary = {
		"dashicons": {
			"": {
				"prefix": "dashicons dashicons-",
				"icon-style": "dashicons-dashboard",
				"list-icon":"dashicons dashicons-dashboard		",
				"icons": [
					"dashicons dashicons-menu",
					"dashicons dashicons-admin-site",
					"dashicons dashicons-dashboard",
					"dashicons dashicons-admin-post",
					"dashicons dashicons-admin-media",
					"dashicons dashicons-admin-links",
					"dashicons dashicons-admin-page",
					"dashicons dashicons-admin-comments",
					"dashicons dashicons-admin-appearance",
					"dashicons dashicons-admin-plugins",
					"dashicons dashicons-admin-users",
					"dashicons dashicons-admin-tools",
					"dashicons dashicons-admin-settings",
					"dashicons dashicons-admin-network",
					"dashicons dashicons-admin-home",
					"dashicons dashicons-admin-generic",
					"dashicons dashicons-admin-collapse",
					"dashicons dashicons-filter",
					"dashicons dashicons-admin-customizer",
					"dashicons dashicons-admin-multisite",
					"dashicons dashicons-welcome-write-blog",
					"dashicons dashicons-welcome-add-page",
					"dashicons dashicons-welcome-view-site",
					"dashicons dashicons-welcome-widgets-menus",
					"dashicons dashicons-welcome-comments",
					"dashicons dashicons-welcome-learn-more",
					"dashicons dashicons-format-aside",
					"dashicons dashicons-format-image",
					"dashicons dashicons-format-gallery",
					"dashicons dashicons-format-video",
					"dashicons dashicons-format-status",
					"dashicons dashicons-format-quote",
					"dashicons dashicons-format-chat",
					"dashicons dashicons-format-audio",
					"dashicons dashicons-camera",
					"dashicons dashicons-images-alt",
					"dashicons dashicons-images-alt2",
					"dashicons dashicons-video-alt",
					"dashicons dashicons-video-alt2",
					"dashicons dashicons-video-alt3",
					"dashicons dashicons-media-archive",
					"dashicons dashicons-media-audio",
					"dashicons dashicons-media-code",
					"dashicons dashicons-media-default",
					"dashicons dashicons-media-document",
					"dashicons dashicons-media-interactive",
					"dashicons dashicons-media-spreadsheet",
					"dashicons dashicons-media-text",
					"dashicons dashicons-media-video",
					"dashicons dashicons-playlist-audio",
					"dashicons dashicons-playlist-video",
					"dashicons dashicons-controls-play",
					"dashicons dashicons-controls-pause",
					"dashicons dashicons-controls-forward",
					"dashicons dashicons-controls-skipforward",
					"dashicons dashicons-controls-back",
					"dashicons dashicons-controls-skipback",
					"dashicons dashicons-controls-repeat",
					"dashicons dashicons-controls-volumeon",
					"dashicons dashicons-controls-volumeoff",
					"dashicons dashicons-image-crop",
					"dashicons dashicons-image-rotate",
					"dashicons dashicons-image-rotate-left",
					"dashicons dashicons-image-rotate-right",
					"dashicons dashicons-image-flip-vertical",
					"dashicons dashicons-image-flip-horizontal",
					"dashicons dashicons-image-filter",
					"dashicons dashicons-undo",
					"dashicons dashicons-redo",
					"dashicons dashicons-editor-bold",
					"dashicons dashicons-editor-italic",
					"dashicons dashicons-editor-ul",
					"dashicons dashicons-editor-ol",
					"dashicons dashicons-editor-quote",
					"dashicons dashicons-editor-alignleft",
					"dashicons dashicons-editor-aligncenter",
					"dashicons dashicons-editor-alignright",
					"dashicons dashicons-editor-insertmore",
					"dashicons dashicons-editor-spellcheck",
					"dashicons dashicons-editor-expand",
					"dashicons dashicons-editor-contract",
					"dashicons dashicons-editor-kitchensink",
					"dashicons dashicons-editor-underline",
					"dashicons dashicons-editor-justify",
					"dashicons dashicons-editor-textcolor",
					"dashicons dashicons-editor-paste-word",
					"dashicons dashicons-editor-paste-text",
					"dashicons dashicons-editor-removeformatting",
					"dashicons dashicons-editor-video",
					"dashicons dashicons-editor-customchar",
					"dashicons dashicons-editor-outdent",
					"dashicons dashicons-editor-indent",
					"dashicons dashicons-editor-help",
					"dashicons dashicons-editor-strikethrough",
					"dashicons dashicons-editor-unlink",
					"dashicons dashicons-editor-rtl",
					"dashicons dashicons-editor-break",
					"dashicons dashicons-editor-code",
					"dashicons dashicons-editor-paragraph",
					"dashicons dashicons-editor-table",
					"dashicons dashicons-align-left",
					"dashicons dashicons-align-right",
					"dashicons dashicons-align-center",
					"dashicons dashicons-align-none",
					"dashicons dashicons-lock",
					"dashicons dashicons-unlock",
					"dashicons dashicons-calendar",
					"dashicons dashicons-calendar-alt",
					"dashicons dashicons-visibility",
					"dashicons dashicons-hidden",
					"dashicons dashicons-post-status",
					"dashicons dashicons-edit",
					"dashicons dashicons-trash",
					"dashicons dashicons-sticky",
					"dashicons dashicons-external",
					"dashicons dashicons-arrow-up",
					"dashicons dashicons-arrow-down",
					"dashicons dashicons-arrow-right",
					"dashicons dashicons-arrow-left",
					"dashicons dashicons-arrow-up-alt",
					"dashicons dashicons-arrow-down-alt",
					"dashicons dashicons-arrow-right-alt",
					"dashicons dashicons-arrow-left-alt",
					"dashicons dashicons-arrow-up-alt2",
					"dashicons dashicons-arrow-down-alt2",
					"dashicons dashicons-arrow-right-alt2",
					"dashicons dashicons-arrow-left-alt2",
					"dashicons dashicons-sort",
					"dashicons dashicons-leftright",
					"dashicons dashicons-randomize",
					"dashicons dashicons-list-view",
					"dashicons dashicons-exerpt-view",
					"dashicons dashicons-grid-view",
					"dashicons dashicons-move",
					"dashicons dashicons-share",
					"dashicons dashicons-share-alt",
					"dashicons dashicons-share-alt2",
					"dashicons dashicons-twitter",
					"dashicons dashicons-rss",
					"dashicons dashicons-email",
					"dashicons dashicons-email-alt",
					"dashicons dashicons-facebook",
					"dashicons dashicons-facebook-alt",
					"dashicons dashicons-googleplus",
					"dashicons dashicons-networking",
					"dashicons dashicons-hammer",
					"dashicons dashicons-art",
					"dashicons dashicons-migrate",
					"dashicons dashicons-performance",
					"dashicons dashicons-universal-access",
					"dashicons dashicons-universal-access-alt",
					"dashicons dashicons-tickets",
					"dashicons dashicons-nametag",
					"dashicons dashicons-clipboard",
					"dashicons dashicons-heart",
					"dashicons dashicons-megaphone",
					"dashicons dashicons-schedule",
					"dashicons dashicons-wordpress",
					"dashicons dashicons-wordpress-alt",
					"dashicons dashicons-pressthis",
					"dashicons dashicons-update",
					"dashicons dashicons-screenoptions",
					"dashicons dashicons-info",
					"dashicons dashicons-cart",
					"dashicons dashicons-feedback",
					"dashicons dashicons-cloud",
					"dashicons dashicons-translation",
					"dashicons dashicons-tag",
					"dashicons dashicons-category",
					"dashicons dashicons-archive",
					"dashicons dashicons-tagcloud",
					"dashicons dashicons-text",
					"dashicons dashicons-yes",
					"dashicons dashicons-no",
					"dashicons dashicons-no-alt",
					"dashicons dashicons-plus",
					"dashicons dashicons-plus-alt",
					"dashicons dashicons-minus",
					"dashicons dashicons-dismiss",
					"dashicons dashicons-marker",
					"dashicons dashicons-star-filled",
					"dashicons dashicons-star-half",
					"dashicons dashicons-star-empty",
					"dashicons dashicons-flag",
					"dashicons dashicons-warning",
					"dashicons dashicons-location",
					"dashicons dashicons-location-alt",
					"dashicons dashicons-vault",
					"dashicons dashicons-shield",
					"dashicons dashicons-shield-alt",
					"dashicons dashicons-sos",
					"dashicons dashicons-search",
					"dashicons dashicons-slides",
					"dashicons dashicons-analytics",
					"dashicons dashicons-chart-pie",
					"dashicons dashicons-chart-bar",
					"dashicons dashicons-chart-line",
					"dashicons dashicons-chart-area",
					"dashicons dashicons-groups",
					"dashicons dashicons-businessman",
					"dashicons dashicons-id",
					"dashicons dashicons-id-alt",
					"dashicons dashicons-products",
					"dashicons dashicons-awards",
					"dashicons dashicons-forms",
					"dashicons dashicons-testimonial",
					"dashicons dashicons-portfolio",
					"dashicons dashicons-book",
					"dashicons dashicons-book-alt",
					"dashicons dashicons-download",
					"dashicons dashicons-upload",
					"dashicons dashicons-backup",
					"dashicons dashicons-clock",
					"dashicons dashicons-lightbulb",
					"dashicons dashicons-microphone",
					"dashicons dashicons-desktop",
					"dashicons dashicons-laptop",
					"dashicons dashicons-tablet",
					"dashicons dashicons-smartphone",
					"dashicons dashicons-phone",
					"dashicons dashicons-index-card",
					"dashicons dashicons-carrot",
					"dashicons dashicons-building",
					"dashicons dashicons-store",
					"dashicons dashicons-album",
					"dashicons dashicons-palmtree",
					"dashicons dashicons-tickets-alt",
					"dashicons dashicons-money",
					"dashicons dashicons-smiley",
					"dashicons dashicons-thumbs-up",
					"dashicons dashicons-thumbs-down",
					"dashicons dashicons-layout",
					"dashicons dashicons-paperclip"
				]
			},
		}
	}

	var defaults = {
		iconLibrary: {},
		valueSelector: 'input[name="icon"]',
		iconSelector: '.select-icon i'
	}

	var AI_Icon_Picker = function ( $picker, options ) {

		this.$picker = $picker;

		this.config = $.extend( {}, defaults, options );

		if ( ! this.config.valueSelector ) return;
		if ( ! this.$picker.find( this.config.valueSelector ).length ) return;

		this.iconLibrary = $.extend( {}, iconLibrary, this.config.iconLibrary );

		this.addPickerToDom();

		this.addPickerEvent();

	}

	AI_Icon_Picker.prototype.addPickerToDom = function() {

		if ( this.isPickerInDom() ) return;

		$('body').append( '<div class="aim-modal aim-close" id="aim-modal"><div class="aim-modal--content"><div class="aim-modal--header"><div class="aim-modal--header-logo-area"><span class="aim-modal--header-logo-title"><img src="'+ WPAdminifyMenuEditor.icon_picker_logo +'"> WP Adminify Icon Picker</span></div><div class="aim-modal--header-close-btn"><i class="dashicons dashicons-no-alt" title="Close"></i></div></div><div class="aim-modal--body"><div id="aim-modal--sidebar" class="aim-modal--sidebar"><div class="aim-modal--sidebar-tabs"></div></div><div id="aim-modal--icon-preview-wrap" class="aim-modal--icon-preview-wrap"><div class="aim-modal--icon-search"><input name="" value="" placeholder="Filter by name..."><i class="fas fa-search"></i></div><div class="aim-modal--icon-preview-inner"><div id="aim-modal--icon-preview"></div></div></div></div><div class="aim-modal--footer"><button class="aim-insert-icon-button">Insert</button></div></div></div>' );

		this.$pickerDom 	  = $('body').children( '#aim-modal' );
		this.$previewDomWrap  = this.$pickerDom.find('.aim-modal--icon-preview-wrap');
		this.$sidebarTabs 	  = this.$pickerDom.find('.aim-modal--sidebar-tabs');
		this.$previewWrap 	  = this.$pickerDom.find('#aim-modal--icon-preview');
		this.$searchInput 	  = this.$pickerDom.find('.aim-modal--icon-search input');

		this.sideBarList = [{
			"title": " all icons",
			"list-icon": "icomoon-stack",
			"library-id": "all",
		}];

		this.iconMarkup = '';

		this.setIconAndSidebarList();

		this.$previewWrap.html( this.iconMarkup );
		this.$sidebarTabs.html( this.sideBarListMarkup() );

		this.customIconSidebarMenu();
		this.customIconUploader();

		this.selected_icon = '';

	}

	AI_Icon_Picker.prototype.addPickerEvent = function() {

		var _this = this;

		this.$searchInput.on( 'keyup', debounce(function() {
			_this.searchFilterFunc();
		}, 100) );

		this.$sidebarTabs.children().on( 'click', function() {
			$(this).addClass('aesthetic-active').siblings().removeClass('aesthetic-active');
			_this.searchFilterFunc();
			_this.customIconSidebarMenuSettings($(this));
		});

		this.$previewWrap.children().on( 'click', function() {
			$(this).addClass('aesthetic-selected').siblings().removeClass('aesthetic-selected');
			_this.selected_icon = $(this).find('i').attr('class');
		});

		this.$pickerDom.find('.aim-insert-icon-button').on('click', function (e) {
			if ( _this.selected_icon ) {
				_this.$currentPicker.find( _this.config.valueSelector ).val( _this.selected_icon );
				if ( Array.isArray(_this.selected_icon) ) {
					_this.$currentPicker.find( _this.config.iconSelector ).parent('.select-icon').addClass('custom-icon');
					_this.$currentPicker.find( _this.config.iconSelector ).empty().removeAttr('class').html( '<img src="'+_this.selected_icon[1]+'" />' );
				}else{
					_this.$currentPicker.find( _this.config.iconSelector ).parent('.select-icon').removeClass('custom-icon');
					_this.$currentPicker.find( _this.config.iconSelector ).empty().removeAttr('class').addClass( _this.selected_icon );
				}
			}
			_this.hidePicker();
		});

		this.$pickerDom.find('.aim-modal--header-close-btn').on('click', function (e) {
			_this.hidePicker();
		});

		// this.$picker.on('click', function() {
		$('body').on('click','.select-icon', function() {
			_this.$currentPicker = $(this).parents('.wp-adminify-menu-icon-picker');
			_this.openPicker();

			_this.customIconsListLoad();
		});

		// this.$picker.find('.icon-none').on('click', function(e) {
		$('body').on('click','.icon-none', function(e) {
			e.stopPropagation();
			_this.selected_icon = '';
			$(this).parent().find( _this.config.valueSelector ).val('');
			$(this).parent().find( _this.config.iconSelector ).parent('.select-icon').removeClass('custom-icon');
			$(this).parent().find( _this.config.iconSelector ).removeAttr('class').text('Select Icon');
		});

	}

	AI_Icon_Picker.prototype.openPicker = function() {

		this.$pickerDom.removeClass('aim-close').addClass('aim-open');

	}

	AI_Icon_Picker.prototype.hidePicker = function() {

		this.$pickerDom.addClass('aim-close').removeClass('aim-open');

	}

	AI_Icon_Picker.prototype.isPickerInDom = function() {

		return $('body').children('#aim-modal').length;

	}

	AI_Icon_Picker.prototype.searchFilterFunc = function( searchText ) {

		var searchText = this.$searchInput.val().toLowerCase();
		var libraryID = this.$sidebarTabs.find('.aesthetic-active').data('library-id');

		this.$previewWrap.find('.aim-icon-item').hide().filter(function() {
			return ( 'all' === libraryID || libraryID === $(this).data('library-id') ) && ( -1 !== $(this).data( 'filter' ).indexOf(searchText) );
		}).show();

	}

	AI_Icon_Picker.prototype.sideBarListMarkup = function() {

		var markup = '';
		var elementorActive = WPAdminifyIconPicker.is_elementor_active;
		this.sideBarList.filter(item => {
			if( !elementorActive && ('Elementor Icons' == item.title) ) {
				return;
			}else{
				return item;
			}
		}).forEach(function( item, index ) {
			if ( 'all' !== item['library-id'] ) {
				markup += '<div class="aim-modal--sidebar-tab-item" data-library-id="'+item['library-id']+'"><i class="'+item['list-icon']+'"></i>'+item['title']+'</div>';
			} else {
				markup += '<div class="aim-modal--sidebar-tab-item aesthetic-active" data-library-id="'+item['library-id']+'"><i class="'+item['list-icon']+'"></i>'+item['title']+'</div>';
			}
		});

		return markup;

	}

	AI_Icon_Picker.prototype.iconItemMarkup = function( libraryItem ) {
		var markup = '',
			library = libraryItem['icon-style'],
			prefix = libraryItem['prefix'];

		libraryItem['icons'].forEach(function (item, index) {
			markup += '<div class="aim-icon-item" data-library-id="' + library + '" data-filter="' + item.replace(prefix, "") + '"><div class="aim-icon-item-inner"><i class="' + item + '"></i><div class="aim-icon-item-name" title="' + item.replace(prefix, "") + '">' + item.replace(prefix, "").replace("-", " ") + '</div></div></div>';
		})

		return markup;
	}

	AI_Icon_Picker.prototype.getLibraryName = function( string ) {
		return string.replace( "-", " " );
	}

	AI_Icon_Picker.prototype.setSideBarList = function( library, object ) {
		object.forEach(function (item, index) {
			var icon_title = (item[0] !=='') ? library + ' - ' + item[0] : library,
				listItem = {
					"title": icon_title,
					"list-icon": item[1]['list-icon'].length ? item[1]['list-icon'] : "far fa-dot-circle",
					"library-id": item[1]['icon-style'].length ? item[1]['icon-style'] : "all",
			};

			this.sideBarList.push( listItem )

		}.bind(this) );
	}

	AI_Icon_Picker.prototype.setIconAndSidebarList = function() {

		Object.entries(this.iconLibrary).forEach(function (item, index) {

			var libraryName = this.getLibraryName(item[0]);
			this.setSideBarList(libraryName, Object.entries( item[1] ));

			Object.entries(item[1]).forEach(function (item, index) {
				this.iconMarkup += this.iconItemMarkup(item[1])
			}.bind(this) );

		}.bind(this) );

	}

	AI_Icon_Picker.prototype.customIconSidebarMenu = function() {

		var markup = '<div class="aim-modal--sidebar-tab-item" data-library-id="custom-icon"><i class="icon-cloud-upload"></i>Custom Icons</div>';
		this.$sidebarTabs.append( markup );

	}

	AI_Icon_Picker.prototype.customIconSidebarMenuSettings = function(_this) {

		this.$searchForm = this.$pickerDom.find('.aim-modal--icon-search');
		this.$iconList   = this.$pickerDom.find('.aim-modal--icon-preview-inner');
		this.$iconCustom = this.$pickerDom.find('.custom-icon-uploader-wrap');

		if( _this.data('library-id') == 'custom-icon' ){
			this.$previewDomWrap.addClass('y-scroll');
			this.$searchForm.addClass('hide');
			this.$iconList.addClass('hide');
			this.$iconCustom.removeClass('hide');
		}else{
			this.$previewDomWrap.removeClass('y-scroll');
			this.$searchForm.removeClass('hide');
			this.$iconList.removeClass('hide');
			this.$iconCustom.addClass('hide');
		}
	}

	AI_Icon_Picker.prototype.customIconsListLoad = function() {
		var _this = this;
		var value = _this.$currentPicker.find( _this.config.valueSelector ).val().split(',');
		let id = value[0]; 
    	var displayIconsWrapper = $('#display-custom-icons ul');
		
		$.ajax({
            url: WPAdminifyMenuEditor.ajax_url,
            type: 'POST',
            data: {
				action: 'adminify_load_custom_icons'
			},
            success: function (response) {
				let data = JSON.parse(response);
				if( data.images != null ){
					let images = data.images;
					let item = '';
					for(var key in images){
						if (images.hasOwnProperty(key)) {
							let image_url = images[key]
							item += `<li data-id="${key}" ${id==key && 'class="selected"'}><img src="${image_url}"/></li>`;
						}
					}
					displayIconsWrapper.html(item);
				}
            }
        });

		this.customIconSeleced();
	}


	AI_Icon_Picker.prototype.customIconSeleced = function() {
		var _this = this;
		$('#display-custom-icons ul').on("click",'li', function(){
			$(this).addClass('selected').siblings().removeClass('selected');
			var id  = $(this).data('id');
			var url = $(this).find('img').attr('src');
			_this.selected_icon = [id, url];
		});
	}

	AI_Icon_Picker.prototype.customIconUploader = function() {
		var markup = `<div class="custom-icon-uploader-wrap hide">
				<div id="icon-upload-bar"></div>
				<div id="adminify-drag-drop-area">
					<div class="drag-drop-inside">
					<p class="drag-drop-info">Drop files to upload</p>
					<p>or</p>
					<p class="drag-drop-buttons">
						<input type="file" id="file" name="my_file_upload[]" multiple="multiple" style="display:none">
						<button id="adminify-browse-button" type="button" class="browser button button-hero">Select Files</button>
					</p>
					<p>Maximum upload file size: ${WPAdminifyMenuEditor.max_upload_size}</p>
				</div>
			</div>
			<div id="display-custom-icons"><ul></ul></div>
		</div>`;
		this.$previewDomWrap.append( markup );

	}

	$.fn.ai_icon_picker = function( options ) {

		new AI_Icon_Picker( $(this), options );

		return $(this);

	}

})(jQuery);
