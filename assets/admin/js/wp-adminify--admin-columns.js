"use strict";
(self["webpackChunkadminify"] = self["webpackChunkadminify"] || []).push([["/assets/admin/js/wp-adminify--admin-columns"],{

/***/ "./dev/admin/modules/admin-columns/app.js":
/*!************************************************!*\
  !*** ./dev/admin/modules/admin-columns/app.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./router */ "./dev/admin/modules/admin-columns/router.js");
/* harmony import */ var _store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./store */ "./dev/admin/modules/admin-columns/store.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./helpers */ "./dev/admin/modules/admin-columns/helpers.js");




Window.Events = new vue__WEBPACK_IMPORTED_MODULE_3__["default"]();
vue__WEBPACK_IMPORTED_MODULE_3__["default"].mixin({
  methods: _helpers__WEBPACK_IMPORTED_MODULE_2__["default"]
});
vue__WEBPACK_IMPORTED_MODULE_3__["default"].component('admin-columns-app', (__webpack_require__(/*! ./app.vue */ "./dev/admin/modules/admin-columns/app.vue")["default"]));
vue__WEBPACK_IMPORTED_MODULE_3__["default"].component('post-types-sidebar', (__webpack_require__(/*! ./components/post-types-sidebar.vue */ "./dev/admin/modules/admin-columns/components/post-types-sidebar.vue")["default"]));
jQuery(function ($) {
  if ($('#wpadminify-admin-columns').length) {
    new vue__WEBPACK_IMPORTED_MODULE_3__["default"]({
      el: '#wpadminify-admin-columns',
      template: '<admin-columns-app></admin-columns-app>',
      router: _router__WEBPACK_IMPORTED_MODULE_0__["default"],
      store: _store__WEBPACK_IMPORTED_MODULE_1__["default"]
    });
  }
});

/***/ }),

/***/ "./dev/admin/modules/admin-columns/helpers.js":
/*!****************************************************!*\
  !*** ./dev/admin/modules/admin-columns/helpers.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var config = Object.assign({}, window.adminify_columns_data);
delete window.adminify_columns_data.ajax_nonce;
delete window.adminify_columns_data.siteurl;
delete window.adminify_columns_data.ajaxurl;
delete window.adminify_columns_data.adminurl;
delete window.adminify_columns_data.ajax_action;
delete window.adminify_columns_data.is_pro;
var helpers = {
  proNotice: function proNotice() {
    return config.pro_notice;
  },
  isPro: function isPro() {
    return !!config.is_pro;
  },
  getSiteURL: function getSiteURL() {
    return config.siteurl;
  },
  getWPNonce: function getWPNonce() {
    return config.ajax_nonce;
  },
  getAjaxURL: function getAjaxURL() {
    return config.ajaxurl;
  },
  getAdminURL: function getAdminURL() {
    return config.adminurl;
  },
  getAjaxAction: function getAjaxAction() {
    return config.ajax_action;
  },
  ajax: function ajax(route, _data) {
    var type = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'POST';
    var data = jQuery.extend({}, _data, {
      route: route,
      _ajax_nonce: this.getWPNonce(),
      action: this.getAjaxAction()
    });
    return jQuery.ajax({
      type: type,
      data: data,
      url: this.getAjaxURL()
    });
  },
  nonReactive: function nonReactive(data) {
    return JSON.parse(JSON.stringify(data));
  },
  triggerLoader: function triggerLoader() {
    var status = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

    if (status) {
      jQuery(".wp-adminify--admin-columns--editor--container .wp-adminify-loader").stop(true, true).fadeIn("slow");
    } else {
      jQuery(".wp-adminify--admin-columns--editor--container .wp-adminify-loader").stop(true, true).fadeOut("slow");
    }
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (helpers);

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/index.js":
/*!********************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/index.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "PostType": () => (/* reexport safe */ _post_type_vue__WEBPACK_IMPORTED_MODULE_1__["default"]),
/* harmony export */   "PostTypes": () => (/* reexport safe */ _post_types_vue__WEBPACK_IMPORTED_MODULE_0__["default"]),
/* harmony export */   "Taxonomies": () => (/* reexport safe */ _taxonomies_vue__WEBPACK_IMPORTED_MODULE_2__["default"]),
/* harmony export */   "Taxonomy": () => (/* reexport safe */ _taxonomy_vue__WEBPACK_IMPORTED_MODULE_3__["default"])
/* harmony export */ });
/* harmony import */ var _post_types_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./post-types.vue */ "./dev/admin/modules/admin-columns/pages/post-types.vue");
/* harmony import */ var _post_type_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./post-type.vue */ "./dev/admin/modules/admin-columns/pages/post-type.vue");
/* harmony import */ var _taxonomies_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./taxonomies.vue */ "./dev/admin/modules/admin-columns/pages/taxonomies.vue");
/* harmony import */ var _taxonomy_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./taxonomy.vue */ "./dev/admin/modules/admin-columns/pages/taxonomy.vue");






/***/ }),

/***/ "./dev/admin/modules/admin-columns/router.js":
/*!***************************************************!*\
  !*** ./dev/admin/modules/admin-columns/router.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm.js");
/* harmony import */ var _pages__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pages */ "./dev/admin/modules/admin-columns/pages/index.js");



vue__WEBPACK_IMPORTED_MODULE_1__["default"].use(vue_router__WEBPACK_IMPORTED_MODULE_2__["default"]);
var routes = [{
  path: '/',
  component: _pages__WEBPACK_IMPORTED_MODULE_0__.PostTypes
}, {
  path: '/post-types',
  component: _pages__WEBPACK_IMPORTED_MODULE_0__.PostTypes,
  children: [{
    path: ':post_type',
    component: _pages__WEBPACK_IMPORTED_MODULE_0__.PostType
  }]
}, {
  path: '/taxonomies',
  component: _pages__WEBPACK_IMPORTED_MODULE_0__.Taxonomies,
  children: [{
    path: ':taxonomy',
    component: _pages__WEBPACK_IMPORTED_MODULE_0__.Taxonomy
  }]
}];
var router = new vue_router__WEBPACK_IMPORTED_MODULE_2__["default"]({
  routes: routes
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (router);

/***/ }),

/***/ "./dev/admin/modules/admin-columns/store.js":
/*!**************************************************!*\
  !*** ./dev/admin/modules/admin-columns/store.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helpers */ "./dev/admin/modules/admin-columns/helpers.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }




vue__WEBPACK_IMPORTED_MODULE_2__["default"].use(vuex__WEBPACK_IMPORTED_MODULE_3__["default"]);
var state = {
  post_types: [],
  taxonomies: []
};
var mutations = {
  set_post_types: function set_post_types(state, _ref) {
    var post_types = _ref.post_types;
    state.post_types = post_types;
  },
  set_taxonomies: function set_taxonomies(state, _ref2) {
    var taxonomies = _ref2.taxonomies;
    state.taxonomies = taxonomies;
  }
};
var getters = {
  post_types: function post_types(state) {
    if (!Array.isArray(state.post_types) || !state.post_types.length) {
      return [];
    }

    return state.post_types.map(function (item) {
      if (!item.display_columns) {
        item.display_columns = [];
      }

      item.display_columns = item.display_columns.map(function (d_col) {
        delete d_col.forceOpen;
        return d_col;
      });
      return item;
    });
  },
  taxonomies: function taxonomies(state) {
    if (!Array.isArray(state.taxonomies) || !state.taxonomies.length) {
      return [];
    }

    return state.taxonomies.map(function (item) {
      if (!item.display_columns) {
        item.display_columns = [];
      }

      item.display_columns = item.display_columns.map(function (d_col) {
        delete d_col.forceOpen;
        return d_col;
      });
      return item;
    });
  },
  post_type_by_name: function post_type_by_name(state, getters) {
    return function (name) {
      return getters.post_types.find(function (post_type) {
        return post_type.name === name;
      });
    };
  },
  taxonomy_by_name: function taxonomy_by_name(state, getters) {
    return function (name) {
      return getters.taxonomies.find(function (taxonomy) {
        return taxonomy.name === name;
      });
    };
  }
};
var actions = {
  get_post_types: function get_post_types(_ref3) {
    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      var getters, commit, response;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              getters = _ref3.getters, commit = _ref3.commit;

              if (!getters.post_types.length) {
                _context.next = 3;
                break;
              }

              return _context.abrupt("return", getters.post_types);

            case 3:
              _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].triggerLoader();
              _context.next = 6;
              return _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].ajax('get_post_type_data');

            case 6:
              response = _context.sent;
              _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].triggerLoader(false);

              if (!(response && response.data && response.success)) {
                _context.next = 11;
                break;
              }

              commit('set_post_types', {
                post_types: response.data
              });
              return _context.abrupt("return", getters.post_types);

            case 11:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  get_taxonomies: function get_taxonomies(_ref4) {
    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
      var getters, commit, response;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              getters = _ref4.getters, commit = _ref4.commit;

              if (!getters.taxonomies.length) {
                _context2.next = 3;
                break;
              }

              return _context2.abrupt("return", getters.taxonomies);

            case 3:
              _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].triggerLoader();
              _context2.next = 6;
              return _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].ajax('get_taxonomy_data');

            case 6:
              response = _context2.sent;
              _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].triggerLoader(false);

              if (!(response && response.data && response.success)) {
                _context2.next = 11;
                break;
              }

              commit('set_taxonomies', {
                taxonomies: response.data
              });
              return _context2.abrupt("return", getters.taxonomies);

            case 11:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }))();
  },
  save_store: function save_store(_ref5, data) {
    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
      var commit, response;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              commit = _ref5.commit;
              _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].triggerLoader();
              _context3.next = 4;
              return _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].ajax('save_columns_data', data);

            case 4:
              response = _context3.sent;
              _helpers__WEBPACK_IMPORTED_MODULE_1__["default"].triggerLoader(false);

              if (response && response.data && response.success) {
                commit('set_post_types', {
                  post_types: response.data.post_types
                });
                commit('set_taxonomies', {
                  taxonomies: response.data.taxonomies
                });
              }

            case 7:
            case "end":
              return _context3.stop();
          }
        }
      }, _callee3);
    }))();
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (new vuex__WEBPACK_IMPORTED_MODULE_3__["default"].Store({
  state: state,
  mutations: mutations,
  getters: getters,
  actions: actions
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/app.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/app.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      post_types: [],
      taxonomies: [],
      popup_open: true,
      disable_save_btn: false,
      success_message: false,
      popup_title: "",
      popup_details: ""
    };
  },
  mounted: function mounted() {
    var _this = this;

    Window.Events.$on("AdminColumnsError", function (data) {
      _this.popup_title = data.title;
      _this.popup_details = data.content;

      _this.open_popup();
    });
    jQuery('body').on('click', function () {
      _this.success_message = false;
    });
  },
  methods: {
    open_popup: function open_popup() {
      jQuery("body").addClass("wp-adminify--popup-show");
      this.popup_open = true;
    },
    hide_popup: function hide_popup() {
      jQuery("body").removeClass("wp-adminify--popup-show");
      this.popup_open = false;
    },
    save_store: function save_store() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var post_types, taxonomies;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                post_types = _this2.post_types;
                taxonomies = _this2.taxonomies;
                _this2.disable_save_btn = true;
                _context.next = 5;
                return _this2.$store.dispatch("save_store", {
                  post_types: post_types,
                  taxonomies: taxonomies
                });

              case 5:
                _this2.disable_save_btn = false;
                _this2.success_message = true;
                setTimeout(function () {
                  _this2.success_message = false;
                }, 1500);

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue_range_slider__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-range-slider */ "./node_modules/vue-range-slider/dist/vue-range-slider.cjs.js");
/* harmony import */ var vue_range_slider__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_range_slider__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuedraggable */ "./node_modules/vuedraggable/dist/vuedraggable.umd.js");
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vuedraggable__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_range_slider_dist_vue_range_slider_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-range-slider/dist/vue-range-slider.css */ "./node_modules/vue-range-slider/dist/vue-range-slider.css");
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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      post_type: {},
      current: null,
      current_column: {},
      drag: false
    };
  },
  components: {
    RangeSlider: (vue_range_slider__WEBPACK_IMPORTED_MODULE_0___default()),
    draggable: (vuedraggable__WEBPACK_IMPORTED_MODULE_1___default())
  },
  mounted: function mounted() {
    this.current = this.$route.params.post_type;
    this.post_type = this.$store.getters.post_type_by_name(this.current);
  },
  computed: {
    dragOptions: function dragOptions() {
      return {
        animation: 150,
        group: "description",
        disabled: !this.isTypePro(),
        ghostClass: "ghost"
      };
    },
    fieldTypeKeys: function fieldTypeKeys() {
      var typedata = this.post_type.fields.find(function (field) {
        return field.id == 'type';
      }).options;
      var options = this.groupToOptions(typedata);
      return Object.keys(options);
    },
    displayColumnKeys: function displayColumnKeys() {
      return this.post_type.display_columns.map(function (column) {
        return column.name;
      });
    } // regularColumnsByGroups( groups = [] ) {
    //     return this.post_type.fields.filter()
    // }

  },
  methods: {
    groupToOptions: function groupToOptions(groups) {
      var data = {};
      groups.forEach(function (group) {
        if (group.group) {
          data = jQuery.extend({}, data, group.options);
        } else {
          data[group.name] = group.title;
        }
      });
      return data;
    },
    isTypePro: function isTypePro() {
      if (this.isPro()) return true;
      if (!this.post_type.is_pro) return true;
      return false;
    },
    editing: function editing(column) {
      if (!this.isTypePro()) return;
      this.current_column = this.nonReactive(column);
    },
    onSliderUnitChange: function onSliderUnitChange(column) {
      if (!this.isTypePro()) return;
      var max = this.getWidthMax(column.width.unit);
      if (column.width.value > max) column.width.value = max;
    },
    formatedWidthValue: function formatedWidthValue(width) {
      if (width == 0) return 'auto';
      return width;
    },
    getWidthMax: function getWidthMax(unit) {
      if (unit == '%') return 100;
      return 1000;
    },
    toggleAccordion: function toggleAccordion(event, column) {
      if (!this.isTypePro()) return;
      var $accordion = jQuery(event.target).closest('.admin-column-accordion').toggleClass('admin-column-accordion--open');
      var $body = $accordion.find('.accordion-body');

      if ($accordion.hasClass('admin-column-accordion--open')) {
        $body.slideDown(200, function () {
          column.forceOpen = true;
        });
      } else {
        $body.slideUp(200, function () {
          $accordion.removeClass('admin-column-accordion-force--open');
          delete column.forceOpen;
        });
      }
    },
    removeColumn: function removeColumn(event) {
      if (!this.isTypePro()) return;
      var index = jQuery(event.target).closest('.admin-column-accordion').index();
      if (index > -1) this.post_type.display_columns.splice(index, 1);
    },
    hasAddedAllFields: function hasAddedAllFields() {
      var _this = this;

      return this.fieldTypeKeys.every(function (field_key) {
        return _this.displayColumnKeys.includes(field_key);
      });
    },
    columnsExtraCheck: function columnsExtraCheck() {
      return {
        "function": 'function_name',
        shortcode: 'shortcode_name'
      };
    },
    changedType: function changedType(column) {
      if (!this.isTypePro()) return;
      var columnsExtraCheck = this.columnsExtraCheck();
      var columns = this.post_type.display_columns.filter(function (_column) {
        if (_column.name in columnsExtraCheck) {
          var _field = columnsExtraCheck[_column.name];
          return column.name == _column.name && _field in column && _field in _column && column[_field] == _column[_field];
        }

        return column.name == _column.name;
      });

      if (columns.length > 1) {
        if (column.name in columnsExtraCheck) {
          var _field = columnsExtraCheck[column.name];
          column[_field] = '';
        } else {
          column.name = this.current_column.name;
        }

        this.showError({
          title: "Can't change the column!",
          content: "This field is already in use, you can't use it twice"
        });
      }
    },
    getNonAddedColumnKeys: function getNonAddedColumnKeys() {
      var _this2 = this;

      return this.fieldTypeKeys.filter(function (field_key) {
        return !_this2.displayColumnKeys.includes(field_key);
      });
    },
    getNewDefaults: function getNewDefaults(columnKey) {
      if (!this.isTypePro()) return;
      var defaults = {
        forceOpen: true,
        label: this.post_type.columns[columnKey],
        name: columnKey,
        width: {
          unit: '%',
          value: 'auto'
        }
      };
      return defaults;
    },
    showError: function showError(data) {
      Window.Events.$emit('AdminColumnsError', data);
    },
    getAddableColumnKeys: function getAddableColumnKeys() {
      var extraKeys = Object.keys(this.columnsExtraCheck());
      return this.getNonAddedColumnKeys().filter(function (_key) {
        return !extraKeys.includes(_key);
      }).concat(extraKeys);
    },
    addNewColumn: function addNewColumn() {
      if (!this.isTypePro()) return;
      this.post_type.display_columns.push(this.getNewDefaults(this.getAddableColumnKeys()[0]));
    },
    cloneColumn: function cloneColumn(column) {
      if (!this.isTypePro()) return;
      var columnKey = column.name;

      if (!(columnKey in this.columnsExtraCheck())) {
        columnKey = this.getAddableColumnKeys()[0];
      }

      var newColumn = this.getNewDefaults(columnKey);
      newColumn.width = this.nonReactive(column.width);
      this.post_type.display_columns.push(newColumn);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      loading: false,
      post_types: [],
      post_type: null
    };
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.post_type = _this.$route.params.post_type;
              _context.next = 3;
              return _this.load_post_type_data();

            case 3:
              if (!_this.post_type && _this.post_types.length) {
                _this.$router.push("/post-types/".concat(_this.post_types[0].name));
              }

            case 4:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    load_post_type_data: function load_post_type_data() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this2.$store.dispatch('get_post_types');

              case 2:
                _this2.post_types = _context2.sent;

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    set_parent_data: function set_parent_data() {
      this.$parent.post_types = this.post_types;
    }
  },
  watch: {
    post_types: {
      deep: true,
      handler: function handler() {
        this.set_parent_data();
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      loading: false,
      taxonomies: [],
      taxonomy: null
    };
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.taxonomy = _this.$route.params.taxonomy;
              _context.next = 3;
              return _this.load_taxonomy_data();

            case 3:
              if (!_this.taxonomy && _this.taxonomies.length) {
                _this.$router.push("/taxonomies/".concat(_this.taxonomies[0].name));
              }

            case 4:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    load_taxonomy_data: function load_taxonomy_data() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this2.$store.dispatch('get_taxonomies');

              case 2:
                _this2.taxonomies = _context2.sent;

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    set_parent_data: function set_parent_data() {
      this.$parent.taxonomies = this.taxonomies;
    }
  },
  watch: {
    taxonomies: {
      deep: true,
      handler: function handler() {
        this.set_parent_data();
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue_range_slider__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-range-slider */ "./node_modules/vue-range-slider/dist/vue-range-slider.cjs.js");
/* harmony import */ var vue_range_slider__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_range_slider__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuedraggable */ "./node_modules/vuedraggable/dist/vuedraggable.umd.js");
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vuedraggable__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_range_slider_dist_vue_range_slider_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-range-slider/dist/vue-range-slider.css */ "./node_modules/vue-range-slider/dist/vue-range-slider.css");
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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      taxonomy: {},
      current: null,
      current_column: {},
      drag: false
    };
  },
  components: {
    RangeSlider: (vue_range_slider__WEBPACK_IMPORTED_MODULE_0___default()),
    draggable: (vuedraggable__WEBPACK_IMPORTED_MODULE_1___default())
  },
  mounted: function mounted() {
    this.current = this.$route.params.taxonomy;
    this.taxonomy = this.$store.getters.taxonomy_by_name(this.current);
  },
  computed: {
    dragOptions: function dragOptions() {
      return {
        animation: 150,
        group: "description",
        disabled: !this.isTaxPro(),
        ghostClass: "ghost"
      };
    },
    fieldTypeKeys: function fieldTypeKeys() {
      return Object.keys(this.taxonomy.fields.find(function (field) {
        return field.id == 'type';
      }).options);
    },
    displayColumnKeys: function displayColumnKeys() {
      return this.taxonomy.display_columns.map(function (column) {
        return column.name;
      });
    }
  },
  methods: {
    isTaxPro: function isTaxPro() {
      if (this.isPro()) return true;
      if (!this.taxonomy.is_pro) return true;
      return false;
    },
    editing: function editing(column) {
      if (!this.isTaxPro()) return;
      this.current_column = this.nonReactive(column);
    },
    changedType: function changedType(column) {
      if (!this.isTaxPro()) return;
      var keys = this.displayColumnKeys.filter(function (field_key) {
        return field_key == column.name;
      });

      if (keys.length > 1) {
        var label = jQuery(this.taxonomy.columns[column.name]).text(); // fix for HTML value

        if (!label) label = this.taxonomy.columns[column.name];
        if (this.current_column.name) column.name = this.current_column.name;
        this.showError({
          title: "Can't change the column!",
          content: "".concat(label, " is already in use, you can't use it twice")
        });
      }
    },
    onSliderUnitChange: function onSliderUnitChange(column) {
      if (!this.isTaxPro()) return;
      var max = this.getWidthMax(column.width.unit);
      if (column.width.value > max) column.width.value = max;
    },
    formatedWidthValue: function formatedWidthValue(width) {
      if (width == 0) return 'auto';
      return width;
    },
    getWidthMax: function getWidthMax(unit) {
      if (unit == '%') return 100;
      return 1000;
    },
    toggleAccordion: function toggleAccordion(event, column) {
      if (!this.isTaxPro()) return;
      var $accordion = jQuery(event.target).closest('.admin-column-accordion').toggleClass('admin-column-accordion--open');
      var $body = $accordion.find('.accordion-body');

      if ($accordion.hasClass('admin-column-accordion--open')) {
        $body.slideDown(200, function () {
          column.forceOpen = true;
        });
      } else {
        $body.slideUp(200, function () {
          $accordion.removeClass('admin-column-accordion-force--open');
          delete column.forceOpen;
        });
      }
    },
    removeColumn: function removeColumn(event) {
      if (!this.isTaxPro()) return;
      var index = jQuery(event.target).closest('.admin-column-accordion').index();
      if (index > -1) this.taxonomy.display_columns.splice(index, 1);
    },
    hasAddedAllFields: function hasAddedAllFields() {
      var _this = this;

      return this.fieldTypeKeys.every(function (field_key) {
        return _this.displayColumnKeys.includes(field_key);
      });
    },
    getNonAddedFieldKeys: function getNonAddedFieldKeys() {
      var _this2 = this;

      return this.fieldTypeKeys.filter(function (field_key) {
        return !_this2.displayColumnKeys.includes(field_key);
      });
    },
    getNewDefaults: function getNewDefaults(columnKey) {
      if (!this.isTaxPro()) return;
      return {
        forceOpen: true,
        fields: ['type', 'label', 'width'],
        label: this.taxonomy.columns[columnKey],
        name: columnKey,
        width: {
          unit: '%',
          value: 'auto'
        }
      };
    },
    showError: function showError(data) {
      Window.Events.$emit('AdminColumnsError', data);
    },
    addNewColumn: function addNewColumn() {
      if (!this.isTaxPro()) return;
      if (this.hasAddedAllFields()) return this.showError({
        title: "Can't add new column!",
        content: "All columns are added, you can't add new column"
      });
      var columnKey = this.getNonAddedFieldKeys()[0];
      var newColumn = this.getNewDefaults(columnKey);
      this.taxonomy.display_columns.push(newColumn);
    },
    cloneColumn: function cloneColumn(column) {
      if (!this.isTaxPro()) return;
      if (this.hasAddedAllFields()) return this.showError({
        title: "Can't clone column!",
        content: "All columns are added, you can't add new column"
      });
      var columnKey = this.getNonAddedFieldKeys()[0];
      var newColumn = this.getNewDefaults(columnKey);
      newColumn.width = this.nonReactive(column.width);
      this.taxonomy.display_columns.push(newColumn);
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/cssWithMappingToString.js */ "./node_modules/css-loader/dist/runtime/cssWithMappingToString.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.ghost {\n    opacity: 0.5;\n    background: #a7a7aa;\n}\n", "",{"version":3,"sources":["webpack://./dev/admin/modules/admin-columns/pages/post-type.vue"],"names":[],"mappings":";AAiXA;IACA,YAAA;IACA,mBAAA;AACA","sourcesContent":["<template>\n    <div class=\"tab-pane\" :id=\"post_type.name\">\n\n        <draggable v-model=\"post_type.display_columns\" v-bind=\"dragOptions\" @start=\"drag = true\" @end=\"drag = false\">\n\n            <div ref=\"accordion\" class=\"admin-column-accordion\" :class=\"column.forceOpen && 'admin-column-accordion-force--open admin-column-accordion--open'\" v-for=\"(column, colIndex) in post_type.display_columns\" :key=\"column.name + colIndex\">\n\n                <div class=\"accordion-title p-4 pr-6 mr-6\">\n\n                    <svg class=\"drag-icon is-pulled-left is-clickable mr-2\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n                        <path d=\"M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                    </svg>\n\n                    <div class=\"accordion-type-title\">\n                        <span class=\"admin-column-name\" v-html=\"column.label\"></span>\n                        <div class=\"accordion-actions\">\n                            <a href=\"#\" class=\"edit-button\" @click.prevent=\"toggleAccordion( $event, column )\">Edit</a>\n                            <a href=\"#\" class=\"remove-button\" @click.prevent=\"removeColumn\">Remove</a>\n                        </div>\n                        <span class=\"accordion-type is-pulled-right\">{{ post_type.title }}</span>\n                    </div>\n\n                    <div class=\"accordion-helper\">\n                        <button class=\"helper-button accordion-clone\" @click=\"cloneColumn(column)\"><i class=\"ti-layers\"></i></button>\n                        <button class=\"helper-button accordion-remove\" @click=\"removeColumn\"><i class=\"ti-close\"></i></button>\n                        <button class=\"helper-button accordion-toggler\"><i class=\"ti-angle-down\"></i></button>\n                    </div>\n\n                </div>\n\n                <div class=\"accordion-opener\" @click=\"toggleAccordion( $event, column )\"></div>\n\n                <div class=\"accordion-body\">\n\n                    <template v-for=\"(field, key) in post_type.fields\">\n\n                        <div class=\"inner-content content-type\" :key=\"key\" v-if=\"field.id == 'type'\">\n                            <div class=\"columns\">\n\n                                <div class=\"column is-4\">\n                                    <label :for=\"`content-${colIndex}-${column.name}-${field.id}`\">{{ field.title }}</label>\n                                </div>\n                                <div class=\"column\">\n                                    <select :name=\"`content-${colIndex}-${column.name}-${field.id}`\" class=\"select-type\" :placeholder=\"field.placeholder\" v-model=\"column.name\" @focus=\"editing(column)\" @change=\"changedType(column)\">\n                                        <template v-for=\"(parent_option, parent_option_key) in field.options\">\n\n                                            <optgroup v-if=\"parent_option.group\" :label=\"parent_option.group\" :key=\"parent_option_key\">\n                                                <option v-for=\"(option, option_val) in parent_option.options\" :key=\"option_val\" :value=\"option_val\" :selected=\"option_val == column.name\">{{option}}</option>\n                                            </optgroup>\n\n                                            <option v-else :key=\"parent_option.name\" :value=\"parent_option.name\" :selected=\"parent_option.name == column.name\">{{parent_option.title}}</option>\n\n                                        </template>\n                                    </select>\n                                </div>\n\n                            </div>\n                        </div>\n\n                        <div class=\"inner-content content-type\" :key=\"key\" v-if=\"field.id == 'function_name' && column.name == 'function'\">\n                            <div class=\"columns\">\n\n                                <div class=\"column is-4\">\n                                    <label :for=\"`content-${colIndex}-${column.name}-${field.id}`\">{{ field.title }}</label>\n                                </div>\n                                <div class=\"column\">\n                                    <input :name=\"`content-${colIndex}-${column.name}-${field.id}`\" type=\"text\" :placeholder=\"field.placeholder\" v-model=\"column.function_name\" @change=\"changedType(column)\">\n                                </div>\n\n                            </div>\n                        </div>\n\n                        <div class=\"inner-content content-type\" :key=\"key\" v-if=\"field.id == 'shortcode_name' && column.name == 'shortcode'\">\n                            <div class=\"columns\">\n\n                                <div class=\"column is-4\">\n                                    <label :for=\"`content-${colIndex}-${column.name}-${field.id}`\">{{ field.title }}</label>\n                                </div>\n                                <div class=\"column\">\n                                    <input :name=\"`content-${colIndex}-${column.name}-${field.id}`\" type=\"text\" :placeholder=\"field.placeholder\" v-model=\"column.shortcode_name\" @change=\"changedType(column)\">\n                                </div>\n\n                            </div>\n                        </div>\n\n                        <div class=\"inner-content content-type\" :key=\"key\" v-if=\"field.id == 'label'\">\n                            <div class=\"columns\">\n                                \n                                <div class=\"column is-4\">\n                                    <label :for=\"`content-${colIndex}-${column.name}-${field.id}`\">{{ field.title }}</label>\n                                </div>\n                                <div class=\"column\">\n                                    <input :name=\"`content-${colIndex}-${column.name}-${field.id}`\" type=\"text\" :placeholder=\"field.placeholder\" v-model=\"column.label\">\n                                </div>\n\n                            </div>\n                        </div>\n\n                        <div class=\"inner-content content-type\" :key=\"key\" v-if=\"field.id == 'width'\">\n                            <div class=\"columns\">\n                                \n                                <div class=\"column is-4\">\n                                    <label :for=\"`content-${colIndex}-${column.name}-${field.id}`\">{{ field.title }}</label>\n                                </div>\n                                <div class=\"column\">\n\n                                    <div class=\"range-slider-wrapper\">\n                                        <input type=\"text\" class=\"range-value\" :value=\"formatedWidthValue(column.width.value)\" readonly>\n                                        <range-slider class=\"slider\" v-model=\"column.width.value\" :min=\"0\" :max=\"getWidthMax(column.width.unit)\"></range-slider>\n                                    </div>\n\n                                    <div class=\"unit-labels\">\n                                        <label class=\"range-width-unit\">\n                                            <input :name=\"`content-${colIndex}-${column.name}-${field.id}`\" @change=\"onSliderUnitChange(column)\" class=\"range-width-unit-%\" type=\"radio\"  value=\"%\" v-model=\"column.width.unit\" :checked=\"column.width.unit == '%' \">%\n                                        </label>\n                                        <label class=\"range-width-unit\">\n                                            <input :name=\"`content-${colIndex}-${column.name}-${field.id}`\" @change=\"onSliderUnitChange(column)\" class=\"range-width-unit-px\" type=\"radio\" value=\"px\" v-model=\"column.width.unit\" :checked=\"column.width.unit == 'px' \">px\n                                        </label>\n                                    </div>\n\n                                </div>\n\n                            </div>\n                        </div>\n\n                    </template>\n\n                </div>\n\n            </div>\n\n        </draggable>\n\n        <div class=\"columns is-desktop is-justify-content-flex-end\">\n            <button class=\"wp-adminify-add-button is-clickable is-pulled-right\" @click=\"addNewColumn\">Add new</button>\n        </div>\n\n        <div class=\"admin-column--pro-guard\" v-if=\"!isTypePro()\" v-html=\"proNotice()\"></div>\n\n    </div>\n</template>\n\n<script>\n\nimport RangeSlider from 'vue-range-slider'\nimport draggable from 'vuedraggable'\nimport 'vue-range-slider/dist/vue-range-slider.css'\n\nexport default {\n    \n    data: () => ({\n        post_type: {},\n        current: null,\n        current_column: {},\n        drag: false\n    }),\n\n    components: {\n        RangeSlider,\n        draggable\n    },\n\n    mounted() {\n        this.current = this.$route.params.post_type;\n        this.post_type = this.$store.getters.post_type_by_name( this.current );\n    },\n\n    computed: {\n        \n        dragOptions() {\n            return {\n                animation: 150,\n                group: \"description\",\n                disabled: ! this.isTypePro(),\n                ghostClass: \"ghost\"\n            };\n        },\n\n        fieldTypeKeys() {\n            let typedata = this.post_type.fields.find( field => field.id == 'type' ).options;\n            let options = this.groupToOptions( typedata );\n            return Object.keys( options );\n        },\n\n        displayColumnKeys() {\n            return this.post_type.display_columns.map( column => column.name );\n        },\n\n        // regularColumnsByGroups( groups = [] ) {\n        //     return this.post_type.fields.filter()\n        // }\n\n    },\n\n    methods: {\n\n        groupToOptions( groups ) {\n            let data = {};\n            groups.forEach( group => {\n                if ( group.group ) {\n                    data = jQuery.extend( {}, data, group.options );\n                } else {\n                    data[group.name] = group.title;\n                }\n            });\n            return data;\n        },\n\n        isTypePro() {\n            if ( this.isPro() ) return true;\n            if ( ! this.post_type.is_pro ) return true;\n            return false;\n        },\n\n        editing( column ) {\n            if ( ! this.isTypePro() ) return;\n            this.current_column = this.nonReactive( column );\n        },\n\n        onSliderUnitChange( column ) {\n            if ( ! this.isTypePro() ) return;\n            let max = this.getWidthMax( column.width.unit );\n            if ( column.width.value > max ) column.width.value = max;\n        },\n\n        formatedWidthValue( width ) {\n            if ( width == 0 ) return 'auto';\n            return width;\n        },\n\n        getWidthMax( unit ) {\n            if ( unit == '%' ) return 100;\n            return 1000;\n        },\n\n        toggleAccordion( event, column ) {\n\n            if ( ! this.isTypePro() ) return;\n\n            let $accordion = jQuery( event.target ).closest('.admin-column-accordion').toggleClass('admin-column-accordion--open');\n            let $body = $accordion.find('.accordion-body');\n\n            if ( $accordion.hasClass('admin-column-accordion--open') ) {\n                $body.slideDown(200, () => {\n                    column.forceOpen = true;\n                });\n            } else {\n                $body.slideUp(200, () => {\n                    $accordion.removeClass('admin-column-accordion-force--open');\n                    delete column.forceOpen;\n                });\n            }\n\n        },\n\n        removeColumn( event ) {\n            \n            if ( ! this.isTypePro() ) return;\n\n            let index = jQuery( event.target ).closest('.admin-column-accordion').index();\n\n            if ( index > -1 ) this.post_type.display_columns.splice( index, 1 );\n\n        },\n\n        hasAddedAllFields() {\n            return this.fieldTypeKeys.every( field_key => this.displayColumnKeys.includes(field_key) );\n        },\n\n        columnsExtraCheck() {\n            return {\n                function: 'function_name',\n                shortcode: 'shortcode_name'\n            };\n        },\n\n        changedType( column ) {\n\n            if ( ! this.isTypePro() ) return;\n\n            let columnsExtraCheck = this.columnsExtraCheck();\n\n            let columns = this.post_type.display_columns.filter( _column => {\n                if ( _column.name in columnsExtraCheck ) {\n                    let _field = columnsExtraCheck[ _column.name ];\n                    return ( column.name == _column.name && _field in column && _field in _column && column[_field] == _column[_field] );\n                }\n                return column.name == _column.name;\n            });\n\n            if ( columns.length > 1 ) {\n\n                if ( column.name in columnsExtraCheck ) {\n                    let _field = columnsExtraCheck[ column.name ];\n                    column[ _field ] = '';\n                } else {\n                    column.name = this.current_column.name;\n                }\n\n                this.showError({\n                    title: `Can't change the column!`,\n                    content: `This field is already in use, you can't use it twice`\n                });\n\n            }\n        },\n\n        getNonAddedColumnKeys() {\n            return this.fieldTypeKeys.filter( field_key => ! this.displayColumnKeys.includes(field_key) );\n        },\n\n        getNewDefaults( columnKey ) {\n\n            if ( ! this.isTypePro() ) return;\n\n            let defaults = {\n                forceOpen: true,\n                label: this.post_type.columns[columnKey],\n                name: columnKey,\n                width: {\n                    unit: '%',\n                    value: 'auto'\n                }\n            }\n\n            return defaults;\n\n        },\n\n        showError( data ) {\n            Window.Events.$emit( 'AdminColumnsError', data );\n        },\n\n        getAddableColumnKeys() {\n            let extraKeys = Object.keys( this.columnsExtraCheck() );\n            return this.getNonAddedColumnKeys().filter( _key => ! extraKeys.includes(_key) ).concat( extraKeys );\n        },\n\n        addNewColumn() {\n            if ( ! this.isTypePro() ) return;\n            this.post_type.display_columns.push( this.getNewDefaults( this.getAddableColumnKeys()[0] ) );\n        },\n\n        cloneColumn( column ) {\n            if ( ! this.isTypePro() ) return;\n\n            let columnKey = column.name;\n            if ( ! (columnKey in this.columnsExtraCheck()) ) {\n                columnKey = this.getAddableColumnKeys()[0];\n            }\n            let newColumn = this.getNewDefaults( columnKey );\n            newColumn.width = this.nonReactive( column.width );\n            this.post_type.display_columns.push( newColumn );\n        }\n\n    }\n\n}\n</script>\n\n<style>\n    .ghost {\n        opacity: 0.5;\n        background: #a7a7aa;\n    }\n</style>"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/cssWithMappingToString.js */ "./node_modules/css-loader/dist/runtime/cssWithMappingToString.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.taxonomy-post-type {\n    text-align: right;\n    text-transform: capitalize;\n    opacity: .5;\n    font-size: .8em;\n    letter-spacing: .3px;\n    font-weight: bold;\n    -webkit-box-flex: 1;\n    -webkit-flex: auto;\n        -ms-flex: auto;\n            flex: auto;\n}\n", "",{"version":3,"sources":["webpack://./dev/admin/modules/admin-columns/pages/taxonomies.vue"],"names":[],"mappings":";AA+EA;IACA,iBAAA;IACA,0BAAA;IACA,WAAA;IACA,eAAA;IACA,oBAAA;IACA,iBAAA;IACA,mBAAA;IAAA,kBAAA;QAAA,cAAA;YAAA,UAAA;AACA","sourcesContent":["<template>\n    <div class=\"tab-pane\" id=\"taxonomies\">\n        <div class=\"columns\">\n            \n            <div class=\"column is-4\">\n                <div class=\"tabs is-boxed\">\n                    <ul class=\"nav-tabs is-flex is-flex-direction-column is-align-items-flex-start\">\n\n                        <router-link v-for=\"(taxonomy_data) in taxonomies\" :key=\"taxonomy_data.name\" :to='\"/taxonomies/\" + taxonomy_data.name' v-slot=\"{ navigate, isActive }\" custom exact>\n                            <li class=\"nav-item\" @click=\"navigate\" @keypress.enter=\"navigate\" role=\"link\" :class=\"[isActive && 'router-link-active']\">\n                                <a class=\"nav-link is-clickable\" :class=\"[taxonomy == taxonomy_data.name && 'active']\" href=\"javascript:void(0);\">\n                                    <span class=\"icon is-small\"><i class=\"dashicons dashicons-edit-page\"></i></span>\n                                    <span>{{taxonomy_data.title}}</span>\n                                    <span v-if=\"! isPro() && taxonomy_data.is_pro\" class=\"adminify-column-post--pro\" style=\"margin-left: 4px;\">- (Pro)</span>\n                                    <span class=\"taxonomy-post-type\" v-if=\"taxonomy_data.object_type\">[{{taxonomy_data.object_type}}]</span>\n                                </a>\n                            </li>\n                        </router-link>\n\n                    </ul>\n                </div>\n            </div>\n\n            <div class=\"column\">\n                <div class=\"tab-content tab-panel pane\">\n                    <router-view :key=\"$route.fullPath\" v-if=\"taxonomies.length\"></router-view>\n                </div>\n            </div>\n\n        </div>\n    </div>\n</template>\n\n<script>\nexport default {\n\n    data: () => ({\n        loading: false,\n        taxonomies: [],\n        taxonomy: null\n    }),\n\n    async mounted() {\n\n        this.taxonomy = this.$route.params.taxonomy;\n\n        await this.load_taxonomy_data();\n\n        if ( ! this.taxonomy && this.taxonomies.length ) {\n            this.$router.push( `/taxonomies/${this.taxonomies[0].name}` );\n        }\n\n    },\n\n    methods: {\n\n        async load_taxonomy_data() {\n            this.taxonomies = await this.$store.dispatch( 'get_taxonomies' );\n        },\n\n        set_parent_data() {\n            this.$parent.taxonomies = this.taxonomies;\n        }\n\n    },\n\n    watch: {\n        taxonomies: {\n            deep: true,\n            handler() {\n                this.set_parent_data()\n            }\n        }\n    }\n\n}\n</script>\n\n<style>\n    .taxonomy-post-type {\n        text-align: right;\n        text-transform: capitalize;\n        opacity: .5;\n        font-size: .8em;\n        letter-spacing: .3px;\n        font-weight: bold;\n        flex: auto;\n    }\n</style>"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/cssWithMappingToString.js */ "./node_modules/css-loader/dist/runtime/cssWithMappingToString.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.ghost {\n    opacity: 0.5;\n    background: #a7a7aa;\n}\n", "",{"version":3,"sources":["webpack://./dev/admin/modules/admin-columns/pages/taxonomy.vue"],"names":[],"mappings":";AAkSA;IACA,YAAA;IACA,mBAAA;AACA","sourcesContent":["<template>\n    <div class=\"tab-pane\" :id=\"taxonomy.name\">\n\n        <draggable v-model=\"taxonomy.display_columns\" v-bind=\"dragOptions\" @start=\"drag = true\" @end=\"drag = false\">\n\n            <div ref=\"accordion\" class=\"admin-column-accordion\" :class=\"column.forceOpen && 'admin-column-accordion-force--open admin-column-accordion--open'\" v-for=\"(column, colIndex) in taxonomy.display_columns\" :key=\"column.name + colIndex\">\n\n                <div class=\"accordion-title p-4 pr-6 mr-6\">\n\n                    <svg class=\"drag-icon is-pulled-left is-clickable mr-2\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n                        <path d=\"M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                        <path d=\"M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z\" fill=\"#4E4B66\" fill-opacity=\"0.72\" />\n                    </svg>\n\n                    <div class=\"accordion-type-title\">\n                        <span class=\"admin-column-name\" v-html=\"column.label\"></span>\n                        <div class=\"accordion-actions\">\n                            <a href=\"#\" class=\"edit-button\" @click.prevent=\"toggleAccordion( $event, column )\">Edit</a>\n                            <a href=\"#\" class=\"remove-button\" @click.prevent=\"removeColumn\">Remove</a>\n                        </div>\n                        <span class=\"accordion-type is-pulled-right\">{{ taxonomy.title }}</span>\n                    </div>\n\n                    <div class=\"accordion-helper\">\n                        <button class=\"helper-button accordion-clone\" @click=\"cloneColumn(column)\"><i class=\"ti-layers\"></i></button>\n                        <button class=\"helper-button accordion-remove\" @click=\"removeColumn\"><i class=\"ti-close\"></i></button>\n                        <button class=\"helper-button accordion-toggler\"><i class=\"ti-angle-down\"></i></button>\n                    </div>\n\n                </div>\n\n                <div class=\"accordion-opener\" @click=\"toggleAccordion( $event, column )\"></div>\n\n                <div class=\"accordion-body\">\n\n                    <template v-for=\"(field, key) in taxonomy.fields\">\n\n                        <div class=\"inner-content content-type\" :key=\"key\" v-if=\"column.fields.includes(field.id)\">\n                            <div class=\"columns\">\n\n                                <div class=\"column is-4\">\n                                    <label :for=\"`content-${colIndex}-${column.name}-${field.id}`\">{{ field.title }}</label>\n                                </div>\n\n                                <div class=\"column\" v-if=\"field.type == 'select'\">\n                                    <select :name=\"`content-${colIndex}-${column.name}-${field.id}`\" class=\"select-type\" :placeholder=\"field.placeholder\" v-model=\"column.name\" @focus=\"editing(column)\" @change=\"changedType(column)\">\n                                        <!-- <optgroup label=\"Default\"></optgroup> -->\n                                        <option v-for=\"(option, option_val) in field.options\" :key=\"option_val\" :value=\"option_val\" :selected=\"option_val == column.name\">{{option}}</option>\n                                    </select>\n                                </div>\n\n                                <div class=\"column\" v-if=\"field.type == 'text'\">\n                                    <input :name=\"`content-${colIndex}-${column.name}-${field.id}`\" type=\"text\" :placeholder=\"field.placeholder\" v-model=\"column.label\">\n                                </div>\n\n                                <div class=\"column\" v-if=\"field.type == 'slider'\">\n\n                                    <div class=\"range-slider-wrapper\">\n                                        <input type=\"text\" class=\"range-value\" :value=\"formatedWidthValue(column.width.value)\" readonly>\n                                        <range-slider class=\"slider\" v-model=\"column.width.value\" :min=\"0\" :max=\"getWidthMax(column.width.unit)\"></range-slider>\n                                    </div>\n\n                                    <div class=\"unit-labels\">\n                                        <label class=\"range-width-unit\">\n                                            <input :name=\"`content-${colIndex}-${column.name}-${field.id}`\" @change=\"onSliderUnitChange(column)\" class=\"range-width-unit-%\" type=\"radio\"  value=\"%\" v-model=\"column.width.unit\" :checked=\"column.width.unit == '%' \">%\n                                        </label>\n                                        <label class=\"range-width-unit\">\n                                            <input :name=\"`content-${colIndex}-${column.name}-${field.id}`\" @change=\"onSliderUnitChange(column)\" class=\"range-width-unit-px\" type=\"radio\" value=\"px\" v-model=\"column.width.unit\" :checked=\"column.width.unit == 'px' \">px\n                                        </label>\n                                    </div>\n\n                                </div>\n\n                            </div>\n                        </div>\n\n                    </template>\n\n                </div>\n\n            </div>\n\n        </draggable>\n\n        <div class=\"columns is-desktop is-justify-content-flex-end\">\n            <button class=\"wp-adminify-add-button is-clickable is-pulled-right\" @click=\"addNewColumn\">Add new</button>\n        </div>\n\n        <div class=\"admin-column--pro-guard\" v-if=\"!isTaxPro()\" v-html=\"proNotice()\"></div>\n\n    </div>\n</template>\n\n<script>\n\nimport RangeSlider from 'vue-range-slider'\nimport draggable from 'vuedraggable'\nimport 'vue-range-slider/dist/vue-range-slider.css'\n\nexport default {\n    \n    data: () => ({\n        taxonomy: {},\n        current: null,\n        current_column: {},\n        drag: false\n    }),\n\n    components: {\n        RangeSlider,\n        draggable\n    },\n\n    mounted() {\n        this.current = this.$route.params.taxonomy;\n        this.taxonomy = this.$store.getters.taxonomy_by_name( this.current );\n    },\n\n    computed: {\n        \n        dragOptions() {\n            return {\n                animation: 150,\n                group: \"description\",\n                disabled: ! this.isTaxPro(),\n                ghostClass: \"ghost\"\n            };\n        },\n\n        fieldTypeKeys() {\n            return Object.keys( this.taxonomy.fields.find( field => field.id == 'type' ).options );\n        },\n\n        displayColumnKeys() {\n            return this.taxonomy.display_columns.map( column => column.name );\n        }\n\n    },\n\n    methods: {\n\n        isTaxPro() {\n            if ( this.isPro() ) return true;\n            if ( ! this.taxonomy.is_pro ) return true;\n            return false;\n        },\n\n        editing( column ) {\n            if ( ! this.isTaxPro() ) return;\n            this.current_column = this.nonReactive( column );\n        },\n\n        changedType( column ) {\n\n            if ( ! this.isTaxPro() ) return;\n\n            let keys = this.displayColumnKeys.filter( field_key => field_key == column.name );\n\n            if ( keys.length > 1 ) {\n                \n                let label = jQuery( this.taxonomy.columns[column.name] ).text(); // fix for HTML value\n                if ( ! label ) label = this.taxonomy.columns[column.name];\n\n                if ( this.current_column.name ) column.name = this.current_column.name;\n\n                this.showError({\n                    title: `Can't change the column!`,\n                    content: `${label} is already in use, you can't use it twice`\n                });\n\n            }\n        },\n\n        onSliderUnitChange( column ) {\n            if ( ! this.isTaxPro() ) return;\n            let max = this.getWidthMax( column.width.unit );\n            if ( column.width.value > max ) column.width.value = max;\n        },\n\n        formatedWidthValue( width ) {\n            if ( width == 0 ) return 'auto';\n            return width;\n        },\n\n        getWidthMax( unit ) {\n            if ( unit == '%' ) return 100;\n            return 1000;\n        },\n\n        toggleAccordion( event, column ) {\n\n            if ( ! this.isTaxPro() ) return;\n\n            let $accordion = jQuery( event.target ).closest('.admin-column-accordion').toggleClass('admin-column-accordion--open');\n            let $body = $accordion.find('.accordion-body');\n\n            if ( $accordion.hasClass('admin-column-accordion--open') ) {\n                $body.slideDown(200, () => {\n                    column.forceOpen = true;\n                });\n            } else {\n                $body.slideUp(200, () => {\n                    $accordion.removeClass('admin-column-accordion-force--open');\n                    delete column.forceOpen;\n                });\n            }\n\n        },\n\n        removeColumn( event ) {\n\n            if ( ! this.isTaxPro() ) return;\n\n            let index = jQuery( event.target ).closest('.admin-column-accordion').index();\n\n            if ( index > -1 ) this.taxonomy.display_columns.splice( index, 1 );\n\n        },\n\n        hasAddedAllFields() {\n            return this.fieldTypeKeys.every( field_key => this.displayColumnKeys.includes(field_key) );\n        },\n\n        getNonAddedFieldKeys() {\n            return this.fieldTypeKeys.filter( field_key => ! this.displayColumnKeys.includes(field_key) );\n        },\n\n        getNewDefaults( columnKey ) {\n\n            if ( ! this.isTaxPro() ) return;\n\n            return {\n                forceOpen: true,\n                fields: ['type', 'label', 'width'],\n                label: this.taxonomy.columns[columnKey],\n                name: columnKey,\n                width: {\n                    unit: '%',\n                    value: 'auto'\n                }\n            }\n\n        },\n        \n        showError( data ) {\n            Window.Events.$emit( 'AdminColumnsError', data );\n        },\n\n        addNewColumn() {\n\n            if ( ! this.isTaxPro() ) return;\n            \n            if ( this.hasAddedAllFields() ) return this.showError({\n                title: `Can't add new column!`,\n                content: `All columns are added, you can't add new column`\n            });\n\n            let columnKey = this.getNonAddedFieldKeys()[0];\n            let newColumn = this.getNewDefaults( columnKey );\n            this.taxonomy.display_columns.push( newColumn );\n        },\n\n        cloneColumn( column ) {\n\n            if ( ! this.isTaxPro() ) return;\n            \n            if ( this.hasAddedAllFields() ) return this.showError({\n                title: `Can't clone column!`,\n                content: `All columns are added, you can't add new column`\n            });\n            \n            let columnKey = this.getNonAddedFieldKeys()[0];\n            let newColumn = this.getNewDefaults( columnKey );\n            newColumn.width = this.nonReactive( column.width );\n            this.taxonomy.display_columns.push( newColumn );\n        }\n\n    }\n\n}\n</script>\n\n<style>\n    .ghost {\n        opacity: 0.5;\n        background: #a7a7aa;\n    }\n</style>"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./post-type.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./taxonomies.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./taxonomy.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./dev/admin/modules/admin-columns/app.vue":
/*!*************************************************!*\
  !*** ./dev/admin/modules/admin-columns/app.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _app_vue_vue_type_template_id_ae7b9ede___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./app.vue?vue&type=template&id=ae7b9ede& */ "./dev/admin/modules/admin-columns/app.vue?vue&type=template&id=ae7b9ede&");
/* harmony import */ var _app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./app.vue?vue&type=script&lang=js& */ "./dev/admin/modules/admin-columns/app.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _app_vue_vue_type_template_id_ae7b9ede___WEBPACK_IMPORTED_MODULE_0__.render,
  _app_vue_vue_type_template_id_ae7b9ede___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/admin-columns/app.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/admin-columns/components/post-types-sidebar.vue":
/*!***************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/components/post-types-sidebar.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _post_types_sidebar_vue_vue_type_template_id_4f19e224___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./post-types-sidebar.vue?vue&type=template&id=4f19e224& */ "./dev/admin/modules/admin-columns/components/post-types-sidebar.vue?vue&type=template&id=4f19e224&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

var script = {}


/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  script,
  _post_types_sidebar_vue_vue_type_template_id_4f19e224___WEBPACK_IMPORTED_MODULE_0__.render,
  _post_types_sidebar_vue_vue_type_template_id_4f19e224___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/admin-columns/components/post-types-sidebar.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/post-type.vue":
/*!*************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/post-type.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _post_type_vue_vue_type_template_id_adce0ea8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./post-type.vue?vue&type=template&id=adce0ea8& */ "./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=template&id=adce0ea8&");
/* harmony import */ var _post_type_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./post-type.vue?vue&type=script&lang=js& */ "./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=script&lang=js&");
/* harmony import */ var _post_type_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./post-type.vue?vue&type=style&index=0&lang=css& */ "./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _post_type_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _post_type_vue_vue_type_template_id_adce0ea8___WEBPACK_IMPORTED_MODULE_0__.render,
  _post_type_vue_vue_type_template_id_adce0ea8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/admin-columns/pages/post-type.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/post-types.vue":
/*!**************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/post-types.vue ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _post_types_vue_vue_type_template_id_7db1bdf7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./post-types.vue?vue&type=template&id=7db1bdf7& */ "./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=template&id=7db1bdf7&");
/* harmony import */ var _post_types_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./post-types.vue?vue&type=script&lang=js& */ "./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _post_types_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _post_types_vue_vue_type_template_id_7db1bdf7___WEBPACK_IMPORTED_MODULE_0__.render,
  _post_types_vue_vue_type_template_id_7db1bdf7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/admin-columns/pages/post-types.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/taxonomies.vue":
/*!**************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/taxonomies.vue ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _taxonomies_vue_vue_type_template_id_08751b1a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./taxonomies.vue?vue&type=template&id=08751b1a& */ "./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=template&id=08751b1a&");
/* harmony import */ var _taxonomies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./taxonomies.vue?vue&type=script&lang=js& */ "./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=script&lang=js&");
/* harmony import */ var _taxonomies_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./taxonomies.vue?vue&type=style&index=0&lang=css& */ "./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _taxonomies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _taxonomies_vue_vue_type_template_id_08751b1a___WEBPACK_IMPORTED_MODULE_0__.render,
  _taxonomies_vue_vue_type_template_id_08751b1a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/admin-columns/pages/taxonomies.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/taxonomy.vue":
/*!************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/taxonomy.vue ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _taxonomy_vue_vue_type_template_id_c1699b08___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./taxonomy.vue?vue&type=template&id=c1699b08& */ "./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=template&id=c1699b08&");
/* harmony import */ var _taxonomy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./taxonomy.vue?vue&type=script&lang=js& */ "./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=script&lang=js&");
/* harmony import */ var _taxonomy_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./taxonomy.vue?vue&type=style&index=0&lang=css& */ "./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _taxonomy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _taxonomy_vue_vue_type_template_id_c1699b08___WEBPACK_IMPORTED_MODULE_0__.render,
  _taxonomy_vue_vue_type_template_id_c1699b08___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/admin-columns/pages/taxonomy.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/admin-columns/app.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/app.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./app.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/app.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./post-type.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_post_types_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./post-types.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_post_types_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./taxonomies.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./taxonomy.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./post-type.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css&":
/*!***********************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./taxonomies.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css&":
/*!*********************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./taxonomy.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./dev/admin/modules/admin-columns/app.vue?vue&type=template&id=ae7b9ede&":
/*!********************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/app.vue?vue&type=template&id=ae7b9ede& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_template_id_ae7b9ede___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_template_id_ae7b9ede___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_app_vue_vue_type_template_id_ae7b9ede___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./app.vue?vue&type=template&id=ae7b9ede& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/app.vue?vue&type=template&id=ae7b9ede&");


/***/ }),

/***/ "./dev/admin/modules/admin-columns/components/post-types-sidebar.vue?vue&type=template&id=4f19e224&":
/*!**********************************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/components/post-types-sidebar.vue?vue&type=template&id=4f19e224& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_types_sidebar_vue_vue_type_template_id_4f19e224___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_types_sidebar_vue_vue_type_template_id_4f19e224___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_types_sidebar_vue_vue_type_template_id_4f19e224___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./post-types-sidebar.vue?vue&type=template&id=4f19e224& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/components/post-types-sidebar.vue?vue&type=template&id=4f19e224&");


/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=template&id=adce0ea8&":
/*!********************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=template&id=adce0ea8& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_template_id_adce0ea8___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_template_id_adce0ea8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_type_vue_vue_type_template_id_adce0ea8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./post-type.vue?vue&type=template&id=adce0ea8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=template&id=adce0ea8&");


/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=template&id=7db1bdf7&":
/*!*********************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=template&id=7db1bdf7& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_types_vue_vue_type_template_id_7db1bdf7___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_types_vue_vue_type_template_id_7db1bdf7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_post_types_vue_vue_type_template_id_7db1bdf7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./post-types.vue?vue&type=template&id=7db1bdf7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=template&id=7db1bdf7&");


/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=template&id=08751b1a&":
/*!*********************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=template&id=08751b1a& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_template_id_08751b1a___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_template_id_08751b1a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomies_vue_vue_type_template_id_08751b1a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./taxonomies.vue?vue&type=template&id=08751b1a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=template&id=08751b1a&");


/***/ }),

/***/ "./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=template&id=c1699b08&":
/*!*******************************************************************************************!*\
  !*** ./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=template&id=c1699b08& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_template_id_c1699b08___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_template_id_c1699b08___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_taxonomy_vue_vue_type_template_id_c1699b08___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./taxonomy.vue?vue&type=template&id=c1699b08& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=template&id=c1699b08&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/app.vue?vue&type=template&id=ae7b9ede&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/app.vue?vue&type=template&id=ae7b9ede& ***!
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
  return _c("div", { attrs: { id: "wpadminify-admin-columns" } }, [
    _vm.success_message
      ? _c("div", { staticClass: "admin-column--message" }, [
          _vm._v("Settings has been saved")
        ])
      : _vm._e(),
    _vm._v(" "),
    _c("div", { staticClass: "tabs is-boxed is-centered" }, [
      _c(
        "ul",
        { staticClass: "nav-tabs", attrs: { role: "tablist" } },
        [
          _c("router-link", {
            attrs: { to: "/post-types", custom: "" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var navigate = ref.navigate
                  var isActive = ref.isActive
                  return [
                    _c(
                      "li",
                      {
                        staticClass: "nav-item",
                        class: [isActive && "router-link-active"],
                        attrs: { id: "analyze-tab", role: "link" },
                        on: {
                          click: navigate,
                          keypress: function($event) {
                            if (
                              !$event.type.indexOf("key") &&
                              _vm._k(
                                $event.keyCode,
                                "enter",
                                13,
                                $event.key,
                                "Enter"
                              )
                            ) {
                              return null
                            }
                            return navigate.apply(null, arguments)
                          }
                        }
                      },
                      [
                        _c(
                          "a",
                          {
                            staticClass: "nav-link is-clickable",
                            class: [isActive && "active"],
                            attrs: { href: "javascript:void(0);" }
                          },
                          [
                            _c("span", { staticClass: "icon is-small" }, [
                              _c("i", {
                                staticClass: "dashicons dashicons-edit-page"
                              })
                            ]),
                            _vm._v(" "),
                            _c("span", [_vm._v("Post Types")])
                          ]
                        )
                      ]
                    )
                  ]
                }
              }
            ])
          }),
          _vm._v(" "),
          _c("router-link", {
            attrs: { to: "/taxonomies", custom: "" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var navigate = ref.navigate
                  var isActive = ref.isActive
                  return [
                    _c(
                      "li",
                      {
                        staticClass: "nav-item",
                        class: [isActive && "router-link-active"],
                        attrs: { id: "analyze-tab", role: "link" },
                        on: {
                          click: navigate,
                          keypress: function($event) {
                            if (
                              !$event.type.indexOf("key") &&
                              _vm._k(
                                $event.keyCode,
                                "enter",
                                13,
                                $event.key,
                                "Enter"
                              )
                            ) {
                              return null
                            }
                            return navigate.apply(null, arguments)
                          }
                        }
                      },
                      [
                        _c(
                          "a",
                          {
                            staticClass: "nav-link is-clickable",
                            class: [isActive && "active"],
                            attrs: { href: "javascript:void(0);" }
                          },
                          [
                            _c("span", { staticClass: "icon is-small" }, [
                              _c("i", {
                                staticClass: "dashicons dashicons-category"
                              })
                            ]),
                            _vm._v(" "),
                            _c("span", [_vm._v("Taxonomies")])
                          ]
                        )
                      ]
                    )
                  ]
                }
              }
            ])
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "tab-content tab-panel pane" },
      [
        _c("div", { staticClass: "wp-adminify-loader" }),
        _vm._v(" "),
        _c("router-view", { key: _vm.$route.fullPath })
      ],
      1
    ),
    _vm._v(" "),
    _c("div", { staticClass: "mt-5 has-text-centered" }, [
      _c(
        "button",
        {
          staticClass: "button-primary is-clickable",
          attrs: { disabled: _vm.disable_save_btn },
          on: { click: _vm.save_store }
        },
        [_vm._v("\n      Save Settings\n    ")]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "wp-adminify--popup-area" }, [
      _c("div", { staticClass: "wp-adminify--popup-container" }, [
        _c("div", { staticClass: "wp-adminify--popup-container_inner" }, [
          _vm.popup_open
            ? _c("div", { staticClass: "popup--delete-folder" }, [
                _c(
                  "a",
                  {
                    staticClass: "wp-adminify--popup-close",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.hide_popup.apply(null, arguments)
                      }
                    }
                  },
                  [_c("span", { staticClass: "dashicons dashicons-no-alt" })]
                ),
                _vm._v(" "),
                _c("h3", [_vm._v(_vm._s(_vm.popup_title))]),
                _vm._v(" "),
                _c("div", {
                  staticClass: "popup-content",
                  domProps: { innerHTML: _vm._s(_vm.popup_details) }
                }),
                _vm._v(" "),
                _c(
                  "a",
                  {
                    staticClass: "button button-primary",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.hide_popup.apply(null, arguments)
                      }
                    }
                  },
                  [_vm._v("Got it")]
                )
              ])
            : _vm._e()
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/components/post-types-sidebar.vue?vue&type=template&id=4f19e224&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/components/post-types-sidebar.vue?vue&type=template&id=4f19e224& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "column is-4" }, [
    _c("div", { staticClass: "tabs is-boxed" }, [
      _c(
        "ul",
        {
          staticClass:
            "nav-tabs is-flex is-flex-direction-column is-align-items-flex-start"
        },
        [
          _c("router-link", {
            attrs: { to: "/post-types/post", custom: "", exact: "" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var navigate = ref.navigate
                  var isActive = ref.isActive
                  return [
                    _c(
                      "li",
                      {
                        staticClass: "nav-item",
                        class: [isActive && "router-link-active"],
                        attrs: { id: "analyze-tab", role: "link" },
                        on: {
                          click: navigate,
                          keypress: function($event) {
                            if (
                              !$event.type.indexOf("key") &&
                              _vm._k(
                                $event.keyCode,
                                "enter",
                                13,
                                $event.key,
                                "Enter"
                              )
                            ) {
                              return null
                            }
                            return navigate.apply(null, arguments)
                          }
                        }
                      },
                      [
                        _c(
                          "a",
                          {
                            staticClass: "nav-link is-clickable",
                            class: [isActive && "active"],
                            attrs: { href: "javascript:void(0);" }
                          },
                          [
                            _c("span", { staticClass: "icon is-small" }, [
                              _c("i", {
                                staticClass: "dashicons dashicons-edit-page"
                              })
                            ]),
                            _vm._v(" "),
                            _c("span", [_vm._v("Post")])
                          ]
                        )
                      ]
                    )
                  ]
                }
              }
            ])
          }),
          _vm._v(" "),
          _c("router-link", {
            attrs: { to: "/post-types/page", custom: "", exact: "" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(ref) {
                  var navigate = ref.navigate
                  var isActive = ref.isActive
                  return [
                    _c(
                      "li",
                      {
                        staticClass: "nav-item",
                        class: [isActive && "router-link-active"],
                        attrs: { id: "analyze-tab", role: "link" },
                        on: {
                          click: navigate,
                          keypress: function($event) {
                            if (
                              !$event.type.indexOf("key") &&
                              _vm._k(
                                $event.keyCode,
                                "enter",
                                13,
                                $event.key,
                                "Enter"
                              )
                            ) {
                              return null
                            }
                            return navigate.apply(null, arguments)
                          }
                        }
                      },
                      [
                        _c(
                          "a",
                          {
                            staticClass: "nav-link is-clickable",
                            class: [isActive && "active"],
                            attrs: { href: "javascript:void(0);" }
                          },
                          [
                            _c("span", { staticClass: "icon is-small" }, [
                              _c("i", {
                                staticClass: "dashicons dashicons-edit-page"
                              })
                            ]),
                            _vm._v(" "),
                            _c("span", [_vm._v("Page")])
                          ]
                        )
                      ]
                    )
                  ]
                }
              }
            ])
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=template&id=adce0ea8&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-type.vue?vue&type=template&id=adce0ea8& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
    "div",
    { staticClass: "tab-pane", attrs: { id: _vm.post_type.name } },
    [
      _c(
        "draggable",
        _vm._b(
          {
            on: {
              start: function($event) {
                _vm.drag = true
              },
              end: function($event) {
                _vm.drag = false
              }
            },
            model: {
              value: _vm.post_type.display_columns,
              callback: function($$v) {
                _vm.$set(_vm.post_type, "display_columns", $$v)
              },
              expression: "post_type.display_columns"
            }
          },
          "draggable",
          _vm.dragOptions,
          false
        ),
        _vm._l(_vm.post_type.display_columns, function(column, colIndex) {
          return _c(
            "div",
            {
              key: column.name + colIndex,
              ref: "accordion",
              refInFor: true,
              staticClass: "admin-column-accordion",
              class:
                column.forceOpen &&
                "admin-column-accordion-force--open admin-column-accordion--open"
            },
            [
              _c("div", { staticClass: "accordion-title p-4 pr-6 mr-6" }, [
                _c(
                  "svg",
                  {
                    staticClass: "drag-icon is-pulled-left is-clickable mr-2",
                    attrs: {
                      width: "24",
                      height: "24",
                      viewBox: "0 0 24 24",
                      fill: "none",
                      xmlns: "http://www.w3.org/2000/svg"
                    }
                  },
                  [
                    _c("path", {
                      attrs: {
                        d:
                          "M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    })
                  ]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "accordion-type-title" }, [
                  _c("span", {
                    staticClass: "admin-column-name",
                    domProps: { innerHTML: _vm._s(column.label) }
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "accordion-actions" }, [
                    _c(
                      "a",
                      {
                        staticClass: "edit-button",
                        attrs: { href: "#" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.toggleAccordion($event, column)
                          }
                        }
                      },
                      [_vm._v("Edit")]
                    ),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "remove-button",
                        attrs: { href: "#" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.removeColumn.apply(null, arguments)
                          }
                        }
                      },
                      [_vm._v("Remove")]
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "span",
                    { staticClass: "accordion-type is-pulled-right" },
                    [_vm._v(_vm._s(_vm.post_type.title))]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "accordion-helper" }, [
                  _c(
                    "button",
                    {
                      staticClass: "helper-button accordion-clone",
                      on: {
                        click: function($event) {
                          return _vm.cloneColumn(column)
                        }
                      }
                    },
                    [_c("i", { staticClass: "ti-layers" })]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "helper-button accordion-remove",
                      on: { click: _vm.removeColumn }
                    },
                    [_c("i", { staticClass: "ti-close" })]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    { staticClass: "helper-button accordion-toggler" },
                    [_c("i", { staticClass: "ti-angle-down" })]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", {
                staticClass: "accordion-opener",
                on: {
                  click: function($event) {
                    return _vm.toggleAccordion($event, column)
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "accordion-body" },
                [
                  _vm._l(_vm.post_type.fields, function(field, key) {
                    return [
                      field.id == "type"
                        ? _c(
                            "div",
                            {
                              key: key,
                              staticClass: "inner-content content-type"
                            },
                            [
                              _c("div", { staticClass: "columns" }, [
                                _c("div", { staticClass: "column is-4" }, [
                                  _c(
                                    "label",
                                    {
                                      attrs: {
                                        for:
                                          "content-" +
                                          colIndex +
                                          "-" +
                                          column.name +
                                          "-" +
                                          field.id
                                      }
                                    },
                                    [_vm._v(_vm._s(field.title))]
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "column" }, [
                                  _c(
                                    "select",
                                    {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: column.name,
                                          expression: "column.name"
                                        }
                                      ],
                                      staticClass: "select-type",
                                      attrs: {
                                        name:
                                          "content-" +
                                          colIndex +
                                          "-" +
                                          column.name +
                                          "-" +
                                          field.id,
                                        placeholder: field.placeholder
                                      },
                                      on: {
                                        focus: function($event) {
                                          return _vm.editing(column)
                                        },
                                        change: [
                                          function($event) {
                                            var $$selectedVal = Array.prototype.filter
                                              .call(
                                                $event.target.options,
                                                function(o) {
                                                  return o.selected
                                                }
                                              )
                                              .map(function(o) {
                                                var val =
                                                  "_value" in o
                                                    ? o._value
                                                    : o.value
                                                return val
                                              })
                                            _vm.$set(
                                              column,
                                              "name",
                                              $event.target.multiple
                                                ? $$selectedVal
                                                : $$selectedVal[0]
                                            )
                                          },
                                          function($event) {
                                            return _vm.changedType(column)
                                          }
                                        ]
                                      }
                                    },
                                    [
                                      _vm._l(field.options, function(
                                        parent_option,
                                        parent_option_key
                                      ) {
                                        return [
                                          parent_option.group
                                            ? _c(
                                                "optgroup",
                                                {
                                                  key: parent_option_key,
                                                  attrs: {
                                                    label: parent_option.group
                                                  }
                                                },
                                                _vm._l(
                                                  parent_option.options,
                                                  function(option, option_val) {
                                                    return _c(
                                                      "option",
                                                      {
                                                        key: option_val,
                                                        domProps: {
                                                          value: option_val,
                                                          selected:
                                                            option_val ==
                                                            column.name
                                                        }
                                                      },
                                                      [_vm._v(_vm._s(option))]
                                                    )
                                                  }
                                                ),
                                                0
                                              )
                                            : _c(
                                                "option",
                                                {
                                                  key: parent_option.name,
                                                  domProps: {
                                                    value: parent_option.name,
                                                    selected:
                                                      parent_option.name ==
                                                      column.name
                                                  }
                                                },
                                                [
                                                  _vm._v(
                                                    _vm._s(parent_option.title)
                                                  )
                                                ]
                                              )
                                        ]
                                      })
                                    ],
                                    2
                                  )
                                ])
                              ])
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      field.id == "function_name" && column.name == "function"
                        ? _c(
                            "div",
                            {
                              key: key,
                              staticClass: "inner-content content-type"
                            },
                            [
                              _c("div", { staticClass: "columns" }, [
                                _c("div", { staticClass: "column is-4" }, [
                                  _c(
                                    "label",
                                    {
                                      attrs: {
                                        for:
                                          "content-" +
                                          colIndex +
                                          "-" +
                                          column.name +
                                          "-" +
                                          field.id
                                      }
                                    },
                                    [_vm._v(_vm._s(field.title))]
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "column" }, [
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: column.function_name,
                                        expression: "column.function_name"
                                      }
                                    ],
                                    attrs: {
                                      name:
                                        "content-" +
                                        colIndex +
                                        "-" +
                                        column.name +
                                        "-" +
                                        field.id,
                                      type: "text",
                                      placeholder: field.placeholder
                                    },
                                    domProps: { value: column.function_name },
                                    on: {
                                      change: function($event) {
                                        return _vm.changedType(column)
                                      },
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          column,
                                          "function_name",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  })
                                ])
                              ])
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      field.id == "shortcode_name" && column.name == "shortcode"
                        ? _c(
                            "div",
                            {
                              key: key,
                              staticClass: "inner-content content-type"
                            },
                            [
                              _c("div", { staticClass: "columns" }, [
                                _c("div", { staticClass: "column is-4" }, [
                                  _c(
                                    "label",
                                    {
                                      attrs: {
                                        for:
                                          "content-" +
                                          colIndex +
                                          "-" +
                                          column.name +
                                          "-" +
                                          field.id
                                      }
                                    },
                                    [_vm._v(_vm._s(field.title))]
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "column" }, [
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: column.shortcode_name,
                                        expression: "column.shortcode_name"
                                      }
                                    ],
                                    attrs: {
                                      name:
                                        "content-" +
                                        colIndex +
                                        "-" +
                                        column.name +
                                        "-" +
                                        field.id,
                                      type: "text",
                                      placeholder: field.placeholder
                                    },
                                    domProps: { value: column.shortcode_name },
                                    on: {
                                      change: function($event) {
                                        return _vm.changedType(column)
                                      },
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          column,
                                          "shortcode_name",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  })
                                ])
                              ])
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      field.id == "label"
                        ? _c(
                            "div",
                            {
                              key: key,
                              staticClass: "inner-content content-type"
                            },
                            [
                              _c("div", { staticClass: "columns" }, [
                                _c("div", { staticClass: "column is-4" }, [
                                  _c(
                                    "label",
                                    {
                                      attrs: {
                                        for:
                                          "content-" +
                                          colIndex +
                                          "-" +
                                          column.name +
                                          "-" +
                                          field.id
                                      }
                                    },
                                    [_vm._v(_vm._s(field.title))]
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "column" }, [
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: column.label,
                                        expression: "column.label"
                                      }
                                    ],
                                    attrs: {
                                      name:
                                        "content-" +
                                        colIndex +
                                        "-" +
                                        column.name +
                                        "-" +
                                        field.id,
                                      type: "text",
                                      placeholder: field.placeholder
                                    },
                                    domProps: { value: column.label },
                                    on: {
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          column,
                                          "label",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  })
                                ])
                              ])
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      field.id == "width"
                        ? _c(
                            "div",
                            {
                              key: key,
                              staticClass: "inner-content content-type"
                            },
                            [
                              _c("div", { staticClass: "columns" }, [
                                _c("div", { staticClass: "column is-4" }, [
                                  _c(
                                    "label",
                                    {
                                      attrs: {
                                        for:
                                          "content-" +
                                          colIndex +
                                          "-" +
                                          column.name +
                                          "-" +
                                          field.id
                                      }
                                    },
                                    [_vm._v(_vm._s(field.title))]
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "column" }, [
                                  _c(
                                    "div",
                                    { staticClass: "range-slider-wrapper" },
                                    [
                                      _c("input", {
                                        staticClass: "range-value",
                                        attrs: { type: "text", readonly: "" },
                                        domProps: {
                                          value: _vm.formatedWidthValue(
                                            column.width.value
                                          )
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("range-slider", {
                                        staticClass: "slider",
                                        attrs: {
                                          min: 0,
                                          max: _vm.getWidthMax(
                                            column.width.unit
                                          )
                                        },
                                        model: {
                                          value: column.width.value,
                                          callback: function($$v) {
                                            _vm.$set(column.width, "value", $$v)
                                          },
                                          expression: "column.width.value"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c("div", { staticClass: "unit-labels" }, [
                                    _c(
                                      "label",
                                      { staticClass: "range-width-unit" },
                                      [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: column.width.unit,
                                              expression: "column.width.unit"
                                            }
                                          ],
                                          staticClass: "range-width-unit-%",
                                          attrs: {
                                            name:
                                              "content-" +
                                              colIndex +
                                              "-" +
                                              column.name +
                                              "-" +
                                              field.id,
                                            type: "radio",
                                            value: "%"
                                          },
                                          domProps: {
                                            checked: column.width.unit == "%",
                                            checked: _vm._q(
                                              column.width.unit,
                                              "%"
                                            )
                                          },
                                          on: {
                                            change: [
                                              function($event) {
                                                return _vm.$set(
                                                  column.width,
                                                  "unit",
                                                  "%"
                                                )
                                              },
                                              function($event) {
                                                return _vm.onSliderUnitChange(
                                                  column
                                                )
                                              }
                                            ]
                                          }
                                        }),
                                        _vm._v(
                                          "%\n                                    "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "label",
                                      { staticClass: "range-width-unit" },
                                      [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: column.width.unit,
                                              expression: "column.width.unit"
                                            }
                                          ],
                                          staticClass: "range-width-unit-px",
                                          attrs: {
                                            name:
                                              "content-" +
                                              colIndex +
                                              "-" +
                                              column.name +
                                              "-" +
                                              field.id,
                                            type: "radio",
                                            value: "px"
                                          },
                                          domProps: {
                                            checked: column.width.unit == "px",
                                            checked: _vm._q(
                                              column.width.unit,
                                              "px"
                                            )
                                          },
                                          on: {
                                            change: [
                                              function($event) {
                                                return _vm.$set(
                                                  column.width,
                                                  "unit",
                                                  "px"
                                                )
                                              },
                                              function($event) {
                                                return _vm.onSliderUnitChange(
                                                  column
                                                )
                                              }
                                            ]
                                          }
                                        }),
                                        _vm._v(
                                          "px\n                                    "
                                        )
                                      ]
                                    )
                                  ])
                                ])
                              ])
                            ]
                          )
                        : _vm._e()
                    ]
                  })
                ],
                2
              )
            ]
          )
        }),
        0
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "columns is-desktop is-justify-content-flex-end" },
        [
          _c(
            "button",
            {
              staticClass:
                "wp-adminify-add-button is-clickable is-pulled-right",
              on: { click: _vm.addNewColumn }
            },
            [_vm._v("Add new")]
          )
        ]
      ),
      _vm._v(" "),
      !_vm.isTypePro()
        ? _c("div", {
            staticClass: "admin-column--pro-guard",
            domProps: { innerHTML: _vm._s(_vm.proNotice()) }
          })
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=template&id=7db1bdf7&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/post-types.vue?vue&type=template&id=7db1bdf7& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "tab-pane", attrs: { id: "post-types" } }, [
    _c("div", { staticClass: "columns" }, [
      _c("div", { staticClass: "column is-4" }, [
        _c("div", { staticClass: "tabs is-boxed" }, [
          _c(
            "ul",
            {
              staticClass:
                "nav-tabs is-flex is-flex-direction-column is-align-items-flex-start"
            },
            _vm._l(_vm.post_types, function(post_type_data) {
              return _c("router-link", {
                key: post_type_data.name,
                attrs: {
                  to: "/post-types/" + post_type_data.name,
                  custom: "",
                  exact: ""
                },
                scopedSlots: _vm._u(
                  [
                    {
                      key: "default",
                      fn: function(ref) {
                        var navigate = ref.navigate
                        var isActive = ref.isActive
                        return [
                          _c(
                            "li",
                            {
                              staticClass: "nav-item",
                              class: [isActive && "router-link-active"],
                              attrs: { role: "link" },
                              on: {
                                click: navigate,
                                keypress: function($event) {
                                  if (
                                    !$event.type.indexOf("key") &&
                                    _vm._k(
                                      $event.keyCode,
                                      "enter",
                                      13,
                                      $event.key,
                                      "Enter"
                                    )
                                  ) {
                                    return null
                                  }
                                  return navigate.apply(null, arguments)
                                }
                              }
                            },
                            [
                              _c(
                                "a",
                                {
                                  staticClass: "nav-link is-clickable",
                                  class: [
                                    _vm.post_type == post_type_data.name &&
                                      "active"
                                  ],
                                  attrs: { href: "javascript:void(0);" }
                                },
                                [
                                  _c("span", { staticClass: "icon is-small" }, [
                                    _c("i", {
                                      staticClass:
                                        "dashicons dashicons-edit-page"
                                    })
                                  ]),
                                  _vm._v(" "),
                                  _c("span", [
                                    _vm._v(_vm._s(post_type_data.title))
                                  ]),
                                  _vm._v(" "),
                                  !_vm.isPro() && post_type_data.is_pro
                                    ? _c(
                                        "span",
                                        {
                                          staticClass:
                                            "adminify-column-post--pro",
                                          staticStyle: { "margin-left": "4px" }
                                        },
                                        [_vm._v("- (Pro)")]
                                      )
                                    : _vm._e()
                                ]
                              )
                            ]
                          )
                        ]
                      }
                    }
                  ],
                  null,
                  true
                )
              })
            }),
            1
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "column" }, [
        _c(
          "div",
          { staticClass: "tab-content tab-panel pane" },
          [
            _vm.post_types.length
              ? _c("router-view", { key: _vm.$route.fullPath })
              : _vm._e()
          ],
          1
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=template&id=08751b1a&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomies.vue?vue&type=template&id=08751b1a& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "tab-pane", attrs: { id: "taxonomies" } }, [
    _c("div", { staticClass: "columns" }, [
      _c("div", { staticClass: "column is-4" }, [
        _c("div", { staticClass: "tabs is-boxed" }, [
          _c(
            "ul",
            {
              staticClass:
                "nav-tabs is-flex is-flex-direction-column is-align-items-flex-start"
            },
            _vm._l(_vm.taxonomies, function(taxonomy_data) {
              return _c("router-link", {
                key: taxonomy_data.name,
                attrs: {
                  to: "/taxonomies/" + taxonomy_data.name,
                  custom: "",
                  exact: ""
                },
                scopedSlots: _vm._u(
                  [
                    {
                      key: "default",
                      fn: function(ref) {
                        var navigate = ref.navigate
                        var isActive = ref.isActive
                        return [
                          _c(
                            "li",
                            {
                              staticClass: "nav-item",
                              class: [isActive && "router-link-active"],
                              attrs: { role: "link" },
                              on: {
                                click: navigate,
                                keypress: function($event) {
                                  if (
                                    !$event.type.indexOf("key") &&
                                    _vm._k(
                                      $event.keyCode,
                                      "enter",
                                      13,
                                      $event.key,
                                      "Enter"
                                    )
                                  ) {
                                    return null
                                  }
                                  return navigate.apply(null, arguments)
                                }
                              }
                            },
                            [
                              _c(
                                "a",
                                {
                                  staticClass: "nav-link is-clickable",
                                  class: [
                                    _vm.taxonomy == taxonomy_data.name &&
                                      "active"
                                  ],
                                  attrs: { href: "javascript:void(0);" }
                                },
                                [
                                  _c("span", { staticClass: "icon is-small" }, [
                                    _c("i", {
                                      staticClass:
                                        "dashicons dashicons-edit-page"
                                    })
                                  ]),
                                  _vm._v(" "),
                                  _c("span", [
                                    _vm._v(_vm._s(taxonomy_data.title))
                                  ]),
                                  _vm._v(" "),
                                  !_vm.isPro() && taxonomy_data.is_pro
                                    ? _c(
                                        "span",
                                        {
                                          staticClass:
                                            "adminify-column-post--pro",
                                          staticStyle: { "margin-left": "4px" }
                                        },
                                        [_vm._v("- (Pro)")]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  taxonomy_data.object_type
                                    ? _c(
                                        "span",
                                        { staticClass: "taxonomy-post-type" },
                                        [
                                          _vm._v(
                                            "[" +
                                              _vm._s(
                                                taxonomy_data.object_type
                                              ) +
                                              "]"
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ]
                              )
                            ]
                          )
                        ]
                      }
                    }
                  ],
                  null,
                  true
                )
              })
            }),
            1
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "column" }, [
        _c(
          "div",
          { staticClass: "tab-content tab-panel pane" },
          [
            _vm.taxonomies.length
              ? _c("router-view", { key: _vm.$route.fullPath })
              : _vm._e()
          ],
          1
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=template&id=c1699b08&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/admin-columns/pages/taxonomy.vue?vue&type=template&id=c1699b08& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
    "div",
    { staticClass: "tab-pane", attrs: { id: _vm.taxonomy.name } },
    [
      _c(
        "draggable",
        _vm._b(
          {
            on: {
              start: function($event) {
                _vm.drag = true
              },
              end: function($event) {
                _vm.drag = false
              }
            },
            model: {
              value: _vm.taxonomy.display_columns,
              callback: function($$v) {
                _vm.$set(_vm.taxonomy, "display_columns", $$v)
              },
              expression: "taxonomy.display_columns"
            }
          },
          "draggable",
          _vm.dragOptions,
          false
        ),
        _vm._l(_vm.taxonomy.display_columns, function(column, colIndex) {
          return _c(
            "div",
            {
              key: column.name + colIndex,
              ref: "accordion",
              refInFor: true,
              staticClass: "admin-column-accordion",
              class:
                column.forceOpen &&
                "admin-column-accordion-force--open admin-column-accordion--open"
            },
            [
              _c("div", { staticClass: "accordion-title p-4 pr-6 mr-6" }, [
                _c(
                  "svg",
                  {
                    staticClass: "drag-icon is-pulled-left is-clickable mr-2",
                    attrs: {
                      width: "24",
                      height: "24",
                      viewBox: "0 0 24 24",
                      fill: "none",
                      xmlns: "http://www.w3.org/2000/svg"
                    }
                  },
                  [
                    _c("path", {
                      attrs: {
                        d:
                          "M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    }),
                    _vm._v(" "),
                    _c("path", {
                      attrs: {
                        d:
                          "M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z",
                        fill: "#4E4B66",
                        "fill-opacity": "0.72"
                      }
                    })
                  ]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "accordion-type-title" }, [
                  _c("span", {
                    staticClass: "admin-column-name",
                    domProps: { innerHTML: _vm._s(column.label) }
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "accordion-actions" }, [
                    _c(
                      "a",
                      {
                        staticClass: "edit-button",
                        attrs: { href: "#" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.toggleAccordion($event, column)
                          }
                        }
                      },
                      [_vm._v("Edit")]
                    ),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "remove-button",
                        attrs: { href: "#" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.removeColumn.apply(null, arguments)
                          }
                        }
                      },
                      [_vm._v("Remove")]
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "span",
                    { staticClass: "accordion-type is-pulled-right" },
                    [_vm._v(_vm._s(_vm.taxonomy.title))]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "accordion-helper" }, [
                  _c(
                    "button",
                    {
                      staticClass: "helper-button accordion-clone",
                      on: {
                        click: function($event) {
                          return _vm.cloneColumn(column)
                        }
                      }
                    },
                    [_c("i", { staticClass: "ti-layers" })]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "helper-button accordion-remove",
                      on: { click: _vm.removeColumn }
                    },
                    [_c("i", { staticClass: "ti-close" })]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    { staticClass: "helper-button accordion-toggler" },
                    [_c("i", { staticClass: "ti-angle-down" })]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", {
                staticClass: "accordion-opener",
                on: {
                  click: function($event) {
                    return _vm.toggleAccordion($event, column)
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "accordion-body" },
                [
                  _vm._l(_vm.taxonomy.fields, function(field, key) {
                    return [
                      column.fields.includes(field.id)
                        ? _c(
                            "div",
                            {
                              key: key,
                              staticClass: "inner-content content-type"
                            },
                            [
                              _c("div", { staticClass: "columns" }, [
                                _c("div", { staticClass: "column is-4" }, [
                                  _c(
                                    "label",
                                    {
                                      attrs: {
                                        for:
                                          "content-" +
                                          colIndex +
                                          "-" +
                                          column.name +
                                          "-" +
                                          field.id
                                      }
                                    },
                                    [_vm._v(_vm._s(field.title))]
                                  )
                                ]),
                                _vm._v(" "),
                                field.type == "select"
                                  ? _c("div", { staticClass: "column" }, [
                                      _c(
                                        "select",
                                        {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: column.name,
                                              expression: "column.name"
                                            }
                                          ],
                                          staticClass: "select-type",
                                          attrs: {
                                            name:
                                              "content-" +
                                              colIndex +
                                              "-" +
                                              column.name +
                                              "-" +
                                              field.id,
                                            placeholder: field.placeholder
                                          },
                                          on: {
                                            focus: function($event) {
                                              return _vm.editing(column)
                                            },
                                            change: [
                                              function($event) {
                                                var $$selectedVal = Array.prototype.filter
                                                  .call(
                                                    $event.target.options,
                                                    function(o) {
                                                      return o.selected
                                                    }
                                                  )
                                                  .map(function(o) {
                                                    var val =
                                                      "_value" in o
                                                        ? o._value
                                                        : o.value
                                                    return val
                                                  })
                                                _vm.$set(
                                                  column,
                                                  "name",
                                                  $event.target.multiple
                                                    ? $$selectedVal
                                                    : $$selectedVal[0]
                                                )
                                              },
                                              function($event) {
                                                return _vm.changedType(column)
                                              }
                                            ]
                                          }
                                        },
                                        _vm._l(field.options, function(
                                          option,
                                          option_val
                                        ) {
                                          return _c(
                                            "option",
                                            {
                                              key: option_val,
                                              domProps: {
                                                value: option_val,
                                                selected:
                                                  option_val == column.name
                                              }
                                            },
                                            [_vm._v(_vm._s(option))]
                                          )
                                        }),
                                        0
                                      )
                                    ])
                                  : _vm._e(),
                                _vm._v(" "),
                                field.type == "text"
                                  ? _c("div", { staticClass: "column" }, [
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: column.label,
                                            expression: "column.label"
                                          }
                                        ],
                                        attrs: {
                                          name:
                                            "content-" +
                                            colIndex +
                                            "-" +
                                            column.name +
                                            "-" +
                                            field.id,
                                          type: "text",
                                          placeholder: field.placeholder
                                        },
                                        domProps: { value: column.label },
                                        on: {
                                          input: function($event) {
                                            if ($event.target.composing) {
                                              return
                                            }
                                            _vm.$set(
                                              column,
                                              "label",
                                              $event.target.value
                                            )
                                          }
                                        }
                                      })
                                    ])
                                  : _vm._e(),
                                _vm._v(" "),
                                field.type == "slider"
                                  ? _c("div", { staticClass: "column" }, [
                                      _c(
                                        "div",
                                        { staticClass: "range-slider-wrapper" },
                                        [
                                          _c("input", {
                                            staticClass: "range-value",
                                            attrs: {
                                              type: "text",
                                              readonly: ""
                                            },
                                            domProps: {
                                              value: _vm.formatedWidthValue(
                                                column.width.value
                                              )
                                            }
                                          }),
                                          _vm._v(" "),
                                          _c("range-slider", {
                                            staticClass: "slider",
                                            attrs: {
                                              min: 0,
                                              max: _vm.getWidthMax(
                                                column.width.unit
                                              )
                                            },
                                            model: {
                                              value: column.width.value,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  column.width,
                                                  "value",
                                                  $$v
                                                )
                                              },
                                              expression: "column.width.value"
                                            }
                                          })
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        { staticClass: "unit-labels" },
                                        [
                                          _c(
                                            "label",
                                            { staticClass: "range-width-unit" },
                                            [
                                              _c("input", {
                                                directives: [
                                                  {
                                                    name: "model",
                                                    rawName: "v-model",
                                                    value: column.width.unit,
                                                    expression:
                                                      "column.width.unit"
                                                  }
                                                ],
                                                staticClass:
                                                  "range-width-unit-%",
                                                attrs: {
                                                  name:
                                                    "content-" +
                                                    colIndex +
                                                    "-" +
                                                    column.name +
                                                    "-" +
                                                    field.id,
                                                  type: "radio",
                                                  value: "%"
                                                },
                                                domProps: {
                                                  checked:
                                                    column.width.unit == "%",
                                                  checked: _vm._q(
                                                    column.width.unit,
                                                    "%"
                                                  )
                                                },
                                                on: {
                                                  change: [
                                                    function($event) {
                                                      return _vm.$set(
                                                        column.width,
                                                        "unit",
                                                        "%"
                                                      )
                                                    },
                                                    function($event) {
                                                      return _vm.onSliderUnitChange(
                                                        column
                                                      )
                                                    }
                                                  ]
                                                }
                                              }),
                                              _vm._v(
                                                "%\n                                    "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "label",
                                            { staticClass: "range-width-unit" },
                                            [
                                              _c("input", {
                                                directives: [
                                                  {
                                                    name: "model",
                                                    rawName: "v-model",
                                                    value: column.width.unit,
                                                    expression:
                                                      "column.width.unit"
                                                  }
                                                ],
                                                staticClass:
                                                  "range-width-unit-px",
                                                attrs: {
                                                  name:
                                                    "content-" +
                                                    colIndex +
                                                    "-" +
                                                    column.name +
                                                    "-" +
                                                    field.id,
                                                  type: "radio",
                                                  value: "px"
                                                },
                                                domProps: {
                                                  checked:
                                                    column.width.unit == "px",
                                                  checked: _vm._q(
                                                    column.width.unit,
                                                    "px"
                                                  )
                                                },
                                                on: {
                                                  change: [
                                                    function($event) {
                                                      return _vm.$set(
                                                        column.width,
                                                        "unit",
                                                        "px"
                                                      )
                                                    },
                                                    function($event) {
                                                      return _vm.onSliderUnitChange(
                                                        column
                                                      )
                                                    }
                                                  ]
                                                }
                                              }),
                                              _vm._v(
                                                "px\n                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      )
                                    ])
                                  : _vm._e()
                              ])
                            ]
                          )
                        : _vm._e()
                    ]
                  })
                ],
                2
              )
            ]
          )
        }),
        0
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "columns is-desktop is-justify-content-flex-end" },
        [
          _c(
            "button",
            {
              staticClass:
                "wp-adminify-add-button is-clickable is-pulled-right",
              on: { click: _vm.addNewColumn }
            },
            [_vm._v("Add new")]
          )
        ]
      ),
      _vm._v(" "),
      !_vm.isTaxPro()
        ? _c("div", {
            staticClass: "admin-column--pro-guard",
            domProps: { innerHTML: _vm._s(_vm.proNotice()) }
          })
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/assets/admin/js/vendor"], () => (__webpack_exec__("./dev/admin/modules/admin-columns/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=wp-adminify--admin-columns.js.map