<template>
  <div id="wpadminify-admin-columns">
    
    <div class="admin-column--message" v-if="success_message">Settings has been saved</div>

    <div class="tabs is-boxed is-centered">
      <ul class="nav-tabs" role="tablist">
        <router-link :to="'/post-types'" v-slot="{ navigate, isActive }" custom>
          <li
            id="analyze-tab"
            class="nav-item"
            @click="navigate"
            @keypress.enter="navigate"
            role="link"
            :class="[isActive && 'router-link-active']"
          >
            <a
              class="nav-link is-clickable"
              :class="[isActive && 'active']"
              href="javascript:void(0);"
            >
              <span class="icon is-small"
                ><i class="dashicons dashicons-edit-page"></i
              ></span>
              <span>Post Types</span>
            </a>
          </li>
        </router-link>

        <router-link :to="'/taxonomies'" v-slot="{ navigate, isActive }" custom>
          <li
            id="analyze-tab"
            class="nav-item"
            @click="navigate"
            @keypress.enter="navigate"
            role="link"
            :class="[isActive && 'router-link-active']"
          >
            <a
              class="nav-link is-clickable"
              :class="[isActive && 'active']"
              href="javascript:void(0);"
            >
              <span class="icon is-small"
                ><i class="dashicons dashicons-category"></i
              ></span>
              <span>Taxonomies</span>
            </a>
          </li>
        </router-link>
      </ul>
    </div>

    <div class="tab-content tab-panel pane">
      <div class="wp-adminify-loader"></div>
      <router-view :key="$route.fullPath"></router-view>
    </div>

    <div class="mt-5 has-text-centered">
      <button class="button-primary is-clickable" :disabled="disable_save_btn" @click="save_store">
        Save Settings
      </button>
    </div>

    <!-- Popup -->
    <div class="wp-adminify--popup-area">
      <div class="wp-adminify--popup-container">
        <div class="wp-adminify--popup-container_inner">
          <div class="popup--delete-folder" v-if="popup_open">
            <a
              class="wp-adminify--popup-close"
              href="#"
              @click.prevent="hide_popup"
              ><span class="dashicons dashicons-no-alt"></span
            ></a>

            <h3>{{ popup_title }}</h3>

            <div class="popup-content" v-html="popup_details"></div>

            <a
              href="#"
              class="button button-primary"
              @click.prevent="hide_popup"
              >Got it</a
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    post_types: [],
    taxonomies: [],
    popup_open: true,
    disable_save_btn: false,
    success_message: false,
    popup_title: "",
    popup_details: "",
  }),

  mounted() {
    
    Window.Events.$on("AdminColumnsError", (data) => {
      this.popup_title = data.title;
      this.popup_details = data.content;
      this.open_popup();
    });

    jQuery('body').on('click', () => {
      this.success_message = false;
    });

  },

  methods: {
    open_popup() {
      jQuery("body").addClass("wp-adminify--popup-show");
      this.popup_open = true;
    },

    hide_popup() {
      jQuery("body").removeClass("wp-adminify--popup-show");
      this.popup_open = false;
    },

    async save_store() {
      let post_types = this.post_types;
      let taxonomies = this.taxonomies;
      
      this.disable_save_btn = true;
      
      await this.$store.dispatch("save_store", { post_types, taxonomies });
      
      this.disable_save_btn = false;
      this.success_message = true;

      setTimeout(() => {
        this.success_message = false;
      }, 1500 );
    },
  },
};
</script>
