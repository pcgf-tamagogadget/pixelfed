<template>
    <div class="modal-stack">
        <b-modal ref="ctxModal" id="ctx-modal" hide-header hide-footer centered rounded size="sm"
            body-class="list-group-flush p-0 rounded">
            <div class="list-group text-center">
                <div v-if="status.visibility !== 'archived'" class="list-group-item rounded cursor-pointer"
                    @click="ctxMenuGoToPost()">{{ $t('menu.viewPost') }}</div>
                <div v-if="status.visibility !== 'archived'" class="list-group-item rounded cursor-pointer"
                    @click="ctxMenuGoToProfile()">{{ $t('menu.viewProfile') }}</div>
                <div class="list-group-item rounded cursor-pointer" @click="ctxMenuCopyLink()">{{ $t('common.copyLink') }}</div> -->
                <div v-if="status.visibility !== 'archived'" class="list-group-item rounded cursor-pointer"
                    @click="ctxMenuShare()">{{ $t('common.share') }}</div>
                <div v-if="status && profile && profile.is_admin == true && status.visibility !== 'archived'"
                    class="list-group-item rounded cursor-pointer" @click="ctxModMenuShow()">{{ $t('menu.moderationTools') }}</div>
                <div v-if="status && status.account.id != profile.id"
                    class="list-group-item rounded cursor-pointer text-danger" @click="ctxMenuReportPost()">{{ $t('menu.report') }}</div>
                <div v-if="status && profile.id == status.account.id && status.visibility !== 'archived'"
                    class="list-group-item rounded cursor-pointer text-danger" @click="archivePost(status)">{{ $t('menu.archive') }}
                </div>
                <div v-if="status && profile.id == status.account.id && status.visibility == 'archived'"
                    class="list-group-item rounded cursor-pointer text-danger" @click="unarchivePost(status)">{{ $t('menu.unarchive') }}
                </div>
                <div v-if="status && profile.id == status.account.id && status.visibility !== 'archived'"
                    class="list-group-item menu-option text-danger" @click="editPost(status)">
                    {{ $t('classic.contextMenu.edit') }}
                </div>
                <div v-if="status && (profile.is_admin || profile.id == status.account.id) && status.visibility !== 'archived'"
                    class="list-group-item rounded cursor-pointer text-danger" @click="deletePost(status)">{{ $t('common.delete') }}</div>
                <div class="list-group-item rounded cursor-pointer text-lighter" @click="closeCtxMenu()">{{ $t('common.cancel') }}</div>
            </div>
        </b-modal>
        <b-modal ref="ctxModModal" id="ctx-mod-modal" hide-header hide-footer centered rounded size="sm"
            body-class="list-group-flush p-0 rounded">
            <div class="list-group text-center">
                <p class="py-2 px-3 mb-0">
                <div class="text-center font-weight-bold text-danger">{{ $t('menu.moderationTools') }}</div>
                <div class="small text-center text-muted">{{ $t('menu.selectOneOption') }}</div>
                </p>
                <div class="list-group-item rounded cursor-pointer" @click="moderatePost(status, 'unlist')">{{ $t('menu.unlistFromTimelines') }}</div>
                <div v-if="status.sensitive" class="list-group-item rounded cursor-pointer"
                    @click="moderatePost(status, 'remcw')">{{ $t('menu.removeCW') }}</div>
                <div v-else class="list-group-item rounded cursor-pointer" @click="moderatePost(status, 'addcw')">{{ $t('menu.addCW') }}</div>
                <div class="list-group-item rounded cursor-pointer" @click="moderatePost(status, 'spammer')">
                    {{ $t('menu.markAsSpammer') }}<br />
                    <span class="small">{{ $t('menu.markAsSpammerText') }}</span>
                </div>
                <div class="list-group-item rounded cursor-pointer text-lighter" @click="ctxModMenuClose()">{{ $t('common.cancel') }}</div>
            </div>
        </b-modal>
        <b-modal ref="ctxModOtherModal" id="ctx-mod-other-modal" hide-header hide-footer centered rounded size="sm"
            body-class="list-group-flush p-0 rounded">
            <div class="list-group text-center">
                <p class="py-2 px-3 mb-0">
                <div class="text-center font-weight-bold text-danger">{{ $t('menu.moderationTools') }}</div>
                <div class="small text-center text-muted">{{ $t('menu.selectOneOption') }}</div>
                </p>
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="confirmModal()">{{ $t('classic.contextMenu.unlistPosts') }}</div>
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="confirmModal()">{{ $t('classic.contextMenu.moderationLog') }}</div>
                <div class="list-group-item rounded cursor-pointer text-lighter" @click="ctxModOtherMenuClose()">{{ $t('common.cancel') }}
                </div>
            </div>
        </b-modal>
        <b-modal ref="ctxShareModal" id="ctx-share-modal" :title="$t('common.share')" hide-footer hide-header centered rounded
            size="sm" body-class="list-group-flush p-0 rounded text-center">
            <div class="list-group-item rounded cursor-pointer" @click="shareStatus(status, $event)">{{ status.reblogged
                ? $t('classic.contextMenu.unshareToFollowers') : $t('classic.contextMenu.shareToFollowers') }}</div>
            <div class="list-group-item rounded cursor-pointer" @click="ctxMenuCopyLink()">{{ $t('common.copyLink') }}</div>
            <div v-if="status && status.local == true && !status.in_reply_to_id"
                class="list-group-item rounded cursor-pointer" @click="ctxMenuEmbed()">{{ $t('menu.embed') }}</div>
            <div class="list-group-item rounded cursor-pointer text-lighter" @click="closeCtxShareMenu()">{{ $t('common.cancel') }}</div>
        </b-modal>
        <b-modal ref="ctxEmbedModal" id="ctx-embed-modal" hide-header hide-footer centered rounded size="md"
            body-class="p-2 rounded">
            <div>
                <div class="form-group">
                    <textarea class="form-control disabled text-monospace" rows="8"
                        style="overflow-y:hidden;border: 1px solid #efefef; font-size: 12px; line-height: 18px; margin: 0 0 7px;resize:none;"
                        v-model="ctxEmbedPayload" disabled=""></textarea>
                </div>
                <div class="form-group pl-2 d-flex justify-content-center">
                    <div class="form-check mr-3">
                        <input class="form-check-input" type="checkbox" v-model="ctxEmbedShowCaption"
                            :disabled="ctxEmbedCompactMode == true">
                        <label class="form-check-label font-weight-light">
                            {{ $t('menu.showCaption') }}
                        </label>
                    </div>
                    <div class="form-check mr-3">
                        <input class="form-check-input" type="checkbox" v-model="ctxEmbedShowLikes"
                            :disabled="ctxEmbedCompactMode == true">
                        <label class="form-check-label font-weight-light">
                            {{ $t('menu.showLikes') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="ctxEmbedCompactMode">
                        <label class="form-check-label font-weight-light">
                            {{ $t('menu.compactMode') }}
                        </label>
                    </div>
                </div>
                <hr>
                <button
                    :class="copiedEmbed ? 'btn btn-primary btn-block btn-sm py-1 font-weight-bold disabed' : 'btn btn-primary btn-block btn-sm py-1 font-weight-bold'"
                    @click="ctxCopyEmbed" :disabled="copiedEmbed">{{
                        copiedEmbed ? $t('classic.contextMenu.embedCopied') : $t('classic.contextMenu.copyEmbed') }}
                </button>
                <i18n path="classic.contextMenu.embedAgree" tag="p" class="mb-0 px-2 small text-muted">
                    <template v-slot:terms><a href="/site/terms">{{ $t('site.terms') }}</a></template>
                </i18n>
            </div>
        </b-modal>
        <b-modal ref="ctxReport" id="ctx-report" hide-header hide-footer centered rounded size="sm"
            body-class="list-group-flush p-0 rounded">
            <p class="py-2 px-3 mb-0">
            <div class="text-center font-weight-bold text-danger">{{ $t('menu.report') }}</div>
            <div class="small text-center text-muted">{{ $t('menu.selectOneOption') }}</div>
            </p>
            <div class="list-group text-center">
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('spam')">{{ $t('menu.spam') }}
                </div>
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('sensitive')">
                    {{ $t('menu.sensitive') }}</div>
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('abusive')">
                    {{ $t('menu.abusive') }}</div>
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="openCtxReportOtherMenu()">
                    {{ $t('common.other') }}</div>
                <!-- <div class="list-group-item rounded cursor-pointer" @click="ctxReportMenuGoBack()">Go Back</div> -->
                <div class="list-group-item rounded cursor-pointer text-lighter" @click="ctxReportMenuGoBack()">{{ $t('common.cancel') }}
                </div>
            </div>
        </b-modal>
        <b-modal ref="ctxReportOther" id="ctx-report-other" hide-header hide-footer centered rounded size="sm"
            body-class="list-group-flush p-0 rounded">
            <p class="py-2 px-3 mb-0">
            <div class="text-center font-weight-bold text-danger">{{ $t('menu.report') }}</div>
            <div class="small text-center text-muted">{{ $t('menu.selectOneOption') }}</div>
            </p>
            <div class="list-group text-center">
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('underage')">
                    {{ $t('menu.underageAccount') }}</div>
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('copyright')">
                    {{ $t('menu.copyrightInfringement') }}</div>
                <div class="list-group-item rounded cursor-pointer font-weight-bold"
                    @click="sendReport('impersonation')">{{ $t('menu.impersonation') }}</div>
                <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('scam')">{{ $t('menu.scamOrFraud') }}</div>
                <!-- <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('terrorism')">Terrorism Related</div> -->
                <!-- <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('other')">Other or Not listed</div> -->
                <!-- <div class="list-group-item rounded cursor-pointer" @click="ctxReportOtherMenuGoBack()">Go Back</div> -->
                <div class="list-group-item rounded cursor-pointer text-lighter" @click="ctxReportOtherMenuGoBack()">
                    {{ $t('common.cancel') }}</div>
            </div>
        </b-modal>
        <b-modal ref="ctxConfirm" id="ctx-confirm" hide-header hide-footer centered rounded size="sm"
            body-class="list-group-flush p-0 rounded">
            <div class="d-flex align-items-center justify-content-center py-3">
                <div>{{ this.confirmModalTitle }}</div>
            </div>
            <div class="d-flex border-top btn-group btn-group-block rounded-0" role="group">
                <button type="button"
                    class="btn btn-outline-lighter border-left-0 border-top-0 border-bottom-0 border-right py-2"
                    style="color: rgb(0,122,255) !important;" @click.prevent="confirmModalCancel()">{{ $t('common.cancel') }}</button>
                <button type="button" class="btn btn-outline-lighter border-0" style="color: rgb(0,122,255) !important;"
                    @click.prevent="confirmModalConfirm()">{{ $t('classic.contextMenu.confirm') }}</button>
            </div>
        </b-modal>
    </div>
</template>

<script type="text/javascript">
export default {
    props: [
        'status',
        'profile'
    ],

    data() {
        return {
            ctxMenuStatus: false,
            ctxMenuRelationship: false,
            ctxEmbedPayload: false,
            copiedEmbed: false,
            replySending: false,
            ctxEmbedShowCaption: true,
            ctxEmbedShowLikes: false,
            ctxEmbedCompactMode: false,
            confirmModalTitle: this.$t('classic.contextMenu.areYouSure'),
            confirmModalIdentifer: null,
            confirmModalType: false,
        }
    },

    watch: {
        ctxEmbedShowCaption: function (n, o) {
            if (n == true) {
                this.ctxEmbedCompactMode = false;
            }
            let mode = this.ctxEmbedCompactMode ? 'compact' : 'full';
            this.ctxEmbedPayload = window.App.util.embed.post(this.ctxMenuStatus.url, this.ctxEmbedShowCaption, this.ctxEmbedShowLikes, mode);
        },
        ctxEmbedShowLikes: function (n, o) {
            if (n == true) {
                this.ctxEmbedCompactMode = false;
            }
            let mode = this.ctxEmbedCompactMode ? 'compact' : 'full';
            this.ctxEmbedPayload = window.App.util.embed.post(this.ctxMenuStatus.url, this.ctxEmbedShowCaption, this.ctxEmbedShowLikes, mode);
        },
        ctxEmbedCompactMode: function (n, o) {
            if (n == true) {
                this.ctxEmbedShowCaption = false;
                this.ctxEmbedShowLikes = false;
            }
            let mode = this.ctxEmbedCompactMode ? 'compact' : 'full';
            this.ctxEmbedPayload = window.App.util.embed.post(this.ctxMenuStatus.url, this.ctxEmbedShowCaption, this.ctxEmbedShowLikes, mode);
        }
    },

    methods: {
        open() {
            this.ctxMenu();
        },

        ctxMenu() {
            this.ctxMenuStatus = this.status;
            this.ctxEmbedPayload = window.App.util.embed.post(this.status.url);
            if (this.status.account.id == this.profile.id) {
                this.ctxMenuRelationship = false;
                this.$refs.ctxModal.show();
            } else {
                axios.get('/api/pixelfed/v1/accounts/relationships', {
                    params: {
                        'id[]': this.status.account.id
                    }
                }).then(res => {
                    this.ctxMenuRelationship = res.data[0];
                    this.$refs.ctxModal.show();
                });
            }
        },

        closeCtxMenu() {
            this.copiedEmbed = false;
            this.ctxMenuStatus = false;
            this.ctxMenuRelationship = false;
            this.$refs.ctxModal.hide();
            this.$refs.ctxReport.hide();
            this.$refs.ctxReportOther.hide();
            this.closeModals();
        },

        ctxMenuCopyLink() {
            let status = this.ctxMenuStatus;
            navigator.clipboard.writeText(status.url);
            this.closeModals();
            return;
        },

        ctxMenuGoToPost() {
            let status = this.ctxMenuStatus;
            window.location.href = this.statusUrl(status);
            this.closeCtxMenu();
            return;
        },

        ctxMenuGoToProfile() {
            let status = this.ctxMenuStatus;
            window.location.href = this.profileUrl(status);
            this.closeCtxMenu();
            return;
        },

        ctxMenuReportPost() {
            this.$refs.ctxModal.hide();
            this.$refs.ctxReport.show();
            return;
        },

        ctxMenuEmbed() {
            this.closeModals();
            this.$refs.ctxEmbedModal.show();
        },

        ctxMenuShare() {
            this.$refs.ctxModal.hide();
            this.$refs.ctxShareModal.show();
        },

        closeCtxShareMenu() {
            this.$refs.ctxShareModal.hide();
            this.$refs.ctxModal.show();
        },

        ctxCopyEmbed() {
            navigator.clipboard.writeText(this.ctxEmbedPayload);
            this.ctxEmbedShowCaption = true;
            this.ctxEmbedShowLikes = false;
            this.ctxEmbedCompactMode = false;
            this.$refs.ctxEmbedModal.hide();
        },

        ctxModMenuShow() {
            this.$refs.ctxModal.hide();
            this.$refs.ctxModModal.show();
        },

        ctxModOtherMenuShow() {
            this.$refs.ctxModal.hide();
            this.$refs.ctxModModal.hide();
            this.$refs.ctxModOtherModal.show();
        },

        ctxModMenu() {
            this.$refs.ctxModal.hide();
        },

        ctxModMenuClose() {
            this.closeModals();
        },

        ctxModOtherMenuClose() {
            this.closeModals();
            this.$refs.ctxModModal.show();
        },

        formatCount(count) {
            return App.util.format.count(count);
        },

        openCtxReportOtherMenu() {
            let s = this.ctxMenuStatus;
            this.closeCtxMenu();
            this.ctxMenuStatus = s;
            this.$refs.ctxReportOther.show();
        },

        ctxReportMenuGoBack() {
            this.$refs.ctxReportOther.hide();
            this.$refs.ctxReport.hide();
            this.$refs.ctxModal.show();
        },

        ctxReportOtherMenuGoBack() {
            this.$refs.ctxReportOther.hide();
            this.$refs.ctxModal.hide();
            this.$refs.ctxReport.show();
        },

        sendReport(type) {
            let id = this.ctxMenuStatus.id;

            swal({
                'title': this.$t('menu.confirmReport'),
                'text': this.$t('menu.confirmReportText'),
                'icon': 'warning',
                'buttons': true,
                'dangerMode': true
            }).then((res) => {
                if (res) {
                    axios.post('/i/report/', {
                        'report': type,
                        'type': 'post',
                        'id': id,
                    }).then(res => {
                        this.closeCtxMenu();
                        swal(this.$t('menu.reportSent'), this.$t('menu.reportSentText'), 'success');
                    }).catch(err => {
                        swal(this.$t('common.oops'), this.$t('menu.reportSentError'), 'error');
                    })
                } else {
                    this.closeCtxMenu();
                }
            });
        },

        closeModals() {
            this.$refs.ctxModal.hide();
            this.$refs.ctxModModal.hide();
            this.$refs.ctxModOtherModal.hide();
            this.$refs.ctxShareModal.hide();
            this.$refs.ctxEmbedModal.hide();
            this.$refs.ctxReport.hide();
            this.$refs.ctxReportOther.hide();
            this.$refs.ctxConfirm.hide();
        },

        openCtxStatusModal() {
            this.closeModals();
            this.$refs.ctxStatusModal.show();
        },

        openConfirmModal() {
            this.closeModals();
            this.$refs.ctxConfirm.show();
        },

        closeConfirmModal() {
            this.closeModals();
            this.confirmModalTitle = this.$t('classic.contextMenu.areYouSure');
            this.confirmModalType = false;
            this.confirmModalIdentifer = null;
        },

        confirmModalConfirm() {
            switch (this.confirmModalType) {
                case 'post.delete':
                    axios.post('/i/delete', {
                        type: 'status',
                        item: this.confirmModalIdentifer
                    }).then(res => {
                        this.feed = this.feed.filter(s => {
                            return s.id != this.confirmModalIdentifer;
                        });
                        this.closeConfirmModal();
                    }).catch(err => {
                        this.closeConfirmModal();
                        swal(this.$t('common.error'), this.$t('classic.contextMenu.errorTryLaterDot'), 'error');
                    });
                    break;
            }

            this.closeConfirmModal();
        },

        confirmModalCancel() {
            this.closeConfirmModal();
        },

        moderatePost(status, action, $event) {
            let username = status.account.username;
            let pid = status.id;
            let msg = '';
            let self = this;
            switch (action) {
                case 'addcw':
                    msg = this.$t('menu.modAddCWConfirm');
                    swal({
                        title: this.$t('classic.contextMenu.confirm'),
                        text: msg,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true
                    }).then(res => {
                        if (res) {
                            axios.post('/api/v2/moderator/action', {
                                action: action,
                                item_id: status.id,
                                item_type: 'status'
                            }).then(res => {
                                swal(this.$t('common.success'), this.$t('menu.modCWSuccess'), 'success');
                                status.sensitive = true;
                                self.closeModals();
                                self.ctxModMenuClose();
                            }).catch(err => {
                                swal(
                                    self.$t('common.error'),
                                    self.$t('classic.contextMenu.errorTryLater'),
                                    'error'
                                );
                                self.closeModals();
                                self.ctxModMenuClose();
                            });
                        }
                    });
                    break;

                case 'remcw':
                    msg = this.$t('menu.modRemoveCWConfirm');
                    swal({
                        title: this.$t('classic.contextMenu.confirm'),
                        text: msg,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true
                    }).then(res => {
                        if (res) {
                            axios.post('/api/v2/moderator/action', {
                                action: action,
                                item_id: status.id,
                                item_type: 'status'
                            }).then(res => {
                                swal(this.$t('common.success'), this.$t('menu.modCWSuccess'), 'success');
                                status.sensitive = false;
                                self.closeModals();
                                self.ctxModMenuClose();
                            }).catch(err => {
                                swal(
                                    self.$t('common.error'),
                                    self.$t('classic.contextMenu.errorTryLater'),
                                    'error'
                                );
                                self.closeModals();
                                self.ctxModMenuClose();
                            });
                        }
                    });
                    break;

                case 'unlist':
                    msg = this.$t('menu.modUnlistConfirm');
                    swal({
                        title: this.$t('classic.contextMenu.confirm'),
                        text: msg,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true
                    }).then(res => {
                        if (res) {
                            axios.post('/api/v2/moderator/action', {
                                action: action,
                                item_id: status.id,
                                item_type: 'status'
                            }).then(res => {
                                this.feed = this.feed.filter(f => {
                                    return f.id != status.id;
                                });
                                swal(this.$t('common.success'), this.$t('menu.modUnlistSuccess'), 'success');
                                self.closeModals();
                                self.ctxModMenuClose();
                            }).catch(err => {
                                self.closeModals();
                                self.ctxModMenuClose();
                                swal(
                                    self.$t('common.error'),
                                    self.$t('classic.contextMenu.errorTryLater'),
                                    'error'
                                );
                            });
                        }
                    });
                    break;

                case 'spammer':
                    msg = this.$t('menu.modMarkAsSpammerConfirm');
                    swal({
                        title: this.$t('classic.contextMenu.confirm'),
                        text: msg,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true
                    }).then(res => {
                        if (res) {
                            axios.post('/api/v2/moderator/action', {
                                action: action,
                                item_id: status.id,
                                item_type: 'status'
                            }).then(res => {
                                swal(this.$t('common.success'), this.$t('menu.modMarkAsSpammerSuccess'), 'success');
                                self.closeModals();
                                self.ctxModMenuClose();
                            }).catch(err => {
                                self.closeModals();
                                self.ctxModMenuClose();
                                swal(
                                    self.$t('common.error'),
                                    self.$t('classic.contextMenu.errorTryLater'),
                                    'error'
                                );
                            });
                        }
                    });
                    break;
            }
        },

        shareStatus(status, $event) {
            if ($('body').hasClass('loggedIn') == false) {
                return;
            }

            this.closeModals();

            axios.post('/i/share', {
                item: status.id
            }).then(res => {
                status.reblogs_count = res.data.count;
                status.reblogged = !status.reblogged;
                if (status.reblogged) {
                    swal(this.$t('common.success'), this.$t('classic.contextMenu.sharedPost'), 'success');
                } else {
                    swal(this.$t('common.success'), this.$t('classic.contextMenu.unsharedPost'), 'success');
                }
            }).catch(err => {
                swal(this.$t('common.error'), this.$t('classic.contextMenu.errorTryLater'), 'error');
            });
        },

        statusUrl(status) {
            if (status.account.local == true) {
                return status.url;
            }

            return '/i/web/post/_/' + status.account.id + '/' + status.id;
        },

        profileUrl(status) {
            if (status.account.local == true) {
                return status.account.url;
            }

            return '/i/web/profile/_/' + status.account.id;
        },

        deletePost(status) {
            if ($('body').hasClass('loggedIn') == false || this.ownerOrAdmin(status) == false) {
                return;
            }

            if (window.confirm(this.$t('menu.deletePostConfirm')) == false) {
                return;
            }

            axios.post('/i/delete', {
                type: 'status',
                item: status.id
            }).then(res => {
                this.$emit('status-delete', status.id);
                this.closeModals();
            }).catch(err => {
                swal(this.$t('common.error'), this.$t('classic.contextMenu.errorTryLaterDot'), 'error');
            });
        },

        owner(status) {
            return this.profile.id === status.account.id;
        },

        admin() {
            return this.profile.is_admin == true;
        },

        ownerOrAdmin(status) {
            return this.owner(status) || this.admin();
        },

        archivePost(status) {
            if (window.confirm(this.$t('menu.archivePostConfirm')) == false) {
                return;
            }

            axios.post('/api/pixelfed/v2/status/' + status.id + '/archive')
                .then(res => {
                    this.$emit('status-delete', status.id);
                    this.closeModals();
                });
        },

        editPost(status) {
            this.closeModals();
            this.$emit('edit', status);
        },

        unarchivePost(status) {
            if (window.confirm(this.$t('menu.unarchivePostConfirm')) == false) {
                return;
            }

            axios.post('/api/pixelfed/v2/status/' + status.id + '/unarchive')
                .then(res => {
                    this.closeModals();
                });
        }
    }
}
</script>
