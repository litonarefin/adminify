"use strict";
(self["webpackChunkadminify"] = self["webpackChunkadminify"] || []).push([["/assets/admin/js/wp-adminify--folder"],{

/***/ "./dev/admin/modules/folder/folder.js":
/*!********************************************!*\
  !*** ./dev/admin/modules/folder/folder.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

vue__WEBPACK_IMPORTED_MODULE_0__["default"].component('folder-app', (__webpack_require__(/*! ./folder-app.vue */ "./dev/admin/modules/folder/folder-app.vue")["default"]));
vue__WEBPACK_IMPORTED_MODULE_0__["default"].component('folders', (__webpack_require__(/*! ./components/folders.vue */ "./dev/admin/modules/folder/components/folders.vue")["default"]));
jQuery(function ($) {
  if ($('#wp-adminify--folder-app').length) {
    new vue__WEBPACK_IMPORTED_MODULE_0__["default"]({
      el: '#wp-adminify--folder-app',
      template: '<folder-app></folder-app>'
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/components/folders.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/components/folders.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    folders: {
      type: Array,
      required: true
    },
    folder_select_toggle: {
      type: Boolean,
      required: true
    }
  },
  methods: {
    is_folder: function is_folder(_folder) {
      return this.$parent.is_folder(_folder);
    },
    get_folder_url: function get_folder_url(_folder) {
      return this.$parent.get_folder_url(_folder);
    },
    folderActions: function folderActions($event, _folder) {
      this.$parent.folderActions($event, _folder);
    },
    showRenameFolderPopup: function showRenameFolderPopup(_folder) {
      this.$parent.showRenameFolderPopup(_folder);
    },
    showDeleteFolderPopup: function showDeleteFolderPopup(_folder) {
      this.$parent.showDeleteFolderPopup(_folder);
    },
    showNewSubFolderPopup: function showNewSubFolderPopup(_folder) {
      this.$parent.showNewSubFolderPopup(_folder);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/folder-app.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/folder-app.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! js-cookie */ "./node_modules/js-cookie/dist/js.cookie.mjs");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e2) { throw _e2; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e3) { didErr = true; err = _e3; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

var $ = jQuery;
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    var _ref;

    return _ref = {
      post_type: '',
      post_type_tax: '',
      folders: [],
      posts: {},
      filter_folder: '',
      total_uncat_posts: ''
    }, _defineProperty(_ref, "total_uncat_posts", ''), _defineProperty(_ref, "folder_select_toggle", false), _defineProperty(_ref, "create_folder_popup", false), _defineProperty(_ref, "new_folder_name", null), _defineProperty(_ref, "create_folder_error", null), _defineProperty(_ref, "rename_folder_popup", false), _defineProperty(_ref, "rename_folder_name", null), _defineProperty(_ref, "rename_folder_error", null), _defineProperty(_ref, "delete_folder_popup", false), _defineProperty(_ref, "delete_folder_error", null), _defineProperty(_ref, "move_to_folder_popup", false), _defineProperty(_ref, "color_tags", ['#7B61FF', '#0347FF', '#F24AE1', '#ED2E7E', '#FFC804', '#00BA88']), _defineProperty(_ref, "active_color_tag", '#7B61FF'), _defineProperty(_ref, "currentView", 'all'), _defineProperty(_ref, "sort", 'a-z'), _defineProperty(_ref, "is_pro", !!wp_adminify__folder_data.is_pro), _defineProperty(_ref, "pro_notice", wp_adminify__folder_data.pro_notice), _defineProperty(_ref, "total_posts", {
      'auto-draft': 0,
      'draft': 0,
      'future': 0,
      'inherit': 0,
      'pending': 0,
      'private': 0,
      'publish': 0,
      'request-completed': 0,
      'request-confirmed': 0,
      'request-failed': 0,
      'request-pending': 0,
      'trash': 0
    }), _ref;
  },
  mounted: function mounted() {
    this.post_type = wp_adminify__folder_data.post_type;
    this.post_type_tax = wp_adminify__folder_data.post_type_tax;
    this.folders = wp_adminify__folder_data.folders;
    this.total_posts = wp_adminify__folder_data.total_posts;
    this.total_uncat_posts = wp_adminify__folder_data.total_uncat_posts;
    this._active_color_tag = this.active_color_tag;
    this.adminurl = wp_adminify__folder_data.adminurl;
    this.folder_hierarchy = wp_adminify__folder_data.folder_hierarchy;
    this.folders_to_edit = [];
    var sort = js_cookie__WEBPACK_IMPORTED_MODULE_1__["default"].get(this.post_type_tax + '__sort');
    if (sort) this.sort = sort;
    this.init_folder_events();
    $(function () {
      this.init_draggable_events();
      this.init_droppable_events();
      this.reset_on_other_ajax_events();
      this.init_submenu_events();
      this.set_posts_folders();
    }.bind(this));
  },
  methods: {
    set_posts_folders: function set_posts_folders() {
      var that = this;
      $('#the-list .adminify-move-file').each(function () {
        var id = $(this).data('id');
        var folders = $(this).data('folders');
        folders = folders ? String(folders).split(',').map(function (folder) {
          return Number(folder);
        }) : [];
        that.posts[id] = folders;
      });
    },
    get_folder_by_id: function get_folder_by_id(id) {
      return this.folders.find(function (folder) {
        return folder.term_id == id;
      });
    },
    get_folder_ids_by_post_id: function get_folder_ids_by_post_id(post_id) {
      return this.posts[post_id];
    },
    init_submenu_events: function init_submenu_events() {
      $('.folder--actions .has--sub-menu > a').on('click', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        $(this).parent().toggleClass('sub-menu--open');
      });
      $('body').on('click', function () {
        $('.has--sub-menu.sub-menu--open').removeClass('sub-menu--open');
      });
    },
    reset_on_other_ajax_events: function reset_on_other_ajax_events() {
      var _this3 = this;

      $(document).ajaxComplete(function (event, xhr, settings) {
        var _this2 = this;

        if (settings.dataType == 'html') {
          return this.init_draggable_events();
        }

        if (!settings.data) return;
        var accepted = ['inline-save', 'query-attachments', 'delete-post'].some(function (_action) {
          return settings.data.indexOf("action=".concat(_action)) != -1;
        });

        if (accepted) {
          setTimeout(function () {
            _this2.init_draggable_events();

            _this2.refresh_folders_data_ajax();
          }, 100);
        }
      }.bind(this));

      if (wp.Uploader && wp.Uploader.queue) {
        wp.Uploader.queue.on('reset', function () {
          _this3.init_draggable_events();

          _this3.refresh_folders_data_ajax();
        });
      }
    },
    init_folder_events: function init_folder_events() {
      var that = this;

      if (wp.media) {
        var AttachmentsView = wp.media.view.Attachments;
        wp.media.view.Attachments = AttachmentsView.extend({
          initialize: function initialize() {
            var _this = this;

            AttachmentsView.prototype.initialize.apply(this, arguments);
            $('.folder--lists, .folder--stats').on('click', 'li a', function (event) {
              event.preventDefault();
              var url = $(this).attr('href');

              if ($('.attachments-browser .attachments').length) {
                _this.model.get('library').props.set('media_folder', that.getUrlParameter(url, 'media_folder'));

                var state = that.getUrlParameter(url);
                window.history.pushState(state, '', url);
              }
            });
          }
        });
      } else {
        $('.folder--lists, .folder--stats').on('click', 'li a', function (event) {
          event.preventDefault();
          var url = $(this).attr('href');
          $('.folder--lists, .folder--stats').find('li').removeClass('active');
          $(this).closest('li').addClass('active');

          if ($('#the-list').length) {
            $('#the-list').load("".concat(url, " #the-list > tr"));
            var state = that.getUrlParameter(url);
            window.history.pushState(state, '', url);
          }
        });
      }
    },
    folderActions: function folderActions(event, folder) {
      event.preventDefault();
      this.folders.forEach(function (_folder) {
        _folder.contexted = false;
      });
      folder.contexted = true;
      $('.folder--lists li').removeClass('sub-menu--open');
      $(event.target).closest('li').addClass('sub-menu--open');
    },
    get_active_folder: function get_active_folder() {
      return $('.folder--lists li.active').toArray().map(function (_folder_dom) {
        return $(_folder_dom).data('folder');
      });
    },
    is_folder: function is_folder(folder) {
      // let URLParams = new URLSearchParams( window.location.href );
      // let currentFolder = URLParams.get( 'folder' );
      // if ( folder == 'all' && ! currentFolder ) return true;
      // if ( this.get_folder_url(  ) == currentFolder ) return true;
      // return false;
      var currenturl = window.location.href;
      if (folder == 'all' && currenturl.indexOf(wp_adminify__folder_data.post_type_tax) > -1) return false;
      return currenturl == this.get_folder_url(folder);
    },
    getUrlParameter: function getUrlParameter(querystring, sParam) {
      querystring = querystring.substring(querystring.indexOf('?') + 1);
      var params = new URLSearchParams(querystring);
      var obj = {};

      var _iterator = _createForOfIteratorHelper(params.keys()),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var key = _step.value;

          if (params.getAll(key).length > 1) {
            obj[key] = params.getAll(key);
          } else {
            obj[key] = params.get(key);
          }
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      if (sParam) {
        if (sParam in obj) return obj[sParam];
        return '';
      }

      return obj;
    },
    get_folder_url: function get_folder_url(folder) {
      var queryStrings = location.search;
      var searchParams = new URLSearchParams(queryStrings);
      var postType = searchParams.get('post_type');
      var baseURL = new URL(location.protocol + '//' + location.host + location.pathname);
      if (postType) baseURL.searchParams.set('post_type', postType);

      if (folder !== 'all') {
        var folderSlug = folder == 'uncategorized' ? '-1' : folder.slug;
        baseURL.searchParams.set(this.post_type_tax, folderSlug);
      }

      var _iterator2 = _createForOfIteratorHelper(searchParams.entries()),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var _step2$value = _slicedToArray(_step2.value, 2),
              key = _step2$value[0],
              value = _step2$value[1];

          if (key == 'post_type') continue;
          if (key == this.post_type_tax) continue;
          baseURL.searchParams.set(key, value);
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }

      return baseURL.toJSON();
    },
    showPopupOverlay: function showPopupOverlay() {
      $('body').addClass('wp-adminify--popup-show');
    },
    hidePopupOverlay: function hidePopupOverlay() {
      $('body').removeClass('wp-adminify--popup-show');
    },
    showNewFolderPopup: function showNewFolderPopup() {
      this.showPopupOverlay();
      this.create_folder_popup = true;
      this.parent_folder = null;
      this.active_color_tag = this.color_tags[0];
      this._active_color_tag = this.active_color_tag;
    },
    showNewSubFolderPopup: function showNewSubFolderPopup(folder) {
      this.showPopupOverlay();
      this.create_folder_popup = true;
      this.parent_folder = folder.term_id;
      this.active_color_tag = this.color_tags[0];
      this._active_color_tag = this.active_color_tag;
    },
    showRenameFolderPopup: function showRenameFolderPopup() {
      var _this4 = this;

      var folder = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

      // Set Editable Folders
      if (folder && folder.term_id) {
        this.folders_to_edit = [folder];
      } else if (this.get_active_folder().length) {
        this.folders_to_edit = [this.folders.find(function (_folder) {
          return _folder.term_id == _this4.get_active_folder()[0];
        })];
      } else {
        this.folders_to_edit = null;
      }

      if (!this.folders_to_edit || !this.folders_to_edit.length) return;
      folder = this.folders_to_edit[0];
      this._rename_folder_name = folder.name;
      this.rename_folder_name = folder.name;
      this.active_color_tag = folder.color;
      this._active_color_tag = this.active_color_tag;
      this.showPopupOverlay();
      this.rename_folder_popup = true;
    },
    showDeleteFolderPopup: function showDeleteFolderPopup() {
      var _this5 = this;

      var folder = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

      // Set Editable Folders
      if (folder && folder.term_id) {
        this.folders_to_edit = [folder];
      } else if (this.folder_select_toggle) {
        this.folders_to_edit = this.folders.filter(function (_folder) {
          return _folder.selected;
        });
      } else if (this.get_active_folder().length) {
        this.folders_to_edit = [this.folders.find(function (_folder) {
          return _folder.term_id == _this5.get_active_folder()[0];
        })];
      } else {
        this.folders_to_edit = null;
      }

      if (!this.folders_to_edit || !this.folders_to_edit.length) return;
      this.showPopupOverlay();
      this.delete_folder_popup = true;
    },
    hide_rename_folder_popup: function hide_rename_folder_popup() {
      this.hidePopupOverlay();
      this.rename_folder_popup = false;
      this.rename_folder_error = null;
    },
    hide_delete_folder_popup: function hide_delete_folder_popup() {
      this.hidePopupOverlay();
      this.delete_folder_popup = false;
      this.delete_folder_error = null;
    },
    hide_move_to_folder_popup: function hide_move_to_folder_popup() {
      this.hidePopupOverlay();
      this.move_to_folder_popup = false;
    },
    hide_create_folder_popup: function hide_create_folder_popup() {
      this.hidePopupOverlay();
      this.create_folder_popup = false;
      this.new_folder_name = null;
      this.create_folder_error = null;
      this.active_color_tag = this._active_color_tag;
    },
    saveNewFolder: function saveNewFolder() {
      var _this = this;

      var data = {
        post_type: wp_adminify__folder_data.post_type,
        post_type_tax: wp_adminify__folder_data.post_type_tax,
        new_folder_name: this.new_folder_name,
        folder_color_tag: this.active_color_tag,
        parent_folder: this.parent_folder,
        action: 'adminify_folder',
        route: 'create_new_folder',
        _ajax_nonce: wp_adminify__folder_data.nonce
      };

      if (this.is_pro) {
        data.parent_folder = this.parent_folder;
      }

      $.ajax({
        url: wp_adminify__folder_data.ajaxurl,
        method: 'post',
        data: data
      }).done(function (response, status, xhr) {
        if (response.success && xhr.status == 200) {
          _this.refresh_folders_data(response.data);

          _this.hide_create_folder_popup();
        } else {
          _this.create_folder_error = response.data.message;
        }
      });
    },
    renameFolder: function renameFolder() {
      var folder = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

      var _this = this;

      var changes = false;
      if (this.active_color_tag != this._active_color_tag) changes = true;
      if (!changes && this._rename_folder_name.trim() != this.rename_folder_name.trim()) changes = true;
      if (!changes) return this.hide_rename_folder_popup();
      $.ajax({
        url: wp_adminify__folder_data.ajaxurl,
        method: 'post',
        data: {
          post_type: wp_adminify__folder_data.post_type,
          post_type_tax: wp_adminify__folder_data.post_type_tax,
          term_id: _this.folders_to_edit[0].term_id,
          folder_name: _this.rename_folder_name,
          folder_color_tag: _this.active_color_tag,
          action: 'adminify_folder',
          route: 'rename_folder',
          _ajax_nonce: wp_adminify__folder_data.nonce
        }
      }).done(function (response, status, xhr) {
        if (response.success && xhr.status == 200) {
          _this.refresh_folders_data(response.data);

          _this.hide_rename_folder_popup();

          $('.folder--lists li.active > a').trigger('click');
        } else {
          _this.rename_folder_error = response.data.message;
        }
      });
    },
    init_draggable_events: function init_draggable_events() {
      $('.adminify-move-file:not(.ui-draggable), .adminify-move-multiple:not(.ui-draggable)').draggable({
        revert: "invalid",
        containment: "document",
        helper: "clone",
        cursor: "move",
        start: function start(event, ui) {
          $(this).closest('td').addClass('adminify-draggable');
          $('body').addClass('adminify--items-dragging');
        },
        stop: function stop(event, ui) {
          $(this).closest('td').removeClass('adminify-draggable');
          $('body').removeClass('adminify--items-dragging');
        } // helper: function (event, ui) {
        //     console.log( event )
        //     console.log( this )
        //     // if ( ui.draggable.hasClass( 'adminify-move-multiple') ) {
        //     let items = $('#the-list .check-column input[type="checkbox"]:checked').length;
        //     return $(`<div>Move ${items} Items</div>`);
        //     // $('.adminify--selected-items').remove();
        //     // let selectedItems = $('.attachments-browser li.attachment.selected').length;
        //     // selectedItems = (selectedItems < 2) ? '1 Item' : `${selectedItems} Items`;
        //     // return $(`<div class='adminify--selected-items'><span class='total-post-count'>${selectedItems} Selected</span></div>`);
        // },

      });
      $('.attachments-browser li.attachment:not(.ui-draggable)').draggable({
        revert: "invalid",
        containment: "document",
        cursor: "move",
        cursorAt: {
          left: 0,
          top: 0
        },
        start: function start(event, ui) {
          $('body').addClass('adminify--items-dragging');
        },
        stop: function stop(event, ui) {
          $('.adminify--selected-items').remove();
          $('body').removeClass('adminify--items-dragging');
        }
      });
    },
    init_droppable_events: function init_droppable_events() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var _this;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this = _this6;
                $('.folder--lists li a:not(.ui-droppable), .folder--stats li.folder--single-uncategorized a:not(.ui-droppable)').droppable({
                  accept: '.adminify-move-file, .adminify-move-multiple, .attachments-browser li.attachment',
                  hoverClass: 'adminify-drop-hover',
                  classes: {
                    'ui-droppable-active': 'ui-state-highlight'
                  },
                  tolerance: 'pointer',
                  drop: function () {
                    var _drop = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(event, ui) {
                      var folderID, postIDs, move_to_folder, folder_found, mode;
                      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
                        while (1) {
                          switch (_context.prev = _context.next) {
                            case 0:
                              folderID = $(this).parent("li").data('folder');

                              if (folderID) {
                                _context.next = 3;
                                break;
                              }

                              return _context.abrupt("return");

                            case 3:
                              postIDs = [];

                              if (ui.draggable.hasClass('adminify-move-multiple')) {
                                postIDs = $('#the-list .check-column input[type=checkbox]:checked').toArray().map(function (_input) {
                                  return _input.value;
                                });
                                $('.wp-list-table .manage-column.check-column input').prop('checked', false);
                              } else if (ui.draggable.hasClass('adminify-move-file')) {
                                postIDs = [ui.draggable[0].attributes['data-id'].nodeValue];
                              } else if (ui.draggable.hasClass('attachment')) {
                                if ($('.media-toolbar.wp-filter').hasClass('media-toolbar-mode-select')) {
                                  postIDs = $('.attachments-browser li.attachment.selected').toArray().map(function (_media) {
                                    return _media.dataset.id;
                                  });
                                } else {
                                  postIDs = [ui.draggable[0].attributes['data-id'].nodeValue];
                                }
                              }

                              if (postIDs.length) {
                                _context.next = 7;
                                break;
                              }

                              return _context.abrupt("return");

                            case 7:
                              move_to_folder = false;

                              if (!(folderID != 'uncategorized')) {
                                _context.next = 14;
                                break;
                              }

                              folder_found = postIDs.some(function (post_id) {
                                var folder_ids = _this.get_folder_ids_by_post_id(post_id);

                                if (folder_ids.length) return true;
                                return false;
                              });

                              if (!folder_found) {
                                _context.next = 14;
                                break;
                              }

                              _context.next = 13;
                              return _this.shouldWeMoveToFolder();

                            case 13:
                              move_to_folder = _context.sent;

                            case 14:
                              if (!ui.draggable.hasClass('attachment')) {
                                mode = $('input[name=post_view]').first().val() || 'list';
                                $.ajax({
                                  url: wp_adminify__folder_data.ajaxurl,
                                  method: 'post',
                                  data: {
                                    post_ids: postIDs,
                                    folder_id: folderID,
                                    post_type: wp_adminify__folder_data.post_type,
                                    post_type_tax: wp_adminify__folder_data.post_type_tax,
                                    action: 'adminify_folder',
                                    route: 'move_to_folder',
                                    move_to_folder: move_to_folder,
                                    screen: pagenow,
                                    mode: mode,
                                    _ajax_nonce: wp_adminify__folder_data.nonce
                                  }
                                }).done(function (response, status) {
                                  if (response.success) {
                                    _this.refresh_rows();

                                    _this.refresh_folders_data(response.data);
                                  }
                                });
                              }

                              if (ui.draggable.hasClass('attachment')) {
                                $.ajax({
                                  url: wp_adminify__folder_data.ajaxurl,
                                  method: 'post',
                                  data: {
                                    post_ids: postIDs,
                                    folder_id: folderID,
                                    post_type: wp_adminify__folder_data.post_type,
                                    post_type_tax: wp_adminify__folder_data.post_type_tax,
                                    action: 'adminify_folder',
                                    route: 'move_to_folder',
                                    copy_type: copy_type,
                                    screen: pagenow,
                                    mode: 'grid',
                                    _ajax_nonce: wp_adminify__folder_data.nonce
                                  }
                                }).done(function (response, status) {
                                  if (response.success) {
                                    _this.refresh_rows();

                                    _this.refresh_folders_data(response.data);
                                  }
                                });
                              }

                            case 16:
                            case "end":
                              return _context.stop();
                          }
                        }
                      }, _callee, this);
                    }));

                    function drop(_x, _x2) {
                      return _drop.apply(this, arguments);
                    }

                    return drop;
                  }()
                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    shouldWeMoveToFolder: function shouldWeMoveToFolder() {
      var _this7 = this;

      this.showPopupOverlay();
      this.move_to_folder_popup = true;
      return new Promise(function (resolve) {
        jQuery('body').on('click.promptDialog', '.button-move, .button-copy', function (e) {
          e.preventDefault();
          if (jQuery(this).hasClass('button-move')) resolve(true);
          resolve(false);
        });
      })["finally"](function () {
        jQuery('.button-move, .button-copy').off('click.promptDialog');

        _this7.hidePopupOverlay();

        _this7.move_to_folder_popup = false;
      });
    },
    refresh_rows: function refresh_rows() {
      var $currentItem = $('.folder--lists li.active, .folder--stats li.active').first();
      if (!$currentItem.length) $currentItem = $('.folder--stats li').first();
      $currentItem.children('a').trigger('click');
    },
    get_allowed_status: function get_allowed_status() {
      return ['pending', 'draft', 'future', 'private', 'publish', 'inherit'];
    },
    refresh_folders_data: function refresh_folders_data() {
      var _this8 = this;

      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      this.folders = data.folders;
      this.total_posts = data.total_posts;
      this.total_uncat_posts = data.total_uncat_posts;
      this.folder_hierarchy = data.folder_hierarchy;
      setTimeout(function () {
        _this8.init_droppable_events();

        _this8.init_draggable_events();

        _this8.set_posts_folders();
      }, 200);
    },
    refresh_folders_data_ajax: function refresh_folders_data_ajax() {
      var _this = this;

      $.ajax({
        url: wp_adminify__folder_data.ajaxurl,
        method: 'post',
        data: {
          post_type: wp_adminify__folder_data.post_type,
          post_type_tax: wp_adminify__folder_data.post_type_tax,
          action: 'adminify_folder',
          route: 'refresh_folders',
          _ajax_nonce: wp_adminify__folder_data.nonce
        }
      }).done(function (response, status) {
        if (response.success) {
          _this.refresh_folders_data(response.data);
        }
      });
    },
    get_color_tags: function get_color_tags() {
      if (!this.folders_to_edit && !this.folders_to_edit.length) return;
      var folder = this.folders_to_edit[0];
      var active_color = '';

      if (folder && folder.color) {
        active_color = folder.color;
      }

      if (!active_color || this.color_tags.includes(active_color)) return this.color_tags;
      return this.color_tags.concat([active_color]);
    },
    deleteFolders: function deleteFolders() {
      var _this = this;

      var folders = this.folders_to_edit;
      if (!folders.length) return this.hide_delete_folder_popup();
      folders = folders.map(function (_folder) {
        return _folder.term_id;
      });
      $.ajax({
        url: wp_adminify__folder_data.ajaxurl,
        method: 'post',
        data: {
          post_type: wp_adminify__folder_data.post_type,
          post_type_tax: wp_adminify__folder_data.post_type_tax,
          term_ids: folders,
          action: 'adminify_folder',
          route: 'delete_folders',
          _ajax_nonce: wp_adminify__folder_data.nonce
        }
      }).done(function (response, status, xhr) {
        if (response.success && xhr.status == 200) {
          _this.refresh_folders_data(response.data);

          _this.hide_delete_folder_popup();

          $('.folder--lists, .folder--stats').find('li.active > a').trigger('click');
        }
      });
    },
    sortFolders: function sortFolders(event) {
      var sort = $(event.currentTarget).data('sort');

      if (sort) {
        js_cookie__WEBPACK_IMPORTED_MODULE_1__["default"].set(this.post_type_tax + '__sort', sort);
        this.sort = sort;
      }
    }
  },
  computed: {
    _filter_folder: function _filter_folder() {
      return this.filter_folder.trim().toLowerCase();
    },
    filtered_folders: function filtered_folders() {
      var _this9 = this;

      var that = this; // Set Default Options

      var folders = this.folders.map(function (_folder) {
        _folder.selected = false;
        _folder.contexted = false;
        _folder.children = [];
        return _folder;
      }); // Sort for Folders

      folders = folders.sort(function (a, b) {
        if (_this9.sort == 'a-z') {
          if (a.name < b.name) {
            return -1;
          }

          if (a.name > b.name) {
            return 1;
          }
        }

        if (_this9.sort == 'z-a') {
          if (a.name < b.name) {
            return 1;
          }

          if (a.name > b.name) {
            return -1;
          }
        }

        return 0;
      });

      function addChild(folder, _folders) {
        that.folder_hierarchy[folder.term_id].forEach(function (child_id) {
          var child_folder = folders.find(function (_folder) {
            return _folder.term_id == child_id;
          });
          var child_folder_index = folders.findIndex(function (_folder) {
            return _folder.term_id == child_id;
          });

          if (child_folder && child_folder_index > -1) {
            if (!folder.children.find(function (_fol_ch) {
              return _fol_ch.term_id == child_folder.term_id;
            })) {
              folder.children.push(child_folder);
              child_folder = folder.children.find(function (_folder) {
                return _folder.term_id == child_id;
              });
              if (child_id in that.folder_hierarchy) addChild(child_folder, _folders);
            }
          }
        });
      } // Search Filter


      if (this._filter_folder) {
        var _folders = folders.filter(function (_folder) {
          return _folder.name.toLowerCase().search(_this9._filter_folder.toLowerCase()) > -1;
        });

        if (_folders.length) return _folders;
      } // Set Sub Folders


      folders.forEach(function (folder) {
        if (folder.term_id in that.folder_hierarchy) {
          addChild(folder, folders);
        }
      }); // Cleanup Extra Sub Folders

      for (var parent_item in that.folder_hierarchy) {
        that.folder_hierarchy[parent_item].forEach(function (child_id) {
          var index = folders.findIndex(function (_folder) {
            return _folder.term_id == child_id;
          });
          folders.splice(index, 1);
        });
      }

      return folders;
    },
    total_posts_count: function total_posts_count() {
      var _this10 = this;

      var total = 0;
      this.get_allowed_status().forEach(function (status) {
        total += Number(_this10.total_posts[status]);
      });
      return total;
    },
    is_reached_limit: function is_reached_limit() {
      if (this.is_pro) return false; // go unlimited

      if (this.folders && this.folders.length) {
        return this.folders.length >= 3;
      }

      return false;
    }
  },
  watch: {
    filter_folder: function filter_folder() {
      var _this11 = this;

      setTimeout(function () {
        _this11.init_draggable_events();

        _this11.init_droppable_events();
      }, 50);
    }
  }
});

/***/ }),

/***/ "./dev/admin/modules/folder/components/folders.vue":
/*!*********************************************************!*\
  !*** ./dev/admin/modules/folder/components/folders.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _folders_vue_vue_type_template_id_b43c4ba6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./folders.vue?vue&type=template&id=b43c4ba6& */ "./dev/admin/modules/folder/components/folders.vue?vue&type=template&id=b43c4ba6&");
/* harmony import */ var _folders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./folders.vue?vue&type=script&lang=js& */ "./dev/admin/modules/folder/components/folders.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _folders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _folders_vue_vue_type_template_id_b43c4ba6___WEBPACK_IMPORTED_MODULE_0__.render,
  _folders_vue_vue_type_template_id_b43c4ba6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/folder/components/folders.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/folder/folder-app.vue":
/*!*************************************************!*\
  !*** ./dev/admin/modules/folder/folder-app.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _folder_app_vue_vue_type_template_id_4bcdf0a3___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./folder-app.vue?vue&type=template&id=4bcdf0a3& */ "./dev/admin/modules/folder/folder-app.vue?vue&type=template&id=4bcdf0a3&");
/* harmony import */ var _folder_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./folder-app.vue?vue&type=script&lang=js& */ "./dev/admin/modules/folder/folder-app.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _folder_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _folder_app_vue_vue_type_template_id_4bcdf0a3___WEBPACK_IMPORTED_MODULE_0__.render,
  _folder_app_vue_vue_type_template_id_4bcdf0a3___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/folder/folder-app.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/folder/components/folders.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./dev/admin/modules/folder/components/folders.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_folders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./folders.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/components/folders.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_folders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/folder/folder-app.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./dev/admin/modules/folder/folder-app.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_folder_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./folder-app.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/folder-app.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_folder_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/folder/components/folders.vue?vue&type=template&id=b43c4ba6&":
/*!****************************************************************************************!*\
  !*** ./dev/admin/modules/folder/components/folders.vue?vue&type=template&id=b43c4ba6& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_folders_vue_vue_type_template_id_b43c4ba6___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_folders_vue_vue_type_template_id_b43c4ba6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_folders_vue_vue_type_template_id_b43c4ba6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./folders.vue?vue&type=template&id=b43c4ba6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/components/folders.vue?vue&type=template&id=b43c4ba6&");


/***/ }),

/***/ "./dev/admin/modules/folder/folder-app.vue?vue&type=template&id=4bcdf0a3&":
/*!********************************************************************************!*\
  !*** ./dev/admin/modules/folder/folder-app.vue?vue&type=template&id=4bcdf0a3& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_folder_app_vue_vue_type_template_id_4bcdf0a3___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_folder_app_vue_vue_type_template_id_4bcdf0a3___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_folder_app_vue_vue_type_template_id_4bcdf0a3___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./folder-app.vue?vue&type=template&id=4bcdf0a3& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/folder-app.vue?vue&type=template&id=4bcdf0a3&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/components/folders.vue?vue&type=template&id=b43c4ba6&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/components/folders.vue?vue&type=template&id=b43c4ba6& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "ul",
    _vm._l(_vm.folders, function(_folder) {
      return _c(
        "li",
        {
          key: _folder.term_id,
          staticClass: "folder--single-root has--sub-menu",
          class: _vm.is_folder(_folder) && "active",
          attrs: { "data-folder": _folder.term_id }
        },
        [
          _c(
            "a",
            {
              style: { color: _folder.color },
              attrs: { href: _vm.get_folder_url(_folder) },
              on: {
                contextmenu: function($event) {
                  return _vm.folderActions($event, _folder)
                }
              }
            },
            [
              _c("span", { staticClass: "wp-adminify--folder-left" }, [
                _c("span", { staticClass: "wp-adminify--icon-control" }, [
                  !_vm.folder_select_toggle
                    ? _c("span", {
                        staticClass:
                          "wp-adminify--icon dashicons dashicons-open-folder"
                      })
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.folder_select_toggle
                    ? _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _folder.selected,
                            expression: "_folder.selected"
                          }
                        ],
                        staticClass: "wp-adminify--control",
                        attrs: { type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_folder.selected)
                            ? _vm._i(_folder.selected, null) > -1
                            : _folder.selected
                        },
                        on: {
                          "!click": function($event) {
                            $event.stopPropagation()
                          },
                          change: function($event) {
                            var $$a = _folder.selected,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 &&
                                  _vm.$set(
                                    _folder,
                                    "selected",
                                    $$a.concat([$$v])
                                  )
                              } else {
                                $$i > -1 &&
                                  _vm.$set(
                                    _folder,
                                    "selected",
                                    $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                                  )
                              }
                            } else {
                              _vm.$set(_folder, "selected", $$c)
                            }
                          }
                        }
                      })
                    : _vm._e()
                ]),
                _vm._v(" "),
                _c("span", { staticClass: "wp-adminify--name" }, [
                  _vm._v(_vm._s(_folder.name))
                ])
              ]),
              _vm._v(" "),
              _c("span", { staticClass: "wp-adminify--count" }, [
                _vm._v(_vm._s(_folder.count))
              ])
            ]
          ),
          _vm._v(" "),
          _folder.children.length
            ? _c("folders", {
                staticClass: "folder--sub-lists",
                attrs: {
                  folders: _folder.children,
                  folder_select_toggle: _vm.folder_select_toggle
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _c("ul", { staticClass: "adminify--sub-menu" }, [
            _c("li", [
              _c(
                "a",
                {
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      $event.stopPropagation()
                      return _vm.showNewSubFolderPopup(_folder)
                    }
                  }
                },
                [_vm._v("New Sub-folder")]
              )
            ]),
            _vm._v(" "),
            _c("li", [
              _c(
                "a",
                {
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      $event.stopPropagation()
                      return _vm.showRenameFolderPopup(_folder)
                    }
                  }
                },
                [_vm._v("Rename")]
              )
            ]),
            _vm._v(" "),
            _c("li", [
              _c(
                "a",
                {
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      $event.stopPropagation()
                      return _vm.showDeleteFolderPopup(_folder)
                    }
                  }
                },
                [_vm._v("Delete")]
              )
            ])
          ])
        ],
        1
      )
    }),
    0
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/folder-app.vue?vue&type=template&id=4bcdf0a3&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/folder/folder-app.vue?vue&type=template&id=4bcdf0a3& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { attrs: { id: "wp-adminify--folder-app" } }, [
    _c("div", { staticClass: "wp-adminify--folder-widget" }, [
      _c("div", { staticClass: "wp-adminify--folder-app" }, [
        _c(
          "div",
          { staticClass: "wp-adminify--folder-app--inner" },
          [
            _c("div", { staticClass: "folder--header" }, [
              _c("span", [_vm._v("Folders")]),
              _vm._v(" -\n                    "),
              _c(
                "a",
                {
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.showNewFolderPopup.apply(null, arguments)
                    }
                  }
                },
                [_vm._v("Create New Folder")]
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "folder--actions" }, [
              _c("span", [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.folder_select_toggle,
                      expression: "folder_select_toggle"
                    }
                  ],
                  attrs: { type: "checkbox" },
                  domProps: {
                    checked: Array.isArray(_vm.folder_select_toggle)
                      ? _vm._i(_vm.folder_select_toggle, null) > -1
                      : _vm.folder_select_toggle
                  },
                  on: {
                    change: function($event) {
                      var $$a = _vm.folder_select_toggle,
                        $$el = $event.target,
                        $$c = $$el.checked ? true : false
                      if (Array.isArray($$a)) {
                        var $$v = null,
                          $$i = _vm._i($$a, $$v)
                        if ($$el.checked) {
                          $$i < 0 &&
                            (_vm.folder_select_toggle = $$a.concat([$$v]))
                        } else {
                          $$i > -1 &&
                            (_vm.folder_select_toggle = $$a
                              .slice(0, $$i)
                              .concat($$a.slice($$i + 1)))
                        }
                      } else {
                        _vm.folder_select_toggle = $$c
                      }
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "btn--folder-rename",
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      $event.stopPropagation()
                      return _vm.showRenameFolderPopup.apply(null, arguments)
                    }
                  }
                },
                [_vm._v("Rename")]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "btn--folder-delete",
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      $event.stopPropagation()
                      return _vm.showDeleteFolderPopup.apply(null, arguments)
                    }
                  }
                },
                [_vm._v("Delete")]
              ),
              _vm._v(" "),
              _c("ul", { staticClass: "folder-sort--list" }, [
                _vm._m(0),
                _vm._v(" "),
                _c("li", { staticClass: "folder--sort has--sub-menu" }, [
                  _vm._m(1),
                  _vm._v(" "),
                  _c("ul", { staticClass: "adminify--sub-menu" }, [
                    _c("li", [
                      _c(
                        "a",
                        {
                          attrs: { "data-sort": "a-z", href: "#" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.sortFolders($event)
                            }
                          }
                        },
                        [_vm._v("A → Z")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("li", [
                      _c(
                        "a",
                        {
                          attrs: { "data-sort": "z-a", href: "#" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.sortFolders($event)
                            }
                          }
                        },
                        [_vm._v("Z → A")]
                      )
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "folder--search" }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.filter_folder,
                    expression: "filter_folder"
                  }
                ],
                attrs: { type: "text", placeholder: "Search folder" },
                domProps: { value: _vm.filter_folder },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.filter_folder = $event.target.value
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("ul", { staticClass: "folder--stats" }, [
              _c(
                "li",
                {
                  staticClass: "folder--single-all",
                  class: _vm.is_folder("all") && "active",
                  attrs: { "data-folder": "all" }
                },
                [
                  _c("a", { attrs: { href: _vm.get_folder_url("all") } }, [
                    _c("span", [_vm._v("All")]),
                    _c("span", { staticClass: "wp-adminify--count" }, [
                      _vm._v(_vm._s(_vm.total_posts_count))
                    ])
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "li",
                {
                  staticClass: "folder--single-uncategorized",
                  class: _vm.is_folder("uncategorized") && "active",
                  attrs: { "data-folder": "uncategorized" }
                },
                [
                  _c(
                    "a",
                    { attrs: { href: _vm.get_folder_url("uncategorized") } },
                    [
                      _c("span", [_vm._v("Uncategorized")]),
                      _c("span", { staticClass: "wp-adminify--count" }, [
                        _vm._v(_vm._s(_vm.total_uncat_posts))
                      ])
                    ]
                  )
                ]
              )
            ]),
            _vm._v(" "),
            _vm.folders
              ? _c("folders", {
                  staticClass: "folder--lists",
                  attrs: {
                    folders: _vm.filtered_folders,
                    folder_select_toggle: _vm.folder_select_toggle
                  }
                })
              : _vm._e()
          ],
          1
        )
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "wp-adminify--popup-area" }, [
      _c("div", { staticClass: "wp-adminify--popup-container" }, [
        _c("div", { staticClass: "wp-adminify--popup-container_inner" }, [
          _vm.create_folder_popup
            ? _c(
                "div",
                { staticClass: "popup--create-new-folder" },
                [
                  _c(
                    "a",
                    {
                      staticClass: "wp-adminify--popup-close",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.hide_create_folder_popup.apply(
                            null,
                            arguments
                          )
                        }
                      }
                    },
                    [_c("span", { staticClass: "dashicons dashicons-no-alt" })]
                  ),
                  _vm._v(" "),
                  _vm.parent_folder
                    ? [
                        _c("h3", [_vm._v("New Sub Folder")]),
                        _vm._v(" "),
                        _vm.is_pro
                          ? [
                              _c(
                                "div",
                                { staticClass: "popup--new-folder__name" },
                                [
                                  _c("div", [_vm._v("Sub Folder Name")]),
                                  _vm._v(" "),
                                  _c("div", [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.new_folder_name,
                                          expression: "new_folder_name"
                                        }
                                      ],
                                      attrs: {
                                        type: "text",
                                        placeholder: "Write here"
                                      },
                                      domProps: { value: _vm.new_folder_name },
                                      on: {
                                        input: [
                                          function($event) {
                                            if ($event.target.composing) {
                                              return
                                            }
                                            _vm.new_folder_name =
                                              $event.target.value
                                          },
                                          function($event) {
                                            _vm.create_folder_error = null
                                          }
                                        ]
                                      }
                                    })
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "div",
                                { staticClass: "popup--new-folder__color" },
                                [
                                  _c("div", [_vm._v("Colour Tag")]),
                                  _vm._v(" "),
                                  _c("div", [
                                    _c(
                                      "ul",
                                      { staticClass: "wp-adminify--colors" },
                                      _vm._l(_vm.color_tags, function(
                                        color_tag
                                      ) {
                                        return _c(
                                          "li",
                                          {
                                            key: color_tag,
                                            class:
                                              color_tag == _vm.active_color_tag
                                                ? "active"
                                                : ""
                                          },
                                          [
                                            _c("a", {
                                              style:
                                                "background: " +
                                                color_tag +
                                                ";",
                                              attrs: { href: "#" },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  _vm.active_color_tag = color_tag
                                                }
                                              }
                                            })
                                          ]
                                        )
                                      }),
                                      0
                                    )
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "a",
                                {
                                  staticClass: "button button-primary",
                                  attrs: { href: "#" },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.saveNewFolder.apply(
                                        null,
                                        arguments
                                      )
                                    }
                                  }
                                },
                                [_vm._v("Save Folder")]
                              ),
                              _vm._v(" "),
                              _vm.create_folder_error
                                ? _c(
                                    "div",
                                    { staticClass: "popup--new-folder-error" },
                                    [_vm._v(_vm._s(_vm.create_folder_error))]
                                  )
                                : _vm._e()
                            ]
                          : [
                              _c("div", {
                                staticClass: "wp-adminify-folder--pro-notice",
                                domProps: { innerHTML: _vm._s(_vm.pro_notice) }
                              })
                            ]
                      ]
                    : [
                        _c("h3", [_vm._v("New Folder")]),
                        _vm._v(" "),
                        _vm.is_reached_limit
                          ? [
                              _c("div", {
                                staticClass: "wp-adminify-folder--pro-notice",
                                domProps: { innerHTML: _vm._s(_vm.pro_notice) }
                              })
                            ]
                          : [
                              _c(
                                "div",
                                { staticClass: "popup--new-folder__name" },
                                [
                                  _c("div", [_vm._v("Folder Name")]),
                                  _vm._v(" "),
                                  _c("div", [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: _vm.new_folder_name,
                                          expression: "new_folder_name"
                                        }
                                      ],
                                      attrs: {
                                        type: "text",
                                        placeholder: "Write here"
                                      },
                                      domProps: { value: _vm.new_folder_name },
                                      on: {
                                        input: [
                                          function($event) {
                                            if ($event.target.composing) {
                                              return
                                            }
                                            _vm.new_folder_name =
                                              $event.target.value
                                          },
                                          function($event) {
                                            _vm.create_folder_error = null
                                          }
                                        ]
                                      }
                                    })
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "div",
                                { staticClass: "popup--new-folder__color" },
                                [
                                  _c("div", [_vm._v("Colour Tag")]),
                                  _vm._v(" "),
                                  _c("div", [
                                    _c(
                                      "ul",
                                      { staticClass: "wp-adminify--colors" },
                                      _vm._l(_vm.color_tags, function(
                                        color_tag
                                      ) {
                                        return _c(
                                          "li",
                                          {
                                            key: color_tag,
                                            class:
                                              color_tag == _vm.active_color_tag
                                                ? "active"
                                                : ""
                                          },
                                          [
                                            _c("a", {
                                              style:
                                                "background: " +
                                                color_tag +
                                                ";",
                                              attrs: { href: "#" },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  _vm.active_color_tag = color_tag
                                                }
                                              }
                                            })
                                          ]
                                        )
                                      }),
                                      0
                                    )
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "a",
                                {
                                  staticClass: "button button-primary",
                                  attrs: { href: "#" },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.saveNewFolder.apply(
                                        null,
                                        arguments
                                      )
                                    }
                                  }
                                },
                                [_vm._v("Save Folder")]
                              ),
                              _vm._v(" "),
                              _vm.create_folder_error
                                ? _c(
                                    "div",
                                    { staticClass: "popup--new-folder-error" },
                                    [_vm._v(_vm._s(_vm.create_folder_error))]
                                  )
                                : _vm._e()
                            ]
                      ]
                ],
                2
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.rename_folder_popup
            ? _c("div", { staticClass: "popup--rename-folder" }, [
                _c(
                  "a",
                  {
                    staticClass: "wp-adminify--popup-close",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.hide_rename_folder_popup.apply(
                          null,
                          arguments
                        )
                      }
                    }
                  },
                  [_c("span", { staticClass: "dashicons dashicons-no-alt" })]
                ),
                _vm._v(" "),
                _c("h3", [_vm._v("Rename Folder")]),
                _vm._v(" "),
                _c("div", { staticClass: "popup--new-folder__name" }, [
                  _c("div", [_vm._v("Rename Folder")]),
                  _vm._v(" "),
                  _c("div", [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.rename_folder_name,
                          expression: "rename_folder_name"
                        }
                      ],
                      attrs: { type: "text", placeholder: "Write here" },
                      domProps: { value: _vm.rename_folder_name },
                      on: {
                        input: [
                          function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.rename_folder_name = $event.target.value
                          },
                          function($event) {
                            _vm.rename_folder_error = null
                          }
                        ]
                      }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c("br"),
                _vm._v(" "),
                _c("div", { staticClass: "popup--new-folder__color" }, [
                  _c("div", [_vm._v("Change Color")]),
                  _vm._v(" "),
                  _c("div", [
                    _c(
                      "ul",
                      { staticClass: "wp-adminify--colors" },
                      _vm._l(_vm.get_color_tags(), function(color_tag) {
                        return _c(
                          "li",
                          {
                            key: color_tag,
                            class:
                              color_tag == _vm.active_color_tag ? "active" : ""
                          },
                          [
                            _c("a", {
                              style: "background: " + color_tag + ";",
                              attrs: { href: "#" },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  _vm.active_color_tag = color_tag
                                }
                              }
                            })
                          ]
                        )
                      }),
                      0
                    )
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "a",
                  {
                    staticClass: "button button-primary",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.renameFolder.apply(null, arguments)
                      }
                    }
                  },
                  [_vm._v("Save Folder")]
                ),
                _vm._v(" "),
                _vm.rename_folder_error
                  ? _c("div", { staticClass: "popup--new-folder-error" }, [
                      _vm._v(_vm._s(_vm.rename_folder_error))
                    ])
                  : _vm._e()
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.delete_folder_popup
            ? _c("div", { staticClass: "popup--delete-folder" }, [
                _c(
                  "a",
                  {
                    staticClass: "wp-adminify--popup-close",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.hide_delete_folder_popup.apply(
                          null,
                          arguments
                        )
                      }
                    }
                  },
                  [_c("span", { staticClass: "dashicons dashicons-no-alt" })]
                ),
                _vm._v(" "),
                _c("h3", [
                  _vm._v("Are you sure you want to delete the selected folder?")
                ]),
                _vm._v(" "),
                _c("p", [_vm._v("Items in the folder will not be deleted.")]),
                _vm._v(" "),
                _c("div", [
                  _c(
                    "a",
                    {
                      staticClass: "button",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.hide_delete_folder_popup.apply(
                            null,
                            arguments
                          )
                        }
                      }
                    },
                    [_vm._v("No, Keep it")]
                  ),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      staticClass: "button button-primary",
                      attrs: { href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.deleteFolders.apply(null, arguments)
                        }
                      }
                    },
                    [_vm._v("Yes, Delete it!")]
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.move_to_folder_popup
            ? _c("div", { staticClass: "popup--move-to-folder" }, [
                _c("h3", [_vm._v("Few posts are already in another Folder")]),
                _vm._v(" "),
                _c("p", [
                  _vm._v(
                    "Please choose a option whether you want to copy or move to new Folder."
                  )
                ]),
                _vm._v(" "),
                _vm._m(2)
              ])
            : _vm._e()
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("li", { staticClass: "folder--expand" }, [
      _c("a", { staticClass: "btn--folder-expand", attrs: { href: "#" } }, [
        _c("span", { staticClass: "dashicons dashicons-arrow-down-alt2" })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("a", { staticClass: "btn--folder-sort", attrs: { href: "#" } }, [
      _c("span", { staticClass: "dashicons dashicons-sort" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c("a", { staticClass: "button button-copy", attrs: { href: "#" } }, [
        _vm._v("Copy To Folder")
      ]),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "button button-primary button-move",
          attrs: { href: "#" }
        },
        [_vm._v("Move To Folder")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/assets/admin/js/vendor"], () => (__webpack_exec__("./dev/admin/modules/folder/folder.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=wp-adminify--folder.js.map