<style scoped>

</style>

<template>
    <div class="card mb-4">
      <div class="card-header bg-white">
        <span class="font-weight-bold h5">{{ $t('classic.followSuggestions.title') }}</span>
        <span class="small float-right font-weight-bold">
          <a href="javascript:void(0);" class="pr-2" v-on:click="fetchData">{{ $t('classic.followSuggestions.refresh') }}</a>
        </span>
      </div>
      <div class="card-body">
        <div v-if="results.length == 0">
          <i18n path="classic.followSuggestions.empty" tag="p" class="mb-0 font-weight-bold">
            <template v-slot:discover><a href="/discover">{{ $t('classic.followSuggestions.discover') }}</a></template>
          </i18n>
        </div>
        <div v-for="(user, index) in results">
          <div class="media " style="width:100%">
            <img class="mr-3" :src="user.avatar" width="40px">
            <div class="media-body" style="width:70%">
              <p class="my-0 font-weight-bold text-truncate" style="text-overflow: hidden">{{user.acct}} <span class="text-muted font-weight-normal">&commat;{{user.username}}</span></p>
              <a class="btn btn-outline-primary px-3 py-0" :href="user.url" style="border-radius:20px;">{{ $t('classic.followSuggestions.follow') }}</a>
            </div>
          </div>
          <div v-if="index != results.length - 1"><hr></div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            results: {},
        };
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      fetchData() {
          axios.get('/api/local/i/follow-suggestions')
            .then(response => {
                this.results = response.data;
            });
      }
    }
}
</script>