<template>
<div class="container">
	<div v-if="loaded" class="row">
		<div class="col-12 col-md-6 offset-md-3 pt-5">
			<div class="text-center pb-4">
				<h1>{{ $t('compose.collectionCompose.createCollection') }}</h1>
			</div>
		</div>
		<div class="col-12 col-md-4 pt-3">
			<div class="card rounded-0 shadow-none border " style="min-height: 440px;">
				<div class="card-body">
					<div>
						<form>
							<div class="form-group">
								<label for="title" class="font-weight-bold text-muted">{{ $t('compose.common.title') }}</label>
								<input type="text" class="form-control" id="title" :placeholder="$t('compose.collectionCompose.titlePlaceholder')" v-model="collection.title" maxlength="50">
                                <div class="text-right small text-muted">
                                    <span>{{collection.title ? collection.title.length : 0}}/50</span>
                                </div>
							</div>
							<div class="form-group">
								<label for="description" class="font-weight-bold text-muted">{{ $t('compose.common.description') }}</label>
								<textarea class="form-control" id="description" :placeholder="$t('compose.collectionCompose.descriptionPlaceholder')" v-model="collection.description" rows="3" maxlength="500">
								</textarea>
                                <div class="text-right small text-muted">
                                    <span>{{collection.description ? collection.description.length : 0}}/500</span>
                                </div>
							</div>
							<div class="form-group">
								<label for="visibility" class="font-weight-bold text-muted">{{ $t('compose.collectionCompose.visibility') }}</label>
								<select class="custom-select" v-model="collection.visibility">
									<option value="public">{{ $t('compose.common.public') }}</option>
									<option value="private">{{ $t('compose.common.followersOnly') }}</option>
									<option value="draft">{{ $t('compose.collectionCompose.draft') }}</option>
								</select>
							</div>
						</form>
						<hr>
						<p>
							<button v-if="posts.length > 0 && collection.visibility != 'draft'" type="button" class="btn btn-primary font-weight-bold btn-block" @click="publish">{{ $t('compose.common.publish') }}</button>
							<button v-else type="button" class="btn btn-primary font-weight-bold btn-block disabled" disabled>{{ $t('compose.common.publish') }}</button>
						</p>
						<p>
							<button type="button" class="btn btn-outline-primary font-weight-bold btn-block" @click="save">{{ $t('compose.common.save') }}</button>
						</p>
						<p class="mb-0">
							<button type="button" class="btn btn-outline-secondary font-weight-bold btn-block" @click="deleteCollection">{{ $t('common.delete') }}</button>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-8 pt-3">
			<div>
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a :class="[tab == 'add' ? 'nav-link font-weight-bold bg-white active' : 'nav-link font-weight-bold text-muted']" href="#" @click.prevent="tab = 'add'">{{ $t('compose.collectionCompose.addPosts') }}</a>
					</li>
					<li class="nav-item">
						<a :class="[tab == 'all' ? 'nav-link font-weight-bold bg-white active' : 'nav-link font-weight-bold text-muted']" href="#" @click.prevent="tab = 'all'">{{ $t('compose.collectionCompose.preview') }}</a>
					</li>
				</ul>
			</div>
			<div class="card rounded-0 shadow-none border border-top-0">
				<div class="card-body" style="min-height: 460px;">
					<div v-if="tab == 'all'" class="row">
						<div class="col-4 p-1" v-for="(s, index) in posts">
							<a class="card info-overlay card-md-border-0" :href="s.url">
								<div class="square">
									<span v-if="s.pf_type == 'photo:album'" class="float-right mr-3 post-icon"><i class="fas fa-images fa-2x"></i></span>
									<span v-if="s.pf_type == 'video'" class="float-right mr-3 post-icon"><i class="fas fa-video fa-2x"></i></span>
									<span v-if="s.pf_type == 'video:album'" class="float-right mr-3 post-icon"><i class="fas fa-film fa-2x"></i></span>
									<div class="square-content" v-bind:style="previewBackground(s)">
									</div>
									<div class="info-overlay-text">
										<h5 class="text-white m-auto font-weight-bold">
											<span>
												<span class="far fa-heart fa-lg p-2 d-flex-inline"></span>
												<span class="d-flex-inline">{{s.favourites_count}}</span>
											</span>
											<span>
												<span class="fas fa-retweet fa-lg p-2 d-flex-inline"></span>
												<span class="d-flex-inline">{{s.reblogs_count}}</span>
											</span>
										</h5>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div v-if="tab == 'add'">
						<div class="form-group">
							<label for="title" class="font-weight-bold text-muted">{{ $t('compose.collectionCompose.addPostByUrl') }}</label>
							<input type="text" class="form-control" placeholder="https://pixelfed.dev/p/admin/1" v-model="id">
							<p class="help-text small text-muted">{{ $t('compose.collectionCompose.onlyLocalPublic') }}</p>
						</div>
						<div class="form-group pt-4">
							<label for="title" class="font-weight-bold text-muted">{{ $t('compose.collectionCompose.addRecentPost') }}</label>
							<div style="max-height: 360px; overflow-y: auto">
								<div v-for="(s, index) in recentPosts" :class="[selectedPost == s.id ? 'box-shadow border border-warning d-inline-block m-1':'d-inline-block m-1']" @click="selectPost(s)">
									<div class="cursor-pointer" :style="'width: 175px; height: 175px; ' + previewBackground(s)"></div>
								</div>
							</div>
						</div>
						<hr>
						<button type="button" class="btn btn-primary font-weight-bold btn-block" @click="addId">{{ $t('compose.collectionCompose.addPost') }}</button>
					</div>
					<div v-if="tab == 'order'">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script type="text/javascript">
export default {
	props: ['collection-id', 'profile-id'],
	data() {
		return {
			config: window.App.config,
			loaded: false,
			limit: 8,
			step: 1,
			title: '',
			description: '',
			collection: {
				title: '',
				description: '',
				visibility: 'draft'
			},
			id: '',
			posts: [],
			tab: 'add',
			tabs: [
				'all',
				'add',
				'order'
			],
			recentPosts: [],
			selectedPost: '',
		}
	},
	beforeMount() {
		axios.get('/api/local/collection/' + this.collectionId)
		.then(res => {
			this.collection = res.data;
		});
	},
	mounted() {
		this.fetchRecentPosts();
		this.fetchItems();
		axios.get('/api/pixelfed/v1/accounts/verify_credentials').then(res => {
			window._sharedData.curUser = res.data;
			window.App.util.navatar();
		});
	},
	methods: {
		addToIds(id) {
			axios.post('/api/local/collection/item', {
				collection_id: this.collectionId,
				post_id: id
			}).then(res => {
				this.fetchItems();
				this.fetchRecentPosts();
				this.tab = 'all';
				this.id = '';
			}).catch(err => {
				swal(this.$t('compose.collectionCompose.invalidUrl'), this.$t('compose.collectionCompose.invalidPost'), 'error');
				this.id = '';
			})
		},

		fetchItems() {
			axios.get('/api/local/collection/items/' + this.collectionId)
			.then(res => {
				this.posts = res.data;
				this.loaded = true;
			});
		},

		addId() {
			let max = this.config.uploader.max_collection_length;
			if(this.posts.length >= max) {
				swal(this.$t('common.error'), this.$t('compose.collectionCompose.maxPosts', { max: max }), 'error');
				return;
			}
			let url = this.id;
			let origin = window.location.origin;
			let split = url.split('/');
			if(url.slice(0, origin.length) !== origin) {
				swal(this.$t('compose.collectionCompose.invalidUrl'), this.$t('compose.collectionCompose.onlyThisInstance'), 'error');
				this.id = '';
			}
            if(url.includes('/i/web/post/') || url.includes('/p/')) {
            	let id = split[split.length - 1];
            	console.log('adding ' + id);
                this.addToIds(id);
                return;
            } else {
				swal(this.$t('compose.collectionCompose.invalidUrl'), this.$t('compose.collectionCompose.invalidUrl'), 'error');
				this.id = '';
            }
			return;
		},

		previewUrl(status) {
			return status.sensitive ? '/storage/no-preview.png?v=' + new Date().getTime() : status.media_attachments[0].preview_url;
		},

		previewBackground(status) {
			let preview = this.previewUrl(status);
			return 'background-image: url(' + preview + ');background-size:cover;';
		},

		fetchRecentPosts() {
			axios.get('/api/v1/accounts/' + this.profileId + '/statuses', {
				params: {
					only_media: true,
					min_id: 1,
                    limit: 40
				}
			}).then(res => {
				this.recentPosts = res.data.filter(s => {
					let ids = this.posts.map(s => {
						return s.id;
					});
					return (s.visibility == 'public' || s.visibility == 'unlisted') && s.sensitive == false && ids.indexOf(s.id) == -1;
				});
			});
		},

		selectPost(status) {
			this.selectedPost = status.id;
			this.id = status.url;
		},

		publish() {
			if(this.posts.length == 0) {
				swal(this.$t('common.error'), this.$t('compose.collectionCompose.emptyCollection'));
				return;
			}
			axios.post('/api/local/collection/' + this.collectionId + '/publish', {
				title: this.collection.title,
				description: this.collection.description,
				visibility: this.collection.visibility	
			})
			.then(res => {
				window.location.href = res.data.url;
			}).catch(err => {
				swal(this.$t('compose.collectionCompose.somethingWentWrong'), this.$t('compose.collectionCompose.requestProblem'), 'error');
			});
		},

		save() {
			axios.post('/api/local/collection/' + this.collectionId, {
				title: this.collection.title,
				description: this.collection.description,
				visibility: this.collection.visibility
			})
			.then(res => {
				swal(this.$t('compose.collectionCompose.saved'), this.$t('compose.collectionCompose.savedMsg'), 'success');
			});
		},

		deleteCollection() {
			let confirm = window.confirm(this.$t('compose.collectionCompose.deleteConfirm'));
			if(!confirm) {
				return;
			}
			axios.delete('/api/local/collection/' + this.collectionId)
			.then(res => {
				window.location.href = '/';
			});
		}
	}
}
</script>
