<template>
    <div class="h-100 pf-import">
        <div v-if="!loaded" class="d-flex justify-content-center align-items-center h-100">
            <b-spinner />
        </div>
        <template v-else>
            <input type="file" name="file" class="d-none" ref="zipInput" @change="zipInputChanged" />
            <template v-if="page === 1">
                <div class="title">
                    <h3 class="font-weight-bold">{{ $t('spa.accountImport.title') }}</h3>
                </div>
                <hr>
                <section>
                    <p class="lead">{{ $t('spa.accountImport.description') }}</p>
                </section>
                <section class="mt-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between flex-column" style="gap:1rem">
                            <div class="d-flex justify-content-between align-items-center" style="gap: 1rem;">
                                <div>
                                    <p class="font-weight-bold mb-1">{{ $t('spa.accountImport.importFromInstagram') }}</p>
                                    <p v-if="showDisabledWarning" class="small mb-0">{{ $t('spa.accountImport.disabled') }}</p>
                                    <i18n v-else-if="showNotAllowedWarning" path="spa.accountImport.notAllowed" tag="p" class="small mb-0"><template v-slot:link><a href="/site/kb/import" class="font-weight-bold">{{ $t('spa.accountImport.helpCenter') }}</a></template></i18n>
                                    <p v-else class="small mb-0">{{ $t('spa.accountImport.uploadHelp') }}<br /><i18n path="spa.accountImport.moreInfo" tag="span"><template v-slot:link><a href="/site/kb/import">{{ $t('spa.accountImport.here') }}</a></template></i18n></p>
                                </div>
                                <div v-if="!showDisabledWarning && !showNotAllowedWarning">
                                    <button
                                        v-if="step === 1 || invalidArchive"
                                        type="button"
                                        class="font-weight-bold btn btn-primary rounded-pill px-4 btn-lg"
                                        @click="selectArchive()"
                                        :disabled="showDisabledWarning">
                                        {{ $t('spa.accountImport.import') }}
                                    </button>

                                    <template v-else-if="step === 2">
                                        <div class="d-flex justify-content-center align-items-center flex-column">
                                            <b-spinner v-if="showUploadLoader" small />
                                            <button v-else type="button" class="font-weight-bold btn btn-outline-primary btn-sm btn-block" @click="reviewImports()">{{ $t('spa.accountImport.reviewImports') }}</button>
                                            <p v-if="zipName" class="small font-weight-bold mt-2 mb-0">{{ zipName }}</p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-group mt-3">

                        <li v-if="processingCount" class="list-group-item d-flex justify-content-between flex-column" style="gap:1rem">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="font-weight-bold mb-1">{{ $t('spa.accountImport.processingTitle') }}</p>
                                    <p class="small mb-0">{{ $t('spa.accountImport.processingDescription') }}</p>
                                </div>
                                <div>
                                    <span class="btn btn-danger rounded-pill py-0 font-weight-bold" disabled>{{ processingCount }}</span>
                                </div>
                            </div>
                        </li>

                        <li v-if="finishedCount" class="list-group-item d-flex justify-content-between flex-column" style="gap:1rem">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="font-weight-bold mb-1">{{ $t('spa.accountImport.importedTitle') }}</p>
                                    <p class="small mb-0">{{ $t('spa.accountImport.importedDescription') }}</p>
                                </div>
                                <div>
                                    <button
                                        type="button"
                                        class="font-weight-bold btn btn-primary btn-sm rounded-pill px-4 btn-block"
                                        @click="handleReviewPosts()"
                                        :disabled="!finishedCount">
                                        {{ $t('spa.accountImport.reviewPosts', { count: finishedCount }) }}
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>

                </section>
            </template>

            <template v-else-if="page === 2">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="title">
                        <h3 class="font-weight-bold">{{ $t('spa.accountImport.importFromInstagram') }}</h3>
                    </div>

                    <button
                        class="btn btn-primary font-weight-bold rounded-pill px-4"
                        :class="{ disabled: !selectedMedia || !selectedMedia.length }"
                        :disabled="!selectedMedia || !selectedMedia.length || importButtonLoading"
                        @click="handleImport()"
                        >
                        <b-spinner v-if="importButtonLoading" small />
                        <span v-else>{{ $t('spa.accountImport.import') }}</span>
                    </button>
                </div>
                <hr>
                <section>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div v-if="!selectedMedia || !selectedMedia.length">
                            <p class="lead mb-0">{{ $t('spa.accountImport.reviewPostsLead') }}</p>
                            <p class="small text-muted mb-0">{{ $t('spa.accountImport.tapToInclude') }}</p>
                        </div>
                        <i18n v-else path="spa.accountImport.postsSelected" tag="p" class="lead mb-0"><template v-slot:count><span class="font-weight-bold">{{ selectedPostsCounter }}</span></template></i18n>

                        <button v-if="selectedMedia.length" class="btn btn-outline-danger font-weight-bold rounded-pill btn-sm my-1" @click="handleClearAll()">{{ $t('spa.accountImport.clearAll') }}</button>
                        <button v-else class="btn btn-outline-primary font-weight-bold rounded-pill" @click="handleSelectAll()">{{ $t('spa.accountImport.selectFirst', { count: toggleLimit }) }}</button>
                    </div>
                </section>
                <section class="row mb-n5 media-selector" style="max-height: 600px;overflow-y: auto;">
                    <div v-for="media in postMeta" class="col-12 col-md-4">
                        <div
                            class="square cursor-pointer"
                            @click="toggleSelectedPost(media)">
                            <div
                                v-if="media.media[0].uri.endsWith('.mp4')"
                                :class="{ selected: selectedMedia.indexOf(media.media[0].uri) != -1 }"
                                class="info-overlay-text-label rounded">
                                <h5 class="text-white m-auto font-weight-bold">
                                    <span>
                                        <span class="far fa-video fa-2x p-2 d-flex-inline"></span>
                                    </span>
                                </h5>
                            </div>
                            <div
                                v-else
                                class="square-content"
                                :class="{ selected: selectedMedia.indexOf(media.media[0].uri) != -1 }"
                                :style="{ borderRadius: '5px', backgroundImage: 'url(' + getFileNameUrl(media.media[0].uri) + ')'}">
                            </div>
                        </div>
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <p class="small"><i class="far fa-clock"></i> {{ formatDate(media.media[0].creation_timestamp) }}</p>
                            <p class="small font-weight-bold"><a href="#" @click.prevent="showDetailsModal(media)"><i class="far fa-info-circle"></i> {{ $t('spa.accountImport.details') }}</a></p>
                        </div>
                    </div>
                </section>
            </template>

            <template v-else-if="page === 'reviewImports'">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="title">
                        <h3 class="font-weight-bold">{{ $t('spa.accountImport.importedFromInstagram') }}</h3>
                    </div>
                </div>
                <hr>
                <section class="row mb-n5 media-selector" style="max-height: 600px;overflow-y: auto;">
                    <div v-for="media in importedPosts.data" class="col-12 col-md-4">
                        <div
                            class="square cursor-pointer">
                            <div
                                v-if="media.media_attachments[0].url.endsWith('.mp4')"
                                class="info-overlay-text-label rounded">
                                <h5 class="text-white m-auto font-weight-bold">
                                    <span>
                                        <span class="far fa-video fa-2x p-2 d-flex-inline"></span>
                                    </span>
                                </h5>
                            </div>
                            <div
                                v-else
                                class="square-content"
                                :style="{ borderRadius: '5px', backgroundImage: 'url(' + media.media_attachments[0].url + ')'}">
                            </div>
                        </div>
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <p class="small"><i class="far fa-clock"></i> {{ formatDate(media.created_at, false) }}</p>
                            <p class="small font-weight-bold"><a :href="media.url"><i class="far fa-info-circle"></i> {{ $t('spa.accountImport.view') }}</a></p>
                        </div>
                    </div>

                    <div class="col-12 my-3">
                        <button
                            v-if="importedPosts.meta && importedPosts.meta.next_cursor"
                            class="btn btn-primary btn-block font-weight-bold"
                            @click="loadMorePosts()">
                            {{ $t('spa.accountImport.loadMore') }}
                        </button>
                    </div>
                </section>
            </template>
        </template>

        <b-modal
            id="detailsModal"
            :title="$t('spa.accountImport.postDetails')"
            v-model="detailsModalShow"
            :ok-only="true"
            :ok-title="$t('common.close')"
            centered>
            <div class="">
                <div v-for="(media, idx) in modalData.media" class="mb-3">
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <p class="text-center font-weight-bold mb-0">{{ $t('spa.accountImport.mediaNumber', { number: idx + 1 }) }}</p>
                            <template v-if="media.uri.endsWith('.jpg') || media.uri.endsWith('.png')">
                                <img :src="getFileNameUrl(media.uri)" width="30" height="30" style="object-fit: cover; border-radius: 5px;">
                            </template>
                        </div>
                        <template v-if="media.uri.endsWith('.mp4')">
                            <div class="list-group-item">
                                <div class="embed-responsive embed-responsive-4by3">
                                    <video :src="getFileNameUrl(media.uri)" controls></video>
                                </div>
                            </div>
                        </template>
                        <div class="list-group-item">
                            <p class="small text-muted">{{ $t('spa.accountImport.caption') }}</p>
                            <p class="mb-0 small read-more" style="font-size: 12px;overflow-y: hidden;">{{ media.title ? media.title : modalData.title }}</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="small mb-0 text-muted">{{ $t('spa.accountImport.timestamp') }}</p>
                                <p class="font-weight-bold mb-0">{{ formatDate(media.creation_timestamp) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script type="text/javascript">
    import * as zip from "@zip.js/zip.js";

    export default {
        data() {
            return {
                page: 1,
                step: 1,
                toggleLimit: 300,
                config: {},
                showDisabledWarning: false,
                showNotAllowedWarning: false,
                invalidArchive: false,
                loaded: false,
                existing: [],
                zipName: undefined,
                zipFiles: [],
                postMeta: [],
                imageCache: [],
                includeArchives: false,
                selectedMedia: [],
                selectedPostsCounter: 0,
                detailsModalShow: false,
                modalData: {},
                importedPosts: [],
                finishedCount: undefined,
                processingCount: undefined,
                showUploadLoader: false,
                importButtonLoading: false,
            }
        },

        mounted() {
            this.fetchConfig();
        },

        methods: {
            fetchConfig() {
                axios.get('/api/local/import/ig/config')
                .then(res => {
                    this.config = res.data;

                    if(res.data.enabled == false) {
                        this.showDisabledWarning = true;
                        this.loaded = true;
                    } else if(res.data.allowed == false) {
                        this.showNotAllowedWarning = true;
                        this.loaded = true;
                    } else {
                        this.fetchExisting();
                    }
                })
            },

            fetchExisting() {
                axios.post('/api/local/import/ig/existing')
                .then(res => {
                    this.existing = res.data;
                })
                .finally(() => {
                    this.fetchProcessing();
                })
            },

            fetchProcessing() {
                axios.post('/api/local/import/ig/processing')
                .then(res => {
                    this.processingCount = res.data.processing_count;
                    this.finishedCount = res.data.finished_count;
                })
                .finally(() => {
                    this.loaded = true;
                })
            },

            selectArchive() {
                event.currentTarget.blur();
                swal({
                    title: this.$t('spa.accountImport.uploadArchive'),
                    icon: 'success',
                    text: this.$t('spa.accountImport.uploadArchiveText', { example: 'username_20230606.zip' }),
                    buttons: {
                        cancel: this.$t('common.cancel'),
                        danger: {
                            text: this.$t('spa.accountImport.uploadZip'),
                            value: "upload"
                        }
                    }
                })
                .then(res => {
                    this.$refs.zipInput.click();
                })
            },

            zipInputChanged(event) {
                this.step = 2;
                this.zipName = event.target.files[0].name;
                this.showUploadLoader = true;
                setTimeout(() => {
                    this.reviewImports();
                }, 1000);
                setTimeout(() => {
                    this.showUploadLoader = false;
                }, 3000);
            },

            reviewImports() {
                this.invalidArchive = false;
                this.checkZip();
            },

            model(file, options = {}) {
                return (new zip.ZipReader(new zip.BlobReader(file))).getEntries(options);
            },

            formatDate(ts, unixt = true) {
                let date = unixt ? new Date(ts * 1000) : new Date(ts);
                return date.toLocaleDateString()
            },

            getFileNameUrl(filename) {
                return this.imageCache.filter(e => e.filename === filename).map(e => e.blob);
            },

            showDetailsModal(entry) {
                this.modalData = entry;
                this.detailsModalShow = true;
                setTimeout(() => {
                    pixelfed.readmore();
                }, 500);
            },

            async fixFacebookEncoding(string) {
                // Facebook and Instagram are encoding UTF8 characters in a weird way in their json
                // here is a good explanation what's going wrong https://sorashi.github.io/fix-facebook-json-archive-encoding
                // See https://github.com/pixelfed/pixelfed/pull/4726 for more info
                const replaced = string.replace(/\\u00([a-f0-9]{2})/g, (x) => String.fromCharCode(parseInt(x.slice(2), 16)));
                const buffer = Array.from(replaced, (c) => c.charCodeAt(0));
                return new TextDecoder().decode(new Uint8Array(buffer));
            },

            async filterPostMeta(media) {
                let fbfix = await this.fixFacebookEncoding(media);
                let json = JSON.parse(fbfix);
                /* Sometimes the JSON isn't an array, when there's only one post */
                if (!Array.isArray(json)) {
                    json = new Array(json);
                }
                let res = json.filter(j => {
                    let ids = j.media.map(m => m.uri).filter(m => {
                        const supportedFormats = ['.png', '.jpg'];
                        if (this.config.allow_video_posts) {
                          supportedFormats.push('.mp4');
                        }
                        if (this.config.allow_image_webp) {
                          supportedFormats.push('.webp');
                        }
                        return supportedFormats.some(format => m.endsWith(format));
                    });
                    return ids.length;
                }).filter(j => {
                    let ids = j.media.map(m => m.uri);
                    return !this.existing.includes(ids[0]);
                })
                this.postMeta = res;
                return res;
            },

            async checkZip() {
                let file = this.$refs.zipInput.files[0];
                let entries = await this.model(file);
                if (entries && entries.length) {
                    let files = await entries.filter(e => e.filename === 'content/posts_1.json' || e.filename === 'your_instagram_activity/content/posts_1.json' || e.filename === 'your_instagram_activity/media/posts_1.json');

                    if(!files || !files.length) {
                        this.contactModal(
                            this.$t('spa.accountImport.invalidArchive'),
                            this.$t('spa.accountImport.invalidArchiveText'),
                            'error'
                        )
                        this.invalidArchive = true;
                        return;
                    } else {
                        this.readZip();
                    }
                }
            },

            async readZip() {
                let file = this.$refs.zipInput.files[0];
                let entries = await this.model(file);
                if (entries && entries.length) {
                    this.zipFiles = entries;
                    let media = await entries.filter(e => e.filename === 'content/posts_1.json' || e.filename === 'your_instagram_activity/content/posts_1.json' || e.filename === 'your_instagram_activity/media/posts_1.json')[0].getData(new zip.TextWriter());
                    this.filterPostMeta(media);

                    let imgs = await Promise.all(entries.filter(entry => {
                        const supportedFormats = ['.png', '.jpg', '.jpeg', '.mp4'];
                        if (this.config.allow_image_webp) {
                            supportedFormats.push('.webp');
                        }
                        return (entry.filename.startsWith('media/posts/') || entry.filename.startsWith('media/other/')) &&
                               supportedFormats.some(format => entry.filename.endsWith(format));
                    })
                    .map(async entry => {
                        const supportedFormats = ['.png', '.jpg', '.jpeg', '.mp4'];
                        if (this.config.allow_image_webp) {
                            supportedFormats.push('.webp');
                        }

                        if(
                            (
                                entry.filename.startsWith('media/posts/') ||
                                entry.filename.startsWith('media/other/')
                            ) &&
                            supportedFormats.some(format => entry.filename.endsWith(format))
                        ) {
                            let types = {
                                'png': 'image/png',
                                'jpg': 'image/jpeg',
                                'jpeg': 'image/jpeg',
                                'mp4': 'video/mp4',
                                'webp': 'image/webp'
                            }
                            let type = types[entry.filename.split('/').pop().split('.').pop()];
                            let blob = await entry.getData(new zip.BlobWriter(type));
                            let url = URL.createObjectURL(blob);
                            return {
                                filename: entry.filename,
                                blob: url,
                                file: blob
                            }
                        } else {
                            return;
                        }
                    }));
                    this.imageCache = imgs.flat(2);
                }
                setTimeout(() => {
                    this.page = 2;
                }, 500);
            },

            toggleLimitReached() {
                this.contactModal(
                    this.$t('spa.accountImport.limitReached'),
                    this.$t('spa.accountImport.limitReachedText', { count: this.toggleLimit }),
                    'error'
                )
            },

            toggleSelectedPost(media) {
                let filename;
                let self = this;
                if(media.media.length === 1) {
                    filename = media.media[0].uri
                    if(this.selectedMedia.indexOf(filename) == -1) {
                        if(this.selectedPostsCounter >= this.toggleLimit) {
                            this.toggleLimitReached();
                            return;
                        }
                        this.selectedMedia.push(filename);
                        this.selectedPostsCounter++;
                    } else {
                        let idx = this.selectedMedia.indexOf(filename);
                        this.selectedMedia.splice(idx, 1);
                        this.selectedPostsCounter--;
                    }
                } else {
                    filename = media.media[0].uri
                    if(this.selectedMedia.indexOf(filename) == -1) {
                        if(this.selectedPostsCounter >= this.toggleLimit) {
                            this.toggleLimitReached();
                            return;
                        }
                        this.selectedPostsCounter++;
                    } else {
                        this.selectedPostsCounter--;
                    }
                    media.media.forEach(function(m) {
                        filename = m.uri
                        if(self.selectedMedia.indexOf(filename) == -1) {
                            self.selectedMedia.push(filename);
                        } else {
                            let idx = self.selectedMedia.indexOf(filename);
                            self.selectedMedia.splice(idx, 1);
                        }
                    })
                }
            },

            sliceIntoChunks(arr, chunkSize) {
                const res = [];
                for (let i = 0; i < arr.length; i += chunkSize) {
                    const chunk = arr.slice(i, i + chunkSize);
                    res.push(chunk);
                }
                return res;
            },

            getFilename(filename) {
                const baseName = filename.split('/').pop();

                const extension = baseName.split('.').pop();
                const originalName = baseName.substring(0, baseName.lastIndexOf('.'));
                const updatedFilename = originalName.replace(/[^a-zA-Z0-9_.-]/g, '_');
                return updatedFilename + '.' + extension;
            },

            handleImport() {
                swal(this.$t('spa.accountImport.importing'), this.$t('spa.accountImport.importingText'), 'success');
                this.importButtonLoading = true;
                let ic = this.imageCache.filter(e => {
                    return this.selectedMedia.indexOf(e.filename) != -1;
                })
                let chunks = this.sliceIntoChunks(ic, 10);
                chunks.forEach(c => {
                    let formData = new FormData();
                    c.map((e, idx) => {
                        let chunkedFilename = this.getFilename(e.filename);
                        let file = new File([e.file], chunkedFilename);
                        formData.append('file['+ idx +']', file, chunkedFilename);
                    })
                    axios.post(
                        '/api/local/import/ig/media',
                        formData,
                        {
                            headers: {
                                'Content-Type': `multipart/form-data`,
                            },
                        }
                    )
                    .catch(err => {
                        this.contactModal(
                            this.$t('common.error'),
                            err.response.data.message,
                            'error'
                        )
                    });
                })
                axios.post('/api/local/import/ig', {
                    files: this.postMeta.filter(e => this.selectedMedia.includes(e.media[0].uri)).map(e => {
                        if(e.hasOwnProperty('title')) {
                            return {
                                title: e.title,
                                'creation_timestamp': e.creation_timestamp,
                                uri: e.uri,
                                media: e.media
                            }
                        } else {
                            return {
                                title: null,
                                'creation_timestamp': null,
                                uri: null,
                                media: e.media
                            }
                        }
                    })
                }).then(res => {
                    if(res) {
                        setTimeout(() => {
                            window.location.reload()
                        }, 5000);
                    }
                }).catch(err => {
                    this.contactModal(
                        this.$t('common.error'),
                        err.response.data.error,
                        'error'
                    )
                })
            },

            handleReviewPosts() {
                this.page = 'reviewImports';

                axios.post('/api/local/import/ig/posts')
                .then(res => {
                    this.importedPosts = res.data;
                })
            },

            loadMorePosts() {
                event.currentTarget.blur();

                axios.post('/api/local/import/ig/posts', {
                    cursor: this.importedPosts.meta.next_cursor
                })
                .then(res => {
                    let data = res.data;
                    data.data = [...this.importedPosts.data, ...res.data.data];
                    this.importedPosts = data;
                })
            },

            contactModal(title = this.$t('common.error'), text, icon, closeButton = this.$t('common.close')) {
                swal({
                    title: title,
                    text: text,
                    icon: icon,
                    dangerMode: true,
                    buttons: {
                        ok: closeButton,
                        danger: {
                            text: this.$t('spa.accountImport.contactSupport'),
                            value: 'contact'
                        }
                    }
                })
                .then(res => {
                    if(res === 'contact') {
                        window.location.href = '/site/contact'
                    }
                });
            },

            handleSelectAll() {
                let medias = this.postMeta.slice(0, this.toggleLimit);
                for (var i = medias.length - 1; i >= 0; i--) {
                    let m = medias[i];
                    this.toggleSelectedPost(m);
                }
            },

            handleClearAll() {
                this.selectedMedia = []
                this.selectedPostsCounter = 0;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .pf-import {
        .media-selector {
            .selected {
                border: 5px solid red;
            }
        }
    }
</style>
