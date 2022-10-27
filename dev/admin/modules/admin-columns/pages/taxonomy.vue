<template>
    <div class="tab-pane" :id="taxonomy.name">

        <draggable v-model="taxonomy.display_columns" v-bind="dragOptions" @start="drag = true" @end="drag = false">

            <div ref="accordion" class="admin-column-accordion" :class="column.forceOpen && 'admin-column-accordion-force--open admin-column-accordion--open'" v-for="(column, colIndex) in taxonomy.display_columns" :key="column.name + colIndex">

                <div class="accordion-title p-4 pr-6 mr-6">

                    <svg class="drag-icon is-pulled-left is-clickable mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" fill="#4E4B66" fill-opacity="0.72" />
                        <path d="M12 7C13.1046 7 14 6.10457 14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5C10 6.10457 10.8954 7 12 7Z" fill="#4E4B66" fill-opacity="0.72" />
                        <path d="M12 21C13.1046 21 14 20.1046 14 19C14 17.8954 13.1046 17 12 17C10.8954 17 10 17.8954 10 19C10 20.1046 10.8954 21 12 21Z" fill="#4E4B66" fill-opacity="0.72" />
                        <path d="M5 14C6.10457 14 7 13.1046 7 12C7 10.8954 6.10457 10 5 10C3.89543 10 3 10.8954 3 12C3 13.1046 3.89543 14 5 14Z" fill="#4E4B66" fill-opacity="0.72" />
                        <path d="M5 7C6.10457 7 7 6.10457 7 5C7 3.89543 6.10457 3 5 3C3.89543 3 3 3.89543 3 5C3 6.10457 3.89543 7 5 7Z" fill="#4E4B66" fill-opacity="0.72" />
                        <path d="M5 21C6.10457 21 7 20.1046 7 19C7 17.8954 6.10457 17 5 17C3.89543 17 3 17.8954 3 19C3 20.1046 3.89543 21 5 21Z" fill="#4E4B66" fill-opacity="0.72" />
                        <path d="M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14Z" fill="#4E4B66" fill-opacity="0.72" />
                        <path d="M19 7C20.1046 7 21 6.10457 21 5C21 3.89543 20.1046 3 19 3C17.8954 3 17 3.89543 17 5C17 6.10457 17.8954 7 19 7Z" fill="#4E4B66" fill-opacity="0.72" />
                        <path d="M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C17.8954 17 17 17.8954 17 19C17 20.1046 17.8954 21 19 21Z" fill="#4E4B66" fill-opacity="0.72" />
                    </svg>

                    <div class="accordion-type-title">
                        <span class="admin-column-name" v-html="column.label"></span>
                        <div class="accordion-actions">
                            <a href="#" class="edit-button" @click.prevent="toggleAccordion( $event, column )">Edit</a>
                            <a href="#" class="remove-button" @click.prevent="removeColumn">Remove</a>
                        </div>
                        <span class="accordion-type is-pulled-right">{{ taxonomy.title }}</span>
                    </div>

                    <div class="accordion-helper">
                        <button class="helper-button accordion-clone" @click="cloneColumn(column)"><i class="ti-layers"></i></button>
                        <button class="helper-button accordion-remove" @click="removeColumn"><i class="ti-close"></i></button>
                        <button class="helper-button accordion-toggler"><i class="ti-angle-down"></i></button>
                    </div>

                </div>

                <div class="accordion-opener" @click="toggleAccordion( $event, column )"></div>

                <div class="accordion-body">

                    <template v-for="(field, key) in taxonomy.fields">

                        <div class="inner-content content-type" :key="key" v-if="column.fields.includes(field.id)">
                            <div class="columns">

                                <div class="column is-4">
                                    <label :for="`content-${colIndex}-${column.name}-${field.id}`">{{ field.title }}</label>
                                </div>

                                <div class="column" v-if="field.type == 'select'">
                                    <select :name="`content-${colIndex}-${column.name}-${field.id}`" class="select-type" :placeholder="field.placeholder" v-model="column.name" @focus="editing(column)" @change="changedType(column)">
                                        <!-- <optgroup label="Default"></optgroup> -->
                                        <option v-for="(option, option_val) in field.options" :key="option_val" :value="option_val" :selected="option_val == column.name">{{option}}</option>
                                    </select>
                                </div>

                                <div class="column" v-if="field.type == 'text'">
                                    <input :name="`content-${colIndex}-${column.name}-${field.id}`" type="text" :placeholder="field.placeholder" v-model="column.label">
                                </div>

                                <div class="column" v-if="field.type == 'slider'">

                                    <div class="range-slider-wrapper">
                                        <input type="text" class="range-value" :value="formatedWidthValue(column.width.value)" readonly>
                                        <range-slider class="slider" v-model="column.width.value" :min="0" :max="getWidthMax(column.width.unit)"></range-slider>
                                    </div>

                                    <div class="unit-labels">
                                        <label class="range-width-unit">
                                            <input :name="`content-${colIndex}-${column.name}-${field.id}`" @change="onSliderUnitChange(column)" class="range-width-unit-%" type="radio"  value="%" v-model="column.width.unit" :checked="column.width.unit == '%' ">%
                                        </label>
                                        <label class="range-width-unit">
                                            <input :name="`content-${colIndex}-${column.name}-${field.id}`" @change="onSliderUnitChange(column)" class="range-width-unit-px" type="radio" value="px" v-model="column.width.unit" :checked="column.width.unit == 'px' ">px
                                        </label>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </template>

                </div>

            </div>

        </draggable>

        <div class="columns is-desktop is-justify-content-flex-end">
            <button class="wp-adminify-add-button is-clickable is-pulled-right" @click="addNewColumn">Add new</button>
        </div>

        <div class="admin-column--pro-guard" v-if="!isTaxPro()" v-html="proNotice()"></div>

    </div>
</template>

<script>

import RangeSlider from 'vue-range-slider'
import draggable from 'vuedraggable'
import 'vue-range-slider/dist/vue-range-slider.css'

export default {
    
    data: () => ({
        taxonomy: {},
        current: null,
        current_column: {},
        drag: false
    }),

    components: {
        RangeSlider,
        draggable
    },

    mounted() {
        this.current = this.$route.params.taxonomy;
        this.taxonomy = this.$store.getters.taxonomy_by_name( this.current );
    },

    computed: {
        
        dragOptions() {
            return {
                animation: 150,
                group: "description",
                disabled: ! this.isTaxPro(),
                ghostClass: "ghost"
            };
        },

        fieldTypeKeys() {
            return Object.keys( this.taxonomy.fields.find( field => field.id == 'type' ).options );
        },

        displayColumnKeys() {
            return this.taxonomy.display_columns.map( column => column.name );
        }

    },

    methods: {

        isTaxPro() {
            if ( this.isPro() ) return true;
            if ( ! this.taxonomy.is_pro ) return true;
            return false;
        },

        editing( column ) {
            if ( ! this.isTaxPro() ) return;
            this.current_column = this.nonReactive( column );
        },

        changedType( column ) {

            if ( ! this.isTaxPro() ) return;

            let keys = this.displayColumnKeys.filter( field_key => field_key == column.name );

            if ( keys.length > 1 ) {
                
                let label = jQuery( this.taxonomy.columns[column.name] ).text(); // fix for HTML value
                if ( ! label ) label = this.taxonomy.columns[column.name];

                if ( this.current_column.name ) column.name = this.current_column.name;

                this.showError({
                    title: `Can't change the column!`,
                    content: `${label} is already in use, you can't use it twice`
                });

            }
        },

        onSliderUnitChange( column ) {
            if ( ! this.isTaxPro() ) return;
            let max = this.getWidthMax( column.width.unit );
            if ( column.width.value > max ) column.width.value = max;
        },

        formatedWidthValue( width ) {
            if ( width == 0 ) return 'auto';
            return width;
        },

        getWidthMax( unit ) {
            if ( unit == '%' ) return 100;
            return 1000;
        },

        toggleAccordion( event, column ) {

            if ( ! this.isTaxPro() ) return;

            let $accordion = jQuery( event.target ).closest('.admin-column-accordion').toggleClass('admin-column-accordion--open');
            let $body = $accordion.find('.accordion-body');

            if ( $accordion.hasClass('admin-column-accordion--open') ) {
                $body.slideDown(200, () => {
                    column.forceOpen = true;
                });
            } else {
                $body.slideUp(200, () => {
                    $accordion.removeClass('admin-column-accordion-force--open');
                    delete column.forceOpen;
                });
            }

        },

        removeColumn( event ) {

            if ( ! this.isTaxPro() ) return;

            let index = jQuery( event.target ).closest('.admin-column-accordion').index();

            if ( index > -1 ) this.taxonomy.display_columns.splice( index, 1 );

        },

        hasAddedAllFields() {
            return this.fieldTypeKeys.every( field_key => this.displayColumnKeys.includes(field_key) );
        },

        getNonAddedFieldKeys() {
            return this.fieldTypeKeys.filter( field_key => ! this.displayColumnKeys.includes(field_key) );
        },

        getNewDefaults( columnKey ) {

            if ( ! this.isTaxPro() ) return;

            return {
                forceOpen: true,
                fields: ['type', 'label', 'width'],
                label: this.taxonomy.columns[columnKey],
                name: columnKey,
                width: {
                    unit: '%',
                    value: 'auto'
                }
            }

        },
        
        showError( data ) {
            Window.Events.$emit( 'AdminColumnsError', data );
        },

        addNewColumn() {

            if ( ! this.isTaxPro() ) return;
            
            if ( this.hasAddedAllFields() ) return this.showError({
                title: `Can't add new column!`,
                content: `All columns are added, you can't add new column`
            });

            let columnKey = this.getNonAddedFieldKeys()[0];
            let newColumn = this.getNewDefaults( columnKey );
            this.taxonomy.display_columns.push( newColumn );
        },

        cloneColumn( column ) {

            if ( ! this.isTaxPro() ) return;
            
            if ( this.hasAddedAllFields() ) return this.showError({
                title: `Can't clone column!`,
                content: `All columns are added, you can't add new column`
            });
            
            let columnKey = this.getNonAddedFieldKeys()[0];
            let newColumn = this.getNewDefaults( columnKey );
            newColumn.width = this.nonReactive( column.width );
            this.taxonomy.display_columns.push( newColumn );
        }

    }

}
</script>

<style>
    .ghost {
        opacity: 0.5;
        background: #a7a7aa;
    }
</style>