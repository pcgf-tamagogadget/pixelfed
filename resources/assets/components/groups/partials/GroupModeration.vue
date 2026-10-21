<template>
	<div class="group-moderation-component">
		<div v-if="initalLoad">
			<div v-if="tab === 'home'">
				<div class="row justify-content-center">
					<div class="col-12 col-md-6 pt-4">
						<div class="d-flex justify-content-between align-items-center mb-3">
							<p class="lead mb-0">{{ $t('groups.groupModeration.latestReports') }}</p>
							<button class="btn btn-light border font-weight-bold btn-sm rounded shadow-sm">
								<i class="far fa-redo"></i>
							</button>
						</div>

						<div v-if="reports.length" class="list-group">
							<div v-for="(report, index) in reports" class="list-group-item">
								<div class="media align-items-center">
									<img :src="report.profile.avatar" width="40" height="40" class="rounded-circle mr-3">
									<div class="media-body">
										<i18n path="groups.groupModeration.reportedAs" tag="p" class="mb-0">
											<template v-slot:reporter><a v-if="report.total_count == 1" class="font-weight-bold" :href="report.profile.url">{{ report.profile.username }}</a><i18n v-else path="groups.groupModeration.andOthers" tag="span"><template v-slot:user><a class="font-weight-bold" :href="report.profile.url">{{ report.profile.username }}</a></template><template v-slot:others><a class="font-weight-bold" href="#">{{ $t('groups.groupModeration.othersCount', { count: report.total_count - 1 }) }}</a></template></i18n></template>
											<template v-slot:post><a href="#" class="font-weight-bold" :id="`report_post:${index}`">{{ $t('groups.groupModeration.thisPost') }}</a></template>
											<template v-slot:type>{{ report.type }}</template>
										</i18n>
										<p class="mb-0 small">
											<span class="text-muted font-weight-bold">
												{{ timeago(report.created_at) }}
											</span>
											<!-- <span>·</span>
											<a class="text-muted font-weight-bold" href="#">
												View Full Report
											</a> -->
											<span>·</span>
											<a class="text-danger font-weight-bold" href="#" @click.prevent="actionMenu(index)">
												{{ $t('groups.groupModeration.actions') }}
											</a>
										</p>
									</div>

									<!-- <div class="text-muted">
										<button class="btn btn-light btn-sm shadow-sm" @click.prevent="actionMenu(index)">
											<i class="far fa-cog fa-lg text-lighter"></i>
										</button>
									</div> -->

									<b-popover :target="`report_post:${index}`" triggers="hover" placement="bottom" custom-class="popover-wide">
										<template #title>
											<div class="d-flex justify-content-between">
												<span>
													&commat;{{ report.status.account.username }}
												</span>
												<span>
													{{ timeago(report.status.created_at) }}
												</span>
											</div>
										</template>

										<div v-if="report.status.pf_type == 'group:post'">
											<div v-if="report.status.media_attachments.length">
												<img :src="report.status.media_attachments[0].url" width="100%" height="300" style="object-fit:cover;">
											</div>
											<div v-else>
												<p v-html="report.status.content"></p>
											</div>
										</div>
										<div v-else-if="report.status.pf_type == 'reply-text'">
											<p v-html="report.status.content"></p>
										</div>
										<div v-else>
											<p>{{ $t('groups.groupModeration.cannotGeneratePreview') }}</p>
										</div>

										<p class="mb-1 mt-3">
											<a class="btn btn-primary btn-block font-weight-bold" :href="report.status.url">{{ $t('groups.groupModeration.viewPost') }}</a>
										</p>
									</b-popover>
								</div>
							</div>

							<div v-if="canLoadMore" class="list-group-item">
								<button class="btn btn-light font-weight-bold btn-block" @click.prevent="loadMoreReports()">{{ $t('groups.groupModeration.loadMore') }}</button>
							</div>
						</div>
						<div v-else class="card card-body shadow-none border rounded-pill">
							<p class="lead font-weight-bold text-center mb-0">{{ $t('groups.groupModeration.noReports') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div v-else class="col-12 col-md-6 pt-4 d-flex align-items-center justify-content-center">
			<div class="spinner-border" role="status">
				<span class="sr-only">{{ $t('common.loading') }}</span>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: {
			group: {
				type: Object
			}
		},

		data() {
			return {
				initalLoad: false,
				reports: [],
				page: 1,
				canLoadMore: false,
				tab: 'home'
			}
		},

		mounted() {
			this.getReports();
		},

		methods: {
			getReports() {
				axios.get(`/api/v0/groups/${this.group.id}/reports/list`)
				.then(res => {
					this.reports = res.data;
					this.initalLoad = true;
					this.page++;
					this.canLoadMore = res.data.length == 10;
				})
			},

			loadMoreReports() {
				axios.get(`/api/v0/groups/${this.group.id}/reports/list`, {
					params: {
						page: this.page
					}
				})
				.then(res => {
					this.reports.push(...res.data);
					this.page++;
					this.canLoadMore = res.data.length == 10;
				})
			},

			timeago(ts) {
				return App.util.format.timeAgo(ts);
			},

			actionMenu(index) {
				event.currentTarget.blur();

				swal({
					title: this.$t('groups.groupModeration.moderatorAction'),
					dangerMode: true,
					text: this.$t('groups.groupModeration.selectAction'),
					buttons: {
						ignore: {
							text: this.$t('groups.groupModeration.ignore'),
							className: "btn-warning",
							value: "ignore"
						},
						cw: {
							text: "NSFW",
							className: "btn-warning",
							value: "cw",
						},
						delete: {
							text: this.$t('common.delete'),
							className: "btn-danger",
							value: "delete",
						},
					},
				})
				.then((value) => {
					switch (value) {

						case "ignore":
							axios.post(`/api/v0/groups/${this.group.id}/report/action`, {
								action: 'ignore',
								id: this.reports[index].id
							}).then(res => {
								let report = this.reports[index];
								this.$emit('decrement', report.total_count);
								this.reports.splice(index, 1);
								this.$bvToast.toast(this.$t('groups.groupModeration.ignoredToast'), {
									title: this.$t('groups.groupModeration.moderationAction'),
									autoHideDelay: 5000,
									appendToast: true
								});
							})
						break;

						case "cw":
							axios.post(`/api/v0/groups/${this.group.id}/report/action`, {
								action: 'cw',
								id: this.reports[index].id
							}).then(res => {
								let report = this.reports[index];
								this.$emit('decrement', report.total_count);
								this.reports.splice(index, 1);
								this.$bvToast.toast(this.$t('groups.groupModeration.cwAppliedToast'), {
									title: this.$t('groups.groupModeration.moderationAction'),
									autoHideDelay: 5000,
									appendToast: true
								});
							})
						break;

						case "delete":
							swal(this.$t('groups.groupModeration.notImplementedTitle'), this.$t('groups.groupModeration.notImplementedText'), 'error');
						break;
					}
				});
			}
		}
	}
</script>

<style lang="scss">
	.group-moderation-component {
		min-height: 80vh;
		margin-bottom: 100px;
	}

	.popover-wide {
		min-width: 200px !important;
	}
</style>
