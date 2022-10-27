<template>
  <div class="tab-pane" id="history" role="tabpanel" aria-labelledby="history-tab">
    <div class="wp-adminify-speed-analyze-history" v-if="histories && histories.length">
      <table class="history-table">
        <tr>
          <th class="has-text-left">Screenshot</th>
          <th class="has-text-left">Repost name</th>
          <th class="has-text-left">URL</th>
          <th class="has-text-centered">Desktop score</th>
          <th class="has-text-centered">Mobile score</th>
          <th class="has-text-right">Actions</th>
        </tr>

        <history-single v-for="history in histories" :history="history" :key="history.id"></history-single>
      </table>

      <nav class="wp-adminify-pagination pagination mt-4" role="navigation" aria-label="pagination">
        <ul class="pagination-list has-text-centered mt-5 mb-5">
          <li>
            <router-link
              :disabled="paginatePage(page) == 1"
              :to="`/history/${paginatePage(page-1)}`"
              class="pagination-link"
              tag="a"
            >
              <i class="dashicons dashicons-arrow-left-alt2"></i>
            </router-link>
          </li>

          <li v-for="(_page, _index) in pagination.pages" :key="_index">
            <span v-if="_page == '.'" class="pagination-ellipsis">&hellip;</span>
            <router-link
              v-else
              :to="`/history/${paginatePage(_page)}`"
              class="pagination-link"
              :class="paginatePage(_page) == page ? 'is-current' : ''"
              tag="a"
            >{{ paginatePage(_page) }}</router-link>
          </li>

          <li>
            <router-link
              :disabled="paginatePage(page) == pagination.total"
              :to="`/history/${paginatePage(page+1)}`"
              class="pagination-link"
              tag="a"
            >
              <i class="dashicons dashicons-arrow-right-alt2"></i>
            </router-link>
          </li>
        </ul>
      </nav>
    </div>

    <!-- Delete Folder Popup -->
    <div class="wp-adminify--popup-area is-flex is-align-items-center is-justify-content-center">
      <div class="wp-adminify--popup-container has-text-centered">
        <div class="wp-adminify--popup-container_inner pt-6 pb-6">
          <div class="popup--delete-history" v-if="delete_history_popup && history_going_to_delete">
            <a class="wp-adminify--popup-close" href="#" @click.prevent="hide_delete_history_popup">
              <span class="dashicons dashicons-no-alt"></span>
            </a>

            <h3 class="mt-0 ml-4 mr-4">Are you sure you want to delete the below history?</h3>
            <p>{{ history_going_to_delete.url }}</p>

            <div>
              <a href="#" class="button" @click.prevent="hide_delete_history_popup">No, Keep it</a>
              <a
                href="#"
                class="button button-primary"
                @click.prevent="_deleteHistory"
              >Yes, Delete it!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      total: 0,
      items_per_page: 5,
      histories: [],
      delete_history_popup: true,
      history_going_to_delete: null,
    };
  },

  mounted() {
    this.page = Number(this.$route.params.page) || 1;
    this.$ = jQuery;
    this.adminify_data = window.wp_adminify__pagespeed_data;
    this.fetchHistories(this.page, this.items_per_page);
  },

  methods: {
    showDeleteHistoryPopup(history = false) {
      this.history_going_to_delete = history;
      this.showPopupOverlay();
      this.delete_history_popup = true;
    },

    hide_delete_history_popup() {
      this.hidePopupOverlay();
      this.history_going_to_delete = null;
      this.delete_history_popup = false;
    },

    showPopupOverlay() {
      this.$("body").addClass("wp-adminify--popup-show");
    },

    hidePopupOverlay() {
      this.$("body").removeClass("wp-adminify--popup-show");
    },

    deleteHistory(history_id) {
      let history = this.histories.find(
        (_history) => _history.id == history_id
      );

      const _this = this;

      this.showDeleteHistoryPopup(history);
    },

    _deleteHistory() {
      const _this = this;

      _this.$.ajax({
        type: "POST",
        url: _this.adminify_data.ajaxurl,
        data: {
          url: _this.url,
          action: "adminify_page_speed",
          route: "delete_history",
          ids: [_this.history_going_to_delete.id],
          _ajax_nonce: _this.adminify_data.nonce,
        },
        success: function (response) {
          if (response && response.data) {
            _this.fetchHistories(_this.page, _this.items_per_page);
          }
        },
      }).always(function () {
        _this.hide_delete_history_popup();
      });
    },

    paginatePage(page) {
      if (page < 1) return 1;
      if (page > this.pagination.total) return this.pagination.total;

      return page;
    },

    check_max_page(
      total,
      items_per_page = this.items_per_page,
      current_page = this.page
    ) {
      let max = Math.ceil(total / items_per_page);

      if (max == 0) return;

      if (current_page > max) {
        this.$router.push({ path: `/history/${max}` });
      }
    },

    fetchHistories(page, items_per_page) {
      const _this = this;

      this.$.ajax({
        type: "POST",
        url: this.adminify_data.ajaxurl,
        data: {
          url: this.url,
          action: "adminify_page_speed",
          route: "fetch_histories",
          page: page,
          items_per_page: items_per_page,
          _ajax_nonce: this.adminify_data.nonce,
        },
        success: function (response) {
          if (response && response.data) {
            _this.total = response.data.total;
            _this.histories = response.data.histories;

            if (_this.page > 1 && _this.histories.length == 0) {
              _this.check_max_page(_this.total);
            }
          }
        },
      });
    },

    isURL(url) {
      return /^(ftp|http|https):\/\/[^ "]+$/.test(url);
    },
  },

  computed: {
    pagination() {
      let total = Math.ceil(this.total / this.items_per_page);
      let current = this.page;
      let pages = [];

      if (total > 5) {
        for (let n = 1; n <= total; n++) {
          let conditions = [
            n == 1,
            n == total,
            current == n,
            current - 1 == n,
            current + 1 == n,
            current == total && n > total - 3,
            current == 1 && n < 4,
          ];

          if (conditions.some((_state) => _state)) {
            pages.push(n);
          }
        }

        let _pages = JSON.parse(JSON.stringify(pages));
        let count = 0;
        pages.forEach((item, index) => {
          if (item + 1 < pages[index + 1]) {
            _pages.splice(index + 1 + count, 0, ".");
            count++;
          }
        });

        pages = _pages;
      } else {
        for (let n = 1; n <= total; n++) {
          pages.push(n);
        }
      }

      return { total, current, pages };
    },
  },
};
</script>
