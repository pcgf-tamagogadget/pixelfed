<template>
	<div class="col-12 col-md-9" style="height: 100vh - 51px !important;overflow:hidden">
		<div class="row h-100 bg-lighter">
			<div class="col-12 col-md-8 border-left">
				<div class="d-flex justify-content-center">
					<div class="p-4 mb-4">
						<p class="h4 font-weight-bold mb-1">{{ $t('groups.selfRemoteSearch.title') }}</p>
						<p class="lead text-muted">{{ $t('groups.selfRemoteSearch.subtitle') }}</p>
					</div>
				</div>
				<div class="mb-5">
					<div class="p-4 mb-4">
						<div class="form-group">
							<label>{{ $t('groups.selfRemoteSearch.groupUrl') }}</label>
							<input type="text" class="form-control form-control-lg rounded-pill bg-white border" placeholder="https://pixelfed.social/groups/328323406233735168" v-model="q">
						</div>
						<button class="btn btn-primary btn-block btn-lg rounded-pill font-weight-bold">{{ $t('groups.selfRemoteSearch.search') }}</button>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 bg-white border-left">
				<div class="my-4">
					<h4 class="font-weight-bold">{{ $t('groups.selfRemoteSearch.tips') }}</h4>
					<ul class="pl-3">
						<li class="font-weight-bold">{{ $t('groups.selfRemoteSearch.tipUnsupported') }}*</li>
						<li>{{ $t('groups.selfRemoteSearch.tipRules') }}</li>
						<i18n path="groups.selfRemoteSearch.tipFullUrl" tag="li"><template v-slot:groupUrl><span class="font-weight-bold">{{ $t('groups.selfRemoteSearch.groupUrl') }}</span></template><template v-slot:scheme><code>https://</code></template></i18n>
						<li>{{ $t('groups.selfRemoteSearch.tipPrivate') }}</li>
						<li>{{ $t('groups.selfRemoteSearch.tipInvite') }}</li>
						<li>{{ $t('groups.selfRemoteSearch.tipTerminated') }}</li>
					</ul>
					<p class="small">* {{ $t('groups.selfRemoteSearch.compatNote') }}</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data() {
			return {
				q: undefined
			}
		}
	}
</script>
