<template>
    <div class="list-group-item">
        <div class="d-flex justify-content-between align-items-center">
            <div class="filter-card-info cursor-pointer" @click="$emit('edit', filter)">
                <div class="d-flex align-items-center" style="gap:0.5rem;">
                    <div class="d-flex align-items-center" style="gap:5px;">
                        <div class="font-weight-bold">{{ filter.title }}</div>
                        <div class="small text-muted">({{ filter.keywords?.length ?? 0 }})</div>
                    </div>
                    <div class="text-muted">·</div>
                    <div v-if="filter.expires_at" class="small text-muted">
                        {{ $t('settings.filters.expires')  }}: {{ formatExpiry(filter.expires_at) }}
                    </div>
                    <div v-else class="small text-muted">
                        {{ $t('settings.filters.never_expires')  }}
                    </div>
                </div>
                <div>
                    <div class="text-muted small">{{ $t('compose.filters.actionOn', { action: formatAction(filter.filter_action), contexts: formatContexts() }) }}</div>
                </div>
            </div>

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" v-model="checked" @click="$emit('delete', filter.id)">
                <label class="custom-control-label" for="customSwitch1"></label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FilterCard',
        props: {
            filter: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                checked: true,
            }
        },
        computed: {
            actionBadgeClass() {
                const classes = {
                    'warn': 'badge-warning',
                    'hide': 'badge-danger',
                    'blur': 'badge-light'
                };
                return classes[this.filter.filter_action] || 'badge-secondary';
            }
        },
        watch: {
            checked: {
                deep: true,
                handler: function(val, old) {
                    console.log(val, old)
                    setTimeout(() => {
                        this.checked = true;
                    }, 1000);
                },
            },
        },
        methods: {
            formatContext(context) {
                const contexts = {
                    'home': this.$t('compose.filters.homeFeed'),
                    'notifications': this.$t('compose.filters.notifications'),
                    'public': this.$t('compose.filters.publicFeeds'),
                    'thread': this.$t('compose.filters.conversations'),
                    'tags': this.$t('compose.filters.hashtags'),
                    'groups': this.$t('compose.filters.groups')
                };
                return contexts[context] || context;
            },
            formatExpiry(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString(undefined, {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            },
            formatContexts() {
                if (!this.filter.context?.length) return '';

                const hasHome = this.filter.context.includes('home');
                const hasPublic = this.filter.context.includes('public');

                if (hasHome && hasPublic) {
                    const otherContexts = this.filter.context
                    .filter(c => c !== 'home' && c !== 'public')
                    .map(c => this.formatContext(c));

                    return [this.$t('compose.filters.feeds'), ...otherContexts].join(', ');
                } else {
                    return this.filter.context.map(c => this.formatContext(c)).join(', ');
                }
            },
            formatAction(action) {
                const actions = {
                    'warn': this.$t('compose.filters.warning'),
                    'hide': this.$t('compose.filters.hidden'),
                    'block': this.$t('compose.filters.blocked')
                };
                return actions[action] || action.charAt(0).toUpperCase() + action.slice(1);
            },
            renderActionDescription() {
                console.log(this.filter)
                if(this.filter.filter_action === 'warn') {
                    return `<div><i class="fas fa-exclamation-triangle text-warning mr-1"></i> <span class="font-weight-light text-muted">${this.$t('compose.filters.warn')}</span></div>`
                }
                else if(this.filter.filter_action === 'blur') {
                    return `<div><i class="fas fa-tint mr-1 text-info"></i> <span class="font-weight-light text-muted">${this.$t('compose.filters.blur')}</span></div>`
                }
                else if(this.filter.filter_action === 'hide') {
                    return `<div><i class="fas fa-eye-slash mr-1 text-danger"></i> <span class="font-weight-light text-muted">${this.$t('compose.filters.hide')}</span></div>`
                }
            }
        }
    }
</script>

<style scoped>
.filter-card {
    overflow: hidden;
    border-radius: 20px;
}

.filter-card:hover {
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1) !important;
}

.badge-pill {
    padding: 0.35em 0.7em;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}
</style>
