<template>
<div class="container d-flex justify-content-center">
  <div class="error-page py-5 my-5" style="max-width: 450px;">
    <h3 class="font-weight-bold">404 &nbsp; {{ $t('spa.notFound.title') }}</h3>
    <p class="lead">{{ $t('spa.notFound.lead') }}</p>

    <div class="text-muted">
		<p class="mb-1">{{ $t('spa.notFound.reasons') }}</p>
		<ul>
			<li>{{ $t('spa.notFound.reasonInvalidUrl') }}</li>
			<li>{{ $t('spa.notFound.reasonFlagged') }}</li>
			<li>{{ $t('spa.notFound.reasonDeleted') }}</li>
			<li>{{ $t('spa.notFound.reasonNoPermission') }}</li>
		</ul>
    </div>
  </div>
  <drawer />
</div>
</template>

<script type="text/javascript">
	import Drawer from './partials/drawer.vue';

	export default {
		components: {
			"drawer": Drawer
		}
	}
</script>
