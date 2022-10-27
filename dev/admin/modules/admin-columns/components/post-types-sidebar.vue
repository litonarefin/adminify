<template>
    <div class="column is-4">
        <div class="tabs is-boxed">
            <ul class="nav-tabs is-flex is-flex-direction-column is-align-items-flex-start">

                <router-link :to='"/post-types/post"' v-slot="{ navigate, isActive }" custom exact>
                    <li id="analyze-tab" class="nav-item" @click="navigate" @keypress.enter="navigate" role="link" :class="[isActive && 'router-link-active']">
                        <a class="nav-link is-clickable" :class="[isActive && 'active']" href="javascript:void(0);">
                            <span class="icon is-small"><i class="dashicons dashicons-edit-page"></i></span>
                            <span>Post</span>
                        </a>
                    </li>
                </router-link>

                <router-link :to='"/post-types/page"' v-slot="{ navigate, isActive }" custom exact>
                    <li id="analyze-tab" class="nav-item" @click="navigate" @keypress.enter="navigate" role="link" :class="[isActive && 'router-link-active']">
                        <a class="nav-link is-clickable" :class="[isActive && 'active']" href="javascript:void(0);">
                            <span class="icon is-small"><i class="dashicons dashicons-edit-page"></i></span>
                            <span>Page</span>
                        </a>
                    </li>
                </router-link>

            </ul>
        </div>
    </div>
</template>