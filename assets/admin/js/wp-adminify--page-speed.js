"use strict";
(self["webpackChunkadminify"] = self["webpackChunkadminify"] || []).push([["/assets/admin/js/wp-adminify--page-speed"],{

/***/ "./dev/admin/modules/page-speed/helpers.js":
/*!*************************************************!*\
  !*** ./dev/admin/modules/page-speed/helpers.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var helpers = {
  nonReactive: function nonReactive(data) {
    return JSON.parse(JSON.stringify(data));
  },
  getScoreClass: function getScoreClass(score) {
    if (score >= 90) {
      return "pass";
    }

    if (score >= 50) {
      return "average";
    }

    return "fail";
  },
  markdownToLink: function markdownToLink(linkUrl) {
    var regularHTML = linkUrl.replace(/\[([^\]]+)\]\(([^\)]+)\)/, '<a href="$2" rel="noopener" target="_blank">$1</a>');
    return regularHTML;
  },
  fcpScoreClass: function fcpScoreClass(seconds) {
    if (seconds < 1.8) {
      return "adminify-ps-pass";
    }

    if (seconds > 1.8 && seconds < 3) {
      return "adminify-ps-average";
    }

    if (seconds > 3) {
      return "adminify-ps-fail";
    }
  },
  lcpScoreClass: function lcpScoreClass(seconds) {
    if (seconds < 2.5) {
      return "adminify-ps-pass";
    }

    if (seconds > 2.5 && seconds < 4) {
      return "adminify-ps-average";
    }

    if (seconds > 4) {
      return "adminify-ps-fail";
    }
  },
  fidScoreClass: function fidScoreClass(miliseconds) {
    if (miliseconds < 100) {
      return "adminify-ps-pass";
    }

    if (miliseconds > 100 && miliseconds < 300) {
      return "adminify-ps-average";
    }

    if (miliseconds > 300) {
      return "adminify-ps-fail";
    }
  },
  clsScoreClass: function clsScoreClass(seconds) {
    if (seconds < 0.1) {
      return "adminify-ps-pass";
    }

    if (seconds > 100 && seconds < 300) {
      return "adminify-ps-average";
    }

    if (seconds > 300) {
      return "adminify-ps-fail";
    }
  },
  barClass: function barClass(index) {
    if (index === 0) {
      return "fast";
    } else if (index == 1) {
      return "average";
    } else if (index == 2) {
      return "slow";
    }
  },
  toRatio: function toRatio(number) {
    return (number * 100).toFixed(2);
  },
  MilisecondsToSeconds: function MilisecondsToSeconds(miliseconds) {
    var seconds, fractionSeconds;
    seconds = miliseconds / 1000;
    fractionSeconds = seconds.toFixed(2);
    return parseFloat(fractionSeconds);
  },
  ProportionToPercentage: function ProportionToPercentage(proption) {
    return proption.toFixed(2);
  },
  getScoreStatusInt: function getScoreStatusInt(score) {
    var fullMode = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

    if (typeof score == null) {
      return 0;
    }

    if (!fullMode) {
      score = score * 100;
    }

    if (score >= 90) {
      return 2;
    }

    if (score >= 50) {
      return 1;
    }

    return 0;
  },
  getScoreStatusClass: function getScoreStatusClass(score) {
    var fullMode = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var scoreInt = this.getScoreStatusInt(score, fullMode);

    if (scoreInt == 2) {
      return "data-metric--pass";
    }

    if (scoreInt == 1) {
      return "data-metric--average";
    }

    return "data-metric--fail";
  },
  getScoreStatus: function getScoreStatus(score) {
    var fullMode = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var scoreInt = this.getScoreStatusInt(score, fullMode);

    if (scoreInt == 2) {
      return "Excellent";
    }

    if (scoreInt == 1) {
      return "Good";
    }

    return "Poor";
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (helpers);

/***/ }),

/***/ "./dev/admin/modules/page-speed/page-speed.js":
/*!****************************************************!*\
  !*** ./dev/admin/modules/page-speed/page-speed.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./dev/admin/modules/page-speed/helpers.js");
/* harmony import */ var _pages_analyze_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./pages/analyze.vue */ "./dev/admin/modules/page-speed/pages/analyze.vue");
/* harmony import */ var _pages_report_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./pages/report.vue */ "./dev/admin/modules/page-speed/pages/report.vue");
/* harmony import */ var _pages_history_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./pages/history.vue */ "./dev/admin/modules/page-speed/pages/history.vue");



vue__WEBPACK_IMPORTED_MODULE_1__["default"].mixin({
  methods: _helpers__WEBPACK_IMPORTED_MODULE_0__["default"]
});
vue__WEBPACK_IMPORTED_MODULE_1__["default"].use(vue_router__WEBPACK_IMPORTED_MODULE_2__["default"]);
vue__WEBPACK_IMPORTED_MODULE_1__["default"].component('page-speed-app', (__webpack_require__(/*! ./page-speed-app.vue */ "./dev/admin/modules/page-speed/page-speed-app.vue")["default"]));
vue__WEBPACK_IMPORTED_MODULE_1__["default"].component('history-single', (__webpack_require__(/*! ./components/history-single.vue */ "./dev/admin/modules/page-speed/components/history-single.vue")["default"]));



jQuery(function ($) {
  if ($('#wp-adminify--page-speed-app').length) {
    var routes = [{
      path: '/',
      component: _pages_analyze_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
    }, {
      path: '/history',
      component: _pages_history_vue__WEBPACK_IMPORTED_MODULE_5__["default"]
    }, {
      path: '/history/:page',
      component: _pages_history_vue__WEBPACK_IMPORTED_MODULE_5__["default"]
    }, {
      path: '/report/:id',
      component: _pages_report_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
      name: 'report'
    }];
    var router = new vue_router__WEBPACK_IMPORTED_MODULE_2__["default"]({
      routes: routes
    });
    router.beforeEach(function (to, from, next) {
      if (to.path == '/history') next({
        path: '/history/1'
      });
      next();
    });
    new vue__WEBPACK_IMPORTED_MODULE_1__["default"]({
      el: '#wp-adminify--page-speed-app',
      template: '<page-speed-app></page-speed-app>',
      router: router
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/history-single.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/history-single.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    history: {
      type: Object,
      required: true
    }
  },
  methods: {
    deleteHistory: function deleteHistory() {
      this.$parent.deleteHistory(this.history.id);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "labData",
  props: {
    data: {
      type: Object,
      required: true,
      "default": function _default() {
        return {};
      }
    },
    device: {
      type: String,
      required: true,
      "default": "desktop"
    }
  },
  data: function data() {
    return {
      isDetail: false
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    return {};
  },
  props: {
    data: {
      type: Object,
      required: true,
      "default": function _default() {
        return {};
      }
    }
  },
  computed: {
    parent_data: function parent_data() {
      return this.$parent.activeData;
    },
    auditRefs: function auditRefs() {
      return this.parent_data.lighthouseResult.categories.performance.auditRefs;
    }
  },
  mounted: function mounted() {},
  methods: {
    getTabletLabel: function getTabletLabel(data) {
      return data.text || data.label;
    },
    escapeHtml: function escapeHtml(text) {
      var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      };
      return text.replace(/[&<>"']/g, function (m) {
        return map[m];
      });
    },
    getKey: function getKey(data) {
      var isSub = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

      if (isSub && 'subItemsHeading' in data && 'key' in data.subItemsHeading && data.subItemsHeading.key) {
        return data.subItemsHeading.key;
      }

      if ('key' in data) return data.key;
      return null;
    },
    getType: function getType(data) {
      var isSub = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      var data_type;

      if (isSub && 'subItemsHeading' in data) {
        if ('itemType' in data.subItemsHeading) {
          data_type = data.subItemsHeading.itemType;
        } else if ('valueType' in data.subItemsHeading) {
          data_type = data.subItemsHeading.valueType;
        }

        if (data_type) return data_type;
      }

      if ('itemType' in data) {
        data_type = data.itemType;
      } else if ('valueType' in data) {
        data_type = data.valueType;
      }

      return data_type;
    },
    itemType_node: function itemType_node(data) {
      var label = 'nodeLabel' in data ? data.nodeLabel : data.text;
      return "<div class=\"single-node\"><div class=\"node-level\">".concat(label, "</div><div class=\"node-snippet\">").concat(this.escapeHtml(data.snippet), "</div></div>");
    },
    itemType_numeric: function itemType_numeric(data) {
      return Math.round((data + Number.EPSILON) * 1000) / 1000;
    },
    is_valid_url: function is_valid_url(str) {
      var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
      '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
      '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
      '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
      '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
      '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator

      return !!pattern.test(str);
    },
    itemType_url: function itemType_url(url) {
      if (!this.is_valid_url(url)) return url;
      var URL_Obj = new URL(url);
      var origin = URL_Obj.origin;
      var pathname = URL_Obj.pathname == '/' ? '' : URL_Obj.pathname;
      var isRoot = !pathname;
      var query = URL_Obj.search;
      var hasQuery = !!query;
      var hostname = URL_Obj.hostname.replace('www.', '');
      var short_url = origin;
      var isFileURL = this.urlIsFile(pathname);
      var displayHost = true;

      if (!isRoot) {
        var parts = pathname.split('/').filter(function (path) {
          return path;
        });
        var hasGap = false;

        if (parts.length > 2) {
          hasGap = true;
          parts = parts.slice(Math.max(parts.length - 2, 0));
        }

        if (isFileURL) {
          if (parts.length > 1) {
            var dirs = parts[0];
            var file = parts[1];
            var dot_index = file.indexOf('.');

            if (dot_index > 9) {
              file = file.substring(0, 9) + '...' + file.substring(dot_index);
              parts = [dirs, file];
            }
          }
        }

        if (parts.length) pathname = parts.join('/');
        short_url = (hasGap ? '...' : '/') + pathname;
      }

      if (!isRoot && !isFileURL && !hasQuery) short_url += '/';

      if (hasQuery) {
        if (!isRoot) {
          if (query.length > 20) query = query.substr(0, 20) + '...';
          short_url += '/' + query;
        }
      }

      if (short_url.indexOf('...') < 0 && short_url.indexOf(hostname) > 0 && new URL(short_url).host == hostname) displayHost = false;
      var template = "<span class=\"chain-url\" title=\"".concat(url, "\" data-url=\"").concat(url, "\"><a rel=\"noopener\" target=\"_blank\" href=\"").concat(url, "\" class=\"chain-link\">").concat(short_url, "</a>");
      if (displayHost) template += "<span class=\"chain-host\">(".concat(hostname, ")</span>");
      template += "</span>";
      return template;
    },
    itemType_ms: function itemType_ms(ms) {
      var second = 1000;
      var minute = 60 * second;
      var hour = 60 * minute;
      var day = 24 * hour;
      var year = 365 * day;
      if (ms >= year) return Math.round(ms / year) + ' y';
      if (ms >= day) return Math.round(ms / day) + ' d';
      if (ms >= hour) return Math.round(ms / hour) + ' h';
      if (ms >= minute) return Math.round(ms / minute) + ' m';
      if (ms >= second) return Math.round(ms / second) + ' s';
      return Math.floor(ms) + ' ms';
    },
    itemType_text: function itemType_text(data) {
      return data;
    },
    itemType_thumbnail: function itemType_thumbnail(data) {
      return "<img class=\"lh-thumbnail\" src=\"".concat(data, "\" title=\"").concat(data, "\" alt=\"\">");
    },
    itemType_timespanMs: function itemType_timespanMs(data) {
      return data;
    },
    itemType_bytes: function itemType_bytes(data) {
      return this.byteTokib(data, 0);
    },
    itemType_link: function itemType_link(data) {
      return "<a href=\"".concat(data.url, "\" rel=\"noopener\" target=\"_blank\" class=\"lh-link\">").concat(data.text, "</a>");
    },
    itemType_source_location: function itemType_source_location(data) {
      return this.itemType_url(data.url);
    },
    itemType_code: function itemType_code(data) {
      return "<pre class=\"lh-code\">".concat(data, "</pre>");
    },
    getData: function getData(data) {
      var itemType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'text';
      if (data == undefined) return '';
      itemType = itemType.replace('-', '_');
      var typeMethod = 'itemType_' + itemType;
      return this[typeMethod](data);
    },
    getChainTemplate: function getChainTemplate(data, type) {
      var html = '';

      for (var key in data) {
        var item = data[key];
        var hasChild = item.children && Object.keys(item.children).length;
        html += "<li class=\"".concat(hasChild ? 'has-child' : '', "\">\n                    ").concat(this.getChainSingleTemplate(item.request, type), "\n                    ").concat(hasChild ? '<ul class="chain-child">' + this.getChainTemplate(item.children, type) + '</ul>' : '', "\n                </li>");
      }

      return html;
    },
    getChainSingleTemplate: function getChainSingleTemplate(data, type) {
      type = type.replaceAll('-', '_');
      return this['getChildTemplate_' + type](data);
    },
    get_i18n: function get_i18n(key) {
      return this.parent_data.lighthouseResult.i18n.rendererFormattedStrings[key];
    },
    getHostName: function getHostName(url) {
      if (!this.is_valid_url(url)) return url;
      var domain = new URL(url);
      return domain.hostname.replace('www.', '');
    },
    getUrlExtension: function getUrlExtension(url) {
      var extStart = url.indexOf('.', url.lastIndexOf('/') + 1);
      if (extStart == -1) return '';
      var ext = url.substr(extStart + 1),
          extEnd = ext.search(/$|[?#]/);
      return ext.substring(0, extEnd);
    },
    urlIsFile: function urlIsFile(url) {
      return !!this.getUrlExtension(url);
    },
    getChildTemplate_critical_request_chains: function getChildTemplate_critical_request_chains(data) {
      return "<div class=\"chain-single\">\n                ".concat(this.itemType_url(data.url), "\n                <strong class=\"chain-duration\"> - ").concat(this.byteTokib(data.transferSize), "</strong>\n            </div>");
    },
    byteTokib: function byteTokib(bytes) {
      var fixed = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2;
      return (bytes / 1024).toFixed(fixed) + ' KiB';
    },
    getChain: function getChain(data) {
      var html = '';

      for (var key in data) {
        var item = data[key];
        var hasChild = item.children && Object.keys(item.children).length;
        html += "<li class=\"".concat(hasChild ? 'has-child' : '', "\">\n                    ").concat(this.itemHtml(item.request), "\n                    ").concat(hasChild ? '<ul class="chain-child">' + this.getChain(item.children) + '</ul>' : '', "\n                </li>");
      }

      return html;
    },
    getAcronym: function getAcronym(key) {
      var _this = this;

      return this.auditRefs.filter(function (audit) {
        return audit.id == key || audit.relevantAudits && audit.relevantAudits.includes(key);
      }).filter(function (audit) {
        return audit.acronym;
      }).map(function (audit) {
        return "<span class=\"data-audit__adorn\" title=\"Relevant to ".concat(_this.parent_data.lighthouseResult.audits[audit.id].title, "\">").concat(audit.acronym, "</span>");
      }).join('');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    return {
      activeTab: 'analyze'
    };
  },
  mounted: function mounted() {},
  methods: {
    isURL: function isURL(url) {
      return /^(ftp|http|https):\/\/[^ "]+$/.test(url);
    }
  },
  computed: {},
  watch: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      url: '',
      error: '',
      loading: false,
      loaded: 0,
      limit: 2,
      proNoticeShow: false,
      is_pro: !!window.wp_adminify__pagespeed_data.is_pro,
      pro_notice: window.wp_adminify__pagespeed_data.pro_notice
    };
  },
  mounted: function mounted() {
    this.$ = jQuery;
    this.adminify_data = window.wp_adminify__pagespeed_data;
  },
  methods: {
    startProgress: function startProgress() {
      this.loading = true;

      var _this = this;

      var max = 90;

      (function loop() {
        var rand = Math.floor(Math.random() * 5) + 1;
        setTimeout(function () {
          if (_this.loaded < max) {
            _this.loaded += rand;
            loop();
          }
        }, rand * 350);
      })();
    },
    completeProgress: function completeProgress() {
      this.loaded = 100;
    },
    checkLimit: function checkLimit() {
      return this.$.ajax({
        type: "POST",
        url: this.adminify_data.ajaxurl,
        data: {
          url: this.url,
          action: "adminify_page_speed",
          route: "count_total",
          _ajax_nonce: this.adminify_data.nonce
        }
      });
    },
    showProNotice: function showProNotice() {
      this.proNoticeShow = true;
      this.error = 'Max limit 2 reached in Free version';
    },
    alalyzeURL: function alalyzeURL() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var response, _this, isValid;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this2.loading) {
                  _context.next = 2;
                  break;
                }

                return _context.abrupt("return");

              case 2:
                if (_this2.is_pro) {
                  _context.next = 8;
                  break;
                }

                _context.next = 5;
                return _this2.checkLimit();

              case 5:
                response = _context.sent;

                if (!(response.data >= 2)) {
                  _context.next = 8;
                  break;
                }

                return _context.abrupt("return", _this2.showProNotice());

              case 8:
                _this = _this2;
                _this2.error = '';
                isValid = _this2.$parent.isURL(_this2.url);

                if (isValid) {
                  _context.next = 13;
                  break;
                }

                return _context.abrupt("return", _this2.error = 'Enter a valid URL');

              case 13:
                _this2.startProgress();

                _this2.$.ajax({
                  type: 'POST',
                  url: _this2.adminify_data.ajaxurl,
                  data: {
                    url: _this2.url,
                    action: 'adminify_page_speed',
                    route: 'new_analyze',
                    _ajax_nonce: _this2.adminify_data.nonce
                  }
                }).done(function (response) {
                  if (response && response.data) {
                    _this.completeProgress();

                    setTimeout(function () {
                      _this.$router.push({
                        path: "/report/".concat(response.data)
                      });
                    }, 350);
                  }
                }).fail(function (response) {
                  _this.loading = false;

                  if (response && response.responseJSON && response.responseJSON.data.message) {
                    return _this.error = response.responseJSON.data.message;
                  }

                  _this.error = 'Something is wrong, please try again later';
                });

              case 15:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  },
  watch: {
    url: function url() {
      this.error = '';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/history.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/history.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      total: 0,
      items_per_page: 5,
      histories: [],
      delete_history_popup: true,
      history_going_to_delete: null
    };
  },
  mounted: function mounted() {
    this.page = Number(this.$route.params.page) || 1;
    this.$ = jQuery;
    this.adminify_data = window.wp_adminify__pagespeed_data;
    this.fetchHistories(this.page, this.items_per_page);
  },
  methods: {
    showDeleteHistoryPopup: function showDeleteHistoryPopup() {
      var history = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      this.history_going_to_delete = history;
      this.showPopupOverlay();
      this.delete_history_popup = true;
    },
    hide_delete_history_popup: function hide_delete_history_popup() {
      this.hidePopupOverlay();
      this.history_going_to_delete = null;
      this.delete_history_popup = false;
    },
    showPopupOverlay: function showPopupOverlay() {
      this.$("body").addClass("wp-adminify--popup-show");
    },
    hidePopupOverlay: function hidePopupOverlay() {
      this.$("body").removeClass("wp-adminify--popup-show");
    },
    deleteHistory: function deleteHistory(history_id) {
      var history = this.histories.find(function (_history) {
        return _history.id == history_id;
      });

      var _this = this;

      this.showDeleteHistoryPopup(history);
    },
    _deleteHistory: function _deleteHistory() {
      var _this = this;

      _this.$.ajax({
        type: "POST",
        url: _this.adminify_data.ajaxurl,
        data: {
          url: _this.url,
          action: "adminify_page_speed",
          route: "delete_history",
          ids: [_this.history_going_to_delete.id],
          _ajax_nonce: _this.adminify_data.nonce
        },
        success: function success(response) {
          if (response && response.data) {
            _this.fetchHistories(_this.page, _this.items_per_page);
          }
        }
      }).always(function () {
        _this.hide_delete_history_popup();
      });
    },
    paginatePage: function paginatePage(page) {
      if (page < 1) return 1;
      if (page > this.pagination.total) return this.pagination.total;
      return page;
    },
    check_max_page: function check_max_page(total) {
      var items_per_page = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.items_per_page;
      var current_page = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : this.page;
      var max = Math.ceil(total / items_per_page);
      if (max == 0) return;

      if (current_page > max) {
        this.$router.push({
          path: "/history/".concat(max)
        });
      }
    },
    fetchHistories: function fetchHistories(page, items_per_page) {
      var _this = this;

      this.$.ajax({
        type: "POST",
        url: this.adminify_data.ajaxurl,
        data: {
          url: this.url,
          action: "adminify_page_speed",
          route: "fetch_histories",
          page: page,
          items_per_page: items_per_page,
          _ajax_nonce: this.adminify_data.nonce
        },
        success: function success(response) {
          if (response && response.data) {
            _this.total = response.data.total;
            _this.histories = response.data.histories;

            if (_this.page > 1 && _this.histories.length == 0) {
              _this.check_max_page(_this.total);
            }
          }
        }
      });
    },
    isURL: function isURL(url) {
      return /^(ftp|http|https):\/\/[^ "]+$/.test(url);
    }
  },
  computed: {
    pagination: function pagination() {
      var total = Math.ceil(this.total / this.items_per_page);
      var current = this.page;
      var pages = [];

      if (total > 5) {
        for (var n = 1; n <= total; n++) {
          var conditions = [n == 1, n == total, current == n, current - 1 == n, current + 1 == n, current == total && n > total - 3, current == 1 && n < 4];

          if (conditions.some(function (_state) {
            return _state;
          })) {
            pages.push(n);
          }
        }

        var _pages = JSON.parse(JSON.stringify(pages));

        var count = 0;
        pages.forEach(function (item, index) {
          if (item + 1 < pages[index + 1]) {
            _pages.splice(index + 1 + count, 0, ".");

            count++;
          }
        });
        pages = _pages;
      } else {
        for (var _n = 1; _n <= total; _n++) {
          pages.push(_n);
        }
      }

      return {
        total: total,
        current: current,
        pages: pages
      };
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/report.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/report.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_loop_data_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/loop-data.vue */ "./dev/admin/modules/page-speed/components/loop-data.vue");
/* harmony import */ var _components_lab_data_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/lab-data.vue */ "./dev/admin/modules/page-speed/components/lab-data.vue");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }



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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "report",
  components: {
    LoopData: _components_loop_data_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    LabData: _components_lab_data_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  data: function data() {
    return {
      // activeTab: "desktop",
      activeTab: "mobile",
      history: null,
      show_origin_sum: false,
      hasScreenshots: false
    };
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      var _yield$_this$fetchHis, data;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.history_id = Number(_this.$route.params.id) || 1;
              _this.$ = jQuery;
              _this.adminify_data = window.wp_adminify__pagespeed_data;
              _context.next = 5;
              return _this.fetchHistory();

            case 5:
              _yield$_this$fetchHis = _context.sent;
              data = _yield$_this$fetchHis.data;
              _this.history = data.history;
              _this.allowedTypes = ["criticalrequestchain", "filmstrip", "opportunity", "table", "statistics", "diagnostic"];
              _this.Audit = {
                SCORING_MODES: {
                  NUMERIC: "numeric",
                  BINARY: "binary",
                  MANUAL: "manual",
                  INFORMATIVE: "informative",
                  NOT_APPLICABLE: "notApplicable",
                  ERROR: "error"
                }
              };

            case 10:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    checkStatus: function checkStatus(data) {
      if (!data || !("overall_category" in data)) return -1;
      if ("overall_category" in data && data.overall_category == "FAST") return 1;
      return 0;
    },
    clampTo2Decimals: function clampTo2Decimals(val) {
      return Math.round(val * 100) / 100;
    },
    arithmeticMean: function arithmeticMean(items) {
      // Filter down to just the items with a weight as they have no effect on score
      items = items.filter(function (item) {
        return item.weight > 0;
      }); // If there is 1 null score, return a null average

      if (items.some(function (item) {
        return item.score === null;
      })) return null;
      var results = items.reduce(function (result, item) {
        var score = item.score;
        var weight = item.weight;
        return {
          weight: result.weight + weight,
          sum: result.sum +
          /** @type {number} */
          score * weight
        };
      }, {
        weight: 0,
        sum: 0
      });
      return this.clampTo2Decimals(results.sum / results.weight || 0);
    },
    scoreAllCategories: function scoreAllCategories(configCategories, resultsByAuditId) {
      var _this2 = this;

      var scoredCategories = {};

      for (var _i = 0, _Object$entries = Object.entries(configCategories); _i < _Object$entries.length; _i++) {
        var _Object$entries$_i = _slicedToArray(_Object$entries[_i], 2),
            categoryId = _Object$entries$_i[0],
            configCategory = _Object$entries$_i[1];

        var auditRefs = configCategory.auditRefs.map(function (configMember) {
          var member = _objectSpread({}, configMember);

          var result = resultsByAuditId[member.id];

          if (!result || result.scoreDisplayMode === _this2.Audit.SCORING_MODES.NOT_APPLICABLE || result.scoreDisplayMode === _this2.Audit.SCORING_MODES.INFORMATIVE || result.scoreDisplayMode === _this2.Audit.SCORING_MODES.MANUAL) {
            member.weight = 0;
          }

          return member;
        });
        var scores = auditRefs.map(function (auditRef) {
          return {
            score: resultsByAuditId[auditRef.id] ? resultsByAuditId[auditRef.id].score : 0,
            weight: auditRef.weight
          };
        });
        var score = this.arithmeticMean(scores);
        scoredCategories[categoryId] = _objectSpread(_objectSpread({}, configCategory), {}, {
          auditRefs: auditRefs,
          id: categoryId,
          score: score
        });
      }

      return scoredCategories;
    },
    toggleTab: function toggleTab(tab) {
      this.activeTab = tab;
    },
    fetchHistory: function fetchHistory() {
      return this.$.ajax({
        type: "POST",
        url: this.adminify_data.ajaxurl,
        data: {
          action: "adminify_page_speed",
          route: "fetch_history",
          id: this.history_id,
          _ajax_nonce: this.adminify_data.nonce
        }
      });
    }
  },
  computed: {
    display_data: function display_data() {
      var _data = {};

      for (var key in this.activeData.lighthouseResult.audits) {
        var audit = this.activeData.lighthouseResult.audits[key];

        if ("details" in audit && audit.details.type && this.allowedTypes.includes(audit.details.type)) {
          _data[key] = audit;
        }
      }

      this.hasScreenshots = false;
      var screenshots = {};
      var diagnostics = {};
      var opportunities = {};
      var passed_audits = {};

      for (var _key in _data) {
        var _audit = _data[_key];
        var type = _audit.details.type;
        var mode = _audit.scoreDisplayMode;

        if ("screenshot-thumbnails" == _key) {
          screenshots[_key] = _audit;
          this.hasScreenshots = true;
        } else if ("diagnostic" == type) {
          diagnostics[_key] = _audit;
        } else if ("opportunity" == type && 0.9 > _audit.score) {
          opportunities[_key] = _audit;
        } else if ("opportunity" != type && 0.9 > _audit.score) {
          diagnostics[_key] = _audit;
        } else if ("informative" == mode || "not_applicable" == mode) {
          diagnostics[_key] = _audit;
        } else {
          passed_audits[_key] = _audit;
        }
      }

      return {
        screenshots: screenshots,
        diagnostics: diagnostics,
        opportunities: opportunities,
        passed_audits: passed_audits
      };
    },
    desktop: function desktop() {
      return this.history.data_desktop;
    },
    mobile: function mobile() {
      return this.history.data_mobile;
    },
    activeData: function activeData() {
      return this[this.activeTab];
    },
    score: function score() {
      return this.activeTab == "desktop" ? this.history.score_desktop : this.history.score_mobile;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.node-snippet {\n    color: #2f66ff;\n}\n.filmstrip-list.screenshot-thumbnails {\n    display: -webkit-box;\n    display: -webkit-flex;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: normal;\n    -webkit-flex-direction: row;\n        -ms-flex-direction: row;\n            flex-direction: row;\n    -webkit-box-pack: justify;\n    -webkit-justify-content: space-between;\n        -ms-flex-pack: justify;\n            justify-content: space-between;\n}\n.filmstrip-list.screenshot-thumbnails li {\n    text-align: right;\n    position: relative;\n}\n.filmstrip-list.screenshot-thumbnails img {\n    border: 1px solid #ebebeb;\n    max-height: 100px;\n    max-width: 60px;\n}\n.data-table.data-details {\n    border-spacing: 0;\n    width: 100%;\n}\n.data-table.data-details th,\n.data-table.data-details td {\n    padding: 8px 6px;\n}\n.data-table.data-details tbody tr.data-row--odd td {\n    background: #f9f9fb;\n}\n.data-table.data-details .data-row--subitem td:first-child {\n    padding-left: 20px;\n}\n.data-table.data-details .data-table-column--thumbnail {\n    width: 48px;\n    padding: 0;\n    line-height: 0;\n}\n.data-table-column--thumbnail img {\n    -o-object-fit: cover;\n       object-fit: cover;\n    width: 48px;\n    height: 48px;\n}\n.chain-list {\n    font-size: 14px;\n}\n.chain-list li {\n    margin-bottom: 14px;\n}\n.chain-child {\n    margin-top: 14px;\n    padding-left: 30px;\n}\n\n", "",{"version":3,"sources":["webpack://./dev/admin/modules/page-speed/components/loop-data.vue"],"names":[],"mappings":";AAwaA;IACA,cAAA;AACA;AAEA;IACA,oBAAA;IAAA,qBAAA;IAAA,oBAAA;IAAA,aAAA;IACA,8BAAA;IAAA,6BAAA;IAAA,2BAAA;QAAA,uBAAA;YAAA,mBAAA;IACA,yBAAA;IAAA,sCAAA;QAAA,sBAAA;YAAA,8BAAA;AACA;AACA;IACA,iBAAA;IACA,kBAAA;AACA;AACA;IACA,yBAAA;IACA,iBAAA;IACA,eAAA;AACA;AAEA;IACA,iBAAA;IACA,WAAA;AACA;AAEA;;IAEA,gBAAA;AACA;AAEA;IACA,mBAAA;AACA;AAEA;IACA,kBAAA;AACA;AAEA;IACA,WAAA;IACA,UAAA;IACA,cAAA;AACA;AAEA;IACA,oBAAA;OAAA,iBAAA;IACA,WAAA;IACA,YAAA;AACA;AAEA;IACA,eAAA;AACA;AAEA;IACA,mBAAA;AACA;AAEA;IACA,gBAAA;IACA,kBAAA;AACA","sourcesContent":["<template>\n\n    <div class=\"data-audit-group data-audit-group--diagnostics\">\n\n        <div :id=\"itemIndex\" class=\"data-audit data-audit--binary mt-4\" :class=\"item.scoreDisplayMode == 'informative' ? 'data-metric--informative' : getScoreStatusClass( item.score )\" v-for=\"(item, itemIndex) in data\" :key=\"itemIndex\">\n            <details class=\"data-expandable-details\">\n\n                <summary>\n                    <div class=\"data-audit__header data-expandable-details__summary summary-wrapper\">\n                        <span class=\"data-audit__score-icon\"></span>\n                        <span class=\"data-audit__title-and-text summary-top mb-1\">\n                            <span class=\"data-audit__title\" v-html=\"item.title\"></span>\n                            <span class=\"data-audit__display-text\" v-html=\"item.displayValue\"></span>\n                        </span>\n                    </div>\n                </summary>\n\n                <div class=\"data-audit__description mt-4\">\n\n                    <span v-html=\"markdownToLink( item.description )\"></span>\n                    <span class=\"data-audit__adorn-list\" v-html=\"getAcronym(itemIndex)\"></span>\n                    \n                    <template v-if=\"item.details && item.details.type == 'filmstrip'\">\n                        <ul v-if=\"item.details.items\" :class=\"['filmstrip-list', itemIndex]\">\n                            <li v-for=\"(strip, strip_index) in item.details.items\" :key=\"`${item.details.type}-${strip_index}`\">\n                                <img :src=\"strip.data\" alt=\"\">\n                            </li>\n                        </ul>\n                    </template>\n                    \n                    <template v-if=\"item.details && item.details.type == 'criticalrequestchain'\">\n                        <ul v-if=\"item.details.chains\" :class=\"['chain-list', itemIndex]\" v-html=\"getChainTemplate( item.details.chains, itemIndex )\"></ul>\n                    </template>\n                    \n                    <template v-if=\"item.details && ['opportunity', 'table'].includes( item.details.type )\">\n                        <table v-if=\"item.details.items && item.details.items.length\" class=\"data-table data-details\">\n                            \n                            <thead>\n                                <tr>\n                                    <th :class=\"'data-table-column--' + getType(tdh)\" v-for=\"(tdh, thdIndex) in item.details.headings\" :key=\"thdIndex\">\n                                        <div class=\"data-text\">{{ getTabletLabel(tdh) }}</div>\n                                    </th>\n                                </tr>\n                            </thead>\n\n                            <tbody>\n                                <template v-for=\"(tr, trIndex) in item.details.items\">\n\n                                    <!-- Item -->\n                                    <tr :class=\"'data-row--' + ( trIndex % 2 ? 'odd' : 'even' )\" :key=\"`${tr.id}-${trIndex}`\">\n                                        \n                                        <template v-for=\"(trd, trdIndex) in item.details.headings\">\n\n                                            <td v-if=\"getKey(trd)\"\n                                                :class=\"'data-table-column--' + getType(trd)\"\n                                                :key=\"`${tr.id}-${trIndex}-${trdIndex}`\"\n                                                v-html=\"getData( tr[ getKey(trd) ], getType(trd) )\">\n                                            </td>\n\n                                            <td v-else class=\"data-table-column--empty\" :key=\"`${tr.id}-${trIndex}-${trdIndex}`\"></td>\n\n                                        </template>\n\n                                    </tr>\n\n                                    <!-- SubItems -->\n                                    <template v-if=\"tr.subItems && tr.subItems.items.length\">\n                                        <tr v-for=\"(trs, trsIndex) in tr.subItems.items\"\n                                            :class=\"'data-row--subitem data-row--' + ( trIndex % 2 ? 'odd' : 'even' )\"\n                                            :key=\"`${tr.id}-${trIndex}-${trsIndex}`\">\n\n                                            <template v-for=\"(trd, trdIndex) in item.details.headings\">\n\n                                                <td v-if=\"getKey(trd, true)\"\n                                                    :class=\"'data-table-column--' + getType(trd, true)\"\n                                                    :key=\"`${tr.id}-${trIndex}-${trsIndex}-${trdIndex}`\"\n                                                    v-html=\"getData( trs[ getKey(trd, true) ], getType(trd, true) )\">\n                                                </td>\n\n                                                <td v-else class=\"data-table-column--empty\" :key=\"`${tr.id}-${trIndex}-${trsIndex}-${trdIndex}`\"></td>\n\n                                            </template>\n\n                                        </tr>\n                                    </template>\n\n                                </template>\n                            </tbody>\n\n                        </table>\n                    </template>\n\n                </div>\n\n            </details>\n        </div>\n\n    </div>\n</template>\n\n<script>\nexport default {\n\n    data: () => ({\n    }),\n\n    props: {\n\n        data: {\n            type: Object,\n            required: true,\n            default() {\n                return {};\n            }\n        }\n\n    },\n\n    computed: {\n\n        parent_data() {\n            return this.$parent.activeData\n        },\n\n        auditRefs() {\n            return this.parent_data.lighthouseResult.categories.performance.auditRefs;\n        },\n\n    },\n\n    mounted() {\n\n    },\n\n    methods: {\n\n        getTabletLabel( data ) {\n            return data.text || data.label;\n        },\n\n        escapeHtml( text ) {\n            var map = {\n                '&': '&amp;',\n                '<': '&lt;',\n                '>': '&gt;',\n                '\"': '&quot;',\n                \"'\": '&#039;'\n            };\n\n            return text.replace(/[&<>\"']/g, function(m) { return map[m]; });\n        },\n\n        getKey( data, isSub = false ) {\n\n            if ( isSub && 'subItemsHeading' in data && 'key' in data.subItemsHeading && data.subItemsHeading.key ) {\n                return data.subItemsHeading.key;\n            }\n\n            if ( 'key' in data ) return data.key;\n\n            return null;\n\n        },\n\n        getType( data, isSub = false ) {\n\n            let data_type;\n\n            if ( isSub && 'subItemsHeading' in data ) {\n\n                if ( 'itemType' in data.subItemsHeading ) {\n                    data_type = data.subItemsHeading.itemType;\n                } else if ( 'valueType' in data.subItemsHeading ) {\n                    data_type = data.subItemsHeading.valueType;\n                }\n\n                if ( data_type ) return data_type;\n\n            }\n\n            if ( 'itemType' in data ) {\n                data_type = data.itemType;\n            } else if ( 'valueType' in data ) {\n                data_type = data.valueType;\n            }\n\n            return data_type;\n        \n        },\n\n        itemType_node( data ) {\n            let label = ('nodeLabel') in data ? data.nodeLabel : data.text;\n            return `<div class=\"single-node\"><div class=\"node-level\">${label}</div><div class=\"node-snippet\">${this.escapeHtml(data.snippet)}</div></div>`;\n        },\n\n        itemType_numeric( data ) {\n            return Math.round((data + Number.EPSILON) * 1000) / 1000;\n        },\n\n        is_valid_url(str) {\n            var pattern = new RegExp('^(https?:\\\\/\\\\/)?'+ // protocol\n                '((([a-z\\\\d]([a-z\\\\d-]*[a-z\\\\d])*)\\\\.)+[a-z]{2,}|'+ // domain name\n                '((\\\\d{1,3}\\\\.){3}\\\\d{1,3}))'+ // OR ip (v4) address\n                '(\\\\:\\\\d+)?(\\\\/[-a-z\\\\d%_.~+]*)*'+ // port and path\n                '(\\\\?[;&a-z\\\\d%_.~+=-]*)?'+ // query string\n                '(\\\\#[-a-z\\\\d_]*)?$','i'); // fragment locator\n            return !!pattern.test(str);\n        },\n\n        itemType_url( url ) {\n\n            if ( ! this.is_valid_url(url) ) return url;\n\n            let URL_Obj         = new URL( url );\n            let origin          = URL_Obj.origin;\n            let pathname        = URL_Obj.pathname == '/' ? '' : URL_Obj.pathname;\n            let isRoot          = ! pathname;\n            let query           = URL_Obj.search;\n            let hasQuery        = !! query;\n            let hostname        = URL_Obj.hostname.replace( 'www.', '' );\n            let short_url       = origin;\n            let isFileURL       = this.urlIsFile( pathname );\n            let displayHost     = true;\n\n            if ( ! isRoot ) {\n\n                let parts = pathname.split('/').filter( path => path );\n                let hasGap = false;\n    \n                if ( parts.length > 2 ) {\n                    hasGap = true;\n                    parts = parts.slice( Math.max(parts.length - 2, 0) );\n                }\n    \n                if ( isFileURL ) {\n                    \n                    if ( parts.length > 1 ) {\n    \n                        let dirs = parts[0];\n                        let file = parts[1];\n                        let dot_index = file.indexOf('.');\n    \n                        if ( dot_index > 9 ) {\n                            file = file.substring( 0, 9 ) + '...' + file.substring( dot_index );\n                            parts = [dirs, file];\n                        }\n    \n                    }\n    \n                }\n    \n                if ( parts.length ) pathname = parts.join('/');\n                short_url = ( hasGap ? '...' : '/' ) + pathname;\n\n            }\n\n            if ( ! isRoot && ! isFileURL && ! hasQuery ) short_url += '/';\n\n            if ( hasQuery ) {\n                if ( ! isRoot ) {\n                    if ( query.length > 20 ) query = query.substr( 0, 20 ) + '...';\n                    short_url += '/' + query;\n                }\n            }\n\n            if ( short_url.indexOf('...') < 0 && short_url.indexOf(hostname) > 0 && (new URL(short_url)).host == hostname ) displayHost = false;\n\n            let template = `<span class=\"chain-url\" title=\"${url}\" data-url=\"${url}\"><a rel=\"noopener\" target=\"_blank\" href=\"${url}\" class=\"chain-link\">${short_url}</a>`;\n                if ( displayHost ) template += `<span class=\"chain-host\">(${hostname})</span>`;\n            template += `</span>`;\n\n            return template;\n\n        },\n\n        itemType_ms( ms ) {\n\n            let second = 1000;\n            let minute = 60 * second;\n            let hour = 60 * minute;\n            let day = 24 * hour;\n            let year = 365 * day;\n\n            if ( ms >= year ) return Math.round(ms/year) + ' y';\n            if ( ms >= day ) return Math.round(ms/day) + ' d';\n            if ( ms >= hour ) return Math.round(ms/hour) + ' h';\n            if ( ms >= minute ) return Math.round(ms/minute) + ' m';\n            if ( ms >= second ) return Math.round(ms/second) + ' s';\n            \n            return Math.floor(ms) + ' ms';\n\n        },\n\n        itemType_text( data ) {\n            return data;\n        },\n\n        itemType_thumbnail( data ) {\n            return `<img class=\"lh-thumbnail\" src=\"${data}\" title=\"${data}\" alt=\"\">`\n        },\n\n        itemType_timespanMs( data ) {\n            return data;\n        },\n\n        itemType_bytes( data ) {\n            return this.byteTokib( data, 0 );\n        },\n\n        itemType_link( data ) {\n            return `<a href=\"${data.url}\" rel=\"noopener\" target=\"_blank\" class=\"lh-link\">${data.text}</a>`\n        },\n\n        itemType_source_location( data ) {\n            return this.itemType_url( data.url );\n        },\n\n        itemType_code( data ) {\n            return `<pre class=\"lh-code\">${data}</pre>`;\n        },\n\n        getData( data, itemType = 'text' ) {\n            if ( data == undefined ) return '';\n            itemType = itemType.replace( '-', '_' );\n            let typeMethod = 'itemType_' + itemType;\n            return this[typeMethod]( data );\n        },\n\n        getChainTemplate( data, type ) {\n\n            let html = '';\n\n            for ( let key in data ) {\n\n                let item = data[key];\n                let hasChild = item.children && Object.keys(item.children).length;\n\n                html += `<li class=\"${hasChild ? 'has-child' : ''}\">\n                    ${ this.getChainSingleTemplate( item.request, type ) }\n                    ${ hasChild ? '<ul class=\"chain-child\">' + this.getChainTemplate( item.children, type ) + '</ul>' : '' }\n                </li>`;\n\n            }\n\n            return html;\n\n        },\n\n        getChainSingleTemplate( data, type ) {\n            type = type.replaceAll('-', '_');\n            return this[ 'getChildTemplate_' + type ]( data );\n        },\n\n        get_i18n( key ) {\n            return this.parent_data.lighthouseResult.i18n.rendererFormattedStrings[key];\n        },\n\n        getHostName( url ) {\n            if ( ! this.is_valid_url(url) ) return url;\n            let domain = (new URL(url));\n            return domain.hostname.replace('www.','');\n        },\n\n        getUrlExtension( url ) {\n            let extStart = url.indexOf('.',url.lastIndexOf('/')+1);\n            if ( extStart == -1 ) return '';\n            let ext = url.substr(extStart+1),\n            extEnd = ext.search(/$|[?#]/);\n            return ext.substring (0,extEnd);\n        },\n\n        urlIsFile( url ) {\n            return !! this.getUrlExtension( url );\n        },\n\n        getChildTemplate_critical_request_chains( data ) {\n            \n            return `<div class=\"chain-single\">\n                ${ this.itemType_url( data.url ) }\n                <strong class=\"chain-duration\"> - ${this.byteTokib(data.transferSize)}</strong>\n            </div>`\n\n        },\n\n        byteTokib( bytes, fixed = 2 ) {\n            return (bytes / 1024).toFixed( fixed ) + ' KiB';\n        },\n\n        getChain( data ) {\n\n            let html = '';\n\n            for ( let key in data ) {\n\n                let item = data[key];\n                let hasChild = item.children && Object.keys(item.children).length;\n\n                html += `<li class=\"${hasChild ? 'has-child' : ''}\">\n                    ${ this.itemHtml( item.request ) }\n                    ${ hasChild ? '<ul class=\"chain-child\">' + this.getChain( item.children ) + '</ul>' : '' }\n                </li>`;\n\n            }\n\n            return html;\n\n        },\n\n        getAcronym( key ) {\n            return this.auditRefs\n                .filter( audit => audit.id == key || ( audit.relevantAudits && audit.relevantAudits.includes(key)) )\n                .filter( audit => audit.acronym )\n                .map( audit => `<span class=\"data-audit__adorn\" title=\"Relevant to ${ this.parent_data.lighthouseResult.audits[audit.id].title }\">${ audit.acronym }</span>`)\n                .join('');\n        }\n\n    }\n\n}\n</script>\n\n\n<style>\n\n    .node-snippet {\n        color: #2f66ff;\n    }\n\n    .filmstrip-list.screenshot-thumbnails {\n        display: flex;\n        flex-direction: row;\n        justify-content: space-between;\n    }\n    .filmstrip-list.screenshot-thumbnails li {\n        text-align: right;\n        position: relative;\n    }\n    .filmstrip-list.screenshot-thumbnails img {\n        border: 1px solid #ebebeb;\n        max-height: 100px;\n        max-width: 60px;\n    }\n\n    .data-table.data-details {\n        border-spacing: 0;\n        width: 100%;\n    }\n\n    .data-table.data-details th,\n    .data-table.data-details td {\n        padding: 8px 6px;\n    }\n\n    .data-table.data-details tbody tr.data-row--odd td {\n        background: #f9f9fb;\n    }\n\n    .data-table.data-details .data-row--subitem td:first-child {\n        padding-left: 20px;\n    }\n\n    .data-table.data-details .data-table-column--thumbnail {\n        width: 48px;\n        padding: 0;\n        line-height: 0;\n    }\n\n    .data-table-column--thumbnail img {\n        object-fit: cover;\n        width: 48px;\n        height: 48px;\n    }\n\n    .chain-list {\n        font-size: 14px;\n    }\n\n    .chain-list li {\n        margin-bottom: 14px;\n    }\n    \n    .chain-child {\n        margin-top: 14px;\n        padding-left: 30px;\n    }\n\n</style>"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./loop-data.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./dev/admin/modules/page-speed/components/history-single.vue":
/*!********************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/history-single.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _history_single_vue_vue_type_template_id_41467144___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./history-single.vue?vue&type=template&id=41467144& */ "./dev/admin/modules/page-speed/components/history-single.vue?vue&type=template&id=41467144&");
/* harmony import */ var _history_single_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./history-single.vue?vue&type=script&lang=js& */ "./dev/admin/modules/page-speed/components/history-single.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _history_single_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _history_single_vue_vue_type_template_id_41467144___WEBPACK_IMPORTED_MODULE_0__.render,
  _history_single_vue_vue_type_template_id_41467144___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/page-speed/components/history-single.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/page-speed/components/lab-data.vue":
/*!**************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/lab-data.vue ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _lab_data_vue_vue_type_template_id_377c4d4d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lab-data.vue?vue&type=template&id=377c4d4d& */ "./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=template&id=377c4d4d&");
/* harmony import */ var _lab_data_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lab-data.vue?vue&type=script&lang=js& */ "./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _lab_data_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _lab_data_vue_vue_type_template_id_377c4d4d___WEBPACK_IMPORTED_MODULE_0__.render,
  _lab_data_vue_vue_type_template_id_377c4d4d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/page-speed/components/lab-data.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/page-speed/components/loop-data.vue":
/*!***************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/loop-data.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _loop_data_vue_vue_type_template_id_358d6be0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./loop-data.vue?vue&type=template&id=358d6be0& */ "./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=template&id=358d6be0&");
/* harmony import */ var _loop_data_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./loop-data.vue?vue&type=script&lang=js& */ "./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=script&lang=js&");
/* harmony import */ var _loop_data_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./loop-data.vue?vue&type=style&index=0&lang=css& */ "./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _loop_data_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _loop_data_vue_vue_type_template_id_358d6be0___WEBPACK_IMPORTED_MODULE_0__.render,
  _loop_data_vue_vue_type_template_id_358d6be0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/page-speed/components/loop-data.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/page-speed/page-speed-app.vue":
/*!*********************************************************!*\
  !*** ./dev/admin/modules/page-speed/page-speed-app.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _page_speed_app_vue_vue_type_template_id_7effdd7a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./page-speed-app.vue?vue&type=template&id=7effdd7a& */ "./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=template&id=7effdd7a&");
/* harmony import */ var _page_speed_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./page-speed-app.vue?vue&type=script&lang=js& */ "./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _page_speed_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _page_speed_app_vue_vue_type_template_id_7effdd7a___WEBPACK_IMPORTED_MODULE_0__.render,
  _page_speed_app_vue_vue_type_template_id_7effdd7a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/page-speed/page-speed-app.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/analyze.vue":
/*!********************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/analyze.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _analyze_vue_vue_type_template_id_99ffa9ea___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./analyze.vue?vue&type=template&id=99ffa9ea& */ "./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=template&id=99ffa9ea&");
/* harmony import */ var _analyze_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./analyze.vue?vue&type=script&lang=js& */ "./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _analyze_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _analyze_vue_vue_type_template_id_99ffa9ea___WEBPACK_IMPORTED_MODULE_0__.render,
  _analyze_vue_vue_type_template_id_99ffa9ea___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/page-speed/pages/analyze.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/history.vue":
/*!********************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/history.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _history_vue_vue_type_template_id_e3c0635a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./history.vue?vue&type=template&id=e3c0635a& */ "./dev/admin/modules/page-speed/pages/history.vue?vue&type=template&id=e3c0635a&");
/* harmony import */ var _history_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./history.vue?vue&type=script&lang=js& */ "./dev/admin/modules/page-speed/pages/history.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _history_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _history_vue_vue_type_template_id_e3c0635a___WEBPACK_IMPORTED_MODULE_0__.render,
  _history_vue_vue_type_template_id_e3c0635a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/page-speed/pages/history.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/report.vue":
/*!*******************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/report.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _report_vue_vue_type_template_id_0b9b6bc5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./report.vue?vue&type=template&id=0b9b6bc5& */ "./dev/admin/modules/page-speed/pages/report.vue?vue&type=template&id=0b9b6bc5&");
/* harmony import */ var _report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./report.vue?vue&type=script&lang=js& */ "./dev/admin/modules/page-speed/pages/report.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _report_vue_vue_type_template_id_0b9b6bc5___WEBPACK_IMPORTED_MODULE_0__.render,
  _report_vue_vue_type_template_id_0b9b6bc5___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "dev/admin/modules/page-speed/pages/report.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./dev/admin/modules/page-speed/components/history-single.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/history-single.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_history_single_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./history-single.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/history-single.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_history_single_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lab_data_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lab-data.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lab_data_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./loop-data.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_page_speed_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./page-speed-app.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_page_speed_app_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_analyze_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./analyze.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_analyze_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/history.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/history.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_history_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./history.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/history.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_history_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/report.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/report.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./report.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/report.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css&":
/*!************************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_102_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./loop-data.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-102[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./dev/admin/modules/page-speed/components/history-single.vue?vue&type=template&id=41467144&":
/*!***************************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/history-single.vue?vue&type=template&id=41467144& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_history_single_vue_vue_type_template_id_41467144___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_history_single_vue_vue_type_template_id_41467144___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_history_single_vue_vue_type_template_id_41467144___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./history-single.vue?vue&type=template&id=41467144& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/history-single.vue?vue&type=template&id=41467144&");


/***/ }),

/***/ "./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=template&id=377c4d4d&":
/*!*********************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=template&id=377c4d4d& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lab_data_vue_vue_type_template_id_377c4d4d___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lab_data_vue_vue_type_template_id_377c4d4d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lab_data_vue_vue_type_template_id_377c4d4d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lab-data.vue?vue&type=template&id=377c4d4d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=template&id=377c4d4d&");


/***/ }),

/***/ "./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=template&id=358d6be0&":
/*!**********************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=template&id=358d6be0& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_template_id_358d6be0___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_template_id_358d6be0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_loop_data_vue_vue_type_template_id_358d6be0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./loop-data.vue?vue&type=template&id=358d6be0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=template&id=358d6be0&");


/***/ }),

/***/ "./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=template&id=7effdd7a&":
/*!****************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=template&id=7effdd7a& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_page_speed_app_vue_vue_type_template_id_7effdd7a___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_page_speed_app_vue_vue_type_template_id_7effdd7a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_page_speed_app_vue_vue_type_template_id_7effdd7a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./page-speed-app.vue?vue&type=template&id=7effdd7a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=template&id=7effdd7a&");


/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=template&id=99ffa9ea&":
/*!***************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=template&id=99ffa9ea& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_analyze_vue_vue_type_template_id_99ffa9ea___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_analyze_vue_vue_type_template_id_99ffa9ea___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_analyze_vue_vue_type_template_id_99ffa9ea___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./analyze.vue?vue&type=template&id=99ffa9ea& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=template&id=99ffa9ea&");


/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/history.vue?vue&type=template&id=e3c0635a&":
/*!***************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/history.vue?vue&type=template&id=e3c0635a& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_history_vue_vue_type_template_id_e3c0635a___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_history_vue_vue_type_template_id_e3c0635a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_history_vue_vue_type_template_id_e3c0635a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./history.vue?vue&type=template&id=e3c0635a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/history.vue?vue&type=template&id=e3c0635a&");


/***/ }),

/***/ "./dev/admin/modules/page-speed/pages/report.vue?vue&type=template&id=0b9b6bc5&":
/*!**************************************************************************************!*\
  !*** ./dev/admin/modules/page-speed/pages/report.vue?vue&type=template&id=0b9b6bc5& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_report_vue_vue_type_template_id_0b9b6bc5___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_report_vue_vue_type_template_id_0b9b6bc5___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_report_vue_vue_type_template_id_0b9b6bc5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./report.vue?vue&type=template&id=0b9b6bc5& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/report.vue?vue&type=template&id=0b9b6bc5&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/history-single.vue?vue&type=template&id=41467144&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/history-single.vue?vue&type=template&id=41467144& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
  return _c("tr", [
    _c("td", { staticClass: "has-text-left" }, [
      _c("div", { staticClass: "screenshot-wrapper" }, [
        _c("img", { attrs: { src: _vm.history.screenshot, width: "100" } })
      ])
    ]),
    _vm._v(" "),
    _c("td", { staticClass: "has-text-left" }, [
      _c("div", { staticClass: "log-date-time is-relative pl-3" }, [
        _c("time", { attrs: { datetime: _vm.history.time } }, [
          _c("div", { staticClass: "date" }, [
            _vm._v(_vm._s(_vm.history.formated_date))
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "time is-relative pl-4" }, [
            _vm._v(_vm._s(_vm.history.formated_time))
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c("td", { staticClass: "has-text-left" }, [
      _c(
        "div",
        { staticClass: "url", staticStyle: { "text-transform": "initial" } },
        [
          _c(
            "a",
            {
              ref: "noreferrer noopener",
              attrs: { href: _vm.history.url, target: "_blank" }
            },
            [_vm._v(_vm._s(_vm.history.url))]
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c("td", { staticClass: "has-text-centered" }, [
      _c("div", { staticClass: "progress-chart desktop" }, [
        _c("span", { staticClass: "progress-percentagte" }, [
          _vm._v(_vm._s(_vm.history.score_desktop))
        ])
      ])
    ]),
    _vm._v(" "),
    _c("td", { staticClass: "has-text-centered" }, [
      _c("div", { staticClass: "progress-chart mobile" }, [
        _c("span", { staticClass: "progress-percentagte" }, [
          _vm._v(_vm._s(_vm.history.score_mobile))
        ])
      ])
    ]),
    _vm._v(" "),
    _c(
      "td",
      { staticClass: "has-text-right" },
      [
        _c(
          "router-link",
          {
            staticClass: "report-button",
            attrs: { to: "/report/" + _vm.history.id, tag: "button" }
          },
          [_vm._v("Full report")]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "remove-button",
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.deleteHistory.apply(null, arguments)
              }
            }
          },
          [_vm._v("Delete")]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=template&id=377c4d4d&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/lab-data.vue?vue&type=template&id=377c4d4d& ***!
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
  return _c(
    "div",
    { staticClass: "data-audit-group data-audit-group--metrics" },
    [
      _c("div", { staticClass: "data-audit-group__header is-pulled-left" }, [
        _vm._v("Lab Data")
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "data-audit-tab is-pulled-right" }, [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.isDetail,
              expression: "isDetail"
            }
          ],
          staticClass: "data-metrics-toggle__input",
          attrs: {
            type: "checkbox",
            id: "data-metric-descriptions",
            "aria-label": "Toggle the display of metric descriptions"
          },
          domProps: {
            checked: Array.isArray(_vm.isDetail)
              ? _vm._i(_vm.isDetail, null) > -1
              : _vm.isDetail
          },
          on: {
            change: function($event) {
              var $$a = _vm.isDetail,
                $$el = $event.target,
                $$c = $$el.checked ? true : false
              if (Array.isArray($$a)) {
                var $$v = null,
                  $$i = _vm._i($$a, $$v)
                if ($$el.checked) {
                  $$i < 0 && (_vm.isDetail = $$a.concat([$$v]))
                } else {
                  $$i > -1 &&
                    (_vm.isDetail = $$a
                      .slice(0, $$i)
                      .concat($$a.slice($$i + 1)))
                }
              } else {
                _vm.isDetail = $$c
              }
            }
          }
        }),
        _vm._v(" "),
        _c(
          "label",
          {
            staticClass: "data-metrics-toggle__label is-flex",
            attrs: { for: "data-metric-descriptions" }
          },
          [
            _c(
              "div",
              {
                staticClass:
                  "\n          data-metrics-toggle__icon data-metrics-toggle__icon--less\n          is-flex is-align-items-center is-justify-content-center\n        ",
                attrs: { "aria-hidden": "true" }
              },
              [
                _c(
                  "svg",
                  {
                    attrs: {
                      xmlns: "http://www.w3.org/2000/svg",
                      "xmlns:xlink": "http://www.w3.org/1999/xlink",
                      width: "24",
                      height: "24",
                      viewBox: "0 0 24 24"
                    }
                  },
                  [
                    _c("path", {
                      staticClass: "data-metrics-toggle__lines",
                      attrs: { d: "M4 9h16v2H4zm0 4h10v2H4z" }
                    })
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "\n          data-metrics-toggle__icon data-metrics-toggle__icon--more\n          is-flex is-align-items-center is-justify-content-center\n        ",
                attrs: { "aria-hidden": "true" }
              },
              [
                _c(
                  "svg",
                  {
                    attrs: {
                      xmlns: "http://www.w3.org/2000/svg",
                      width: "24",
                      height: "24",
                      viewBox: "0 0 24 24"
                    }
                  },
                  [
                    _c("path", {
                      staticClass: "data-metrics-toggle__lines",
                      attrs: {
                        d: "M3 18h12v-2H3v2zM3 6v2h18V6H3zm0 7h18v-2H3v2z"
                      }
                    })
                  ]
                )
              ]
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "data-metrics-container pt-5 mt-6" }, [
        _c("div", { staticClass: "columns" }, [
          _c("div", { staticClass: "column" }, [
            _c(
              "div",
              {
                staticClass: "data-metric",
                class: _vm.getScoreStatusClass(
                  _vm.data.lighthouseResult.audits["first-contentful-paint"]
                    .score
                ),
                attrs: { id: "first-contentful-paint" }
              },
              [
                _c(
                  "div",
                  { staticClass: "data-metric__innerwrap summary-wrapper" },
                  [
                    _c("div", { staticClass: "summary-top" }, [
                      _c(
                        "span",
                        {
                          staticClass:
                            "data-metric__title summary-description is-pulled-left"
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.data.lighthouseResult.audits[
                                "first-contentful-paint"
                              ].title
                            )
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "\n                  data-metric__value\n                  summary-value\n                  adminify-ps-pass\n                  is-pulled-right\n                "
                        },
                        [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                _vm.data.lighthouseResult.audits[
                                  "first-contentful-paint"
                                ].displayValue
                              ) +
                              "\n              "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm.isDetail
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "data-metric__description result-description"
                          },
                          [
                            _c("span", {
                              domProps: {
                                innerHTML: _vm._s(
                                  _vm.markdownToLink(
                                    _vm.data.lighthouseResult.audits[
                                      "first-contentful-paint"
                                    ].description
                                  )
                                )
                              }
                            })
                          ]
                        )
                      : _vm._e()
                  ]
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "column" }, [
            _c(
              "div",
              {
                staticClass: "data-metric",
                class: _vm.getScoreStatusClass(
                  _vm.data.lighthouseResult.audits["interactive"].score
                ),
                attrs: { id: "interactive" }
              },
              [
                _c(
                  "div",
                  { staticClass: "data-metric__innerwrap summary-wrapper" },
                  [
                    _c("div", { staticClass: "summary-top" }, [
                      _c(
                        "span",
                        {
                          staticClass:
                            "data-metric__title summary-description is-pulled-left"
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.data.lighthouseResult.audits["interactive"]
                                .title
                            )
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "\n                  data-metric__value\n                  summary-value\n                  adminify-ps-pass\n                  is-pulled-right\n                "
                        },
                        [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                _vm.data.lighthouseResult.audits["interactive"]
                                  .displayValue
                              ) +
                              "\n              "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm.isDetail
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "data-metric__description result-description"
                          },
                          [
                            _c("span", {
                              domProps: {
                                innerHTML: _vm._s(
                                  _vm.markdownToLink(
                                    _vm.data.lighthouseResult.audits[
                                      "interactive"
                                    ].description
                                  )
                                )
                              }
                            })
                          ]
                        )
                      : _vm._e()
                  ]
                )
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "columns" }, [
          _c("div", { staticClass: "column" }, [
            _c(
              "div",
              {
                staticClass: "data-metric",
                class: _vm.getScoreStatusClass(
                  _vm.data.lighthouseResult.audits["speed-index"].score
                ),
                attrs: { id: "speed-index" }
              },
              [
                _c(
                  "div",
                  { staticClass: "data-metric__innerwrap summary-wrapper" },
                  [
                    _c("div", { staticClass: "summary-top" }, [
                      _c(
                        "span",
                        {
                          staticClass:
                            "data-metric__title summary-description is-pulled-left"
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.data.lighthouseResult.audits["speed-index"]
                                .title
                            )
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "\n                  data-metric__value\n                  summary-value\n                  adminify-ps-pass\n                  is-pulled-right\n                "
                        },
                        [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                _vm.data.lighthouseResult.audits["speed-index"]
                                  .displayValue
                              ) +
                              "\n              "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm.isDetail
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "data-metric__description result-description"
                          },
                          [
                            _c("span", {
                              domProps: {
                                innerHTML: _vm._s(
                                  _vm.markdownToLink(
                                    _vm.data.lighthouseResult.audits[
                                      "speed-index"
                                    ].description
                                  )
                                )
                              }
                            })
                          ]
                        )
                      : _vm._e()
                  ]
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "column" }, [
            _c(
              "div",
              {
                staticClass: "data-metric",
                class: _vm.getScoreStatusClass(
                  _vm.data.lighthouseResult.audits["total-blocking-time"].score
                ),
                attrs: { id: "total-blocking-time" }
              },
              [
                _c(
                  "div",
                  { staticClass: "data-metric__innerwrap summary-wrapper" },
                  [
                    _c("div", { staticClass: "summary-top" }, [
                      _c(
                        "span",
                        {
                          staticClass:
                            "data-metric__title summary-description is-pulled-left"
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.data.lighthouseResult.audits[
                                "total-blocking-time"
                              ].title
                            )
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "\n                  data-metric__value\n                  summary-value\n                  adminify-ps-pass\n                  is-pulled-right\n                "
                        },
                        [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                _vm.data.lighthouseResult.audits[
                                  "total-blocking-time"
                                ].displayValue
                              ) +
                              "\n              "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm.isDetail
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "data-metric__description result-description"
                          },
                          [
                            _c("span", {
                              domProps: {
                                innerHTML: _vm._s(
                                  _vm.markdownToLink(
                                    _vm.data.lighthouseResult.audits[
                                      "total-blocking-time"
                                    ].description
                                  )
                                )
                              }
                            })
                          ]
                        )
                      : _vm._e()
                  ]
                )
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "columns" }, [
          _c("div", { staticClass: "column" }, [
            _c(
              "div",
              {
                staticClass: "data-metric",
                class: _vm.getScoreStatusClass(
                  _vm.data.lighthouseResult.audits["largest-contentful-paint"]
                    .score
                ),
                attrs: { id: "largest-contentful-paint" }
              },
              [
                _c(
                  "div",
                  { staticClass: "data-metric__innerwrap summary-wrapper" },
                  [
                    _c("div", { staticClass: "summary-top" }, [
                      _c(
                        "span",
                        {
                          staticClass:
                            "data-metric__title summary-description is-pulled-left"
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.data.lighthouseResult.audits[
                                "largest-contentful-paint"
                              ].title
                            ) + "\n                "
                          ),
                          _c("a", {
                            staticClass: "icon--cwv",
                            attrs: {
                              href: "https://web.dev/vitals",
                              target: "_blank",
                              title: "Core Web Vital"
                            }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "\n                  data-metric__value\n                  summary-value\n                  adminify-ps-average\n                  is-pulled-right\n                "
                        },
                        [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                _vm.data.lighthouseResult.audits[
                                  "largest-contentful-paint"
                                ].displayValue
                              ) +
                              "\n              "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm.isDetail
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "data-metric__description result-description"
                          },
                          [
                            _c("span", {
                              domProps: {
                                innerHTML: _vm._s(
                                  _vm.markdownToLink(
                                    _vm.data.lighthouseResult.audits[
                                      "largest-contentful-paint"
                                    ].description
                                  )
                                )
                              }
                            })
                          ]
                        )
                      : _vm._e()
                  ]
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "column" }, [
            _c(
              "div",
              {
                staticClass: "data-metric",
                class: _vm.getScoreStatusClass(
                  _vm.data.lighthouseResult.audits["cumulative-layout-shift"]
                    .score
                ),
                attrs: { id: "cumulative-layout-shift" }
              },
              [
                _c(
                  "div",
                  { staticClass: "data-metric__innerwrap summary-wrapper" },
                  [
                    _c("div", { staticClass: "summary-top" }, [
                      _c(
                        "span",
                        {
                          staticClass:
                            "data-metric__title summary-description is-pulled-left"
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.data.lighthouseResult.audits[
                                "cumulative-layout-shift"
                              ].title
                            ) + "\n                "
                          ),
                          _c("a", {
                            staticClass: "icon--cwv",
                            attrs: {
                              href: "https://web.dev/vitals",
                              target: "_blank",
                              title: "Core Web Vital"
                            }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "\n                  data-metric__value\n                  summary-value\n                  adminify-ps-pass\n                  is-pulled-right\n                "
                        },
                        [
                          _vm._v(
                            "\n                " +
                              _vm._s(
                                _vm.data.lighthouseResult.audits[
                                  "cumulative-layout-shift"
                                ].displayValue
                              ) +
                              "\n              "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm.isDetail
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "data-metric__description result-description"
                          },
                          [
                            _c("span", {
                              domProps: {
                                innerHTML: _vm._s(
                                  _vm.markdownToLink(
                                    _vm.data.lighthouseResult.audits[
                                      "cumulative-layout-shift"
                                    ].description
                                  )
                                )
                              }
                            })
                          ]
                        )
                      : _vm._e()
                  ]
                )
              ]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "data-metrics__disclaimer result-description mt-5 pt-5 mb-5"
        },
        [
          _c("span", {
            domProps: {
              innerHTML: _vm._s(
                _vm.markdownToLink(
                  _vm.data.lighthouseResult.i18n.rendererFormattedStrings
                    .varianceDisclaimer
                )
              )
            }
          }),
          _vm._v(" "),
          _c(
            "a",
            {
              attrs: {
                href:
                  "https://googlechrome.github.io/lighthouse/scorecalc/#FCP=" +
                  _vm.data.lighthouseResult.audits["first-contentful-paint"]
                    .numericValue +
                  "&SI=" +
                  _vm.data.lighthouseResult.audits["speed-index"].numericValue +
                  "&LCP=" +
                  _vm.data.lighthouseResult.audits["largest-contentful-paint"]
                    .numericValue +
                  "&TTI=" +
                  _vm.data.lighthouseResult.audits["interactive"].numericValue +
                  "&TBT=" +
                  _vm.data.lighthouseResult.audits["total-blocking-time"]
                    .numericValue +
                  "&CLS=" +
                  _vm.data.lighthouseResult.audits["cumulative-layout-shift"]
                    .numericValue +
                  "&FMP=" +
                  _vm.data.lighthouseResult.audits["first-meaningful-paint"]
                    .numericValue +
                  "&device=" +
                  _vm.device +
                  "&version=" +
                  _vm.data.lighthouseResult.lighthouseVersion,
                target: "_blank"
              }
            },
            [
              _vm._v(
                "\n      " +
                  _vm._s(
                    _vm.data.lighthouseResult.i18n.rendererFormattedStrings
                      .calculatorLink
                  ) +
                  "\n    "
              )
            ]
          )
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=template&id=358d6be0&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/components/loop-data.vue?vue&type=template&id=358d6be0& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "data-audit-group data-audit-group--diagnostics" },
    _vm._l(_vm.data, function(item, itemIndex) {
      return _c(
        "div",
        {
          key: itemIndex,
          staticClass: "data-audit data-audit--binary mt-4",
          class:
            item.scoreDisplayMode == "informative"
              ? "data-metric--informative"
              : _vm.getScoreStatusClass(item.score),
          attrs: { id: itemIndex }
        },
        [
          _c("details", { staticClass: "data-expandable-details" }, [
            _c("summary", [
              _c(
                "div",
                {
                  staticClass:
                    "data-audit__header data-expandable-details__summary summary-wrapper"
                },
                [
                  _c("span", { staticClass: "data-audit__score-icon" }),
                  _vm._v(" "),
                  _c(
                    "span",
                    {
                      staticClass: "data-audit__title-and-text summary-top mb-1"
                    },
                    [
                      _c("span", {
                        staticClass: "data-audit__title",
                        domProps: { innerHTML: _vm._s(item.title) }
                      }),
                      _vm._v(" "),
                      _c("span", {
                        staticClass: "data-audit__display-text",
                        domProps: { innerHTML: _vm._s(item.displayValue) }
                      })
                    ]
                  )
                ]
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "data-audit__description mt-4" },
              [
                _c("span", {
                  domProps: {
                    innerHTML: _vm._s(_vm.markdownToLink(item.description))
                  }
                }),
                _vm._v(" "),
                _c("span", {
                  staticClass: "data-audit__adorn-list",
                  domProps: { innerHTML: _vm._s(_vm.getAcronym(itemIndex)) }
                }),
                _vm._v(" "),
                item.details && item.details.type == "filmstrip"
                  ? [
                      item.details.items
                        ? _c(
                            "ul",
                            { class: ["filmstrip-list", itemIndex] },
                            _vm._l(item.details.items, function(
                              strip,
                              strip_index
                            ) {
                              return _c(
                                "li",
                                { key: item.details.type + "-" + strip_index },
                                [
                                  _c("img", {
                                    attrs: { src: strip.data, alt: "" }
                                  })
                                ]
                              )
                            }),
                            0
                          )
                        : _vm._e()
                    ]
                  : _vm._e(),
                _vm._v(" "),
                item.details && item.details.type == "criticalrequestchain"
                  ? [
                      item.details.chains
                        ? _c("ul", {
                            class: ["chain-list", itemIndex],
                            domProps: {
                              innerHTML: _vm._s(
                                _vm.getChainTemplate(
                                  item.details.chains,
                                  itemIndex
                                )
                              )
                            }
                          })
                        : _vm._e()
                    ]
                  : _vm._e(),
                _vm._v(" "),
                item.details &&
                ["opportunity", "table"].includes(item.details.type)
                  ? [
                      item.details.items && item.details.items.length
                        ? _c(
                            "table",
                            { staticClass: "data-table data-details" },
                            [
                              _c("thead", [
                                _c(
                                  "tr",
                                  _vm._l(item.details.headings, function(
                                    tdh,
                                    thdIndex
                                  ) {
                                    return _c(
                                      "th",
                                      {
                                        key: thdIndex,
                                        class:
                                          "data-table-column--" +
                                          _vm.getType(tdh)
                                      },
                                      [
                                        _c(
                                          "div",
                                          { staticClass: "data-text" },
                                          [
                                            _vm._v(
                                              _vm._s(_vm.getTabletLabel(tdh))
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  }),
                                  0
                                )
                              ]),
                              _vm._v(" "),
                              _c(
                                "tbody",
                                [
                                  _vm._l(item.details.items, function(
                                    tr,
                                    trIndex
                                  ) {
                                    return [
                                      _c(
                                        "tr",
                                        {
                                          key: tr.id + "-" + trIndex,
                                          class:
                                            "data-row--" +
                                            (trIndex % 2 ? "odd" : "even")
                                        },
                                        [
                                          _vm._l(
                                            item.details.headings,
                                            function(trd, trdIndex) {
                                              return [
                                                _vm.getKey(trd)
                                                  ? _c("td", {
                                                      key:
                                                        tr.id +
                                                        "-" +
                                                        trIndex +
                                                        "-" +
                                                        trdIndex,
                                                      class:
                                                        "data-table-column--" +
                                                        _vm.getType(trd),
                                                      domProps: {
                                                        innerHTML: _vm._s(
                                                          _vm.getData(
                                                            tr[_vm.getKey(trd)],
                                                            _vm.getType(trd)
                                                          )
                                                        )
                                                      }
                                                    })
                                                  : _c("td", {
                                                      key:
                                                        tr.id +
                                                        "-" +
                                                        trIndex +
                                                        "-" +
                                                        trdIndex,
                                                      staticClass:
                                                        "data-table-column--empty"
                                                    })
                                              ]
                                            }
                                          )
                                        ],
                                        2
                                      ),
                                      _vm._v(" "),
                                      tr.subItems && tr.subItems.items.length
                                        ? _vm._l(tr.subItems.items, function(
                                            trs,
                                            trsIndex
                                          ) {
                                            return _c(
                                              "tr",
                                              {
                                                key:
                                                  tr.id +
                                                  "-" +
                                                  trIndex +
                                                  "-" +
                                                  trsIndex,
                                                class:
                                                  "data-row--subitem data-row--" +
                                                  (trIndex % 2 ? "odd" : "even")
                                              },
                                              [
                                                _vm._l(
                                                  item.details.headings,
                                                  function(trd, trdIndex) {
                                                    return [
                                                      _vm.getKey(trd, true)
                                                        ? _c("td", {
                                                            key:
                                                              tr.id +
                                                              "-" +
                                                              trIndex +
                                                              "-" +
                                                              trsIndex +
                                                              "-" +
                                                              trdIndex,
                                                            class:
                                                              "data-table-column--" +
                                                              _vm.getType(
                                                                trd,
                                                                true
                                                              ),
                                                            domProps: {
                                                              innerHTML: _vm._s(
                                                                _vm.getData(
                                                                  trs[
                                                                    _vm.getKey(
                                                                      trd,
                                                                      true
                                                                    )
                                                                  ],
                                                                  _vm.getType(
                                                                    trd,
                                                                    true
                                                                  )
                                                                )
                                                              )
                                                            }
                                                          })
                                                        : _c("td", {
                                                            key:
                                                              tr.id +
                                                              "-" +
                                                              trIndex +
                                                              "-" +
                                                              trsIndex +
                                                              "-" +
                                                              trdIndex,
                                                            staticClass:
                                                              "data-table-column--empty"
                                                          })
                                                    ]
                                                  }
                                                )
                                              ],
                                              2
                                            )
                                          })
                                        : _vm._e()
                                    ]
                                  })
                                ],
                                2
                              )
                            ]
                          )
                        : _vm._e()
                    ]
                  : _vm._e()
              ],
              2
            )
          ])
        ]
      )
    }),
    0
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=template&id=7effdd7a&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/page-speed-app.vue?vue&type=template&id=7effdd7a& ***!
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
  return _c("div", { attrs: { id: "wp-adminify--page-speed-app" } }, [
    _c(
      "div",
      { staticClass: "wp-adminify-page-speed-wrapper tabbable mt-6 p-4" },
      [
        _c(
          "ul",
          {
            staticClass:
              "nav nav-tabs speed-wrapper-tabs is-pulled-left m-0 p-0",
            attrs: { role: "tablist" }
          },
          [
            _vm.$route.name !== "report"
              ? _c("router-link", {
                  attrs: { to: "/", custom: "", exact: "" },
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
                                    attrs: { href: "javascript:void(0);" }
                                  },
                                  [
                                    _c(
                                      "svg",
                                      {
                                        staticClass: "tab-icon",
                                        attrs: {
                                          width: "20",
                                          height: "20",
                                          viewBox: "0 0 20 20",
                                          fill: "none",
                                          xmlns: "http://www.w3.org/2000/svg"
                                        }
                                      },
                                      [
                                        _c("path", {
                                          attrs: {
                                            "fill-rule": "evenodd",
                                            "clip-rule": "evenodd",
                                            d:
                                              "M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20ZM13.4252 7.06241L11.6073 11.6071L7.06264 13.4249C6.75652 13.5474 6.45274 13.2436 6.57519 12.9375L8.39306 8.39283L12.9377 6.57496C13.2438 6.45251 13.5476 6.7563 13.4252 7.06241Z",
                                            fill: "#0347FF"
                                          }
                                        })
                                      ]
                                    ),
                                    _vm._v(
                                      "\n                        Analyze\n                    "
                                    )
                                  ]
                                )
                              ]
                            )
                          ]
                        }
                      }
                    ],
                    null,
                    false,
                    987750116
                  )
                })
              : _vm._e(),
            _vm._v(" "),
            _vm.$route.name == "report" && _vm.$route.params.id
              ? _c(
                  "li",
                  {
                    staticClass:
                      "nav-item router-link-active router-link-exact-active",
                    attrs: { id: "report-tab", role: "presentation" }
                  },
                  [_vm._m(0)]
                )
              : _vm._e(),
            _vm._v(" "),
            _c("router-link", {
              attrs: { to: "/history", custom: "" },
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
                          attrs: { id: "history-tab", role: "link" },
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
                              attrs: { href: "javascript:void(0);" }
                            },
                            [
                              _c(
                                "svg",
                                {
                                  staticClass: "tab-icon",
                                  attrs: {
                                    width: "22",
                                    height: "20",
                                    viewBox: "0 0 22 20",
                                    fill: "none",
                                    xmlns: "http://www.w3.org/2000/svg"
                                  }
                                },
                                [
                                  _c("path", {
                                    attrs: {
                                      d:
                                        "M13.1055 9H17.0585C17.6045 9 18.0465 9.448 18.0465 10C18.0465 10.552 17.6045 11 17.0585 11H12.1175C11.987 10.9992 11.8579 10.9727 11.7376 10.922C11.6173 10.8714 11.5082 10.7975 11.4164 10.7046C11.3247 10.6118 11.2521 10.5017 11.2029 10.3808C11.1537 10.2599 11.1287 10.1305 11.1295 10V4C11.1295 3.448 11.5715 3 12.1175 3C12.6635 3 13.1055 3.448 13.1055 4V9ZM19.1055 2.929C20.9654 4.81183 22.0056 7.35348 21.9995 10C21.9995 15.523 17.5755 20 12.1175 20V18C16.4835 18 20.0235 14.418 20.0235 10C20.0286 7.88253 19.196 5.84899 17.7075 4.343C16.9781 3.60074 16.1081 3.01126 15.1483 2.60898C14.1885 2.20669 13.1582 1.99967 12.1175 2C8.57353 2 5.57353 4.36 4.57053 7.612L5.92253 6.689C6.03 6.61562 6.15101 6.56436 6.27849 6.53821C6.40597 6.51205 6.53739 6.51153 6.66507 6.53665C6.79276 6.56178 6.91418 6.61206 7.02224 6.68457C7.13031 6.75708 7.22287 6.85037 7.29453 6.959C7.4412 7.17907 7.49542 7.44801 7.44546 7.70772C7.3955 7.96742 7.24538 8.19705 7.02753 8.347L3.75053 10.584C3.64305 10.6574 3.52204 10.7086 3.39456 10.7348C3.26708 10.7609 3.13567 10.7615 3.00798 10.7363C2.88029 10.7112 2.75888 10.6609 2.65081 10.5884C2.54275 10.5159 2.45019 10.4226 2.37853 10.314L0.169526 6.998C0.0225357 6.77785 -0.0318606 6.50868 0.0181082 6.24873C0.068077 5.98878 0.218392 5.75896 0.436526 5.609C0.544005 5.53562 0.665009 5.48436 0.792491 5.45821C0.919973 5.43205 1.05139 5.43153 1.17907 5.45665C1.30676 5.48178 1.42818 5.53206 1.53624 5.60457C1.64431 5.67708 1.73687 5.77037 1.80853 5.879L2.64753 7.138C3.86253 3.01 7.64253 0 12.1175 0C14.8465 0 17.3175 1.12 19.1055 2.929Z",
                                      fill: "#9391A0"
                                    }
                                  })
                                ]
                              ),
                              _vm._v(
                                "\n                        History\n                    "
                              )
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
        ),
        _vm._v(" "),
        _c("router-link", {
          attrs: { to: "/", custom: "" },
          scopedSlots: _vm._u([
            {
              key: "default",
              fn: function(ref) {
                var navigate = ref.navigate
                return [
                  _c(
                    "button",
                    {
                      staticClass:
                        "wp-adminify-analyze-button is-clickable is-pulled-right",
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
                    [_vm._v("New Analyze")]
                  )
                ]
              }
            }
          ])
        }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "tab-content" },
          [_c("router-view", { key: _vm.$route.fullPath })],
          1
        )
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "a",
      {
        staticClass: "nav-link is-clickable",
        attrs: { href: "javascript:void(0);" }
      },
      [
        _c("i", { staticClass: "tab-icon dashicons dashicons-list-view" }),
        _vm._v("\n                    Report\n                ")
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=template&id=99ffa9ea&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/analyze.vue?vue&type=template&id=99ffa9ea& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "tab-pane fade show active",
      attrs: {
        id: "analyze",
        role: "tabpanel",
        "aria-labelledby": "analyze-tab"
      }
    },
    [
      _c(
        "div",
        {
          staticClass:
            "wp-adminify-form-container is-flex is-align-items-center is-justify-content-center"
        },
        [
          _c(
            "form",
            {
              staticClass: "wp-adminify-speed-analyze-form",
              attrs: { action: "#" },
              on: {
                submit: function($event) {
                  $event.preventDefault()
                  return _vm.alalyzeURL.apply(null, arguments)
                }
              }
            },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.url,
                    expression: "url"
                  }
                ],
                staticClass: "url",
                attrs: {
                  type: "text",
                  name: "url",
                  inputmode: "url",
                  placeholder: "Enter a web page URL",
                  "aria-label": "Enter a web page URL"
                },
                domProps: { value: _vm.url },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.url = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                staticClass: "is-clickable",
                attrs: { type: "submit" }
              }),
              _vm._v(" "),
              _c(
                "svg",
                {
                  staticClass: "search-icon",
                  attrs: {
                    width: "17",
                    height: "17",
                    viewBox: "0 0 17 17",
                    fill: "none",
                    xmlns: "http://www.w3.org/2000/svg"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      d:
                        "M15.1916 16.6076L9.47663 10.8916C6.9343 12.6991 3.43107 12.257 1.4175 9.87456C-0.596063 7.49214 -0.448212 3.96422 1.75763 1.75863C3.96289 -0.447923 7.49115 -0.596414 9.87402 1.41705C12.2569 3.4305 12.6992 6.93408 10.8916 9.47663L16.6066 15.1926L15.1916 16.6076ZM5.99963 2.00062C4.10333 2.00019 2.46732 3.33131 2.0821 5.18807C1.69689 7.04482 2.66834 8.9169 4.40831 9.67087C6.14827 10.4248 8.17853 9.85346 9.26987 8.30268C10.3612 6.7519 10.2137 4.64795 8.91663 3.26463L9.52163 3.86463L8.83963 3.18463L8.82763 3.17263C8.07942 2.41981 7.06102 1.99776 5.99963 2.00062Z",
                      fill: "#4E4B66",
                      "fill-opacity": "0.54"
                    }
                  })
                ]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "bottom-wrapper" }, [
                _vm.loading
                  ? _c("div", { staticClass: "progress-area" }, [
                      _c("div", { staticClass: "hr-progress" }, [
                        _c(
                          "div",
                          {
                            staticClass: "hr-progress-bar",
                            style: { width: _vm.loaded + "%" }
                          },
                          [_vm._v(_vm._s(_vm.loaded) + "%")]
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "progress-hint" }, [
                        _vm._v("It takes about 1 minute on average.")
                      ])
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.error
                  ? _c("span", { staticClass: "error" }, [
                      _vm._v(_vm._s(_vm.error))
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _vm.proNoticeShow
                  ? _c("div", {
                      staticStyle: { "margin-top": "16px" },
                      domProps: { innerHTML: _vm._s(_vm.pro_notice) }
                    })
                  : _vm._e()
              ])
            ]
          )
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/history.vue?vue&type=template&id=e3c0635a&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/history.vue?vue&type=template&id=e3c0635a& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "tab-pane",
      attrs: {
        id: "history",
        role: "tabpanel",
        "aria-labelledby": "history-tab"
      }
    },
    [
      _vm.histories && _vm.histories.length
        ? _c("div", { staticClass: "wp-adminify-speed-analyze-history" }, [
            _c(
              "table",
              { staticClass: "history-table" },
              [
                _vm._m(0),
                _vm._v(" "),
                _vm._l(_vm.histories, function(history) {
                  return _c("history-single", {
                    key: history.id,
                    attrs: { history: history }
                  })
                })
              ],
              2
            ),
            _vm._v(" "),
            _c(
              "nav",
              {
                staticClass: "wp-adminify-pagination pagination mt-4",
                attrs: { role: "navigation", "aria-label": "pagination" }
              },
              [
                _c(
                  "ul",
                  {
                    staticClass: "pagination-list has-text-centered mt-5 mb-5"
                  },
                  [
                    _c(
                      "li",
                      [
                        _c(
                          "router-link",
                          {
                            staticClass: "pagination-link",
                            attrs: {
                              disabled: _vm.paginatePage(_vm.page) == 1,
                              to: "/history/" + _vm.paginatePage(_vm.page - 1),
                              tag: "a"
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "dashicons dashicons-arrow-left-alt2"
                            })
                          ]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _vm._l(_vm.pagination.pages, function(_page, _index) {
                      return _c(
                        "li",
                        { key: _index },
                        [
                          _page == "."
                            ? _c(
                                "span",
                                { staticClass: "pagination-ellipsis" },
                                [_vm._v("…")]
                              )
                            : _c(
                                "router-link",
                                {
                                  staticClass: "pagination-link",
                                  class:
                                    _vm.paginatePage(_page) == _vm.page
                                      ? "is-current"
                                      : "",
                                  attrs: {
                                    to: "/history/" + _vm.paginatePage(_page),
                                    tag: "a"
                                  }
                                },
                                [_vm._v(_vm._s(_vm.paginatePage(_page)))]
                              )
                        ],
                        1
                      )
                    }),
                    _vm._v(" "),
                    _c(
                      "li",
                      [
                        _c(
                          "router-link",
                          {
                            staticClass: "pagination-link",
                            attrs: {
                              disabled:
                                _vm.paginatePage(_vm.page) ==
                                _vm.pagination.total,
                              to: "/history/" + _vm.paginatePage(_vm.page + 1),
                              tag: "a"
                            }
                          },
                          [
                            _c("i", {
                              staticClass:
                                "dashicons dashicons-arrow-right-alt2"
                            })
                          ]
                        )
                      ],
                      1
                    )
                  ],
                  2
                )
              ]
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "wp-adminify--popup-area is-flex is-align-items-center is-justify-content-center"
        },
        [
          _c(
            "div",
            { staticClass: "wp-adminify--popup-container has-text-centered" },
            [
              _c(
                "div",
                { staticClass: "wp-adminify--popup-container_inner pt-6 pb-6" },
                [
                  _vm.delete_history_popup && _vm.history_going_to_delete
                    ? _c("div", { staticClass: "popup--delete-history" }, [
                        _c(
                          "a",
                          {
                            staticClass: "wp-adminify--popup-close",
                            attrs: { href: "#" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.hide_delete_history_popup.apply(
                                  null,
                                  arguments
                                )
                              }
                            }
                          },
                          [
                            _c("span", {
                              staticClass: "dashicons dashicons-no-alt"
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c("h3", { staticClass: "mt-0 ml-4 mr-4" }, [
                          _vm._v(
                            "Are you sure you want to delete the below history?"
                          )
                        ]),
                        _vm._v(" "),
                        _c("p", [
                          _vm._v(_vm._s(_vm.history_going_to_delete.url))
                        ]),
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
                                  return _vm.hide_delete_history_popup.apply(
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
                                  return _vm._deleteHistory.apply(
                                    null,
                                    arguments
                                  )
                                }
                              }
                            },
                            [_vm._v("Yes, Delete it!")]
                          )
                        ])
                      ])
                    : _vm._e()
                ]
              )
            ]
          )
        ]
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", { staticClass: "has-text-left" }, [_vm._v("Screenshot")]),
      _vm._v(" "),
      _c("th", { staticClass: "has-text-left" }, [_vm._v("Repost name")]),
      _vm._v(" "),
      _c("th", { staticClass: "has-text-left" }, [_vm._v("URL")]),
      _vm._v(" "),
      _c("th", { staticClass: "has-text-centered" }, [_vm._v("Desktop score")]),
      _vm._v(" "),
      _c("th", { staticClass: "has-text-centered" }, [_vm._v("Mobile score")]),
      _vm._v(" "),
      _c("th", { staticClass: "has-text-right" }, [_vm._v("Actions")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/report.vue?vue&type=template&id=0b9b6bc5&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./dev/admin/modules/page-speed/pages/report.vue?vue&type=template&id=0b9b6bc5& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "tab-pane fade show active",
      attrs: { id: "report", role: "tabpanel", "aria-labelledby": "report-tab" }
    },
    [
      _c("div", { staticClass: "wp-adminify-speed-analyze-result" }, [
        _vm.history
          ? _c("div", { staticClass: "analyze-result-tab" }, [
              _c("div", { staticClass: "device-tabs has-text-centered" }, [
                _c(
                  "ul",
                  {
                    staticClass:
                      "\n            nav nav-tabs\n            is-inline-flex is-align-content-center is-justify-content-center\n          ",
                    attrs: { id: "resulttabs", role: "tablist" }
                  },
                  [
                    _c(
                      "li",
                      {
                        staticClass: "nav-item",
                        class: _vm.activeTab == "mobile" ? "active" : ""
                      },
                      [
                        _c(
                          "a",
                          {
                            staticClass: "nav-link is-clickable",
                            attrs: {
                              id: "mobile-tab",
                              "data-toggle": "tab",
                              href: "#"
                            },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.toggleTab("mobile")
                              }
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "dashicons dashicons-smartphone"
                            }),
                            _vm._v("Mobile")
                          ]
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "li",
                      {
                        staticClass: "nav-item",
                        class: _vm.activeTab == "desktop" ? "active" : ""
                      },
                      [
                        _c(
                          "a",
                          {
                            staticClass: "nav-link is-clickable",
                            attrs: {
                              id: "desktop-tab",
                              "data-toggle": "tab",
                              href: "#"
                            },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.toggleTab("desktop")
                              }
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "dashicons dashicons-desktop"
                            }),
                            _vm._v("Desktop")
                          ]
                        )
                      ]
                    )
                  ]
                )
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "tab-content", attrs: { id: "resultContent" } },
                [
                  _c("div", { staticClass: "tab-pane fade show active" }, [
                    _c(
                      "div",
                      { staticClass: "desktop-result has-text-centered" },
                      [
                        _c("div", { staticClass: "result-top mb-5" }, [
                          _c("div", { staticClass: "columns is-vcentered" }, [
                            _c("div", { staticClass: "column" }, [
                              _c("div", { staticClass: "health-progress" }, [
                                _c(
                                  "div",
                                  {
                                    class: [
                                      "progress-bar",
                                      _vm.getScoreClass(_vm.score)
                                    ]
                                  },
                                  [
                                    _c(
                                      "div",
                                      { staticClass: "progress-percentage" },
                                      [
                                        _vm._v(
                                          "\n                        " +
                                            _vm._s(_vm.score) +
                                            "\n                      "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      { staticClass: "progress-status" },
                                      [
                                        _vm._v(
                                          "\n                        " +
                                            _vm._s(
                                              _vm.getScoreStatus(
                                                _vm.score,
                                                true
                                              )
                                            ) +
                                            "\n                      "
                                        )
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c("span", { staticClass: "title" }, [
                                  _vm._v("Overall Progress")
                                ])
                              ]),
                              _vm._v(" "),
                              _vm._m(0)
                            ]),
                            _vm._v(" "),
                            _c("div", { staticClass: "column" }, [
                              _c(
                                "div",
                                { staticClass: "url-screenshot has-text-left" },
                                [
                                  _c("img", {
                                    attrs: {
                                      src:
                                        _vm.activeData.lighthouseResult.audits[
                                          "final-screenshot"
                                        ].details.data,
                                      alt: "Screenshot"
                                    }
                                  })
                                ]
                              )
                            ])
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "section--field-data mt-3 mb-3" },
                          [
                            _c(
                              "div",
                              { staticClass: "result-header has-text-left" },
                              [
                                _c("span", { staticClass: "result-title" }, [
                                  _vm._v("Field Data ")
                                ]),
                                _vm._v(" "),
                                _vm.checkStatus(
                                  _vm.activeData.loadingExperience
                                ) == 1
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "result-description adminify-ps-pass"
                                      },
                                      [
                                        _vm._v(
                                          "Over the previous 28-day collection period,\n                  "
                                        ),
                                        _c(
                                          "a",
                                          {
                                            attrs: {
                                              href:
                                                "https://developers.google.com/speed/docs/insights/v5/about",
                                              target: "_blank"
                                            }
                                          },
                                          [_vm._v("field data")]
                                        ),
                                        _vm._v(
                                          "\n                  shows that this page "
                                        ),
                                        _c("b", [_vm._v("passes")]),
                                        _vm._v(" the\n                  "),
                                        _c(
                                          "a",
                                          {
                                            attrs: {
                                              href: "https://web.dev/vitals/",
                                              target: "_blank"
                                            }
                                          },
                                          [_vm._v("Core Web Vitals")]
                                        ),
                                        _vm._v(
                                          "\n                  assessment."
                                        )
                                      ]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.checkStatus(
                                  _vm.activeData.loadingExperience
                                ) == 0
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "result-description adminify-ps-fail"
                                      },
                                      [
                                        _vm._v(
                                          "Over the previous 28-day collection period,\n                  "
                                        ),
                                        _c(
                                          "a",
                                          {
                                            attrs: {
                                              href:
                                                "https://developers.google.com/speed/docs/insights/v5/about",
                                              target: "_blank"
                                            }
                                          },
                                          [_vm._v("field data")]
                                        ),
                                        _vm._v(
                                          "\n                  shows that this page "
                                        ),
                                        _c("b", [_vm._v("does not pass")]),
                                        _vm._v(" the\n                  "),
                                        _c(
                                          "a",
                                          {
                                            attrs: {
                                              href: "https://web.dev/vitals/",
                                              target: "_blank"
                                            }
                                          },
                                          [_vm._v("Core Web Vitals")]
                                        ),
                                        _vm._v(
                                          "\n                  assessment."
                                        )
                                      ]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.checkStatus(
                                  _vm.activeData.loadingExperience
                                ) == -1
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "result-description adminify-ps-average"
                                      },
                                      [
                                        _vm._v(
                                          "The Chrome User Experience Report\n                  "
                                        ),
                                        _c(
                                          "a",
                                          {
                                            attrs: {
                                              href:
                                                "https://developers.google.com/speed/docs/insights/about#faq",
                                              "data-ga-id":
                                                "speed-data-unavailable-faq",
                                              target: "_blank"
                                            }
                                          },
                                          [
                                            _vm._v(
                                              "does not have sufficient real-world speed data"
                                            )
                                          ]
                                        ),
                                        _vm._v(
                                          "\n                  for this page."
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ]
                            ),
                            _vm._v(" "),
                            "metrics" in _vm.activeData.loadingExperience
                              ? _c(
                                  "div",
                                  { staticClass: "result-summary pt-4" },
                                  [
                                    _c("div", { staticClass: "columns" }, [
                                      _c("div", { staticClass: "column" }, [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "summary-wrapper has-text-left"
                                          },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "summary-top is-inline-block"
                                              },
                                              [
                                                _c(
                                                  "span",
                                                  {
                                                    staticClass:
                                                      "summary-description is-pulled-left"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "First Contentful Paint (FCP)"
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    class: [
                                                      "summary-value is-pulled-right",
                                                      _vm.fcpScoreClass(
                                                        _vm.MilisecondsToSeconds(
                                                          _vm.activeData
                                                            .loadingExperience
                                                            .metrics
                                                            .FIRST_CONTENTFUL_PAINT_MS
                                                            .percentile
                                                        )
                                                      )
                                                    ]
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                          " +
                                                        _vm._s(
                                                          _vm.MilisecondsToSeconds(
                                                            _vm.activeData
                                                              .loadingExperience
                                                              .metrics
                                                              .FIRST_CONTENTFUL_PAINT_MS
                                                              .percentile
                                                          )
                                                        ) +
                                                        "\n                          s\n                        "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "summary-chart is-flex"
                                              },
                                              _vm._l(
                                                _vm.activeData.loadingExperience
                                                  .metrics
                                                  .FIRST_CONTENTFUL_PAINT_MS
                                                  .distributions,
                                                function(item, index) {
                                                  return _c(
                                                    "div",
                                                    {
                                                      key: item.proportion,
                                                      class: [
                                                        "bar",
                                                        _vm.barClass(index)
                                                      ],
                                                      style:
                                                        "flex-grow: " +
                                                        _vm.toRatio(
                                                          item.proportion
                                                        )
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                          " +
                                                          _vm._s(
                                                            _vm.toRatio(
                                                              item.proportion
                                                            )
                                                          ) +
                                                          "%\n                        "
                                                      )
                                                    ]
                                                  )
                                                }
                                              ),
                                              0
                                            )
                                          ]
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("div", { staticClass: "column" }, [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "summary-wrapper has-text-left"
                                          },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "summary-top is-inline-block"
                                              },
                                              [
                                                _vm._m(1),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    class: [
                                                      "summary-value is-pulled-right",
                                                      _vm.fidScoreClass(
                                                        _vm.activeData
                                                          .loadingExperience
                                                          .metrics
                                                          .FIRST_INPUT_DELAY_MS
                                                          .percentile
                                                      )
                                                    ]
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                          " +
                                                        _vm._s(
                                                          _vm.activeData
                                                            .loadingExperience
                                                            .metrics
                                                            .FIRST_INPUT_DELAY_MS
                                                            .percentile
                                                        ) +
                                                        "\n                          ms\n                        "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "summary-chart is-flex"
                                              },
                                              _vm._l(
                                                _vm.activeData.loadingExperience
                                                  .metrics.FIRST_INPUT_DELAY_MS
                                                  .distributions,
                                                function(item, index) {
                                                  return _c(
                                                    "div",
                                                    {
                                                      key: item.proportion,
                                                      class: [
                                                        "bar",
                                                        _vm.barClass(index)
                                                      ],
                                                      style:
                                                        "flex-grow: " +
                                                        _vm.toRatio(
                                                          item.proportion
                                                        )
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                          " +
                                                          _vm._s(
                                                            _vm.toRatio(
                                                              item.proportion
                                                            )
                                                          ) +
                                                          "%\n                        "
                                                      )
                                                    ]
                                                  )
                                                }
                                              ),
                                              0
                                            )
                                          ]
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("div", { staticClass: "columns" }, [
                                      _c("div", { staticClass: "column" }, [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "summary-wrapper has-text-left"
                                          },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "summary-top is-inline-block"
                                              },
                                              [
                                                _vm._m(2),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    class: [
                                                      "summary-value is-pulled-right",
                                                      _vm.lcpScoreClass(
                                                        _vm.MilisecondsToSeconds(
                                                          _vm.activeData
                                                            .loadingExperience
                                                            .metrics
                                                            .LARGEST_CONTENTFUL_PAINT_MS
                                                            .percentile
                                                        )
                                                      )
                                                    ]
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                          " +
                                                        _vm._s(
                                                          _vm.MilisecondsToSeconds(
                                                            _vm.activeData
                                                              .loadingExperience
                                                              .metrics
                                                              .LARGEST_CONTENTFUL_PAINT_MS
                                                              .percentile
                                                          )
                                                        ) +
                                                        "\n                          s\n                        "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "summary-chart is-flex"
                                              },
                                              _vm._l(
                                                _vm.activeData.loadingExperience
                                                  .metrics
                                                  .LARGEST_CONTENTFUL_PAINT_MS
                                                  .distributions,
                                                function(item, index) {
                                                  return _c(
                                                    "div",
                                                    {
                                                      key: item.proportion,
                                                      class: [
                                                        "bar",
                                                        _vm.barClass(index)
                                                      ],
                                                      style:
                                                        "flex-grow: " +
                                                        _vm.toRatio(
                                                          item.proportion
                                                        )
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                          " +
                                                          _vm._s(
                                                            _vm.toRatio(
                                                              item.proportion
                                                            )
                                                          ) +
                                                          "%\n                        "
                                                      )
                                                    ]
                                                  )
                                                }
                                              ),
                                              0
                                            )
                                          ]
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("div", { staticClass: "column" }, [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "summary-wrapper has-text-left"
                                          },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "summary-top is-inline-block"
                                              },
                                              [
                                                _vm._m(3),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    class: [
                                                      "summary-value is-pulled-right",
                                                      _vm.clsScoreClass(
                                                        _vm.activeData
                                                          .loadingExperience
                                                          .metrics
                                                          .CUMULATIVE_LAYOUT_SHIFT_SCORE
                                                          .percentile / 100
                                                      )
                                                    ]
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                          " +
                                                        _vm._s(
                                                          _vm.activeData
                                                            .loadingExperience
                                                            .metrics
                                                            .CUMULATIVE_LAYOUT_SHIFT_SCORE
                                                            .percentile / 100
                                                        ) +
                                                        "\n                          s\n                        "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "summary-chart is-flex"
                                              },
                                              _vm._l(
                                                _vm.activeData.loadingExperience
                                                  .metrics
                                                  .CUMULATIVE_LAYOUT_SHIFT_SCORE
                                                  .distributions,
                                                function(item, index) {
                                                  return _c(
                                                    "div",
                                                    {
                                                      key: item.proportion,
                                                      class: [
                                                        "bar",
                                                        _vm.barClass(index)
                                                      ],
                                                      style:
                                                        "flex-grow: " +
                                                        _vm.toRatio(
                                                          item.proportion
                                                        )
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                          " +
                                                          _vm._s(
                                                            _vm.toRatio(
                                                              item.proportion
                                                            )
                                                          ) +
                                                          "%\n                        "
                                                      )
                                                    ]
                                                  )
                                                }
                                              ),
                                              0
                                            )
                                          ]
                                        )
                                      ])
                                    ])
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            "origin_fallback" in
                              _vm.activeData.loadingExperience &&
                            _vm.activeData.loadingExperience.origin_fallback
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "origin-summary-trigger pt-5 has-text-left"
                                  },
                                  [
                                    _c(
                                      "button",
                                      { staticClass: "is-clickable" },
                                      [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: _vm.show_origin_sum,
                                              expression: "show_origin_sum"
                                            }
                                          ],
                                          staticClass: "is-pulled-left",
                                          attrs: { type: "checkbox" },
                                          domProps: {
                                            checked: Array.isArray(
                                              _vm.show_origin_sum
                                            )
                                              ? _vm._i(
                                                  _vm.show_origin_sum,
                                                  null
                                                ) > -1
                                              : _vm.show_origin_sum
                                          },
                                          on: {
                                            change: function($event) {
                                              var $$a = _vm.show_origin_sum,
                                                $$el = $event.target,
                                                $$c = $$el.checked
                                                  ? true
                                                  : false
                                              if (Array.isArray($$a)) {
                                                var $$v = null,
                                                  $$i = _vm._i($$a, $$v)
                                                if ($$el.checked) {
                                                  $$i < 0 &&
                                                    (_vm.show_origin_sum = $$a.concat(
                                                      [$$v]
                                                    ))
                                                } else {
                                                  $$i > -1 &&
                                                    (_vm.show_origin_sum = $$a
                                                      .slice(0, $$i)
                                                      .concat(
                                                        $$a.slice($$i + 1)
                                                      ))
                                                }
                                              } else {
                                                _vm.show_origin_sum = $$c
                                              }
                                            }
                                          }
                                        }),
                                        _vm._v(
                                          "\n                  Show origin summary\n                "
                                        )
                                      ]
                                    )
                                  ]
                                )
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _vm.show_origin_sum ||
                        !("metrics" in _vm.activeData.loadingExperience)
                          ? _c(
                              "div",
                              {
                                staticClass:
                                  "section--origin-summery has-text-left pt-5"
                              },
                              [
                                _c("div", { staticClass: "result-header" }, [
                                  _c("span", { staticClass: "result-title" }, [
                                    _vm._v("Origin Summary ")
                                  ]),
                                  _vm._v(" "),
                                  _vm.checkStatus(
                                    _vm.activeData.originLoadingExperience
                                  ) == 1
                                    ? _c(
                                        "span",
                                        {
                                          staticClass:
                                            "result-description adminify-ps-pass"
                                        },
                                        [
                                          _vm._v(
                                            "Over the previous 28-day collection period, the aggregate\n                  experience of all pages served from this origin\n                  "
                                          ),
                                          _c("b", [_vm._v("passes")]),
                                          _vm._v(" the\n                  "),
                                          _c(
                                            "a",
                                            {
                                              attrs: {
                                                href: "https://web.dev/vitals/",
                                                target: "_blank"
                                              }
                                            },
                                            [_vm._v("Core Web Vitals")]
                                          ),
                                          _vm._v(
                                            "\n                  assessment. To view suggestions tailored to each page,\n                  analyze individual page URLs."
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.checkStatus(
                                    _vm.activeData.originLoadingExperience
                                  ) == 0
                                    ? _c(
                                        "span",
                                        {
                                          staticClass:
                                            "result-description adminify-ps-fail"
                                        },
                                        [
                                          _vm._v(
                                            "Over the previous 28-day collection period, the aggregate\n                  experience of all pages served from this origin\n                  "
                                          ),
                                          _c("b", [_vm._v("does not pass")]),
                                          _vm._v(" the\n                  "),
                                          _c(
                                            "a",
                                            {
                                              attrs: {
                                                href: "https://web.dev/vitals/",
                                                target: "_blank"
                                              }
                                            },
                                            [_vm._v("Core Web Vitals")]
                                          ),
                                          _vm._v(
                                            "\n                  assessment. To view suggestions tailored to each page,\n                  analyze individual page URLs."
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.checkStatus(
                                    _vm.activeData.originLoadingExperience
                                  ) == -1
                                    ? _c(
                                        "span",
                                        {
                                          staticClass:
                                            "result-description adminify-ps-average"
                                        },
                                        [
                                          _vm._v(
                                            "The Chrome User Experience Report\n                  "
                                          ),
                                          _c(
                                            "a",
                                            {
                                              attrs: {
                                                href:
                                                  "https://developers.google.com/speed/docs/insights/about#faq",
                                                "data-ga-id":
                                                  "speed-data-unavailable-faq",
                                                target: "_blank"
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "does not have sufficient real-world speed data"
                                              )
                                            ]
                                          ),
                                          _vm._v(
                                            "\n                  for this origin."
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ]),
                                _vm._v(" "),
                                "originLoadingExperience" in _vm.activeData
                                  ? _c(
                                      "div",
                                      {
                                        staticClass:
                                          "result-summary origin-result-summary"
                                      },
                                      [
                                        _vm._m(4),
                                        _vm._v(" "),
                                        _c("div", { staticClass: "columns" }, [
                                          _c("div", { staticClass: "column" }, [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "summary-wrapper"
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "summary-top"
                                                  },
                                                  [
                                                    _c(
                                                      "span",
                                                      {
                                                        staticClass:
                                                          "summary-description is-pulled-left"
                                                      },
                                                      [
                                                        _vm._v(
                                                          "First Contentful Paint (FCP)"
                                                        )
                                                      ]
                                                    ),
                                                    _vm._v(" "),
                                                    _c(
                                                      "div",
                                                      {
                                                        class: [
                                                          "summary-value is-pulled-right",
                                                          _vm.fcpScoreClass(
                                                            _vm.MilisecondsToSeconds(
                                                              _vm.activeData
                                                                .originLoadingExperience
                                                                .metrics
                                                                .FIRST_CONTENTFUL_PAINT_MS
                                                                .percentile
                                                            )
                                                          )
                                                        ]
                                                      },
                                                      [
                                                        _vm._v(
                                                          "\n                          " +
                                                            _vm._s(
                                                              _vm.MilisecondsToSeconds(
                                                                _vm.activeData
                                                                  .originLoadingExperience
                                                                  .metrics
                                                                  .FIRST_CONTENTFUL_PAINT_MS
                                                                  .percentile
                                                              )
                                                            ) +
                                                            "\n                          s\n                        "
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "summary-chart is-flex"
                                                  },
                                                  _vm._l(
                                                    _vm.activeData
                                                      .originLoadingExperience
                                                      .metrics
                                                      .FIRST_CONTENTFUL_PAINT_MS
                                                      .distributions,
                                                    function(item, index) {
                                                      return _c(
                                                        "div",
                                                        {
                                                          key: item.proportion,
                                                          class: [
                                                            "bar",
                                                            _vm.barClass(index)
                                                          ],
                                                          style:
                                                            "flex-grow: " +
                                                            _vm.toRatio(
                                                              item.proportion
                                                            )
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                          " +
                                                              _vm._s(
                                                                _vm.toRatio(
                                                                  item.proportion
                                                                )
                                                              ) +
                                                              "%\n                        "
                                                          )
                                                        ]
                                                      )
                                                    }
                                                  ),
                                                  0
                                                )
                                              ]
                                            )
                                          ]),
                                          _vm._v(" "),
                                          _c("div", { staticClass: "column" }, [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "summary-wrapper"
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "summary-top"
                                                  },
                                                  [
                                                    _vm._m(5),
                                                    _vm._v(" "),
                                                    _c(
                                                      "div",
                                                      {
                                                        class: [
                                                          "summary-value is-pulled-right",
                                                          _vm.fidScoreClass(
                                                            _vm.activeData
                                                              .originLoadingExperience
                                                              .metrics
                                                              .FIRST_INPUT_DELAY_MS
                                                              .percentile
                                                          )
                                                        ]
                                                      },
                                                      [
                                                        _vm._v(
                                                          "\n                          " +
                                                            _vm._s(
                                                              _vm.activeData
                                                                .originLoadingExperience
                                                                .metrics
                                                                .FIRST_INPUT_DELAY_MS
                                                                .percentile
                                                            ) +
                                                            "\n                          ms\n                        "
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "summary-chart is-flex"
                                                  },
                                                  _vm._l(
                                                    _vm.activeData
                                                      .originLoadingExperience
                                                      .metrics
                                                      .FIRST_INPUT_DELAY_MS
                                                      .distributions,
                                                    function(item, index) {
                                                      return _c(
                                                        "div",
                                                        {
                                                          key: item.proportion,
                                                          class: [
                                                            "bar",
                                                            _vm.barClass(index)
                                                          ],
                                                          style:
                                                            "flex-grow: " +
                                                            _vm.toRatio(
                                                              item.proportion
                                                            )
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                          " +
                                                              _vm._s(
                                                                _vm.toRatio(
                                                                  item.proportion
                                                                )
                                                              ) +
                                                              "%\n                        "
                                                          )
                                                        ]
                                                      )
                                                    }
                                                  ),
                                                  0
                                                )
                                              ]
                                            )
                                          ])
                                        ]),
                                        _vm._v(" "),
                                        _c("div", { staticClass: "columns" }, [
                                          _c("div", { staticClass: "column" }, [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "summary-wrapper"
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "summary-top"
                                                  },
                                                  [
                                                    _vm._m(6),
                                                    _vm._v(" "),
                                                    _c(
                                                      "div",
                                                      {
                                                        class: [
                                                          "summary-value is-pulled-right",
                                                          _vm.lcpScoreClass(
                                                            _vm.MilisecondsToSeconds(
                                                              _vm.activeData
                                                                .originLoadingExperience
                                                                .metrics
                                                                .LARGEST_CONTENTFUL_PAINT_MS
                                                                .percentile
                                                            )
                                                          )
                                                        ]
                                                      },
                                                      [
                                                        _vm._v(
                                                          "\n                          " +
                                                            _vm._s(
                                                              _vm.MilisecondsToSeconds(
                                                                _vm.activeData
                                                                  .originLoadingExperience
                                                                  .metrics
                                                                  .LARGEST_CONTENTFUL_PAINT_MS
                                                                  .percentile
                                                              )
                                                            ) +
                                                            "\n                          s\n                        "
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "summary-chart is-flex"
                                                  },
                                                  _vm._l(
                                                    _vm.activeData
                                                      .originLoadingExperience
                                                      .metrics
                                                      .LARGEST_CONTENTFUL_PAINT_MS
                                                      .distributions,
                                                    function(item, index) {
                                                      return _c(
                                                        "div",
                                                        {
                                                          key: item.proportion,
                                                          class: [
                                                            "bar",
                                                            _vm.barClass(index)
                                                          ],
                                                          style:
                                                            "flex-grow: " +
                                                            _vm.toRatio(
                                                              item.proportion
                                                            )
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                          " +
                                                              _vm._s(
                                                                _vm.toRatio(
                                                                  item.proportion
                                                                )
                                                              ) +
                                                              "%\n                        "
                                                          )
                                                        ]
                                                      )
                                                    }
                                                  ),
                                                  0
                                                )
                                              ]
                                            )
                                          ]),
                                          _vm._v(" "),
                                          _c("div", { staticClass: "column" }, [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "summary-wrapper"
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "summary-top"
                                                  },
                                                  [
                                                    _vm._m(7),
                                                    _vm._v(" "),
                                                    _c(
                                                      "div",
                                                      {
                                                        class: [
                                                          "summary-value is-pulled-right",
                                                          _vm.clsScoreClass(
                                                            _vm.activeData
                                                              .originLoadingExperience
                                                              .metrics
                                                              .CUMULATIVE_LAYOUT_SHIFT_SCORE
                                                              .percentile / 100
                                                          )
                                                        ]
                                                      },
                                                      [
                                                        _vm._v(
                                                          "\n                          " +
                                                            _vm._s(
                                                              _vm.activeData
                                                                .originLoadingExperience
                                                                .metrics
                                                                .CUMULATIVE_LAYOUT_SHIFT_SCORE
                                                                .percentile /
                                                                100
                                                            ) +
                                                            "\n                          s\n                        "
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "summary-chart is-flex"
                                                  },
                                                  _vm._l(
                                                    _vm.activeData
                                                      .originLoadingExperience
                                                      .metrics
                                                      .CUMULATIVE_LAYOUT_SHIFT_SCORE
                                                      .distributions,
                                                    function(item, index) {
                                                      return _c(
                                                        "div",
                                                        {
                                                          key: item.proportion,
                                                          class: [
                                                            "bar",
                                                            _vm.barClass(index)
                                                          ],
                                                          style:
                                                            "flex-grow: " +
                                                            _vm.toRatio(
                                                              item.proportion
                                                            )
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                          " +
                                                              _vm._s(
                                                                _vm.toRatio(
                                                                  item.proportion
                                                                )
                                                              ) +
                                                              "%\n                        "
                                                          )
                                                        ]
                                                      )
                                                    }
                                                  ),
                                                  0
                                                )
                                              ]
                                            )
                                          ])
                                        ])
                                      ]
                                    )
                                  : _vm._e()
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c("div", { staticClass: "result-data-wrapper mt-6" }, [
                          _c("div", { staticClass: "result-data" }, [
                            _c(
                              "div",
                              { staticClass: "data-category" },
                              [
                                _c("LabData", {
                                  attrs: {
                                    data: _vm.activeData,
                                    device: _vm.activeTab
                                  }
                                })
                              ],
                              1
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "result-body has-text-left" },
                          [
                            _c(
                              "div",
                              { staticClass: "result-inner pt-4" },
                              [
                                "screenshot-thumbnails" in
                                _vm.display_data.screenshots
                                  ? [
                                      _vm.display_data.screenshots[
                                        "screenshot-thumbnails"
                                      ].details &&
                                      _vm.display_data.screenshots[
                                        "screenshot-thumbnails"
                                      ].details.type == "filmstrip"
                                        ? _c("div", [
                                            _vm.display_data.screenshots[
                                              "screenshot-thumbnails"
                                            ].details.items
                                              ? _c(
                                                  "ul",
                                                  {
                                                    class: [
                                                      "filmstrip-list screenshot-thumbnails"
                                                    ]
                                                  },
                                                  _vm._l(
                                                    _vm.display_data
                                                      .screenshots[
                                                      "screenshot-thumbnails"
                                                    ].details.items,
                                                    function(
                                                      strip,
                                                      strip_index
                                                    ) {
                                                      return _c(
                                                        "li",
                                                        {
                                                          key:
                                                            _vm.display_data
                                                              .screenshots[
                                                              "screenshot-thumbnails"
                                                            ].details.type +
                                                            "-" +
                                                            strip_index
                                                        },
                                                        [
                                                          _c("img", {
                                                            attrs: {
                                                              src: strip.data,
                                                              alt: ""
                                                            }
                                                          })
                                                        ]
                                                      )
                                                    }
                                                  ),
                                                  0
                                                )
                                              : _vm._e()
                                          ])
                                        : _vm._e()
                                    ]
                                  : _vm._e(),
                                _vm._v(" "),
                                Object.keys(_vm.display_data.opportunities)
                                  .length
                                  ? _c(
                                      "div",
                                      { staticClass: "section mt-6" },
                                      [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "data-audit-group__header pb-4"
                                          },
                                          [
                                            _c(
                                              "strong",
                                              {
                                                staticClass:
                                                  "data-audit-group__title"
                                              },
                                              [
                                                _vm._v(
                                                  _vm._s(
                                                    _vm.activeData
                                                      .lighthouseResult
                                                      .categoryGroups[
                                                      "load-opportunities"
                                                    ].title
                                                  )
                                                )
                                              ]
                                            ),
                                            _vm._v(
                                              "\n                    -\n                    "
                                            ),
                                            _c("span", {
                                              staticClass:
                                                "data-audit-group__description",
                                              domProps: {
                                                innerHTML: _vm._s(
                                                  _vm.markdownToLink(
                                                    _vm.activeData
                                                      .lighthouseResult
                                                      .categoryGroups[
                                                      "load-opportunities"
                                                    ].description
                                                  )
                                                )
                                              }
                                            })
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c("LoopData", {
                                          attrs: {
                                            data: _vm.display_data.opportunities
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                Object.keys(_vm.display_data.diagnostics).length
                                  ? _c(
                                      "div",
                                      { staticClass: "section mt-6" },
                                      [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "data-audit-group__header pb-4"
                                          },
                                          [
                                            _c(
                                              "strong",
                                              {
                                                staticClass:
                                                  "data-audit-group__title"
                                              },
                                              [
                                                _vm._v(
                                                  _vm._s(
                                                    _vm.activeData
                                                      .lighthouseResult
                                                      .categoryGroups
                                                      .diagnostics.title
                                                  )
                                                )
                                              ]
                                            ),
                                            _vm._v(
                                              "\n                    -\n                    "
                                            ),
                                            _c("span", {
                                              staticClass:
                                                "data-audit-group__description",
                                              domProps: {
                                                innerHTML: _vm._s(
                                                  _vm.markdownToLink(
                                                    _vm.activeData
                                                      .lighthouseResult
                                                      .categoryGroups
                                                      .diagnostics.description
                                                  )
                                                )
                                              }
                                            })
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c("LoopData", {
                                          attrs: {
                                            data: _vm.display_data.diagnostics
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                Object.keys(_vm.display_data.passed_audits)
                                  .length
                                  ? _c(
                                      "div",
                                      { staticClass: "section mt-6" },
                                      [
                                        _c("div", [
                                          _c("strong", [
                                            _vm._v(
                                              _vm._s(
                                                _vm.activeData.lighthouseResult
                                                  .i18n.rendererFormattedStrings
                                                  .passedAuditsGroupTitle
                                              )
                                            )
                                          ]),
                                          _vm._v(" "),
                                          _c("span", [
                                            _vm._v(
                                              _vm._s(
                                                Object.keys(
                                                  _vm.display_data.passed_audits
                                                ).length
                                              )
                                            )
                                          ])
                                        ]),
                                        _vm._v(" "),
                                        _c("LoopData", {
                                          attrs: {
                                            data: _vm.display_data.passed_audits
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  : _vm._e()
                              ],
                              2
                            )
                          ]
                        )
                      ]
                    )
                  ])
                ]
              )
            ])
          : _vm._e()
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "progress-scale" }, [
      _c("span", { staticClass: "range-fail ml-4" }, [_vm._v("0-49")]),
      _vm._v(" "),
      _c("span", { staticClass: "range-average ml-4" }, [_vm._v("50-89")]),
      _vm._v(" "),
      _c("span", { staticClass: "range-pass ml-4" }, [_vm._v("90-100")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "summary-description is-pulled-left" }, [
      _vm._v("First Input Delay (FID)"),
      _c("a", {
        staticClass: "adminify-icon-cwv",
        attrs: {
          href: "https://web.dev/vitals/",
          target: "_blank",
          title: "Core Web Vital"
        }
      })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "summary-description is-pulled-left" }, [
      _vm._v("Largest Contentful Paint (LCP)"),
      _c("a", {
        staticClass: "adminify-icon-cwv",
        attrs: {
          href: "https://web.dev/vitals/",
          target: "_blank",
          title: "Core Web Vital"
        }
      })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "summary-description is-pulled-left" }, [
      _vm._v("Cumulative Layout Shift (CLS)"),
      _c("a", {
        staticClass: "adminify-icon-cwv",
        attrs: { href: "#", target: "_blank", title: "Core Web Vital" }
      })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "result-header mt-5 mb-4" }, [
      _c("span", { staticClass: "result-title" }, [_vm._v("Origin Summary ")]),
      _vm._v(" "),
      _c("span", { staticClass: "result-description result-description" }, [
        _vm._v(
          "\n                    - Over the previous 28-day collection period, the\n                    aggregate experience of all pages served from this origin\n                    shows that this page\n                    "
        ),
        _c("b", { staticClass: "adminify-ps-pass" }, [_vm._v("does not pass")]),
        _vm._v(" the\n                    "),
        _c(
          "a",
          { attrs: { href: "https://web.dev/vitals/", target: "_blank" } },
          [_vm._v("Core Web Vitals")]
        ),
        _vm._v("\n                    assessment.\n                  ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "summary-description is-pulled-left" }, [
      _vm._v("First Input Delay (FID)"),
      _c("a", {
        staticClass: "adminify-icon-cwv",
        attrs: {
          href: "https://web.dev/vitals/",
          target: "_blank",
          title: "Core Web Vital"
        }
      })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "summary-description is-pulled-left" }, [
      _vm._v("Largest Contentful Paint (LCP)"),
      _c("a", {
        staticClass: "adminify-icon-cwv",
        attrs: {
          href: "https://web.dev/vitals/",
          target: "_blank",
          title: "Core Web Vital"
        }
      })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "summary-description is-pulled-left" }, [
      _vm._v("Cumulative Layout Shift (CLS)"),
      _c("a", {
        staticClass: "adminify-icon-cwv",
        attrs: {
          href: "https://web.dev/vitals/",
          target: "_blank",
          title: "Core Web Vital"
        }
      })
    ])
  }
]
render._withStripped = true



/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/assets/admin/js/vendor"], () => (__webpack_exec__("./dev/admin/modules/page-speed/page-speed.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=wp-adminify--page-speed.js.map