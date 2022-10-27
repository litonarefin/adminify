<template>
    
    <ul>

        <li class="folder--single-root has--sub-menu" :class="is_folder(_folder) && 'active'" v-for="_folder in folders" :key="_folder.term_id" :data-folder="_folder.term_id">

            <a :href="get_folder_url(_folder)" @contextmenu="folderActions( $event, _folder )" :style="{'color': _folder.color}">
                <span class="wp-adminify--folder-left">
                    <span class="wp-adminify--icon-control">
                        <span class="wp-adminify--icon dashicons dashicons-open-folder" v-if="!folder_select_toggle"></span>
                        <input class="wp-adminify--control" type="checkbox" v-if="folder_select_toggle" v-model="_folder.selected" @click.stop.capture="">
                    </span>
                    <span class="wp-adminify--name">{{ _folder.name }}</span>
                </span>
                <span class="wp-adminify--count">{{ _folder.count }}</span>
            </a>

            <folders :folders="_folder.children" :folder_select_toggle="folder_select_toggle" class="folder--sub-lists" v-if="_folder.children.length"></folders>

            <ul class="adminify--sub-menu">
                <li><a href="#" @click.prevent.stop="showNewSubFolderPopup( _folder )">New Sub-folder</a></li>
                <li><a href="#" @click.prevent.stop="showRenameFolderPopup( _folder )">Rename</a></li>
                <li><a href="#" @click.prevent.stop="showDeleteFolderPopup( _folder )">Delete</a></li>
            </ul>

        </li>
    </ul>

</template>

<script>

export default {

    props: {

		folders: {
			type: Array,
			required: true
		},

		folder_select_toggle: {
			type: Boolean,
			required: true
		},

	},

    methods: {

        is_folder(_folder) {
            return this.$parent.is_folder(_folder)
        },

        get_folder_url(_folder) {
            return this.$parent.get_folder_url(_folder)
        },

        folderActions( $event, _folder ) {
            this.$parent.folderActions( $event, _folder )
        },

        showRenameFolderPopup( _folder ) {
            this.$parent.showRenameFolderPopup( _folder )
        },

        showDeleteFolderPopup( _folder ) {
            this.$parent.showDeleteFolderPopup( _folder )
        },

        showNewSubFolderPopup( _folder ) {
            this.$parent.showNewSubFolderPopup( _folder )
        }

    }

}

</script>