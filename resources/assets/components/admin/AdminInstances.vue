<template>
<div>
	<div class="header bg-primary pb-3 mt-n4">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
						<p class="display-1 text-white d-inline-block mb-0">{{ $t('admin.instances.title') }}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-2 col-md-6">
						<div class="mb-3">
							<h5 class="text-light text-uppercase mb-0">{{ $t('admin.instances.totalInstances') }}</h5>
							<span class="text-white h2 font-weight-bold mb-0 human-size">{{ prettyCount(stats.total_count) }}</span>
						</div>
					</div>

					<div class="col-xl-2 col-md-6">
						<div class="mb-3">
							<h5 class="text-light text-uppercase mb-0">{{ $t('admin.instances.newPast14Days') }}</h5>
							<span class="text-white h2 font-weight-bold mb-0 human-size">{{ prettyCount(stats.new_count) }}</span>
						</div>
					</div>

					<div class="col-xl-2 col-md-6">
						<div class="mb-3">
							<h5 class="text-light text-uppercase mb-0">{{ $t('admin.instances.bannedInstances') }}</h5>
							<span class="text-white h2 font-weight-bold mb-0 human-size">{{ prettyCount(stats.banned_count) }}</span>
						</div>
					</div>

					<div class="col-xl-2 col-md-6">
						<div class="mb-3">
							<h5 class="text-light text-uppercase mb-0">{{ $t('admin.instances.nsfwInstances') }}</h5>
							<span class="text-white h2 font-weight-bold mb-0 human-size">{{ prettyCount(stats.nsfw_count) }}</span>
						</div>
					</div>
					<div class="col-xl-2 col-md-6">
						<div class="mb-3">
							<button class="btn btn-outline-white btn-block btn-sm mt-1" @click.prevent="showAddModal = true">{{ $t('admin.instances.createNewInstance') }}</button>
							<div v-if="showImportForm">
								<div class="form-group mt-3">
									<div class="custom-file">
										<input ref="importInput" type="file" class="custom-file-input" id="customFile" v-on:change="onImportUpload">
										<label class="custom-file-label" for="customFile">{{ $t('admin.instances.chooseFile') }}</label>
									</div>
								</div>
								<p class="mb-0 mt-n3">
									<a href="#" class="text-white font-weight-bold small" @click.prevent="showImportForm = false">{{ $t('common.cancel') }}</a>
								</p>
							</div>
							<div v-else class="d-flex mt-1">
								<button class="btn btn-outline-white btn-sm mt-1" @click="openImportForm">{{ $t('admin.instances.import') }}</button>
								<button class="btn btn-outline-white btn-block btn-sm mt-1" @click="downloadBackup()">{{ $t('admin.instances.downloadBackup') }}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div v-if="!loaded" class="my-5 text-center">
		<b-spinner />
	</div>

	<div v-else class="m-n2 m-lg-4">
		<div class="container-fluid mt-4">
			<div class="row mb-3 justify-content-between">
				<div class="col-12 col-md-8">
					<ul class="nav nav-pills">
						<li class="nav-item">
							<button :class="['nav-link', { active: tabIndex == 0}]" @click="toggleTab(0)">{{ $t('admin.instances.tabAll') }}</button>
						</li>
						<li class="nav-item">
							<button :class="['nav-link', { active: tabIndex == 1}]" @click="toggleTab(1)">{{ $t('admin.instances.tabNew') }}</button>
						</li>
						<li class="nav-item">
							<button :class="['nav-link', { active: tabIndex == 2}]" @click="toggleTab(2)">{{ $t('admin.instances.banned') }}</button>
						</li>
						<li class="nav-item">
							<button :class="['nav-link', { active: tabIndex == 3}]" @click="toggleTab(3)">NSFW</button>
						</li>
						<li class="nav-item">
							<button :class="['nav-link', { active: tabIndex == 4}]" @click="toggleTab(4)">{{ $t('admin.instances.unlisted') }}</button>
						</li>
						<li class="nav-item">
							<button :class="['nav-link', { active: tabIndex == 5}]" @click="toggleTab(5)">{{ $t('admin.instances.tabMostUsers') }}</button>
						</li>
						<li class="nav-item">
							<button :class="['nav-link', { active: tabIndex == 6}]" @click="toggleTab(6)">{{ $t('admin.instances.tabMostStatuses') }}</button>
						</li>
					</ul>
				</div>
				<div class="col-12 col-md-4">
					<autocomplete
						:search="composeSearch"
						:disabled="searchLoading"
						:defaultValue="searchQuery"
						:placeholder="$t('admin.instances.searchByDomain')"
						:aria-label="$t('admin.instances.searchByDomain')"
						:get-result-value="getTagResultValue"
						@submit="onSearchResultClick"
						ref="autocomplete"
						>
							<template #result="{ result, props }">
								<li
								v-bind="props"
								class="autocomplete-result d-flex justify-content-between align-items-center"
								>
								<div class="font-weight-bold" :class="{ 'text-danger': result.banned }">
									{{ result.domain }}
								</div>
								<div class="small text-muted">
									{{ $t('admin.instances.usersCount', { count: prettyCount(result.user_count) }) }}
								</div>
							</li>
						</template>
					</autocomplete>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table table-dark">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="cursor-pointer" v-html="buildColumn('ID', 'id')" @click="toggleCol('id')"></th>
							<th scope="col" class="cursor-pointer" v-html="buildColumn($t('admin.instances.domain'), 'domain')" @click="toggleCol('domain')"></th>
							<th scope="col" class="cursor-pointer" v-html="buildColumn($t('admin.instances.software'), 'software')" @click="toggleCol('software')"></th>
							<th scope="col" class="cursor-pointer" v-html="buildColumn($t('admin.instances.userCount'), 'user_count')" @click="toggleCol('user_count')"></th>
							<th scope="col" class="cursor-pointer" v-html="buildColumn($t('admin.instances.statusCount'), 'status_count')" @click="toggleCol('status_count')"></th>
							<th scope="col" class="cursor-pointer" v-html="buildColumn($t('admin.instances.banned'), 'banned')" @click="toggleCol('banned')"></th>
							<th scope="col" class="cursor-pointer" v-html="buildColumn('NSFW', 'auto_cw')" @click="toggleCol('auto_cw')"></th>
							<th scope="col" class="cursor-pointer" v-html="buildColumn($t('admin.instances.unlisted'), 'unlisted')" @click="toggleCol('unlisted')"></th>
							<th scope="col">{{ $t('admin.instances.created') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(instance, idx) in instances">
							<td class="font-weight-bold text-monospace text-muted">
								<a href="#" @click.prevent="openInstanceModal(instance.id)">
									{{ instance.id }}
								</a>
							</td>
							<td class="font-weight-bold">{{ instance.domain }}</td>
							<td class="font-weight-bold">{{ instance.software }}</td>
							<td class="font-weight-bold">{{ prettyCount(instance.user_count) }}</td>
							<td class="font-weight-bold">{{ prettyCount(instance.status_count) }}</td>
							<td class="font-weight-bold" v-html="boolIcon(instance.banned, 'text-danger')"></td>
							<td class="font-weight-bold" v-html="boolIcon(instance.auto_cw, 'text-danger')"></td>
							<td class="font-weight-bold" v-html="boolIcon(instance.unlisted, 'text-danger')"></td>
							<td class="font-weight-bold">{{ timeAgo(instance.created_at) }}</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="d-flex align-items-center justify-content-center">
				<button
					class="btn btn-primary rounded-pill"
					:disabled="!pagination.prev"
					@click="paginate('prev')">
					{{ $t('admin.instances.prev') }}
				</button>
				<button
					class="btn btn-primary rounded-pill"
					:disabled="!pagination.next"
					@click="paginate('next')">
					{{ $t('common.next') }}
				</button>
			</div>
		</div>
	</div>

	<b-modal
		v-model="showInstanceModal"
		:title="$t('admin.instances.viewInstance')"
		header-class="d-flex align-items-center justify-content-center mb-0 pb-0"
		:ok-title="$t('admin.instances.save')"
		:ok-disabled="!editingInstanceChanges"
		@ok="saveInstanceModalChanges">
		<div v-if="editingInstance && canEditInstance" class="list-group">
			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.domain') }}</div>
				<div class="font-weight-bold">{{ editingInstance.domain }}</div>
			</div>
			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div v-if="editingInstance.software">
					<div class="text-muted small">{{ $t('admin.instances.software') }}</div>
					<div class="font-weight-bold">{{ editingInstance.software ?? $t('admin.instances.unknown') }}</div>
				</div>
				<div>
					<div class="text-muted small">{{ $t('admin.instances.totalUsers') }}</div>
					<div class="font-weight-bold">{{ formatCount(editingInstance.user_count ?? 0) }}</div>
				</div>
				<div>
					<div class="text-muted small">{{ $t('admin.instances.totalStatuses') }}</div>
					<div class="font-weight-bold">{{ formatCount(editingInstance.status_count ?? 0) }}</div>
				</div>
			</div>
			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.banned') }}</div>
				<div class="mr-n2 mb-1">
					<b-form-checkbox v-model="editingInstance.banned" switch size="lg"></b-form-checkbox>
				</div>
			</div>
			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.applyCwToMedia') }}</div>
				<div class="mr-n2 mb-1">
					<b-form-checkbox v-model="editingInstance.auto_cw" switch size="lg"></b-form-checkbox>
				</div>
			</div>
			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.unlisted') }}</div>
				<div class="mr-n2 mb-1">
					<b-form-checkbox v-model="editingInstance.unlisted" switch size="lg"></b-form-checkbox>
				</div>
			</div>
			<div class="list-group-item d-flex justify-content-between" :class="[ instanceModalNotes ? 'flex-column gap-2' : 'align-items-center']">
				<div class="text-muted small">{{ $t('admin.instances.notes') }}</div>
				<transition name="fade">
					<div v-if="instanceModalNotes" class="w-100">
						<b-form-textarea v-model="editingInstance.notes" rows="3" max-rows="5" maxlength="500"></b-form-textarea>
						<p class="small text-muted">{{editingInstance.notes ? editingInstance.notes.length : 0}}/500</p>
					</div>
					<div v-else class="mb-1">
						<a href="#" class="font-weight-bold small" @click.prevent="showModalNotes()">{{ editingInstance.notes ? $t('admin.instances.view') : $t('admin.instances.add') }}</a>
					</div>
				</transition>
			</div>
		</div>
		<template #modal-footer>
		<div class="w-100 d-flex justify-content-between align-items-center">
			<div>
				<b-button
					variant="outline-danger"
					size="sm"
					@click="deleteInstanceModal"
				>
					{{ $t('common.delete') }}
				</b-button>
				<b-button
					v-if="!refreshedModalStats"
					variant="outline-primary"
					size="sm"
					@click="refreshModalStats"
				>
					{{ $t('admin.instances.refreshStats') }}
				</b-button>
			</div>
		  <div>
			  <b-button
				variant="link-dark"
                size="sm"
				@click="onViewMoreInstance"
			  >
				{{ $t('admin.instances.viewMore') }}
			  </b-button>
			  <b-button
				variant="primary"
				@click="saveInstanceModalChanges"
			  >
				{{ $t('admin.instances.save') }}
			  </b-button>
		  </div>
		</div>
	  </template>
	</b-modal>

	<b-modal
		v-model="showAddModal"
		:title="$t('admin.instances.addInstance')"
		:ok-title="$t('admin.instances.save')"
		:ok-disabled="addNewInstance.domain.length < 2"
		@ok="saveNewInstance">
		<div class="list-group">
			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.domain') }}</div>
				<div>
					<b-form-input v-model="addNewInstance.domain" :placeholder="$t('admin.instances.addDomainPlaceholder')" />
					<p class="small text-light mb-0">{{ $t('admin.instances.enterValidDomain') }}</p>
				</div>
			</div>

			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.banned') }}</div>
				<div class="mr-n2 mb-1">
					<b-form-checkbox v-model="addNewInstance.banned" switch size="lg"></b-form-checkbox>
				</div>
			</div>
			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.applyCwToMedia') }}</div>
				<div class="mr-n2 mb-1">
					<b-form-checkbox v-model="addNewInstance.auto_cw" switch size="lg"></b-form-checkbox>
				</div>
			</div>
			<div class="list-group-item d-flex align-items-center justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.unlisted') }}</div>
				<div class="mr-n2 mb-1">
					<b-form-checkbox v-model="addNewInstance.unlisted" switch size="lg"></b-form-checkbox>
				</div>
			</div>
			<div class="list-group-item d-flex flex-column gap-2 justify-content-between">
				<div class="text-muted small">{{ $t('admin.instances.notes') }}</div>
				<div class="w-100">
					<b-form-textarea v-model="addNewInstance.notes" rows="3" max-rows="5" maxlength="500" :placeholder="$t('admin.instances.notesPlaceholder')"></b-form-textarea>
					<p class="small text-muted">{{addNewInstance.notes ? addNewInstance.notes.length : 0}}/500</p>
				</div>
			</div>
		</div>
	</b-modal>

	<b-modal
		v-model="showImportModal"
		:title="$t('admin.instances.importBackupTitle')"
		:ok-title="$t('admin.instances.import')"
		scrollable
		:ok-disabled="!importData || (!importData.banned.length && !importData.unlisted.length && !importData.auto_cw.length)"
		@ok="completeImport"
		@cancel="cancelImport">
		<div v-if="showImportModal && importData">
			<div v-if="importData.auto_cw && importData.auto_cw.length" class="mb-5">
				<p class="font-weight-bold text-center my-0">{{ $t('admin.instances.nsfwInstancesCount', { count: importData.auto_cw.length }) }}</p>
				<p class="small text-center text-muted mb-1">{{ $t('admin.instances.tapToRemove') }}</p>
				<div class="list-group">
					<a v-for="(instance, idx) in importData.auto_cw" class="list-group-item d-flex align-items-center justify-content-between" href="#" @click.prevent="filterImportData('auto_cw', idx)">
						{{ instance }}

						<span class="badge badge-warning">{{ $t('admin.instances.autoCw') }}</span>
					</a>
				</div>
			</div>

			<div v-if="importData.unlisted && importData.unlisted.length" class="mb-5">
				<p class="font-weight-bold text-center my-0">{{ $t('admin.instances.unlistedInstancesCount', { count: importData.unlisted.length }) }}</p>
				<p class="small text-center text-muted mb-1">{{ $t('admin.instances.tapToRemove') }}</p>
				<div class="list-group">
					<a v-for="(instance, idx) in importData.unlisted" class="list-group-item d-flex align-items-center justify-content-between" href="#" @click.prevent="filterImportData('unlisted', idx)">
						{{ instance }}

						<span class="badge badge-primary">{{ $t('admin.instances.unlisted') }}</span>
					</a>
				</div>
			</div>

			<div v-if="importData.banned && importData.banned.length" class="mb-5">
				<p class="font-weight-bold text-center my-0">{{ $t('admin.instances.bannedInstancesCount', { count: importData.banned.length }) }}</p>
				<p class="small text-center text-muted mb-1">{{ $t('admin.instances.reviewTapToRemove') }}</p>
				<div class="list-group">
					<a v-for="(instance, idx) in importData.banned" class="list-group-item d-flex align-items-center justify-content-between" href="#" @click.prevent="filterImportData('banned', idx)">
						{{ instance }}

						<span class="badge badge-danger">{{ $t('admin.instances.banned') }}</span>
					</a>
				</div>
			</div>

			<div v-if="!importData.banned.length && !importData.unlisted.length && !importData.auto_cw.length">
				<div class="text-center">
					<p>
						<i class="far fa-check-circle fa-4x text-success"></i>
					</p>
					<p class="lead">{{ $t('admin.instances.nothingToImport') }}</p>
				</div>
			</div>
		</div>
	</b-modal>
</div>
</template>

<script type="text/javascript">
	import Autocomplete from '@trevoreyre/autocomplete-vue'
	import '@trevoreyre/autocomplete-vue/dist/style.css'

	export default {
		components: {
			Autocomplete,
		},

		data() {
			return {
				loaded: false,
				tabIndex: 0,
				stats: {
					total_count: 0,
					new_count: 0,
					banned_count: 0,
					nsfw_count: 0
				},
				instances: [],
				pagination: [],
				sortCol: undefined,
				sortDir: undefined,
				searchQuery: undefined,
				filterMap: [
					'all',
					'new',
					'banned',
					'cw',
					'unlisted',
					'popular_users',
					'popular_statuses'
				],
				searchLoading: false,
				showInstanceModal: false,
				instanceModal: {},
				editingInstanceChanges: false,
				canEditInstance: false,
				editingInstance: {},
				editingInstanceIndex: 0,
				instanceModalNotes: false,
				showAddModal: false,
				refreshedModalStats: false,
				addNewInstance: {
					domain: "",
					banned: false,
					auto_cw: false,
					unlisted: false,
					notes: undefined
				},
				showImportForm: false,
				showImportModal: false,
				importData: undefined,
			}
		},

		mounted() {
			this.fetchStats();

			let u = new URLSearchParams(window.location.search);
			if(u.has('filter') && !u.has('q') && !u.has('sort')) {
				const url = new URL(window.location.origin + '/i/admin/api/instances/get');

				if(u.has('filter')) {
					this.tabIndex = this.filterMap.indexOf(u.get('filter'));
					url.searchParams.set('filter', u.get('filter'));
				}
				if(u.has('cursor')) {
					url.searchParams.set('cursor', u.get('cursor'));
				}

				this.fetchInstances(url.toString());
			} else if(u.has('sort') && !u.has('q')) {
				const url = new URL(window.location.origin + '/i/admin/api/instances/get');
				url.searchParams.set('sort', u.get('sort'));

				if(u.has('dir')) {
					url.searchParams.set('dir', u.get('dir'));
				}

				if(u.has('filter')) {
					url.searchParams.set('filter', u.get('filter'));
				}

				if(u.has('cursor')) {
					url.searchParams.set('cursor', u.get('cursor'));
				}

				this.fetchInstances(url.toString());
			} else if(u.has('q')) {
				this.tabIndex = -1;
				this.searchQuery = u.get('q');

				const url = new URL(window.location.origin + '/i/admin/api/instances/query');
				url.searchParams.set('q', u.get('q'));

				if(u.has('cursor')) {
					url.searchParams.set('cursor', u.get('cursor'));
				}

				this.fetchInstances(url.toString());
			} else {
				this.fetchInstances();
			}
		},

		watch: {
			editingInstance: {
				deep: true,
				immediate: true,
				handler: function(updated, old) {
					if(!this.canEditInstance) {
						return;
					}

					if(
						JSON.stringify(old) === JSON.stringify(this.instances.filter(i => i.id === updated.id)[0]) &&
						JSON.stringify(updated) === JSON.stringify(this.instanceModal)
					) {
						this.editingInstanceChanges = true;
					} else {
						this.editingInstanceChanges = false;
					}
				}
			}
		},

		methods: {
			fetchStats() {
				axios.get('/i/admin/api/instances/stats')
				.then(res => {
					this.stats = res.data;
				})
			},

			fetchInstances(url = '/i/admin/api/instances/get') {
				axios.get(url)
				.then(res => {
					this.instances = res.data.data;
					this.pagination = {...res.data.links, ...res.data.meta};
				})
				.then(() => {
					this.$nextTick(() => {
						this.loaded = true;
					})
				})
			},

			toggleTab(idx) {
				this.loaded = false;
				this.tabIndex = idx;
				this.searchQuery = undefined;
				let url = '/i/admin/api/instances/get?filter=' + this.filterMap[idx];
				history.pushState(null, '', '/i/admin/instances?filter=' + this.filterMap[idx]);
				this.fetchInstances(url);
			},

			prettyCount(str) {
				if(str) {
				   return str.toLocaleString('en-CA', { compactDisplay: "short", notation: "compact"});
				} else {
					return 0;
				}
				return str;
			},

			formatCount(str) {
				if(str) {
				   return str.toLocaleString('en-CA');
				} else {
					return 0;
				}
				return str;
			},

			timeAgo(str) {
				if(!str) {
					return str;
				}
				return App.util.format.timeAgo(str);
			},

			boolIcon(val, success = 'text-success', danger = 'text-muted') {
				if(val) {
					return `<i class="far fa-check-circle fa-lg ${success}"></i>`;
				}

				return `<i class="far fa-times-circle fa-lg ${danger}"></i>`;
			},

			toggleCol(col) {
				if(this.filterMap[this.tabIndex] == col || this.searchQuery) {
					return;
				}
				this.sortCol = col;

				if(!this.sortDir) {
				    this.sortDir = 'desc';
				} else {
				    this.sortDir = this.sortDir == 'asc' ? 'desc' : 'asc';
				}

				const url = new URL(window.location.origin + '/i/admin/instances');
				url.searchParams.set('sort', col);
				url.searchParams.set('dir', this.sortDir);
				if(this.tabIndex != 0) {
					url.searchParams.set('filter', this.filterMap[this.tabIndex]);
				}
				history.pushState(null, '', url);

				const apiUrl = new URL(window.location.origin + '/i/admin/api/instances/get');
				apiUrl.searchParams.set('sort', col);
				apiUrl.searchParams.set('dir', this.sortDir);
				if(this.tabIndex != 0) {
					apiUrl.searchParams.set('filter', this.filterMap[this.tabIndex]);
				}

				this.fetchInstances(apiUrl.toString());
			},

			buildColumn(name, col) {
				if([1, 5, 6].indexOf(this.tabIndex) != -1 || (this.searchQuery && this.searchQuery.length)) {
					return name;
				}

				if(this.tabIndex === 2 && col === 'banned') {
					return name;
				}

				if(this.tabIndex === 3 && col === 'auto_cw') {
					return name;
				}

				if(this.tabIndex === 4 && col === 'unlisted') {
					return name;
				}

				let icon = `<i class="far fa-sort"></i>`;
				if(col == this.sortCol) {
					icon = this.sortDir == 'desc' ?
					`<i class="far fa-sort-up"></i>` :
					`<i class="far fa-sort-down"></i>`
				}
				return `${name} ${icon}`;
			},

			paginate(dir) {
				event.currentTarget.blur();
				let apiUrl = dir == 'next' ? this.pagination.next : this.pagination.prev;
				let cursor = dir == 'next' ? this.pagination.next_cursor : this.pagination.prev_cursor;

				const url = new URL(window.location.origin + '/i/admin/instances');

				if(cursor) {
					url.searchParams.set('cursor', cursor);
				}

				if(this.searchQuery) {
					url.searchParams.set('q', this.searchQuery);
				}

				if(this.sortCol) {
					url.searchParams.set('sort', this.sortCol);
				}

				if(this.sortDir) {
					url.searchParams.set('dir', this.sortDir);
				}

				history.pushState(null, '', url.toString());
				this.fetchInstances(apiUrl);
			},

			composeSearch(input) {
				if (input.length < 1) { return []; };
				this.searchQuery = input;
				history.pushState(null, '', '/i/admin/instances?q=' + input);
				return axios.get('/i/admin/api/instances/query', {
					params: {
						q: input,
					}
				}).then(res => {
					if(!res || !res.data) {
						this.fetchInstances();
					} else {
						this.tabIndex = -1;
						this.instances = res.data.data;
						this.pagination = {...res.data.links, ...res.data.meta};
					}
					return res.data.data;
				});
			},

			getTagResultValue(result) {
				return result.name;
			},

			onSearchResultClick(result) {
				this.openInstanceModal(result.id);
				return;
			},

			openInstanceModal(id) {
				const cached = this.instances.filter(i => i.id === id)[0];
				this.refreshedModalStats = false;
				this.editingInstanceChanges = false;
				this.instanceModalNotes = false;
				this.canEditInstance = false;
				this.instanceModal = cached;
				this.$nextTick(() => {
					this.editingInstance = cached;
					this.showInstanceModal = true;
					this.canEditInstance = true;
				})
			},

			showModalNotes() {
				this.instanceModalNotes = true;
			},

			saveInstanceModalChanges() {
				axios.post('/i/admin/api/instances/update', this.editingInstance)
				.then(res => {
					this.showInstanceModal = false;
					this.$bvToast.toast(this.$t('admin.instances.updatedToast', { domain: res.data.data.domain }), {
						title: this.$t('admin.instances.instanceUpdated'),
						autoHideDelay: 5000,
						appendToast: true,
						variant: 'success'
					})
				})
			},

			saveNewInstance() {
				axios.post('/i/admin/api/instances/create', this.addNewInstance)
				.then(res => {
					this.showInstanceModal = false;
					this.instances.unshift(res.data.data);
				})
				.catch(err => {
					swal(this.$t('common.oops'), this.$t('admin.instances.errorTryLater'), 'error');
					this.addNewInstance = {
						domain: "",
						banned: false,
						auto_cw: false,
						unlisted: false,
						notes: undefined
					}
				})
			},

			refreshModalStats() {
				axios.post('/i/admin/api/instances/refresh-stats', {
					id: this.instanceModal.id
				})
				.then(res => {
					this.refreshedModalStats = true;
					this.instanceModal = res.data.data;
					this.editingInstance = res.data.data;
					this.instances = this.instances.map(i => {
						if(i.id === res.data.data.id) {
							return res.data.data;
						}
						return i;
					})
				})
			},

			deleteInstanceModal() {
				if(!window.confirm(this.$t('admin.instances.confirmDelete'))) {
					return;
				}
				axios.post('/i/admin/api/instances/delete', {
					id: this.instanceModal.id
				})
				.then(res => {
					this.showInstanceModal = false;
					this.instances = this.instances.filter(i => i.id != this.instanceModal.id);
				})
				.then(() => {
					setTimeout(() => this.fetchStats(), 1000);
				})
			},

			openImportForm() {
				let el = document.createElement('p');
					el.classList.add('text-left');
					el.classList.add('mb-0');
					el.innerHTML = '<p class="lead mb-0">' + this.$t('admin.instances.importHelp.lead') + '</span></p><br /><p>' + this.$t('admin.instances.importHelp.instructions') + '</p><ol><li>' + this.$t('admin.instances.importHelp.step1') + '</li><li>' + this.$t('admin.instances.importHelp.step2') + '</li><li>' + this.$t('admin.instances.importHelp.step3', { file: '<kbd>pixelfed-instances-mod.json</kbd>' }) + '</li><li>' + this.$t('admin.instances.importHelp.step4') + '</li><li>' + this.$t('admin.instances.importHelp.step5') + '</li></ol>';
					let wrapper = document.createElement('div');
					wrapper.appendChild(el);
				swal({
					title: this.$t('admin.instances.importBackup'),
					content: wrapper,
					icon: 'info'
				})
				this.showImportForm = true;
			},

			downloadBackup($event) {
				axios.get('/i/admin/api/instances/download-backup', {
					responseType: "blob"
				})
				.then(res => {
					let el = document.createElement('a');
					el.setAttribute('download', 'pixelfed-instances-mod.json')
					const href = URL.createObjectURL(res.data);
      				el.href = href;
      				el.setAttribute('target', '_blank');
      				el.click();

      				swal(
      					this.$t('admin.instances.backupDownloading'),
      					this.$t('admin.instances.backupDownloadingBody'),
      					'success'
      				)
				})
			},

			async onImportUpload(ev) {
				let res = await this.getParsedImport(ev.target.files[0]);

				if(!res.hasOwnProperty('version') || res.version !== 1) {
					swal(this.$t('admin.instances.invalidBackup'), this.$t('admin.instances.invalidBackupBody'), 'error');
					this.showImportForm = false;
					this.$refs.importInput.reset();
					return;
				}
				this.importData = res;
				this.showImportModal = true;
			},

			async getParsedImport(ev) {
				try {
					return await this.parseJsonFile(ev);
				} catch(err) {
					let el = document.createElement('p');
					el.classList.add('text-left');
					el.classList.add('mb-0');
					el.innerHTML = '<p class="lead">' + this.$t('admin.instances.parseError') + ' <span class="font-weight-bold">' + this.$t('admin.instances.pleaseTryAgainLater') + '</span></p><br /><p class="small text-danger mb-0">' + this.$t('admin.instances.errorMessage') + '</p><div class="card card-body"><code>' + err.message + '</code></div>';
					let wrapper = document.createElement('div');
					wrapper.appendChild(el);
					swal({
						title: this.$t('admin.instances.importError'),
						content: wrapper,
						icon: 'error'
					})
					return;
				}
			},

			async promisedParseJSON(json) {
				return new Promise((resolve, reject) => {
					try {
						resolve(JSON.parse(json))
					} catch (e) {
						reject(e)
					}
				})
			},

			async parseJsonFile(file) {
				return new Promise((resolve, reject) => {
					const fileReader = new FileReader()
					fileReader.onload = event => resolve(this.promisedParseJSON(event.target.result))
					fileReader.onerror = error => reject(error)
					fileReader.readAsText(file)
				})
			},

			filterImportData(type, index) {
				switch(type) {
					case 'auto_cw':
						this.importData.auto_cw.splice(index, 1);
					break;

					case 'unlisted':
						this.importData.unlisted.splice(index, 1);
					break;

					case 'banned':
						this.importData.banned.splice(index, 1);
					break;
				}
			},

			completeImport() {
				this.showImportForm = false;

				axios.post('/i/admin/api/instances/import-data', {
					'banned': this.importData.banned,
					'auto_cw': this.importData.auto_cw,
					'unlisted': this.importData.unlisted,
				})
				.then(res => {
					swal(this.$t('admin.instances.importUploaded'), this.$t('admin.instances.importUploadedBody'), 'success');
				})
				.then(() => {
					setTimeout(() => this.fetchStats(), 1000);
				})
			},

			cancelImport(bvModalEvent) {
				if(this.importData.banned.length || this.importData.auto_cw.length || this.importData.unlisted.length) {
					if(!window.confirm(this.$t('admin.instances.confirmCancelImport'))) {
						bvModalEvent.preventDefault();
						return;
					} else {
						this.showImportForm = false;
						this.$refs.importInput.value = '';
						this.importData = {
							banned: [],
							auto_cw: [],
							unlisted: []
						};
					}
				}
			},

            onViewMoreInstance() {
                this.showInstanceModal = false;
                window.location.href = '/i/admin/instances/show/' + this.instanceModal.id
            }
		}
	}
</script>

<style lang="scss" scoped>
	.gap-2 {
		gap: 1rem;
	}
</style>
