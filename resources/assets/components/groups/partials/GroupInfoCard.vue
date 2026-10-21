<template>
	<div class="group-info-card">
		<div class="card card-body mt-3 shadow-none border rounded-lg">
			<p class="title">{{ $t('groups.about.about') }}</p>

			<p v-if="group.description && group.description.length > 1" class="description" v-html="group.description"></p>
			<p v-else class="description">{{ $t('groups.about.noDescription') }}</p>

		</div>
		<div class="card card-body mt-3 shadow-none border rounded-lg">
			<div v-if="group.membership == 'all'" class="fact">
				<div class="fact-icon">
					<i class="fal fa-globe fa-lg"></i>
				</div>
				<div class="fact-body">
					<p class="fact-title">{{ $t('groups.about.public') }}</p>
					<p class="fact-subtitle">{{ $t('groups.about.publicHelp') }}</p>
				</div>
			</div>

			<div v-if="group.membership == 'private'" class="fact">
				<div class="fact-icon">
					<i class="fal fa-lock fa-lg"></i>
				</div>
				<div class="fact-body">
					<p class="fact-title">{{ $t('groups.about.private') }}</p>
					<p class="fact-subtitle">{{ $t('groups.about.privateHelp') }}</p>
				</div>
			</div>

			<div v-if="group.config.discoverable == true" class="fact">
				<div class="fact-icon">
					<i class="fal fa-eye fa-lg"></i>
				</div>
				<div class="fact-body">
					<p class="fact-title">{{ $t('groups.about.visible') }}</p>
					<p class="fact-subtitle">{{ $t('groups.about.visibleHelp') }}</p>
				</div>
			</div>

			<div v-if="group.config.discoverable == false" class="fact">
				<div class="fact-icon">
					<i class="fal fa-eye-slash fa-lg"></i>
				</div>
				<div class="fact-body">
					<p class="fact-title">{{ $t('groups.about.hidden') }}</p>
					<p class="fact-subtitle">{{ $t('groups.about.hiddenHelp') }}</p>
				</div>
			</div>

			<!-- <div class="fact">
				<div class="fact-icon">
					<i class="fal fa-map-marker-alt fa-lg"></i>
				</div>
				<div class="fact-body">
					<p class="fact-title">Fediverse</p>
					<p class="fact-subtitle">This group has not specified a location.</p>
				</div>
			</div> -->

			<div class="fact">
				<div class="fact-icon">
					<i class="fal fa-users fa-lg"></i>
				</div>
				<div class="fact-body">
					<p class="fact-title"">{{ group.category.name }}</p>
					<p class="fact-subtitle">{{ $t('groups.about.category') }}</p>
				</div>
			</div>

			<p class="mb-0 font-weight-light text-lighter">{{ $t('groups.about.created', { date: timestampFormat(group.created_at) }) }}</p>
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

		methods: {
			timestampFormat(date, showTime = false) {
				let ts = new Date(date);
				return showTime ? ts.toDateString() + ' · ' + ts.toLocaleTimeString() : ts.toDateString();
			}
		}
	}
</script>

<style lang="scss" scoped>
	.group-info-card {
		.title {
			font-size: 16px;
			font-weight: bold;
		}

		.description {
			font-size: 15px;
			font-weight:400;
			color: #6c757d;
			margin-bottom: 0;
			white-space: break-spaces;
		}

		.fact {
			display: flex;
			align-items: center;
			margin-bottom: 1.5rem;

			&-body {
				flex: 1;
			}

			&-icon {
				width: 50px;
				text-align: center;
			}

			&-title {
				font-size: 17px;
				font-weight: 500;
				margin-bottom: 0;
			}

			&-subtitle {
				font-size: 14px;
				margin-bottom: 0;
				color: #6c757d;
			}
		}
	}
</style>
