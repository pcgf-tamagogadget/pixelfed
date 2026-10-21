<template>
	<div class="group-settings-component">
		<div v-if="!initalLoad">
			<p class="text-center mt-5 pt-5 font-weight-bold">{{ $t('common.loading') }}</p>
		</div>

		<div v-else>
			<div class="bg-white mb-3 border-bottom">
				<div class="container">
					<div class="col-12 group-settings-component-header">
						<div>
							<h1 class="font-weight-bold mb-4">{{ $t('groups.groupSettings.title') }}</h1>
							<p class="text-muted mb-0">
								<span v-once>
									<i class="fas fa-globe mr-1"></i>
									{{ group.membership == 'all' ? $t('groups.groupSettings.publicGroup') : $t('groups.groupSettings.privateGroup') }}
								</span>
								<span class="mx-2">
									·
								</span>
								<span>{{ group.member_count == 1 ? $t('groups.groupSettings.memberCount', { count: group.member_count }) : $t('groups.groupSettings.membersCount', { count: group.member_count }) }}</span>
								<span class="mx-2">
									·
								</span>
								<span class="text-lighter">ID:{{ group.id }}</span>
							</p>
						</div>
						<div>
							<a
								v-if="isAdmin"
								class="mr-2 btn btn-outline-secondary rounded-pill cta-btn font-weight-bold"
								:href="group.url">
								<i class="fas fa-chevron-left mr-1"></i> {{ $t('groups.groupSettings.backToGroup') }}
							</a>
							<button class="btn btn-primary font-weight-bold rounded-pill px-4" :disabled="savingChanges" @click="submit">
								{{ $t('groups.groupSettings.saveChanges') }}
							</button>
						</div>
					</div>
					<div class="col-12">
						<ul class="nav nav-tabs border-bottom-0 font-weight-bold small">
							<li class="nav-item">
								<a
									:class="{ active: tab == 'home'}"
									class="nav-link"
									href="#"
									@click.prevent="toggleTab('home')">
									{{ $t('groups.groupSettings.tabGeneral') }}
								</a>
							</li>
							<li class="nav-item">
								<a
									:class="{ active: tab == 'customize'}"
									class="nav-link"
									href="#"
									@click.prevent="toggleTab('customize')">
									{{ $t('groups.groupSettings.tabCustomize') }}
								</a>
							</li>
							<!-- <li class="nav-item">
								<a
									:class="{ active: tab == 'mod'}"
									class="nav-link"
									href="#"
									@click.prevent="toggleTab('mod')">
									Moderation
								</a>
							</li> -->
							<li class="nav-item">
								<a
									:class="{ active: tab == 'blocked'}"
									class="nav-link"
									href="#"
									@click.prevent="toggleTab('blocked')">
									{{ $t('groups.groupSettings.tabBlocks') }}
								</a>
							</li>
							<li class="nav-item">
								<a
									:class="{ active: tab == 'interactions'}"
									class="nav-link"
									href="#"
									@click.prevent="toggleTab('interactions')">
									{{ $t('groups.groupSettings.tabInteractions') }}
								</a>
							</li>
							<!-- <li class="nav-item">
								<a class="nav-link" href="#">Interaction Log</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Blocked Instances &amp; Users</a>
							</li> -->
							<li class="nav-item">
								<a
									:class="{ active: tab == 'limits'}"
									class="nav-link"
									href="#"
									@click.prevent="toggleTab('limits')">
									{{ $t('groups.groupSettings.tabLimits') }}
								</a>
							</li>
							<!-- <li class="nav-item">
								<a class="nav-link" href="#">Limits</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Roles</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Import &amp; Export</a>
							</li> -->
							<li class="nav-item">
								<a
									:class="{ active: tab == 'advanced'}"
									class="nav-link"
									href="#"
									@click.prevent="toggleTab('advanced')">
									{{ $t('groups.groupSettings.tabAdvanced') }}
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="container-xl pt-3">

				<div v-if="tab == 'home'" class="row">
					<div class="col-12 col-md-6 offset-md-3">
						<div class="">
							<div class="form-group">
								<label class="font-weight-bold">{{ $t('groups.groupSettings.name') }}</label>
								<input class="form-control" :value="group.name" disabled>
								<p class="form-text small text-muted">{{ $t('groups.groupSettings.nameHelp') }}</p>
							</div>
							<hr>

							<div class="form-group">
								<label class="font-weight-bold">{{ $t('groups.groupSettings.category') }}</label>
								<select class="custom-select" v-model="category">
									<option value="" selected="" disabled="">{{ $t('groups.groupSettings.selectCategory') }}</option>
									<option v-for="c in categories" :value="c">{{ c }}</option>
								</select>
								<p class="form-text small text-muted">{{ $t('groups.groupSettings.categoryHelp') }}</p>
							</div>
							<hr>

							<div class="form-group">
								<label class="font-weight-bold">{{ $t('groups.groupSettings.description') }}</label>
								<textarea class="form-control" rows="4" v-model="group.description" style="resize: none;">
								</textarea>
								<span class="form-text small text-muted font-weight-bold text-right">
									{{group.description ? group.description.length : 0}}/500
								</span>
								<p class="form-text small text-muted">{{ $t('groups.groupSettings.descriptionHelp') }}</p>
							</div>
							<!-- <hr>
							<div class="form-group">
								<label class="font-weight-bold">Avatar Photo</label>
								<div v-if="group.metadata && group.metadata.hasOwnProperty('avatar')" class="d-flex justify-content-between align-items-center">
									<img :src="group.metadata.avatar.url" width="100" height="100" class="rounded-circle border" style="object-fit: cover;">
									<p class="mb-0 mt-2 text-lighter">
										<a href="" class="text-muted font-weight-bold">
											Preview
										</a>
										<span class="mx-1">·</span>
										<a href="" class="text-muted font-weight-bold">
											Update
										</a>
										<span class="mx-1">·</span>
										<a href="" class="text-danger font-weight-bold">
											Delete
										</a>
									</p>
								</div>
								<div v-else>
									<div class="custom-file">
										<input type="file" class="custom-file-input" ref="avatarInput">
										<label class="custom-file-label" for="avatarInput">Choose file</label>
									</div>
									<p class="form-text small text-muted">Must be jpeg or png format, up to 2MB</p>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label class="font-weight-bold">Header Photo</label>

								<div v-if="group.metadata && group.metadata.hasOwnProperty('header')" class="d-flex justify-content-between align-items-center">
									<img :src="group.metadata.header.url" width="200" height="100" class="rounded border" style="object-fit: cover;">
									<p class="mb-0 mt-2 text-lighter">
										<a href="" class="text-muted font-weight-bold">
											Preview
										</a>
										<span class="mx-1">·</span>
										<a href="" class="text-muted font-weight-bold">
											Update
										</a>
										<span class="mx-1">·</span>
										<a href="" class="text-danger font-weight-bold">
											Delete
										</a>
									</p>
								</div>
								<div v-else>
									<div class="custom-file">
										<input type="file" class="custom-file-input" ref="headerInput">
										<label class="custom-file-label" for="headerInput">Choose file</label>
									</div>
									<p class="form-text small text-muted">Must be jpeg or png format, up to 10MB</p>
								</div>
							</div> -->
						</div>
					</div>
				</div>

				<div v-if="tab == 'customize'" class="row">
					<div class="col-12 col-md-6 offset-md-3">
						<div class="">
							<div class="form-group">
								<label class="font-weight-bold">{{ $t('groups.groupSettings.avatarPhoto') }}</label>
								<div v-if="group.metadata && group.metadata.hasOwnProperty('avatar')" class="d-flex justify-content-between align-items-center">
									<img :src="group.metadata.avatar.url" width="100" height="100" class="rounded-circle border" style="object-fit: cover;">
									<p class="mb-0 mt-2 text-lighter">
										<a href="" class="text-muted font-weight-bold">
											{{ $t('groups.groupSettings.preview') }}
										</a>
										<span class="mx-1">·</span>
										<a href="" class="text-muted font-weight-bold">
											{{ $t('groups.groupSettings.update') }}
										</a>
										<span class="mx-1">·</span>
										<a href="#" class="text-danger font-weight-bold" @click.prevent="handleDeleteAvatar()">
											{{ $t('common.delete') }}
										</a>
									</p>
								</div>
								<div v-else>
									<div class="custom-file">
										<input type="file" class="custom-file-input" ref="avatarInput">
										<label class="custom-file-label" for="avatarInput">{{ $t('groups.groupSettings.chooseFile') }}</label>
									</div>
									<p class="form-text small text-muted">{{ $t('groups.groupSettings.avatarHelp') }}</p>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label class="font-weight-bold">{{ $t('groups.groupSettings.headerPhoto') }}</label>

								<div v-if="group.metadata && group.metadata.hasOwnProperty('header')" class="d-flex justify-content-between align-items-center">
									<img :src="group.metadata.header.url" width="200" height="100" class="rounded border" style="object-fit: cover;">
									<p class="mb-0 mt-2 text-lighter">
										<a href="" class="text-muted font-weight-bold">
											{{ $t('groups.groupSettings.preview') }}
										</a>
										<span class="mx-1">·</span>
										<a href="" class="text-muted font-weight-bold">
											{{ $t('groups.groupSettings.update') }}
										</a>
										<span class="mx-1">·</span>
										<a href="#" class="text-danger font-weight-bold" @click.prevent="handleDeleteHeader()">
											{{ $t('common.delete') }}
										</a>
									</p>
								</div>
								<div v-else>
									<div class="custom-file">
										<input type="file" class="custom-file-input" ref="headerInput">
										<label class="custom-file-label" for="headerInput">{{ $t('groups.groupSettings.chooseFile') }}</label>
									</div>
									<p class="form-text small text-muted">{{ $t('groups.groupSettings.headerHelp') }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div v-if="tab == 'interactions'" class="row">
					<div class="col-12 col-md-3">
						<i18n path="groups.groupSettings.interactionLogIntro" tag="p" class="lead"><template v-slot:log><strong>{{ $t('groups.groupSettings.interactionLog') }}</strong></template></i18n>
						<p class="lead">{{ $t('groups.groupSettings.interactionLogRemote') }}</p>
					</div>
					<div class="col-12 col-md-6">
						<div class="list-group">
							<div v-for="(log, index) in interactionLog" class="list-group-item">
								<div class="media align-items-center">
									<img :src="log.profile.avatar" width="32" height="32" class="rounded-circle border mr-3" onerror="this.onerror=null;this.src='/storage/avatars/default.png?v=2'">
									<div class="media-body">
										<span class="font-weight-bold">{{log.profile.username}}</span>

										<i18n v-if="log.type == 'group:comment:created'" path="groups.groupSettings.logCommented" tag="span"><template v-slot:post><a :href="sidToUrl(log.metadata.status_id)" class="font-weight-bold">{{ $t('groups.groupSettings.logPost') }}</a></template></i18n>

										<span v-else-if="log.type == 'group:joined'">
											{{ $t('groups.groupSettings.logJoined') }}
										</span>

										<i18n v-else-if="log.type == 'group:like'" path="groups.groupSettings.logLiked" tag="span"><template v-slot:post><a :href="sidToUrl(log.metadata.status_id)" class="font-weight-bold">{{ $t('groups.groupSettings.logPost') }}</a></template></i18n>

										<i18n v-else-if="log.type == 'group:settings:updated'" path="groups.groupSettings.logSettingsUpdated" tag="span"><template v-slot:settings><a href="" class="font-weight-bold">{{ $t('groups.groupSettings.logGroupSettings') }}</a></template></i18n>

										<i18n v-else-if="log.type == 'group:status:created'" path="groups.groupSettings.logCreatedPost" tag="span"><template v-slot:post><a :href="sidToUrl(log.metadata.status_id)" class="font-weight-bold">{{ $t('groups.groupSettings.logPost') }}</a></template></i18n>

										<i18n v-else-if="log.type == 'group:status:deleted'" path="groups.groupSettings.logDeletedPost" tag="span"><template v-slot:post><a :href="sidToUrl(log.metadata.status_id)" class="font-weight-bold">{{ $t('groups.groupSettings.logPost') }}</a></template></i18n>

										<i18n v-else-if="log.type == 'group:unlike'" path="groups.groupSettings.logUnliked" tag="span"><template v-slot:post><a :href="sidToUrl(log.metadata.status_id)" class="font-weight-bold">{{ $t('groups.groupSettings.logPost') }}</a></template></i18n>

										<i18n v-else-if="log.type == 'group:admin:block:instance'" path="groups.groupSettings.logBlocked" tag="span"><template v-slot:target><span class="font-weight-bold text-primary">{{ log.metadata.domain }}</span></template></i18n>

										<i18n v-else-if="log.type == 'group:admin:block:user'" path="groups.groupSettings.logBlocked" tag="span"><template v-slot:target><a class="font-weight-bold text-primary" :href="'/' + log.metadata.username">{{ log.metadata.username }}</a></template></i18n>

										<i18n v-else-if="log.type == 'group:report:create'" path="groups.groupSettings.logReportCreated" tag="span"><template v-slot:report><a :href="reportUrl(log.metadata.report_id)" class="font-weight-bold">{{ $t('groups.groupSettings.logReport') }}</a></template><template v-slot:username><a :href="'/' + log.metadata.username" class="font-weight-bold">{{ log.metadata.username }}</a></template><template v-slot:post><a :href="log.metadata.url" class="font-weight-bold">{{ $t('groups.groupSettings.logPost') }}</a></template></i18n>

										<i18n v-else-if="log.type == 'group:moderation:action'" path="groups.groupSettings.logModAction" tag="span"><template v-slot:report><a :href="reportUrl(log.metadata.report_id)" class="font-weight-bold">{{ $t('groups.groupSettings.logModReport') }}</a></template><template v-slot:post><a :href="log.metadata.status_url" class="font-weight-bold">{{ $t('groups.groupSettings.logThisPost') }}</a></template></i18n>

										<i18n v-else-if="log.type =='group:member-limits:updated'" path="groups.groupSettings.logLimitsUpdated" tag="span"><template v-slot:limits><a :href="memberInteractionUrl(log.metadata.profile_id)" class="font-weight-bold">{{ $t('groups.groupSettings.logInteractionLimits') }}</a></template><template v-slot:username><a :href="'/' + log.metadata.username" class="font-weight-bold">{{ log.metadata.username }}</a></template></i18n>

										<span v-else>{{log.type}}</span>

										<div class="float-right text-muted small font-weight-bold">{{timeago(log.created_at)}}</div>
									</div>
								</div>
							</div>
							<div v-if="interactionLogShowMore" class="list-group-item">
								<button class="btn btn-light font-weight-bold btn-block" @click="loadMoreInteractions">{{ $t('groups.groupSettings.loadMore') }}</button>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-3">
						<p class="font-weight-bold small">{{ $t('groups.groupSettings.searchHeading') }}</p>
						<div class="form-group">
							<input class="form-control rounded-pill" :placeholder="$t('groups.groupSettings.searchPlaceholder')"/>
						</div>
						<hr>

						<p class="font-weight-bold small">{{ $t('groups.groupSettings.activitiesHeading') }}</p>

						<div class="form-check">
							<input class="form-check-input" type="checkbox" checked id="filter1">
							<label class="form-check-label font-weight-bold" for="filter1">
								{{ $t('groups.groupSettings.filterJoined') }}
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input" type="checkbox" checked id="filter1">
							<label class="form-check-label font-weight-bold" for="filter1">
								{{ $t('groups.groupSettings.filterLeft') }}
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input" type="checkbox" checked id="filter1">
							<label class="form-check-label font-weight-bold" for="filter1">
								{{ $t('groups.groupSettings.filterPosts') }}
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input" type="checkbox" checked id="filter1">
							<label class="form-check-label font-weight-bold" for="filter1">
								{{ $t('groups.groupSettings.filterComments') }}
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input" type="checkbox" checked id="filter1">
							<label class="form-check-label font-weight-bold" for="filter1">
								{{ $t('groups.groupSettings.filterLikes') }}
							</label>
						</div>

						<hr>

						<p class="font-weight-bold small">{{ $t('groups.groupSettings.filtersHeading') }}</p>

						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="filter1">
							<label class="form-check-label font-weight-bold" for="filter1">
								{{ $t('groups.groupSettings.filterLocalOnly') }}
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="filter1">
							<label class="form-check-label font-weight-bold" for="filter1">
								{{ $t('groups.groupSettings.filterRemoteOnly') }}
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="filter1">
							<label class="form-check-label font-weight-bold" for="filter1">
								{{ $t('groups.groupSettings.filterBlockedOnly') }}
							</label>
						</div>
					</div>
				</div>

				<div v-if="tab == 'blocked'" class="row">
					<div class="col-12 col-md-3">
						<p class="h5">{{ $t('groups.groupSettings.blockedTitle') }}</p>
						<p>{{ $t('groups.groupSettings.blockedIntro') }}</p>
						<p>{{ $t('groups.groupSettings.blockInstanceHelp') }}</p>
						<p>{{ $t('groups.groupSettings.blockUserHelp') }}</p>
						<p>{{ $t('groups.groupSettings.moderateInstanceHelp') }}</p>
					</div>
					<div class="col-12 col-md-6">
						<div class="card mb-3">
							<div class="card-header text-muted font-weight-bold small">{{ $t('groups.groupSettings.blockedInstances') }}</div>
							<div class="list-group list-group-flush">
								<div v-for="instance in blockedInstances" class="list-group-item d-flex justify-content-between align-items-center">
									<div>
										{{instance}}
									</div>
									<button class="btn btn-light" @click.prevent="undoBlock('instance', instance)">
										<i class="far fa-trash-alt text-lighter"></i>
									</button>
								</div>
								<div v-if="blockedInstances.length == 3" class="list-group-item">
									<p class="mb-0 small font-weight-bold text-lighter text-center">{{ $t('groups.groupSettings.viewAll') }}</p>
								</div>
							</div>
						</div>

						<div class="card mb-3">
							<div class="card-header text-muted font-weight-bold small">{{ $t('groups.groupSettings.blockedUsers') }}</div>
							<div class="list-group list-group-flush">
								<div v-for="instance in blockedUsers" class="list-group-item d-flex justify-content-between align-items-center">
									<div>
										<img src="/storage/avatars/default.jpg" width="32" height="32" class="rounded-circle border mr-3">{{instance}}
									</div>
									<button class="btn btn-light" @click.prevent="undoBlock('user', instance)">
										<i class="far fa-trash-alt text-lighter"></i>
									</button>
								</div>
								<div v-if="blockedUsers.length == 3" class="list-group-item">
									<p class="mb-0 small font-weight-bold text-lighter text-center">{{ $t('groups.groupSettings.viewAll') }}</p>
								</div>
							</div>
						</div>

						<div class="card mb-3">
							<div class="card-header text-muted font-weight-bold small">{{ $t('groups.groupSettings.moderatedJoinRequests') }}</div>
							<div class="list-group list-group-flush">
								<div v-for="instance in moderatedInstances" class="list-group-item d-flex justify-content-between align-items-center">
									<div>
										{{instance}}
									</div>
									<button class="btn btn-light" @click.prevent="undoBlock('moderate', instance)">
										<i class="far fa-trash-alt text-lighter"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-3">
						<button class="btn btn-light border btn-block font-weight-bold" @click.prevent="blockAction('instance')">{{ $t('groups.groupSettings.blockInstance') }}</button>
						<button class="btn btn-light border btn-block font-weight-bold" @click.prevent="blockAction('user')">{{ $t('groups.groupSettings.blockUser') }}</button>
						<button class="btn btn-light border btn-block font-weight-bold" @click.prevent="blockAction('moderate')">{{ $t('groups.groupSettings.moderateJoinRequests') }}</button>
						<hr>
						<button class="btn btn-light border btn-block font-weight-bold">{{ $t('groups.groupSettings.import') }}</button>
						<button class="btn btn-light border btn-block font-weight-bold" @click.prevent="exportBlocks()">{{ $t('groups.groupSettings.export') }}</button>
					</div>
				</div>

				<div v-if="tab == 'advanced'" class="row">
					<div class="col-12 col-md-6 offset-md-3">

						<div class="mt-3">
							<div class="form-group">
								<label class="font-weight-bold">{{ $t('groups.groupSettings.membership') }}</label>
								<select class="form-control rounded-pill" v-model="group.membership">
									<option value="all">{{ $t('groups.groupSettings.membershipPublic') }}</option>
									<option value="private">{{ $t('groups.groupSettings.membershipPrivate') }}</option>
									<option value="local">{{ $t('groups.groupSettings.membershipLocal') }}</option>
								</select>

								<p class="help-text mt-1">
									{{ membershipDescription[group.membership] }}
								</p>
							</div>
							<!-- <hr>
							<div class="form-group">
								<label class="font-weight-bold">Post Types</label>
								<div class="custom-control custom-checkbox mb-2">
									<input type="checkbox" class="custom-control-input" id="textType" checked disabled>
									<label class="custom-control-label" for="textType">Text</label>
								</div>
								<div class="custom-control custom-checkbox mb-2">
									<input type="checkbox" class="custom-control-input" id="photoType" checked>
									<label class="custom-control-label" for="photoType">Photos</label>
								</div>
								<div class="custom-control custom-checkbox mb-2">
									<input type="checkbox" class="custom-control-input" id="videoType" checked>
									<label class="custom-control-label" for="videoType">Videos</label>
								</div>
								<div class="custom-control custom-checkbox mb-2">
									<input type="checkbox" class="custom-control-input" id="pollType" checked>
									<label class="custom-control-label" for="pollType">Polls</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="eventType" disabled>
									<label class="custom-control-label" for="eventType">Events</label>
								</div>
							</div> -->
						</div>

						<hr>

						<div v-if="group.membership !== 'local'" class="form-group row">
							<div class="col-sm-12">
								<div class="mb-1">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" v-model="advanced.activitypub">
										<label class="form-check-label font-weight-bold text-dark text-capitalize ml-1">{{ $t('groups.groupSettings.enableActivityPub') }}</label>
									</div>
								</div>

								<transition name="fade">
									<div v-if="!advanced.activitypub" class="alert alert-info mt-2">
										<div class="media align-items-center">
											<i class="far fa-exclamation-circle fa-2x mr-3"></i>
											<div class="media-body">
												<p class="font-weight-bold mb-0">{{ $t('groups.groupSettings.federationWarning') }}</p>
												<p class="small mb-0" style="font-weight:600;">{{ $t('groups.groupSettings.federationWarningHelp') }}</p>
											</div>
										</div>
									</div>
								</transition>
							</div>
						</div>

						<hr v-if="group.membership !== 'local'">

						<div class="form-group row">
							<div class="col-sm-12">
								<div class="mb-1">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" v-model="advanced.is_nsfw">
										<label class="form-check-label font-weight-bold text-dark text-capitalize ml-1">{{ $t('groups.groupSettings.allowAdultContent') }}</label>
									</div>
								</div>

								<transition name="fade">
									<div v-if="!advanced.is_nsfw" class="alert alert-info mt-2">
										<div class="media align-items-center">
											<i class="far fa-exclamation-circle fa-2x mr-3"></i>
											<div class="media-body">
												<p class="font-weight-bold mb-0">{{ $t('groups.groupSettings.adultContentWarning') }}</p>
												<p class="small mb-0" style="font-weight:600;">{{ $t('groups.groupSettings.adultContentWarningHelp') }}</p>
											</div>
										</div>
									</div>
								</transition>
							</div>
						</div>

						<hr>

						<div class="form-group row">
							<div class="col-sm-12">
								<div class="mb-1">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" v-model="advanced.discoverable">
										<label class="form-check-label font-weight-bold text-dark text-capitalize ml-1">{{ $t('groups.groupSettings.makeDiscoverable') }}</label>
									</div>

									<p class="help-text small text-muted">
										<span>
											{{ $t('groups.groupSettings.discoverableHelp') }}
										</span>
									</p>
								</div>
							</div>
							<hr>
						</div>


						<div v-if="group.member_count >= 25" class="form-group row">
							<div class="col-sm-12">
								<div class="mb-1">
									<div class="form-check">
										<input class="form-check-input" type="checkbox">
										<label class="form-check-label font-weight-bold text-dark text-capitalize ml-1">{{ $t('groups.groupSettings.enableSpamDetection') }}</label>
									</div>

									<p class="help-text small text-muted">
										<span>
											{{ $t('groups.groupSettings.spamDetectionHelp') }} <strong>{{ $t('groups.groupSettings.spamDetectionWarning') }}</strong>
										</span>
									</p>
								</div>
							</div>
							<hr>
						</div>


						<div v-if="group.member_count >= 25"  class="form-group row">
							<div class="col-sm-12">
								<div class="mb-1">
									<div class="form-check">
										<input class="form-check-input" type="checkbox">
										<label class="form-check-label font-weight-bold text-dark text-capitalize ml-1">{{ $t('groups.groupSettings.enableAdminDm') }}</label>
									</div>

									<p class="help-text small text-muted">
										<i18n path="groups.groupSettings.adminDmHelp" tag="span"><template v-slot:audience>{{ group.membership == 'local' ? $t('groups.groupSettings.audienceLocal') : group.membership == 'private' ? $t('groups.groupSettings.audienceMembers') : $t('groups.groupSettings.audienceAnyone') }}</template><template v-slot:dm><a href="#">{{ $t('groups.groupSettings.directMessage') }}</a></template></i18n>
									</p>
								</div>
							</div>
							<hr>
						</div>


						<h4 class="font-weight-bold pt-3">{{ $t('groups.groupSettings.dangerZone') }}</h4>
						<div class="mb-4 border rounded border-danger">
							<ul class="list-group mb-0 pb-0">
								<li class="list-group-item border-left-0 border-right-0 py-3 d-flex justify-content-between disabled">
									<div>
										<p class="font-weight-bold mb-1">{{ $t('groups.groupSettings.disableGroup') }}</p>
										<p class="mb-0 small">{{ $t('groups.groupSettings.notAvailable') }}</p>
									</div>
									<div>
										<a class="btn btn-outline-danger font-weight-bold py-1" href="#">{{ $t('groups.groupSettings.disable') }}</a>
									</div>
								</li>
								<li class="list-group-item border-left-0 border-right-0 py-3 d-flex justify-content-between">
									<div>
										<p class="font-weight-bold mb-1">{{ $t('groups.groupSettings.deleteGroup') }}</p>
										<p class="mb-0 small">{{ $t('groups.groupSettings.deleteGroupHelp') }}</p>
									</div>
									<div>
										<button class="btn btn-outline-danger font-weight-bold py-1" @click="deleteGroup">{{ $t('groups.groupSettings.deleteGroup') }}</button>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div v-if="tab == 'limits'" class="row">
					<div class="col-12 col-md-6 offset-md-3">
						<div class="mt-3">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: {
			groupId: {
				type: String
			}
		},

		data() {
			return {
				initalLoad: false,
				profile: undefined,
				group: {},
				isMember: false,
				isAdmin: false,
				changed: false,
				savingChanges: false,
				categories: [],
				category: 'General',
				tab: 'home',
				tabs: [
					'home',
					'customize',
					'interactions',
					'blocked',
					'advanced',
					'limits',
					'blocked:import'
				],
				interactionLog: [],
				interactionLogPage: 1,
				interactionLogInitialLoad: false,
				interactionLogShowMore: true,
				blockedInitialLoad: false,
				blockedInstances: [
					'facebook.com',
					'instagram.com'
				],
				blockedUsers: [
					'mark@facebook.com',
					'user@example.org',
					'troll'
				],
				moderatedInstances: [
					'pawoo.net',
					'pixelfed.com'
				],
				importBlocksData: {},
				importBlocksUploaded: false,
				advanced: {}
			};
		},

		computed: {
			membershipDescription() {
				return {
					all: this.$t('groups.groupSettings.membershipAll'),
					local: this.$t('groups.groupSettings.membershipLocalHelp'),
					private: this.$t('groups.groupSettings.membershipPrivateHelp')
				};
			}
		},

		beforeMount() {
			axios.get('/api/v0/groups/categories/list')
				.then(res => {
					this.categories = res.data;
				})
		},

		mounted() {
			let u = new URLSearchParams(window.location.search);

			if(u.has('tab') && this.tabs.includes(u.get('tab'))) {
				this.tab = u.get('tab');
				this.toggleTab(this.tab);
			}

			axios.get('/api/pixelfed/v1/accounts/verify_credentials')
			.then(res => {
				this.profile = res.data;

				axios.get('/api/v0/groups/' + this.groupId)
				.then(res => {
					this.group = res.data;
					this.initalLoad = true;
					this.isMember = res.data.self.is_member;
					this.isAdmin = ['founder', 'admin'].includes(res.data.self.role);
					this.advanced = res.data.config;
					this.category = res.data.category.name;
				})
			});
		},

		methods: {
			timestampFormat(date, showTime = false) {
				let ts = new Date(date);
				return showTime ? ts.toDateString() + ' · ' + ts.toLocaleTimeString() : ts.toDateString();
			},

			timeago(ts) {
				return window.App.util.format.timeAgo(ts);
			},

			sidToUrl(sid) {
				return `/groups/${this.groupId}/p/${sid}`;
			},

			submit() {
				this.savingChanges = true;

				let formData = new FormData();
				formData.append('category', this.category);
				formData.append('membership', this.group.membership);
				formData.append('discoverable', this.advanced.discoverable);
				formData.append('activitypub', this.advanced.activitypub);
				formData.append('is_nsfw', this.advanced.is_nsfw);

				if(this.group.description) {
					formData.append('description', this.group.description);
				}

				if(this.$refs.avatarInput) {
					formData.append('avatar', this.$refs.avatarInput.files[0]);
				}

				if(this.$refs.headerInput) {
					formData.append('header', this.$refs.headerInput.files[0]);
				}

				axios.post('/api/v0/groups/' + this.group.id + '/settings', formData)
				.then(res => {
					this.savingChanges = false;
					this.group = res.data;
					swal(this.$t('groups.groupSettings.updatedTitle'), this.$t('groups.groupSettings.updatedMsg'), 'success');
				}).catch(err => {
					this.savingChanges = false;
					console.log(err.response);
					swal(this.$t('common.oops'), this.$t('groups.groupSettings.saveError'), 'error');
				});
			},

			toggleTab(tab) {
				if(event) {
					event.currentTarget.blur();
				}

				switch(tab) {
					case 'home':
						this.tab = 'home';
						history.pushState(null, null, `/groups/${this.groupId}/settings`);
					break;

					case 'customize':
						this.tab = 'customize';
						history.pushState(null, null, `/groups/${this.groupId}/settings?tab=customize`);
					break;

					case 'limits':
						this.tab = 'limits';
						history.pushState(null, null, `/groups/${this.groupId}/settings?tab=limits`);
					break;

					case 'interactions':
						if(!this.interactionLogInitialLoad) {
							this.loadInteractions();
						}
						this.tab = 'interactions';
						history.pushState(null, null, `/groups/${this.groupId}/settings?tab=interactions`);
					break;

					case 'blocked':
						if(!this.blockedInitialLoad) {
							this.loadBlocks();
						}
						this.tab = 'blocked';
						history.pushState(null, null, `/groups/${this.groupId}/settings?tab=blocked`);
					break;

					case 'advanced':
						this.tab = 'advanced';
						history.pushState(null, null, `/groups/${this.groupId}/settings?tab=advanced`);
					break;

					default:
						this.tab = 'home';
						history.pushState(null, null, `/groups/${this.groupId}/settings`);
					break;
				}
			},

			loadInteractions() {
				axios.get('/api/v0/groups/' + this.groupId + '/admin/interactions')
				.then(res => {
					this.interactionLog = res.data;
					this.interactionLogPage++;
					this.interactionLogInitialLoad = true;
				});
			},

			loadMoreInteractions() {
				axios.get('/api/v0/groups/' + this.groupId + '/admin/interactions', {
					params: {
						page: this.interactionLogPage
					}
				}).then(res => {
					if(res.data.length == 0) {
						this.interactionLogShowMore = false;
						return;
					}
					this.interactionLog.push(...res.data);
					this.interactionLogPage++;
				})
			},

			loadBlocks() {
				axios.get(`/api/v0/groups/${this.groupId}/admin/blocks`)
				.then(res => {
					this.blockedInstances = res.data.instances;
					this.blockedUsers = res.data.users;
					this.moderatedInstances = res.data.moderated;
					this.blockedInitialLoad = true;
				})
			},

			blockAction(action) {
				let type = action == 'user' ? 'user' : 'instance domain';

				swal({
					text: type == 'user' ? this.$t('groups.groupSettings.whichUser') : this.$t('groups.groupSettings.whichInstance'),
					content: {
						element: 'input',
						attributes: {
      						placeholder: type == 'user' ? 'pixelfed' : 'pixelfed.org'
      					}
					},
					button: {
						text: this.$t('common.next'),
						closeModal: false,
					},
				})
				.then(name => {
					if (!name) throw null;
					if(action !== 'user' && name.startsWith('http')) {
						swal(this.$t('common.oops'), this.$t('groups.groupSettings.enterInstanceDomain'), 'error');
						return null;
					}
					return name;
				}).then(name => {
					return axios.post('/api/v0/groups/' + this.groupId + '/admin/mbs', {
						type: action == 'user' ? 'user' : 'instance',
						item: name
					}).then(res => {
						if(res.data) {
							return name;
						} else {
							swal.stopLoading();
							swal.close();
							return null;
						}
					}).catch(err => {
						swal.stopLoading();
						swal.close();
						return null;
					});
				}).then(name => {
					if(!name) {
						this.$bvToast.toast(action == 'user' ? this.$t('groups.groupSettings.invalidUser') : this.$t('groups.groupSettings.invalidInstance'), {
							title: this.$t('common.error'),
							variant: 'danger',
							autoHideDelay: 5000
						});
						return;
					}
					swal({
						title: this.$t('groups.groupSettings.areYouSure'),
						text: action === 'moderate' ? this.$t('groups.groupSettings.confirmModerate', { name: name }) : this.$t('groups.groupSettings.confirmLimit', { name: name }),
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((confirm) => {
						if (confirm) {
							axios.post('/api/v0/groups/' + this.groupId + '/admin/blocks/add', {
								item: name,
								type: action
							}).then(res => {
								switch(action) {
									case 'instance':
										this.blockedInstances.push(name);
									break;

									case 'user':
										this.blockedUsers.push(name);
									break;

									case 'moderate':
										this.moderatedInstances.push(name);
									break;
								}
								// swal("Poof! Your imaginary file has been deleted!", {
								// 	icon: "success",
								// });
							})
						}
					});
				});
			},

			reportUrl(report) {
				return `/groups/${this.groupId}/moderation?tab=view&id=${report}`;
			},

			memberInteractionUrl(pid) {
				return `/groups/${this.groupId}/members?a=il&pid=${pid}`;
			},

            handleDeleteAvatar() {
                if(!window.confirm(this.$t('groups.groupSettings.confirmDeleteAvatar'))) {
                    return;
                }
                this.savingChanges = true;
                axios.post('/api/v0/groups/' + this.group.id + '/settings/delete-avatar')
                .then(res => {
                    this.savingChanges = false;
                    this.group = res.data;
                });
            },

			handleDeleteHeader() {
				if(!window.confirm(this.$t('groups.groupSettings.confirmDeleteHeader'))) {
					return;
				}
				this.savingChanges = true;
				axios.post('/api/v0/groups/' + this.group.id + '/settings/delete-header')
				.then(res => {
					this.savingChanges = false;
					this.group = res.data;
				});
			},

			undoBlock(type, val) {
				let text = type == 'moderate' ? this.$t('groups.groupSettings.confirmUnblock', { item: val }) : this.$t('groups.groupSettings.confirmAllowJoin', { item: val });
				swal({
					'title': this.$t('groups.groupSettings.confirm'),
					'text': text,
					'buttons': {
						cancel: {
							text: this.$t('common.cancel'),
							value: null,
							visible: true,
							className: "",
							closeModal: true,
						},
						confirm: {
							text: this.$t('common.proceed'),
							value: true,
							visible: true,
							className: "",
							closeModal: true
						}
					}
				}).then(res => {
					if(res) {
						axios.post(`/api/v0/groups/${this.groupId}/admin/blocks/undo`, {
							item: val,
							type: type
						}).then(res => {
							switch(type) {
								case 'instance':
									this.blockedInstances = this.blockedInstances.filter(i => {
										return i != val;
									})
								break;

								case 'user':
									this.blockedUsers = this.blockedUsers.filter(i => {
										return i != val;
									})
								break;

								case 'moderate':
									this.moderatedInstances = this.moderatedInstances.filter(i => {
										return i != val;
									})
								break;
							}
						})
					}
				});
			},

			exportBlocks() {
				event.currentTarget.blur();
				axios({
					url: '/api/v0/groups/'+this.groupId+'/admin/blocks/export',
					method: 'POST',
					responseType: 'blob',
				}).then((response) => {
					const url = window.URL.createObjectURL(new Blob([response.data]));
					const link = document.createElement('a');
					link.href = url;
					link.setAttribute('download', `pixelfed-group-blocks-${Date.now()}.json`);
					document.body.appendChild(link);
					link.click();
				});
			},

			deleteGroup() {
				axios.post('/api/v0/groups/delete', {
					gid: this.groupId
				})
				.then(res => {
					location.href = `/groups/${this.groupId}`;
				})
			}
		}
	}
</script>

<style lang="scss">
	.group-settings-component {
		&-header {
			display: flex;
			justify-content: space-between;
			align-items: flex-end;
			padding: 2rem 1rem 1rem 1rem;
			background-color: #fff;

			.cta-btn {
				min-width: 140px;
			}
		}
	}
</style>
