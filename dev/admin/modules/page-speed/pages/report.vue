<template>
  <div
    class="tab-pane fade show active"
    id="report"
    role="tabpanel"
    aria-labelledby="report-tab"
  >
    <div class="wp-adminify-speed-analyze-result">
      <div class="analyze-result-tab" v-if="history">
        <div class="device-tabs has-text-centered">
          <ul
            class="
              nav nav-tabs
              is-inline-flex is-align-content-center is-justify-content-center
            "
            id="resulttabs"
            role="tablist"
          >
            <li class="nav-item" :class="activeTab == 'mobile' ? 'active' : ''">
              <a
                @click.prevent="toggleTab('mobile')"
                class="nav-link is-clickable"
                id="mobile-tab"
                data-toggle="tab"
                href="#"
                ><i class="dashicons dashicons-smartphone"></i>Mobile</a
              >
            </li>
            <li
              class="nav-item"
              :class="activeTab == 'desktop' ? 'active' : ''"
            >
              <a
                @click.prevent="toggleTab('desktop')"
                class="nav-link is-clickable"
                id="desktop-tab"
                data-toggle="tab"
                href="#"
                ><i class="dashicons dashicons-desktop"></i>Desktop</a
              >
            </li>
          </ul>
        </div>
        <div class="tab-content" id="resultContent">
          <div class="tab-pane fade show active">
            <div class="desktop-result has-text-centered">
              <div class="result-top mb-5">
                <div class="columns is-vcentered">
                  <div class="column">
                    <div class="health-progress">
                      <div :class="['progress-bar', getScoreClass(score)]">
                        <!-- Draw Progress graph here -->
                        <div class="progress-percentage">
                          {{ score }}
                        </div>
                        <div class="progress-status">
                          {{ getScoreStatus(score, true) }}
                        </div>
                      </div>
                      <span class="title">Overall Progress</span>
                    </div>
                    <div class="progress-scale">
                      <span class="range-fail ml-4">0-49</span>
                      <span class="range-average ml-4">50-89</span>
                      <span class="range-pass ml-4">90-100</span>
                    </div>
                  </div>
                  <div class="column">
                    <div class="url-screenshot has-text-left">
                      <img
                        :src="
                          activeData.lighthouseResult.audits['final-screenshot']
                            .details.data
                        "
                        alt="Screenshot"
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="section--field-data mt-3 mb-3">
                <div class="result-header has-text-left">
                  <span class="result-title">Field Data </span>

                  <!-- If Pass -->
                  <span
                    v-if="checkStatus(activeData.loadingExperience) == 1"
                    class="result-description adminify-ps-pass"
                    >Over the previous 28-day collection period,
                    <a
                      href="https://developers.google.com/speed/docs/insights/v5/about"
                      target="_blank"
                      >field data</a
                    >
                    shows that this page <b>passes</b> the
                    <a href="https://web.dev/vitals/" target="_blank"
                      >Core Web Vitals</a
                    >
                    assessment.</span
                  >

                  <!-- If Not Pass -->
                  <span
                    v-if="checkStatus(activeData.loadingExperience) == 0"
                    class="result-description adminify-ps-fail"
                    >Over the previous 28-day collection period,
                    <a
                      href="https://developers.google.com/speed/docs/insights/v5/about"
                      target="_blank"
                      >field data</a
                    >
                    shows that this page <b>does not pass</b> the
                    <a href="https://web.dev/vitals/" target="_blank"
                      >Core Web Vitals</a
                    >
                    assessment.</span
                  >

                  <!-- If No Data -->
                  <span
                    v-if="checkStatus(activeData.loadingExperience) == -1"
                    class="result-description adminify-ps-average"
                    >The Chrome User Experience Report
                    <a
                      href="https://developers.google.com/speed/docs/insights/about#faq"
                      data-ga-id="speed-data-unavailable-faq"
                      target="_blank"
                      >does not have sufficient real-world speed data</a
                    >
                    for this page.</span
                  >
                </div>

                <div
                  class="result-summary pt-4"
                  v-if="'metrics' in activeData.loadingExperience"
                >
                  <div class="columns">
                    <div class="column">
                      <div class="summary-wrapper has-text-left">
                        <div class="summary-top is-inline-block">
                          <span class="summary-description is-pulled-left"
                            >First Contentful Paint (FCP)</span
                          >
                          <div
                            :class="[
                              'summary-value is-pulled-right',
                              fcpScoreClass(
                                MilisecondsToSeconds(
                                  activeData.loadingExperience.metrics
                                    .FIRST_CONTENTFUL_PAINT_MS.percentile
                                )
                              ),
                            ]"
                          >
                            {{
                              MilisecondsToSeconds(
                                activeData.loadingExperience.metrics
                                  .FIRST_CONTENTFUL_PAINT_MS.percentile
                              )
                            }}
                            s
                          </div>
                        </div>
                        <div class="summary-chart is-flex">
                          <div
                            v-for="(item, index) in activeData.loadingExperience
                              .metrics.FIRST_CONTENTFUL_PAINT_MS.distributions"
                            :key="item.proportion"
                            :class="['bar', barClass(index)]"
                            v-bind:style="
                              'flex-grow: ' + toRatio( item.proportion )
                            "
                          >
                            {{ toRatio( item.proportion ) }}%
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="column">
                      <div class="summary-wrapper has-text-left">
                        <div class="summary-top is-inline-block">
                          <span class="summary-description is-pulled-left"
                            >First Input Delay (FID)<a
                              href="https://web.dev/vitals/"
                              target="_blank"
                              class="adminify-icon-cwv"
                              title="Core Web Vital"
                            ></a
                          ></span>
                          <div
                            :class="[
                              'summary-value is-pulled-right',
                              fidScoreClass(
                                activeData.loadingExperience.metrics
                                  .FIRST_INPUT_DELAY_MS.percentile
                              ),
                            ]"
                          >
                            {{
                              activeData.loadingExperience.metrics
                                .FIRST_INPUT_DELAY_MS.percentile
                            }}
                            ms
                          </div>
                        </div>

                        <div class="summary-chart is-flex">
                          <div
                            v-for="(item, index) in activeData.loadingExperience
                              .metrics.FIRST_INPUT_DELAY_MS.distributions"
                            :key="item.proportion"
                            :class="['bar', barClass(index)]"
                            v-bind:style="
                              'flex-grow: ' + toRatio( item.proportion )
                            "
                          >
                            {{ toRatio( item.proportion ) }}%
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="columns">
                    <div class="column">
                      <div class="summary-wrapper has-text-left">
                        <div class="summary-top is-inline-block">
                          <span class="summary-description is-pulled-left"
                            >Largest Contentful Paint (LCP)<a
                              href="https://web.dev/vitals/"
                              target="_blank"
                              class="adminify-icon-cwv"
                              title="Core Web Vital"
                            ></a
                          ></span>
                          <div
                            :class="[
                              'summary-value is-pulled-right',
                              lcpScoreClass(
                                MilisecondsToSeconds(
                                  activeData.loadingExperience.metrics
                                    .LARGEST_CONTENTFUL_PAINT_MS.percentile
                                )
                              ),
                            ]"
                          >
                            {{
                              MilisecondsToSeconds(
                                activeData.loadingExperience.metrics
                                  .LARGEST_CONTENTFUL_PAINT_MS.percentile
                              )
                            }}
                            s
                          </div>
                        </div>
                        <div class="summary-chart is-flex">
                          <div
                            v-for="(item, index) in activeData.loadingExperience
                              .metrics.LARGEST_CONTENTFUL_PAINT_MS
                              .distributions"
                            :key="item.proportion"
                            :class="['bar', barClass(index)]"
                            v-bind:style="
                              'flex-grow: ' + toRatio( item.proportion )
                            "
                          >
                            {{ toRatio( item.proportion ) }}%
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="column">
                      <div class="summary-wrapper has-text-left">
                        <div class="summary-top is-inline-block">
                          <span class="summary-description is-pulled-left"
                            >Cumulative Layout Shift (CLS)<a
                              href="#"
                              target="_blank"
                              class="adminify-icon-cwv"
                              title="Core Web Vital"
                            ></a
                          ></span>
                          <div
                            :class="[
                              'summary-value is-pulled-right',
                              clsScoreClass(
                                activeData.loadingExperience.metrics
                                  .CUMULATIVE_LAYOUT_SHIFT_SCORE.percentile /
                                  100
                              ),
                            ]"
                          >
                            {{
                              activeData.loadingExperience.metrics
                                .CUMULATIVE_LAYOUT_SHIFT_SCORE.percentile / 100
                            }}
                            s
                          </div>
                        </div>
                        <div class="summary-chart is-flex">
                          <div
                            v-for="(item, index) in activeData.loadingExperience
                              .metrics.CUMULATIVE_LAYOUT_SHIFT_SCORE
                              .distributions"
                            :key="item.proportion"
                            :class="['bar', barClass(index)]"
                            v-bind:style="
                              'flex-grow: ' + toRatio( item.proportion )
                            "
                          >
                            {{ toRatio( item.proportion ) }}%
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="origin-summary-trigger pt-5 has-text-left"
                  v-if="
                    'origin_fallback' in activeData.loadingExperience &&
                    activeData.loadingExperience.origin_fallback
                  "
                >
                  <button class="is-clickable">
                    <input
                      type="checkbox"
                      class="is-pulled-left"
                      v-model="show_origin_sum"
                    />
                    Show origin summary
                  </button>
                </div>
              </div>

              <div
                class="section--origin-summery has-text-left pt-5"
                v-if="
                  show_origin_sum ||
                  !('metrics' in activeData.loadingExperience)
                "
              >
                <div class="result-header">
                  <span class="result-title">Origin Summary </span>

                  <!-- If Pass -->
                  <span
                    v-if="checkStatus(activeData.originLoadingExperience) == 1"
                    class="result-description adminify-ps-pass"
                    >Over the previous 28-day collection period, the aggregate
                    experience of all pages served from this origin
                    <b>passes</b> the
                    <a href="https://web.dev/vitals/" target="_blank"
                      >Core Web Vitals</a
                    >
                    assessment. To view suggestions tailored to each page,
                    analyze individual page URLs.</span
                  >

                  <!-- If Not Pass -->
                  <span
                    v-if="checkStatus(activeData.originLoadingExperience) == 0"
                    class="result-description adminify-ps-fail"
                    >Over the previous 28-day collection period, the aggregate
                    experience of all pages served from this origin
                    <b>does not pass</b> the
                    <a href="https://web.dev/vitals/" target="_blank"
                      >Core Web Vitals</a
                    >
                    assessment. To view suggestions tailored to each page,
                    analyze individual page URLs.</span
                  >

                  <!-- If No Data -->
                  <span
                    v-if="checkStatus(activeData.originLoadingExperience) == -1"
                    class="result-description adminify-ps-average"
                    >The Chrome User Experience Report
                    <a
                      href="https://developers.google.com/speed/docs/insights/about#faq"
                      data-ga-id="speed-data-unavailable-faq"
                      target="_blank"
                      >does not have sufficient real-world speed data</a
                    >
                    for this origin.</span
                  >
                </div>

                <div
                  class="result-summary origin-result-summary"
                  v-if="'originLoadingExperience' in activeData"
                >
                  <div class="result-header mt-5 mb-4">
                    <span class="result-title">Origin Summary </span>
                    <span class="result-description result-description">
                      - Over the previous 28-day collection period, the
                      aggregate experience of all pages served from this origin
                      shows that this page
                      <b class="adminify-ps-pass">does not pass</b> the
                      <a href="https://web.dev/vitals/" target="_blank"
                        >Core Web Vitals</a
                      >
                      assessment.
                    </span>
                  </div>

                  <div class="columns">
                    <div class="column">
                      <div class="summary-wrapper">
                        <div class="summary-top">
                          <span class="summary-description is-pulled-left"
                            >First Contentful Paint (FCP)</span
                          >
                          <div
                            :class="[
                              'summary-value is-pulled-right',
                              fcpScoreClass(
                                MilisecondsToSeconds(
                                  activeData.originLoadingExperience.metrics
                                    .FIRST_CONTENTFUL_PAINT_MS.percentile
                                )
                              ),
                            ]"
                          >
                            {{
                              MilisecondsToSeconds(
                                activeData.originLoadingExperience.metrics
                                  .FIRST_CONTENTFUL_PAINT_MS.percentile
                              )
                            }}
                            s
                          </div>
                        </div>
                        <div class="summary-chart is-flex">
                          <div
                            v-for="(item, index) in activeData
                              .originLoadingExperience.metrics
                              .FIRST_CONTENTFUL_PAINT_MS.distributions"
                            :key="item.proportion"
                            :class="['bar', barClass(index)]"
                            v-bind:style="
                              'flex-grow: ' + toRatio( item.proportion )
                            "
                          >
                            {{ toRatio( item.proportion ) }}%
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="column">
                      <div class="summary-wrapper">
                        <div class="summary-top">
                          <span class="summary-description is-pulled-left"
                            >First Input Delay (FID)<a
                              href="https://web.dev/vitals/"
                              target="_blank"
                              class="adminify-icon-cwv"
                              title="Core Web Vital"
                            ></a
                          ></span>
                          <div
                            :class="[
                              'summary-value is-pulled-right',
                              fidScoreClass(
                                activeData.originLoadingExperience.metrics
                                  .FIRST_INPUT_DELAY_MS.percentile
                              ),
                            ]"
                          >
                            {{
                              activeData.originLoadingExperience.metrics
                                .FIRST_INPUT_DELAY_MS.percentile
                            }}
                            ms
                          </div>
                        </div>

                        <div class="summary-chart is-flex">
                          <div
                            v-for="(item, index) in activeData
                              .originLoadingExperience.metrics
                              .FIRST_INPUT_DELAY_MS.distributions"
                            :key="item.proportion"
                            :class="['bar', barClass(index)]"
                            v-bind:style="
                              'flex-grow: ' + toRatio( item.proportion )
                            "
                          >
                            {{ toRatio( item.proportion ) }}%
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="columns">
                    <div class="column">
                      <div class="summary-wrapper">
                        <div class="summary-top">
                          <span class="summary-description is-pulled-left"
                            >Largest Contentful Paint (LCP)<a
                              href="https://web.dev/vitals/"
                              target="_blank"
                              class="adminify-icon-cwv"
                              title="Core Web Vital"
                            ></a
                          ></span>
                          <div
                            :class="[
                              'summary-value is-pulled-right',
                              lcpScoreClass(
                                MilisecondsToSeconds(
                                  activeData.originLoadingExperience.metrics
                                    .LARGEST_CONTENTFUL_PAINT_MS.percentile
                                )
                              ),
                            ]"
                          >
                            {{
                              MilisecondsToSeconds(
                                activeData.originLoadingExperience.metrics
                                  .LARGEST_CONTENTFUL_PAINT_MS.percentile
                              )
                            }}
                            s
                          </div>
                        </div>
                        <div class="summary-chart is-flex">
                          <div
                            v-for="(item, index) in activeData
                              .originLoadingExperience.metrics
                              .LARGEST_CONTENTFUL_PAINT_MS.distributions"
                            :key="item.proportion"
                            :class="['bar', barClass(index)]"
                            v-bind:style="
                              'flex-grow: ' + toRatio( item.proportion )
                            "
                          >
                            {{ toRatio( item.proportion ) }}%
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="column">
                      <div class="summary-wrapper">
                        <div class="summary-top">
                          <span class="summary-description is-pulled-left"
                            >Cumulative Layout Shift (CLS)<a
                              href="https://web.dev/vitals/"
                              target="_blank"
                              class="adminify-icon-cwv"
                              title="Core Web Vital"
                            ></a
                          ></span>
                          <div
                            :class="[
                              'summary-value is-pulled-right',
                              clsScoreClass(
                                activeData.originLoadingExperience.metrics
                                  .CUMULATIVE_LAYOUT_SHIFT_SCORE.percentile /
                                  100
                              ),
                            ]"
                          >
                            {{
                              activeData.originLoadingExperience.metrics
                                .CUMULATIVE_LAYOUT_SHIFT_SCORE.percentile / 100
                            }}
                            s
                          </div>
                        </div>
                        <div class="summary-chart is-flex">
                          <div
                            v-for="(item, index) in activeData
                              .originLoadingExperience.metrics
                              .CUMULATIVE_LAYOUT_SHIFT_SCORE.distributions"
                            :key="item.proportion"
                            :class="['bar', barClass(index)]"
                            v-bind:style="
                              'flex-grow: ' + toRatio( item.proportion )
                            "
                          >
                            {{ toRatio( item.proportion ) }}%
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="result-data-wrapper mt-6">
                <div class="result-data">
                  <div class="data-category">
                    <LabData :data="activeData" :device="activeTab" />
                  </div>
                </div>
              </div>

              <div class="result-body has-text-left">
                <div class="result-inner pt-4">
                  <!-- Screenshot Thumbnails -->
                  <template
                    v-if="'screenshot-thumbnails' in display_data.screenshots"
                  >
                    <div
                      v-if="
                        display_data.screenshots['screenshot-thumbnails']
                          .details &&
                        display_data.screenshots['screenshot-thumbnails']
                          .details.type == 'filmstrip'
                      "
                    >
                      <ul
                        v-if="
                          display_data.screenshots['screenshot-thumbnails']
                            .details.items
                        "
                        :class="['filmstrip-list screenshot-thumbnails']"
                      >
                        <li
                          v-for="(strip, strip_index) in display_data
                            .screenshots['screenshot-thumbnails'].details.items"
                          :key="`${display_data.screenshots['screenshot-thumbnails'].details.type}-${strip_index}`"
                        >
                          <img :src="strip.data" alt="" />
                        </li>
                      </ul>
                    </div>
                  </template>

                  <!-- Opportunity -->
                  <div
                    class="section mt-6"
                    v-if="Object.keys(display_data.opportunities).length"
                  >
                    <div class="data-audit-group__header pb-4">
                      <strong class="data-audit-group__title">{{
                        activeData.lighthouseResult.categoryGroups[
                          "load-opportunities"
                        ].title
                      }}</strong>
                      -
                      <span
                        class="data-audit-group__description"
                        v-html="
                          markdownToLink(
                            activeData.lighthouseResult.categoryGroups[
                              'load-opportunities'
                            ].description
                          )
                        "
                      ></span>
                    </div>
                    <LoopData :data="display_data.opportunities"></LoopData>
                  </div>

                  <!-- Diagnostics -->
                  <div
                    class="section mt-6"
                    v-if="Object.keys(display_data.diagnostics).length"
                  >
                    <div class="data-audit-group__header pb-4">
                      <strong class="data-audit-group__title">{{
                        activeData.lighthouseResult.categoryGroups.diagnostics
                          .title
                      }}</strong>
                      -
                      <span
                        class="data-audit-group__description"
                        v-html="
                          markdownToLink(
                            activeData.lighthouseResult.categoryGroups
                              .diagnostics.description
                          )
                        "
                      ></span>
                    </div>
                    <LoopData :data="display_data.diagnostics"></LoopData>
                  </div>

                  <!-- Passed Audits -->
                  <div
                    class="section mt-6"
                    v-if="Object.keys(display_data.passed_audits).length"
                  >
                    <div>
                      <strong>{{
                        activeData.lighthouseResult.i18n
                          .rendererFormattedStrings.passedAuditsGroupTitle
                      }}</strong>
                      <span>{{
                        Object.keys(display_data.passed_audits).length
                      }}</span>
                    </div>
                    <LoopData :data="display_data.passed_audits"></LoopData>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import LoopData from "../components/loop-data.vue";
import LabData from "../components/lab-data.vue";

export default {
  name: "report",

  components: {
    LoopData,
    LabData,
  },

  data() {
    return {
      // activeTab: "desktop",
      activeTab: "mobile",
      history: null,
      show_origin_sum: false,
      hasScreenshots: false,
    };
  },

  async mounted() {
    this.history_id = Number(this.$route.params.id) || 1;

    this.$ = jQuery;
    this.adminify_data = window.wp_adminify__pagespeed_data;

    const { data } = await this.fetchHistory();

    this.history = data.history;

    this.allowedTypes = [
      "criticalrequestchain",
      "filmstrip",
      "opportunity",
      "table",
      "statistics",
      "diagnostic",
    ];

    this.Audit = {
      SCORING_MODES: {
        NUMERIC: "numeric",
        BINARY: "binary",
        MANUAL: "manual",
        INFORMATIVE: "informative",
        NOT_APPLICABLE: "notApplicable",
        ERROR: "error",
      },
    };
  },

  methods: {

    checkStatus(data) {
      if ( !data || !("overall_category" in data) ) return -1;
      if ( "overall_category" in data && data.overall_category == "FAST" ) return 1;
      return 0;
    },

    clampTo2Decimals(val) {
      return Math.round(val * 100) / 100;
    },

    arithmeticMean(items) {
      // Filter down to just the items with a weight as they have no effect on score
      items = items.filter((item) => item.weight > 0);

      // If there is 1 null score, return a null average
      if (items.some((item) => item.score === null)) return null;

      const results = items.reduce(
        (result, item) => {
          const score = item.score;
          const weight = item.weight;

          return {
            weight: result.weight + weight,
            sum: result.sum + /** @type {number} */ (score) * weight,
          };
        },
        { weight: 0, sum: 0 }
      );

      return this.clampTo2Decimals(results.sum / results.weight || 0);
    },

    scoreAllCategories(configCategories, resultsByAuditId) {
      const scoredCategories = {};

      for (const [categoryId, configCategory] of Object.entries(
        configCategories
      )) {
        const auditRefs = configCategory.auditRefs.map((configMember) => {
          const member = { ...configMember };

          const result = resultsByAuditId[member.id];
          if (
            !result ||
            result.scoreDisplayMode ===
              this.Audit.SCORING_MODES.NOT_APPLICABLE ||
            result.scoreDisplayMode === this.Audit.SCORING_MODES.INFORMATIVE ||
            result.scoreDisplayMode === this.Audit.SCORING_MODES.MANUAL
          ) {
            member.weight = 0;
          }

          return member;
        });

        const scores = auditRefs.map((auditRef) => ({
          score: resultsByAuditId[auditRef.id]
            ? resultsByAuditId[auditRef.id].score
            : 0,
          weight: auditRef.weight,
        }));

        const score = this.arithmeticMean(scores);

        scoredCategories[categoryId] = {
          ...configCategory,
          auditRefs,
          id: categoryId,
          score,
        };
      }

      return scoredCategories;
    },

    toggleTab(tab) {
      this.activeTab = tab;
    },

    fetchHistory() {
      return this.$.ajax({
        type: "POST",
        url: this.adminify_data.ajaxurl,
        data: {
          action: "adminify_page_speed",
          route: "fetch_history",
          id: this.history_id,
          _ajax_nonce: this.adminify_data.nonce,
        },
      });
    },
  },

  computed: {
    display_data() {
      let _data = {};

      for (let key in this.activeData.lighthouseResult.audits) {
        let audit = this.activeData.lighthouseResult.audits[key];
        if (
          "details" in audit &&
          audit.details.type &&
          this.allowedTypes.includes(audit.details.type)
        ) {
          _data[key] = audit;
        }
      }

      this.hasScreenshots = false;

      let screenshots = {};
      let diagnostics = {};
      let opportunities = {};
      let passed_audits = {};

      for (let key in _data) {
        let audit = _data[key];
        let type = audit.details.type;
        let mode = audit.scoreDisplayMode;

        if ("screenshot-thumbnails" == key) {
          screenshots[key] = audit;
          this.hasScreenshots = true;
        } else if ("diagnostic" == type) {
          diagnostics[key] = audit;
        } else if ("opportunity" == type && 0.9 > audit.score) {
          opportunities[key] = audit;
        } else if ("opportunity" != type && 0.9 > audit.score) {
          diagnostics[key] = audit;
        } else if ("informative" == mode || "not_applicable" == mode) {
          diagnostics[key] = audit;
        } else {
          passed_audits[key] = audit;
        }
      }

      return { screenshots, diagnostics, opportunities, passed_audits };
    },

    desktop() {
      return this.history.data_desktop;
    },

    mobile() {
      return this.history.data_mobile;
    },

    activeData() {
      return this[this.activeTab];
    },

    score() {
      return this.activeTab == "desktop"
        ? this.history.score_desktop
        : this.history.score_mobile;
    },
  },
};
</script>
