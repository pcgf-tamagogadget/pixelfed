<template>
	<b-modal
			ref="avatarUpdateModal"
			centered
			hide-footer
			header-class="py-2"
			body-class="p-0"
			title-class="w-100 text-center pl-4 font-weight-bold"
			title-tag="p"
			:title="$t('spa.updateAvatar.title')"
		>
		<input type="file" class="d-none" ref="avatarUpdateRef" @change="handleAvatarUpdate()" accept="image/jpg,image/png">
		<div class="d-flex align-items-center justify-content-center">
			<div
				v-if="avatarUpdateIndex === 0"
				class="py-5 user-select-none cursor-pointer"
				v-on:drop="handleDrop"
				v-on:dragover="handleDrop"
				@click="avatarUpdateStep(0)">
				<p class="text-center primary">
					<i class="fal fa-cloud-upload fa-3x"></i>
				</p>
				<p class="text-center lead">{{ $t('spa.updateAvatar.dropHere') }}</p>
				<i18n path="spa.updateAvatar.requirements" tag="p" class="text-center small text-muted mb-0"><template v-slot:png><strong>png</strong></template><template v-slot:jpg><strong>jpg</strong></template></i18n>
			</div>

			<div v-else-if="avatarUpdateIndex === 1" class="w-100 p-5">

				<div class="d-md-flex justify-content-between align-items-center">
					<div class="text-center mb-4">
						<p class="small font-weight-bold" style="opacity:0.7;">{{ $t('spa.updateAvatar.current') }}</p>
						<img :src="user.avatar" class="shadow" style="width: 150px;height: 150px;object-fit: cover;border-radius: 18px;opacity: 0.7;">
					</div>

					<div class="text-center mb-4">
						<p class="font-weight-bold">{{ $t('spa.updateAvatar.new') }}</p>
						<img :src="avatarUpdatePreview" class="shadow" style="width: 220px;height: 220px;object-fit: cover;border-radius: 18px;">
					</div>
				</div>

				<hr>

				<div class="d-flex justify-content-between">
					<button class="btn btn-light font-weight-bold btn-block mr-3" @click="avatarUpdateClear()">{{ $t('spa.updateAvatar.clear') }}</button>
					<button class="btn btn-primary primary font-weight-bold btn-block mt-0" @click="confirmUpload()">{{ $t('spa.updateAvatar.upload') }}</button>
				</div>
			</div>
		</div>
		</b-modal>
</template>

<script type="text/javascript">
	export default {
		props: ['user'],

		data() {
			return {
				loaded: false,
				avatarUpdateIndex: 0,
				avatarUpdateFile: undefined,
				avatarUpdatePreview: undefined
			}
		},

		methods: {
			open() {
				this.$refs.avatarUpdateModal.show();
			},

			avatarUpdateClose() {
				this.$refs.avatarUpdateModal.hide();
				this.avatarUpdateIndex = 0;
				this.avatarUpdateFile = undefined;
			},

			avatarUpdateClear() {
				this.avatarUpdateIndex = 0;
				this.avatarUpdateFile = undefined;
			},

			avatarUpdateStep(index) {
				this.$refs.avatarUpdateRef.click();
				this.avatarUpdateIndex = index;
			},

			handleAvatarUpdate() {
				let self = this;
				let files = event.target.files;
				Array.prototype.forEach.call(files, function(io, i) {
					self.avatarUpdateFile = io;
					self.avatarUpdatePreview = URL.createObjectURL(io);
					self.avatarUpdateIndex = 1;
				});
			},

			handleDrop(ev) {
				ev.preventDefault();
				let self = this;

				if (ev.dataTransfer.items) {
					for (var i = 0; i < ev.dataTransfer.items.length; i++) {
						if (ev.dataTransfer.items[i].kind === 'file') {
							var file = ev.dataTransfer.items[i].getAsFile();
							if(!file) {
								return;
							}
							self.avatarUpdateFile = file;
							self.avatarUpdatePreview = URL.createObjectURL(file);
							self.avatarUpdateIndex = 1;
						}
					}
				} else {
					for (var i = 0; i < ev.dataTransfer.files.length; i++) {
						if(!ev.dataTransfer.files[i].hasOwnProperty('name')) {
							return;
						}
						self.avatarUpdateFile = ev.dataTransfer.files[i];
						self.avatarUpdatePreview = URL.createObjectURL(ev.dataTransfer.files[i]);
						self.avatarUpdateIndex = 1;
					}
				}
			},

			confirmUpload() {
				if(!window.confirm(this.$t('spa.updateAvatar.confirm'))) {
					return;
				}

				let formData = new FormData();
				formData.append('_method', 'PATCH');
				formData.append('avatar', this.avatarUpdateFile);

				axios.post('/api/v1/accounts/update_credentials', formData)
				.then(res => {
					window._sharedData.user.avatar = res.data.avatar;
					this.avatarUpdateClose();
				})
				.catch(err => {
					if(err.response.data && err.response.data.errors) {
						if(err.response.data.errors.avatar && err.response.data.errors.avatar.length) {
							swal(this.$t('common.oops'), err.response.data.errors.avatar[0], 'error');
						}
					}
				})
			}
		}
	}
</script>
