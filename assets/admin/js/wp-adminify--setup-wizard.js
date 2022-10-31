"use strict";
(self["webpackChunkadminify"] = self["webpackChunkadminify"] || []).push([["/assets/admin/js/wp-adminify--setup-wizard"],{

/***/ "./dev/admin/modules/setup-wizard/setup-wizard.js":
/*!********************************************************!*\
  !*** ./dev/admin/modules/setup-wizard/setup-wizard.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


jQuery(function ($) {
  new vue__WEBPACK_IMPORTED_MODULE_1__["default"]({
    el: '#wp-adminify--setup-wizard',
    data: function data() {
      return _objectSpread(_objectSpread({}, adminify_setup_wizard_data), {}, {
        active_step: null
      });
    },
    mounted: function mounted() {
      var params = new URLSearchParams(window.location.search);

      if (params.has('step')) {
        this.active_step = params.get('step');
      }
    },
    methods: {
      getMedia: function getMedia() {
        return this.media;
      },
      setMedia: function setMedia(media) {
        this.media = media;
      },
      handle_media: function handle_media(media) {
        var _this = this;

        this.setMedia(media);

        if (this.frame) {
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
        this.frame.on('select', function () {
          var attachment = _this.frame.state().get('selection').first().toJSON();

          attachment.thumbnail = attachment.sizes.thumbnail.url;

          var _media = _this.getMedia();

          for (var media_key in _media) {
            _media[media_key] = attachment[media_key];
          }
        });
        this.frame.on('open', function () {
          var selection = _this.frame.state().get('selection');

          var _media = _this.getMedia();

          if (_media && _media.id) {
            var attachment = wp.media.attachment(_media.id);
            attachment.fetch();
            return selection.add(attachment ? [attachment] : []);
          }

          return selection.add([]);
        });
        this.frame.open();
      },
      handleSubmit: function handleSubmit() {
        var _this2 = this;

        return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
          var res;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  _context.next = 2;
                  return wp.ajax.post('wpadminify_save_wizard_data', {
                    settings: _this2.settings,
                    active_step: _this2.active_step,
                    _wpnonce: _this2.wpnonce
                  });

                case 2:
                  res = _context.sent;

                  if (res && res.redirect) {
                    window.location = res.redirect;
                  }

                case 4:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee);
        }))();
      }
    }
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/assets/admin/js/vendor"], () => (__webpack_exec__("./dev/admin/modules/setup-wizard/setup-wizard.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=wp-adminify--setup-wizard.js.map