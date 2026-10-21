<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <div class="card card-default mb-4">
            <div class="card-header font-weight-bold bg-white">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        {{ $t('classic.clients.title') }}
                    </span>

                    <a class="action-link" tabindex="-1" @click="showCreateClientForm">
                        {{ $t('classic.clients.createNew') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Current Clients -->
                <p class="mb-0 font-weight-bold text-center lead p-5" v-if="clients.length === 0">
                    {{ $t('classic.clients.empty') }}
                </p>

                <table class="table table-borderless mb-0" v-if="clients.length > 0">
                    <thead>
                        <tr>
                            <th>{{ $t('classic.clients.clientId') }}</th>
                            <th>{{ $t('classic.clients.name') }}</th>
                            <th>{{ $t('classic.clients.secret') }}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="client in clients">
                            <!-- ID -->
                            <td style="vertical-align: middle;">
                                {{ client.id }}
                            </td>

                            <!-- Name -->
                            <td style="vertical-align: middle;">
                                {{ client.name }}
                            </td>

                            <!-- Secret -->
                            <td style="vertical-align: middle;">
                                <code v-if="client.plain_secret">{{ client.plain_secret }}</code>
                                <span v-else class="text-muted font-italic">{{ $t('classic.clients.hiddenSecret') }}</span>
                            </td>

                            <!-- Edit Button -->
                            <td style="vertical-align: middle;">
                                <a class="btn btn-outline-secondary btn-sm py-1" tabindex="-1" @click="edit(client)">
                                    {{ $t('classic.clients.edit') }}
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td style="vertical-align: middle;">
                                <a class="btn btn-outline-danger btn-sm py-1" @click.prevent="destroy(client)" href="#">
                                    {{ $t('classic.clients.delete') }}
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Client Secret Modal -->
        <div class="modal fade" id="modal-client-secret" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ $t('classic.clients.clientCreated') }}
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <strong>{{ $t('classic.clients.important') }}</strong> {{ $t('classic.clients.copySecretNotice') }}
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">{{ $t('classic.clients.clientId') }}</label>
                            <input type="text" class="form-control" :value="newClientId" readonly>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">{{ $t('classic.clients.clientSecret') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" :value="newClientSecret" readonly ref="secretInput">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" @click="copySecret">
                                        {{ $t('classic.clients.copy') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary font-weight-bold" data-dismiss="modal">{{ $t('classic.clients.done') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Client Modal -->
        <div class="modal fade" id="modal-create-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ $t('classic.clients.createClient') }}
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p class="mb-0"><strong>{{ $t('classic.clients.whoops') }}</strong> {{ $t('classic.clients.somethingWentWrong') }}</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ $t('classic.clients.name') }}</label>

                                <div class="col-md-9">
                                    <input id="create-client-name" type="text" class="form-control" autocomplete="off"
                                                                @keyup.enter="store" v-model="createForm.name">

                                    <span class="form-text text-muted">
                                        {{ $t('classic.clients.nameHelp') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ $t('classic.clients.description') }}</label>

                                <div class="col-md-9">
                                    <textarea class="form-control" rows="3"></textarea>

                                    <span class="form-text text-muted">
                                        {{ $t('classic.clients.descriptionHelp') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ $t('classic.clients.website') }}</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" autocomplete="off">

                                    <span class="form-text text-muted">
                                        {{ $t('classic.clients.websiteHelp') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Redirect URL -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ $t('classic.clients.redirectUrl') }}</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="redirect"
                                                    @keyup.enter="store" v-model="createForm.redirect">

                                    <span class="form-text text-muted">
                                        {{ $t('classic.clients.redirectUrlHelp') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ $t('classic.clients.scopes') }}</label>

                                <div class="col-md-9">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                      <label class="custom-control-label" for="customSwitch1">{{ $t('classic.clients.read') }}</label>
                                    </div>

                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                      <label class="custom-control-label" for="customSwitch2">{{ $t('classic.clients.write') }}</label>
                                    </div>

                                    <span class="form-text text-muted">
                                        {{ $t('classic.clients.scopesHelp') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">{{ $t('classic.clients.close') }}</button>

                        <button type="button" class="btn btn-primary font-weight-bold" @click="store">
                            {{ $t('classic.clients.create') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Client Modal -->
        <div class="modal fade" id="modal-edit-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ $t('classic.clients.editClient') }}
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p class="mb-0"><strong>{{ $t('classic.clients.whoops') }}</strong> {{ $t('classic.clients.somethingWentWrong') }}</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Client Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ $t('classic.clients.name') }}</label>

                                <div class="col-md-9">
                                    <input id="edit-client-name" type="text" class="form-control"
                                                                @keyup.enter="update" v-model="editForm.name">

                                    <span class="form-text text-muted">
                                        {{ $t('classic.clients.nameHelp') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Redirect URL -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ $t('classic.clients.redirectUrl') }}</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="redirect"
                                                    @keyup.enter="update" v-model="editForm.redirect">

                                    <span class="form-text text-muted">
                                        {{ $t('classic.clients.redirectUrlHelp') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $t('classic.clients.close') }}</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            {{ $t('classic.clients.saveChanges') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                clients: [],

                newClientId: '',
                newClientSecret: '',

                createForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                }
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getClients();

                $('#modal-create-client').on('shown.bs.modal', () => {
                    $('#create-client-name').focus();
                });

                $('#modal-edit-client').on('shown.bs.modal', () => {
                    $('#edit-client-name').focus();
                });
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getClients() {
                axios.get('/oauth/clients')
                        .then(response => {
                            this.clients = response.data;
                        });
            },

            /**
             * Show the form for creating new clients.
             */
            showCreateClientForm() {
                $('#modal-create-client').modal('show');
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/oauth/clients',
                    this.createForm, '#modal-create-client'
                );
            },

            /**
             * Edit the given client.
             */
            edit(client) {
                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.redirect = client.redirect;

                $('#modal-edit-client').modal('show');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/oauth/clients/' + this.editForm.id,
                    this.editForm, '#modal-edit-client'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        // If this was a creation (POST), show the secret to the user
                        if (method === 'post' && response.data.plain_secret) {
                            this.newClientId = response.data.id;
                            this.newClientSecret = response.data.plain_secret;
                        }

                        this.getClients();

                        form.name = '';
                        form.redirect = '';
                        form.errors = [];

                        $(modal).modal('hide');

                        // Show the secret modal after creation
                        if (method === 'post' && this.newClientSecret) {
                            this.$nextTick(() => {
                                $('#modal-client-secret').modal('show');
                            });
                        }
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            form.errors = [this.$t('classic.clients.genericError')];
                        }
                    });
            },

            /**
             * Copy the client secret to clipboard.
             */
            copySecret() {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(this.newClientSecret);
                } else {
                    this.$refs.secretInput.select();
                    document.execCommand('copy');
                }
            },

            /**
             * Destroy the given client.
             */
            destroy(client) {
                if (!confirm(this.$t('classic.clients.confirmDelete'))) {
                    return;
                }

                axios.delete('/oauth/clients/' + client.id)
                    .then(response => {
                        this.getClients();
                    })
                    .catch(error => {
                        if (error.response && error.response.data && error.response.data.error) {
                            alert(error.response.data.error);
                        } else {
                            alert(this.$t('classic.clients.deleteError'));
                        }
                    });
            }
        }
    }
</script>
