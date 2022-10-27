<template>
  <div class="data-audit-group data-audit-group--metrics">
    <div class="data-audit-group__header is-pulled-left">Lab Data</div>
    <div class="data-audit-tab is-pulled-right">
      <input
        class="data-metrics-toggle__input"
        type="checkbox"
        id="data-metric-descriptions"
        v-model="isDetail"
        aria-label="Toggle the display of metric descriptions"
      />
      <label
        class="data-metrics-toggle__label is-flex"
        for="data-metric-descriptions"
      >
        <div
          class="
            data-metrics-toggle__icon data-metrics-toggle__icon--less
            is-flex is-align-items-center is-justify-content-center
          "
          aria-hidden="true"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="24"
            height="24"
            viewBox="0 0 24 24"
          >
            <path
              class="data-metrics-toggle__lines"
              d="M4 9h16v2H4zm0 4h10v2H4z"
            ></path>
          </svg>
        </div>
        <div
          class="
            data-metrics-toggle__icon data-metrics-toggle__icon--more
            is-flex is-align-items-center is-justify-content-center
          "
          aria-hidden="true"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
          >
            <path
              class="data-metrics-toggle__lines"
              d="M3 18h12v-2H3v2zM3 6v2h18V6H3zm0 7h18v-2H3v2z"
            ></path>
          </svg>
        </div>
      </label>
    </div>

    <div class="data-metrics-container pt-5 mt-6">
      <div class="columns">
        <div class="column">
          <div
            class="data-metric"
            :class="
              getScoreStatusClass(
                data.lighthouseResult.audits['first-contentful-paint'].score
              )
            "
            id="first-contentful-paint"
          >
            <div class="data-metric__innerwrap summary-wrapper">
              <div class="summary-top">
                <span
                  class="data-metric__title summary-description is-pulled-left"
                  >{{
                    data.lighthouseResult.audits["first-contentful-paint"].title
                  }}</span
                >
                <div
                  class="
                    data-metric__value
                    summary-value
                    adminify-ps-pass
                    is-pulled-right
                  "
                >
                  {{
                    data.lighthouseResult.audits["first-contentful-paint"]
                      .displayValue
                  }}
                </div>
              </div>
              <div
                class="data-metric__description result-description"
                v-if="isDetail"
              >
                <span
                  v-html="
                    markdownToLink(
                      data.lighthouseResult.audits['first-contentful-paint']
                        .description
                    )
                  "
                >
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="column">
          <div
            class="data-metric"
            :class="
              getScoreStatusClass(
                data.lighthouseResult.audits['interactive'].score
              )
            "
            id="interactive"
          >
            <div class="data-metric__innerwrap summary-wrapper">
              <div class="summary-top">
                <span
                  class="data-metric__title summary-description is-pulled-left"
                  >{{ data.lighthouseResult.audits["interactive"].title }}</span
                >
                <div
                  class="
                    data-metric__value
                    summary-value
                    adminify-ps-pass
                    is-pulled-right
                  "
                >
                  {{ data.lighthouseResult.audits["interactive"].displayValue }}
                </div>
              </div>
              <div
                class="data-metric__description result-description"
                v-if="isDetail"
              >
                <span
                  v-html="
                    markdownToLink(
                      data.lighthouseResult.audits['interactive'].description
                    )
                  "
                >
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="columns">
        <div class="column">
          <div
            class="data-metric"
            :class="
              getScoreStatusClass(
                data.lighthouseResult.audits['speed-index'].score
              )
            "
            id="speed-index"
          >
            <div class="data-metric__innerwrap summary-wrapper">
              <div class="summary-top">
                <span
                  class="data-metric__title summary-description is-pulled-left"
                  >{{ data.lighthouseResult.audits["speed-index"].title }}</span
                >
                <div
                  class="
                    data-metric__value
                    summary-value
                    adminify-ps-pass
                    is-pulled-right
                  "
                >
                  {{ data.lighthouseResult.audits["speed-index"].displayValue }}
                </div>
              </div>
              <div
                class="data-metric__description result-description"
                v-if="isDetail"
              >
                <span
                  v-html="
                    markdownToLink(
                      data.lighthouseResult.audits['speed-index'].description
                    )
                  "
                >
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="column">
          <div
            class="data-metric"
            :class="
              getScoreStatusClass(
                data.lighthouseResult.audits['total-blocking-time'].score
              )
            "
            id="total-blocking-time"
          >
            <div class="data-metric__innerwrap summary-wrapper">
              <div class="summary-top">
                <span
                  class="data-metric__title summary-description is-pulled-left"
                  >{{
                    data.lighthouseResult.audits["total-blocking-time"].title
                  }}</span
                >
                <div
                  class="
                    data-metric__value
                    summary-value
                    adminify-ps-pass
                    is-pulled-right
                  "
                >
                  {{
                    data.lighthouseResult.audits["total-blocking-time"]
                      .displayValue
                  }}
                </div>
              </div>
              <div
                class="data-metric__description result-description"
                v-if="isDetail"
              >
                <span
                  v-html="
                    markdownToLink(
                      data.lighthouseResult.audits['total-blocking-time']
                        .description
                    )
                  "
                >
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="columns">
        <div class="column">
          <div
            class="data-metric"
            :class="
              getScoreStatusClass(
                data.lighthouseResult.audits['largest-contentful-paint'].score
              )
            "
            id="largest-contentful-paint"
          >
            <div class="data-metric__innerwrap summary-wrapper">
              <div class="summary-top">
                <span
                  class="data-metric__title summary-description is-pulled-left"
                  >{{
                    data.lighthouseResult.audits["largest-contentful-paint"]
                      .title
                  }}
                  <a
                    href="https://web.dev/vitals"
                    target="_blank"
                    class="icon--cwv"
                    title="Core Web Vital"
                  ></a>
                </span>
                <div
                  class="
                    data-metric__value
                    summary-value
                    adminify-ps-average
                    is-pulled-right
                  "
                >
                  {{
                    data.lighthouseResult.audits["largest-contentful-paint"]
                      .displayValue
                  }}
                </div>
              </div>
              <div
                class="data-metric__description result-description"
                v-if="isDetail"
              >
                <span
                  v-html="
                    markdownToLink(
                      data.lighthouseResult.audits['largest-contentful-paint']
                        .description
                    )
                  "
                ></span>
              </div>
            </div>
          </div>
        </div>

        <div class="column">
          <div
            class="data-metric"
            :class="
              getScoreStatusClass(
                data.lighthouseResult.audits['cumulative-layout-shift'].score
              )
            "
            id="cumulative-layout-shift"
          >
            <div class="data-metric__innerwrap summary-wrapper">
              <div class="summary-top">
                <span
                  class="data-metric__title summary-description is-pulled-left"
                  >{{
                    data.lighthouseResult.audits["cumulative-layout-shift"]
                      .title
                  }}
                  <a
                    href="https://web.dev/vitals"
                    target="_blank"
                    class="icon--cwv"
                    title="Core Web Vital"
                  ></a>
                </span>
                <div
                  class="
                    data-metric__value
                    summary-value
                    adminify-ps-pass
                    is-pulled-right
                  "
                >
                  {{
                    data.lighthouseResult.audits["cumulative-layout-shift"]
                      .displayValue
                  }}
                </div>
              </div>
              <div
                class="data-metric__description result-description"
                v-if="isDetail"
              >
                <span
                  v-html="
                    markdownToLink(
                      data.lighthouseResult.audits['cumulative-layout-shift']
                        .description
                    )
                  "
                >
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="data-metrics__disclaimer result-description mt-5 pt-5 mb-5">
      <span
        v-html="
          markdownToLink(
            data.lighthouseResult.i18n.rendererFormattedStrings
              .varianceDisclaimer
          )
        "
      >
      </span>
      <a
        :href="`https://googlechrome.github.io/lighthouse/scorecalc/#FCP=${data.lighthouseResult.audits['first-contentful-paint'].numericValue}&SI=${data.lighthouseResult.audits['speed-index'].numericValue}&LCP=${data.lighthouseResult.audits['largest-contentful-paint'].numericValue}&TTI=${data.lighthouseResult.audits['interactive'].numericValue}&TBT=${data.lighthouseResult.audits['total-blocking-time'].numericValue}&CLS=${data.lighthouseResult.audits['cumulative-layout-shift'].numericValue}&FMP=${data.lighthouseResult.audits['first-meaningful-paint'].numericValue}&device=${device}&version=${data.lighthouseResult.lighthouseVersion}`"
        target="_blank"
      >
        {{ data.lighthouseResult.i18n.rendererFormattedStrings.calculatorLink }}
      </a>
    </div>

    <!-- <div class="data-buttons">
      <button class="data-button report-icon report-icon--treemap is-clickable">
        {{
          data.lighthouseResult.i18n.rendererFormattedStrings
            .viewTreemapLabel
        }}
      </button>
    </div> -->
  </div>
</template>


<script>
export default {
  name: "labData",
  props: {
    data: {
      type: Object,
      required: true,
      default() {
        return {};
      },
    },
    device: {
      type: String,
      required: true,
      default: "desktop",
    },
  },
  data() {
    return {
      isDetail: false,
    };
  },
};
</script>
