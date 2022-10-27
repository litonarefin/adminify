<template>

    <div class="data-audit-group data-audit-group--diagnostics">

        <div :id="itemIndex" class="data-audit data-audit--binary mt-4" :class="item.scoreDisplayMode == 'informative' ? 'data-metric--informative' : getScoreStatusClass( item.score )" v-for="(item, itemIndex) in data" :key="itemIndex">
            <details class="data-expandable-details">

                <summary>
                    <div class="data-audit__header data-expandable-details__summary summary-wrapper">
                        <span class="data-audit__score-icon"></span>
                        <span class="data-audit__title-and-text summary-top mb-1">
                            <span class="data-audit__title" v-html="item.title"></span>
                            <span class="data-audit__display-text" v-html="item.displayValue"></span>
                        </span>
                    </div>
                </summary>

                <div class="data-audit__description mt-4">

                    <span v-html="markdownToLink( item.description )"></span>
                    <span class="data-audit__adorn-list" v-html="getAcronym(itemIndex)"></span>
                    
                    <template v-if="item.details && item.details.type == 'filmstrip'">
                        <ul v-if="item.details.items" :class="['filmstrip-list', itemIndex]">
                            <li v-for="(strip, strip_index) in item.details.items" :key="`${item.details.type}-${strip_index}`">
                                <img :src="strip.data" alt="">
                            </li>
                        </ul>
                    </template>
                    
                    <template v-if="item.details && item.details.type == 'criticalrequestchain'">
                        <ul v-if="item.details.chains" :class="['chain-list', itemIndex]" v-html="getChainTemplate( item.details.chains, itemIndex )"></ul>
                    </template>
                    
                    <template v-if="item.details && ['opportunity', 'table'].includes( item.details.type )">
                        <table v-if="item.details.items && item.details.items.length" class="data-table data-details">
                            
                            <thead>
                                <tr>
                                    <th :class="'data-table-column--' + getType(tdh)" v-for="(tdh, thdIndex) in item.details.headings" :key="thdIndex">
                                        <div class="data-text">{{ getTabletLabel(tdh) }}</div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <template v-for="(tr, trIndex) in item.details.items">

                                    <!-- Item -->
                                    <tr :class="'data-row--' + ( trIndex % 2 ? 'odd' : 'even' )" :key="`${tr.id}-${trIndex}`">
                                        
                                        <template v-for="(trd, trdIndex) in item.details.headings">

                                            <td v-if="getKey(trd)"
                                                :class="'data-table-column--' + getType(trd)"
                                                :key="`${tr.id}-${trIndex}-${trdIndex}`"
                                                v-html="getData( tr[ getKey(trd) ], getType(trd) )">
                                            </td>

                                            <td v-else class="data-table-column--empty" :key="`${tr.id}-${trIndex}-${trdIndex}`"></td>

                                        </template>

                                    </tr>

                                    <!-- SubItems -->
                                    <template v-if="tr.subItems && tr.subItems.items.length">
                                        <tr v-for="(trs, trsIndex) in tr.subItems.items"
                                            :class="'data-row--subitem data-row--' + ( trIndex % 2 ? 'odd' : 'even' )"
                                            :key="`${tr.id}-${trIndex}-${trsIndex}`">

                                            <template v-for="(trd, trdIndex) in item.details.headings">

                                                <td v-if="getKey(trd, true)"
                                                    :class="'data-table-column--' + getType(trd, true)"
                                                    :key="`${tr.id}-${trIndex}-${trsIndex}-${trdIndex}`"
                                                    v-html="getData( trs[ getKey(trd, true) ], getType(trd, true) )">
                                                </td>

                                                <td v-else class="data-table-column--empty" :key="`${tr.id}-${trIndex}-${trsIndex}-${trdIndex}`"></td>

                                            </template>

                                        </tr>
                                    </template>

                                </template>
                            </tbody>

                        </table>
                    </template>

                </div>

            </details>
        </div>

    </div>
</template>

<script>
export default {

    data: () => ({
    }),

    props: {

        data: {
            type: Object,
            required: true,
            default() {
                return {};
            }
        }

    },

    computed: {

        parent_data() {
            return this.$parent.activeData
        },

        auditRefs() {
            return this.parent_data.lighthouseResult.categories.performance.auditRefs;
        },

    },

    mounted() {

    },

    methods: {

        getTabletLabel( data ) {
            return data.text || data.label;
        },

        escapeHtml( text ) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };

            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        },

        getKey( data, isSub = false ) {

            if ( isSub && 'subItemsHeading' in data && 'key' in data.subItemsHeading && data.subItemsHeading.key ) {
                return data.subItemsHeading.key;
            }

            if ( 'key' in data ) return data.key;

            return null;

        },

        getType( data, isSub = false ) {

            let data_type;

            if ( isSub && 'subItemsHeading' in data ) {

                if ( 'itemType' in data.subItemsHeading ) {
                    data_type = data.subItemsHeading.itemType;
                } else if ( 'valueType' in data.subItemsHeading ) {
                    data_type = data.subItemsHeading.valueType;
                }

                if ( data_type ) return data_type;

            }

            if ( 'itemType' in data ) {
                data_type = data.itemType;
            } else if ( 'valueType' in data ) {
                data_type = data.valueType;
            }

            return data_type;
        
        },

        itemType_node( data ) {
            let label = ('nodeLabel') in data ? data.nodeLabel : data.text;
            return `<div class="single-node"><div class="node-level">${label}</div><div class="node-snippet">${this.escapeHtml(data.snippet)}</div></div>`;
        },

        itemType_numeric( data ) {
            return Math.round((data + Number.EPSILON) * 1000) / 1000;
        },

        is_valid_url(str) {
            var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
            return !!pattern.test(str);
        },

        itemType_url( url ) {

            if ( ! this.is_valid_url(url) ) return url;

            let URL_Obj         = new URL( url );
            let origin          = URL_Obj.origin;
            let pathname        = URL_Obj.pathname == '/' ? '' : URL_Obj.pathname;
            let isRoot          = ! pathname;
            let query           = URL_Obj.search;
            let hasQuery        = !! query;
            let hostname        = URL_Obj.hostname.replace( 'www.', '' );
            let short_url       = origin;
            let isFileURL       = this.urlIsFile( pathname );
            let displayHost     = true;

            if ( ! isRoot ) {

                let parts = pathname.split('/').filter( path => path );
                let hasGap = false;
    
                if ( parts.length > 2 ) {
                    hasGap = true;
                    parts = parts.slice( Math.max(parts.length - 2, 0) );
                }
    
                if ( isFileURL ) {
                    
                    if ( parts.length > 1 ) {
    
                        let dirs = parts[0];
                        let file = parts[1];
                        let dot_index = file.indexOf('.');
    
                        if ( dot_index > 9 ) {
                            file = file.substring( 0, 9 ) + '...' + file.substring( dot_index );
                            parts = [dirs, file];
                        }
    
                    }
    
                }
    
                if ( parts.length ) pathname = parts.join('/');
                short_url = ( hasGap ? '...' : '/' ) + pathname;

            }

            if ( ! isRoot && ! isFileURL && ! hasQuery ) short_url += '/';

            if ( hasQuery ) {
                if ( ! isRoot ) {
                    if ( query.length > 20 ) query = query.substr( 0, 20 ) + '...';
                    short_url += '/' + query;
                }
            }

            if ( short_url.indexOf('...') < 0 && short_url.indexOf(hostname) > 0 && (new URL(short_url)).host == hostname ) displayHost = false;

            let template = `<span class="chain-url" title="${url}" data-url="${url}"><a rel="noopener" target="_blank" href="${url}" class="chain-link">${short_url}</a>`;
                if ( displayHost ) template += `<span class="chain-host">(${hostname})</span>`;
            template += `</span>`;

            return template;

        },

        itemType_ms( ms ) {

            let second = 1000;
            let minute = 60 * second;
            let hour = 60 * minute;
            let day = 24 * hour;
            let year = 365 * day;

            if ( ms >= year ) return Math.round(ms/year) + ' y';
            if ( ms >= day ) return Math.round(ms/day) + ' d';
            if ( ms >= hour ) return Math.round(ms/hour) + ' h';
            if ( ms >= minute ) return Math.round(ms/minute) + ' m';
            if ( ms >= second ) return Math.round(ms/second) + ' s';
            
            return Math.floor(ms) + ' ms';

        },

        itemType_text( data ) {
            return data;
        },

        itemType_thumbnail( data ) {
            return `<img class="lh-thumbnail" src="${data}" title="${data}" alt="">`
        },

        itemType_timespanMs( data ) {
            return data;
        },

        itemType_bytes( data ) {
            return this.byteTokib( data, 0 );
        },

        itemType_link( data ) {
            return `<a href="${data.url}" rel="noopener" target="_blank" class="lh-link">${data.text}</a>`
        },

        itemType_source_location( data ) {
            return this.itemType_url( data.url );
        },

        itemType_code( data ) {
            return `<pre class="lh-code">${data}</pre>`;
        },

        getData( data, itemType = 'text' ) {
            if ( data == undefined ) return '';
            itemType = itemType.replace( '-', '_' );
            let typeMethod = 'itemType_' + itemType;
            return this[typeMethod]( data );
        },

        getChainTemplate( data, type ) {

            let html = '';

            for ( let key in data ) {

                let item = data[key];
                let hasChild = item.children && Object.keys(item.children).length;

                html += `<li class="${hasChild ? 'has-child' : ''}">
                    ${ this.getChainSingleTemplate( item.request, type ) }
                    ${ hasChild ? '<ul class="chain-child">' + this.getChainTemplate( item.children, type ) + '</ul>' : '' }
                </li>`;

            }

            return html;

        },

        getChainSingleTemplate( data, type ) {
            type = type.replaceAll('-', '_');
            return this[ 'getChildTemplate_' + type ]( data );
        },

        get_i18n( key ) {
            return this.parent_data.lighthouseResult.i18n.rendererFormattedStrings[key];
        },

        getHostName( url ) {
            if ( ! this.is_valid_url(url) ) return url;
            let domain = (new URL(url));
            return domain.hostname.replace('www.','');
        },

        getUrlExtension( url ) {
            let extStart = url.indexOf('.',url.lastIndexOf('/')+1);
            if ( extStart == -1 ) return '';
            let ext = url.substr(extStart+1),
            extEnd = ext.search(/$|[?#]/);
            return ext.substring (0,extEnd);
        },

        urlIsFile( url ) {
            return !! this.getUrlExtension( url );
        },

        getChildTemplate_critical_request_chains( data ) {
            
            return `<div class="chain-single">
                ${ this.itemType_url( data.url ) }
                <strong class="chain-duration"> - ${this.byteTokib(data.transferSize)}</strong>
            </div>`

        },

        byteTokib( bytes, fixed = 2 ) {
            return (bytes / 1024).toFixed( fixed ) + ' KiB';
        },

        getChain( data ) {

            let html = '';

            for ( let key in data ) {

                let item = data[key];
                let hasChild = item.children && Object.keys(item.children).length;

                html += `<li class="${hasChild ? 'has-child' : ''}">
                    ${ this.itemHtml( item.request ) }
                    ${ hasChild ? '<ul class="chain-child">' + this.getChain( item.children ) + '</ul>' : '' }
                </li>`;

            }

            return html;

        },

        getAcronym( key ) {
            return this.auditRefs
                .filter( audit => audit.id == key || ( audit.relevantAudits && audit.relevantAudits.includes(key)) )
                .filter( audit => audit.acronym )
                .map( audit => `<span class="data-audit__adorn" title="Relevant to ${ this.parent_data.lighthouseResult.audits[audit.id].title }">${ audit.acronym }</span>`)
                .join('');
        }

    }

}
</script>


<style>

    .node-snippet {
        color: #2f66ff;
    }

    .filmstrip-list.screenshot-thumbnails {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .filmstrip-list.screenshot-thumbnails li {
        text-align: right;
        position: relative;
    }
    .filmstrip-list.screenshot-thumbnails img {
        border: 1px solid #ebebeb;
        max-height: 100px;
        max-width: 60px;
    }

    .data-table.data-details {
        border-spacing: 0;
        width: 100%;
    }

    .data-table.data-details th,
    .data-table.data-details td {
        padding: 8px 6px;
    }

    .data-table.data-details tbody tr.data-row--odd td {
        background: #f9f9fb;
    }

    .data-table.data-details .data-row--subitem td:first-child {
        padding-left: 20px;
    }

    .data-table.data-details .data-table-column--thumbnail {
        width: 48px;
        padding: 0;
        line-height: 0;
    }

    .data-table-column--thumbnail img {
        object-fit: cover;
        width: 48px;
        height: 48px;
    }

    .chain-list {
        font-size: 14px;
    }

    .chain-list li {
        margin-bottom: 14px;
    }
    
    .chain-child {
        margin-top: 14px;
        padding-left: 30px;
    }

</style>