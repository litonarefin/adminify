<template>
    <tr>
        <td class="has-text-left">
            <div class="screenshot-wrapper">
                <img :src="history.screenshot" width="100">
            </div>
        </td>
        <td class="has-text-left">
            <div class="log-date-time is-relative pl-3">
                <time :datetime="history.time">
                    <div class="date">{{ history.formated_date }}</div>
                    <div class="time is-relative pl-4">{{ history.formated_time }}</div>
                </time>
            </div>
        </td>
        <td class="has-text-left">
            <div class="url" style="text-transform: initial;">
                <a :href="history.url" target="_blank" ref="noreferrer noopener">{{ history.url }}</a>
            </div>
        </td>
        <td class="has-text-centered">
            <div class="progress-chart desktop">
                <span class="progress-percentagte">{{ history.score_desktop }}</span>
            </div>
        </td>
        <td class="has-text-centered">
            <div class="progress-chart mobile">
                <span class="progress-percentagte">{{ history.score_mobile }}</span>
            </div>
        </td>
        <td class="has-text-right">
            <router-link :to='`/report/${history.id}`' class="report-button" tag="button">Full report</router-link>
            <button class="remove-button" @click.prevent="deleteHistory">Delete</button>
        </td>
    </tr>
</template>

<script>

export default {

    props: {
        
        history: {
			type: Object,
			required: true
        }

	},

    methods: {

        deleteHistory() {

            this.$parent.deleteHistory( this.history.id );

        }

    }

}

</script>