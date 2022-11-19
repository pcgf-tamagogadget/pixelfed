"use strict";(self.webpackChunkpixelfed=self.webpackChunkpixelfed||[]).push([[336],{2519:(t,e,s)=>{s.r(e),s.d(e,{default:()=>o});var a=s(87757),i=s.n(a);function n(t,e,s,a,i,n,o){try{var r=t[n](o),l=r.value}catch(t){return void s(t)}r.done?e(l):Promise.resolve(l).then(a,i)}const o={props:["initialData"],data:function(){return{loading:!0,isAuthed:void 0,user:void 0,settings:void 0,post:void 0,profile:void 0,settingsUrl:window._portfolio.path+"/settings"}},mounted:function(){var t=JSON.parse(this.initialData);this.post=t.post,this.profile=t.profile,this.isAuthed=t.authed,this.fetchUser()},methods:{fetchUser:function(){var t,e=this;return(t=i().mark((function t(){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e.isAuthed){t.next=3;break}return t.next=3,axios.get("/api/v1/accounts/verify_credentials").then((function(t){e.user=t.data})).catch((function(t){}));case 3:return t.next=5,axios.get("/api/portfolio/account/settings.json",{params:{id:e.profile.id}}).then((function(t){e.settings=t.data})).then((function(){setTimeout((function(){e.loading=!1}),500)}));case 5:case"end":return t.stop()}}),t)})),function(){var e=this,s=arguments;return new Promise((function(a,i){var o=t.apply(e,s);function r(t){n(o,a,i,r,l,"next",t)}function l(t){n(o,a,i,r,l,"throw",t)}r(void 0)}))})()},profileUrl:function(){return"https://".concat(window._portfolio.domain).concat(window._portfolio.path,"/").concat(this.profile.username)},postUrl:function(t){return"/".concat(this.profile.username,"/").concat(t.id)},formatDate:function(t){return new Date(t).toLocaleDateString(void 0,{weekday:"short",year:"numeric",month:"long",day:"numeric"})}}}},41843:(t,e,s)=>{s.r(e),s.d(e,{default:()=>l});var a=s(87757),i=s.n(a),n=(s(4155),s(31991),s(19755));function o(t,e,s,a,i,n,o){try{var r=t[n](o),l=r.value}catch(t){return void s(t)}r.done?e(l):Promise.resolve(l).then(a,i)}function r(t){return function(){var e=this,s=arguments;return new Promise((function(a,i){var n=t.apply(e,s);function r(t){o(n,a,i,r,l,"next",t)}function l(t){o(n,a,i,r,l,"throw",t)}r(void 0)}))}}const l={props:["initialData"],data:function(){return{loading:!0,user:void 0,profile:void 0,settings:void 0,feed:[],albumIndex:0,settingsUrl:window._portfolio.path+"/settings"}},mounted:function(){var t=JSON.parse(this.initialData);this.profile=t.profile,this.fetchUser()},methods:{fetchUser:function(){var t=this;return r(i().mark((function e(){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return axios.get("/api/v1/accounts/verify_credentials").then((function(e){t.user=e.data})).catch((function(t){})),e.next=3,axios.get("/api/portfolio/account/settings.json",{params:{id:t.profile.id}}).then((function(e){t.settings=e.data})).then((function(){t.fetchFeed()}));case 3:case"end":return e.stop()}}),e)})))()},fetchFeed:function(){var t=this;return r(i().mark((function e(){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:axios.get("/api/portfolio/"+t.profile.id+"/feed").then((function(e){t.feed=e.data.filter((function(t){return"photo"===t.pf_type}))})).then((function(){t.setAlbumSlide()})).then((function(){setTimeout((function(){t.loading=!1}),500)})).then((function(){"masonry"===t.settings.profile_layout&&setTimeout((function(){t.initMasonry()}),500)}));case 1:case"end":return e.stop()}}),e)})))()},postUrl:function(t){return"".concat(window._portfolio.path,"/").concat(this.profile.username,"/").concat(t.id)},albumPrev:function(){if(0!==this.albumIndex){if(1===this.albumIndex){this.albumIndex--;var t=new URL(window.location);return t.searchParams.delete("slide"),void window.history.pushState({},"",t)}this.albumIndex--;var e=new URL(window.location);e.searchParams.set("slide",this.albumIndex+1),window.history.pushState({},"",e)}},albumNext:function(){if(this.albumIndex!==this.feed.length-1){this.albumIndex++;var t=new URL(window.location);t.searchParams.set("slide",this.albumIndex+1),window.history.pushState({},"",t)}},setAlbumSlide:function(){var t=new URL(window.location);if(t.searchParams.has("slide")){var e=Number.parseInt(t.searchParams.get("slide"));if(Number.isNaN(e))return;if(e<=0)return;if(e>this.feed.length)return;this.albumIndex=t.searchParams.get("slide")-1}},initMasonry:function(){n('[data-fancybox="recent"]').fancybox({gutter:20,modal:!1})}}}},57956:(t,e,s)=>{s.r(e),s.d(e,{default:()=>a});const a={data:function(){return{loading:!0,tabIndex:"Configure",tabs:["Configure","Customize","View Portfolio"],user:void 0,settings:void 0,recentPostsLoaded:!1,rpStart:0,recentPosts:[],recentPostsPage:void 0,selectedRecentPosts:[],isSavingCurated:!1,canSaveCurated:!1,customizeSettings:[],profileSourceOptions:[{value:null,text:"Please select an option",disabled:!0},{value:"recent",text:"Most recent posts"}],profileLayoutOptions:[{value:null,text:"Please select an option",disabled:!0},{value:"grid",text:"Grid"},{value:"masonry",text:"Masonry"},{value:"album",text:"Album"}]}},computed:{prevClass:function(){return 0===this.rpStart?"fa fa-arrow-circle-left fa-3x text-dark":"fa fa-arrow-circle-left fa-3x text-muted cursor-pointer"},nextClass:function(){return this.rpStart>this.recentPosts.length-9?"fa fa-arrow-circle-right fa-3x text-dark":"fa fa-arrow-circle-right fa-3x text-muted cursor-pointer"}},watch:{settings:{deep:!0,immediate:!0,handler:function(t,e){this.loading||(e.show_timestamp||(this.settings.show_link=!1),this.updateSettings())}}},mounted:function(){this.fetchUser()},methods:{fetchUser:function(){var t=this;axios.get("/api/v1/accounts/verify_credentials").then((function(e){t.user=e.data,e.data.statuses_count>0?t.profileSourceOptions=[{value:null,text:"Please select an option",disabled:!0},{value:"recent",text:"Most recent posts"},{value:"custom",text:"Curated posts"}]:setTimeout((function(){t.settings.active=!1,t.settings.profile_source="recent",t.tabIndex="Configure"}),1e3)})),axios.post(this.apiPath("/api/portfolio/self/settings.json")).then((function(e){t.settings=e.data,t.updateTabs(),e.data.metadata&&e.data.metadata.posts&&(t.selectedRecentPosts=e.data.metadata.posts)})).then((function(){t.initCustomizeSettings()})).then((function(){var e=new URL(window.location);if(e.searchParams.has("tab")){var s=e.searchParams.get("tab");-1!==("custom"===t.settings.profile_source?["curate","customize","share"]:["customize","share"]).indexOf(s)&&t.toggleTab(s.slice(0,1).toUpperCase()+s.slice(1))}})).then((function(){setTimeout((function(){t.loading=!1}),500)}))},apiPath:function(t){return t},toggleTab:function(t){if("Curate"!==t||this.recentPostsLoaded||this.loadRecentPosts(),this.tabIndex=t,this.rpStart=0,"Configure"==t){var e=new URL(window.location);e.searchParams.delete("tab"),window.history.pushState({},"",e)}else{if("View Portfolio"==t)return this.tabIndex="Configure",void(window.location.href="https://".concat(window._portfolio.domain).concat(window._portfolio.path,"/").concat(this.user.username));var s=new URL(window.location);s.searchParams.set("tab",t.toLowerCase()),window.history.pushState({},"",s)}},updateTabs:function(){"custom"===this.settings.profile_source?this.tabs=["Configure","Curate","Customize","View Portfolio"]:this.tabs=["Configure","Customize","View Portfolio"]},updateSettings:function(){var t=this;axios.post(this.apiPath("/api/portfolio/self/update-settings.json"),this.settings).then((function(e){t.updateTabs(),t.$bvToast.toast("Your settings have been successfully updated!",{variant:"dark",title:"Settings Updated",autoHideDelay:2e3,appendToast:!1})}))},loadRecentPosts:function(){var t=this;axios.get("/api/v1/accounts/"+this.user.id+"/statuses?only_media=1&media_types=photo&limit=100").then((function(e){e.data.length&&(t.recentPosts=e.data.filter((function(t){return"public"===t.visibility})))})).then((function(){setTimeout((function(){t.recentPostsLoaded=!0}),500)}))},toggleRecentPost:function(t){if(-1==this.selectedRecentPosts.indexOf(t)){if(24===this.selectedRecentPosts.length)return;this.selectedRecentPosts.push(t)}else this.selectedRecentPosts=this.selectedRecentPosts.filter((function(e){return e!==t}));this.canSaveCurated=!0},recentPostsPrev:function(){0!==this.rpStart&&(this.rpStart=this.rpStart-9)},recentPostsNext:function(){this.rpStart>this.recentPosts.length-9||(this.rpStart=this.rpStart+9)},clearSelected:function(){this.selectedRecentPosts=[]},saveCurated:function(){var t,e=this;this.isSavingCurated=!0,null===(t=event.currentTarget)||void 0===t||t.blur(),axios.post("/api/portfolio/self/curated.json",{ids:this.selectedRecentPosts}).then((function(t){e.isSavingCurated=!1,e.$bvToast.toast("Your curated posts have been updated!",{variant:"dark",title:"Portfolio Updated",autoHideDelay:2e3,appendToast:!1})})).catch((function(t){e.isSavingCurated=!1,e.$bvToast.toast("An error occured while attempting to update your portfolio, please try again later and contact an admin if this problem persists.",{variant:"dark",title:"Error",autoHideDelay:2e3,appendToast:!1})}))},initCustomizeSettings:function(){this.customizeSettings=[{title:"Post Settings",items:[{label:"Show Captions",model:"show_captions"},{label:"Show License",model:"show_license"},{label:"Show Location",model:"show_location"},{label:"Show Timestamp",model:"show_timestamp"},{label:"Link to Post",description:"Add link to timestamp to view the original post url, requires show timestamp to be enabled",model:"show_link",requiredWithTrue:"show_timestamp"}]},{title:"Profile Settings",items:[{label:"Show Avatar",model:"show_avatar"},{label:"Show Bio",model:"show_bio"}]}]}}}},33897:(t,e,s)=>{s.r(e);var a=s(70538),i=s(25518);window.Vue=a.default,a.default.use(i.default),a.default.component("portfolio-post",s(15414).default),a.default.component("portfolio-profile",s(93324).default),a.default.component("portfolio-settings",s(8662).default)},15414:(t,e,s)=>{s.r(e),s.d(e,{default:()=>o});var a=s(64456),i=s(94042),n={};for(const t in i)"default"!==t&&(n[t]=()=>i[t]);s.d(e,n);const o=(0,s(51900).default)(i.default,a.render,a.staticRenderFns,!1,null,null,null).exports},93324:(t,e,s)=>{s.r(e),s.d(e,{default:()=>o});var a=s(9638),i=s(83147),n={};for(const t in i)"default"!==t&&(n[t]=()=>i[t]);s.d(e,n);const o=(0,s(51900).default)(i.default,a.render,a.staticRenderFns,!1,null,null,null).exports},8662:(t,e,s)=>{s.r(e),s.d(e,{default:()=>o});var a=s(37078),i=s(6667),n={};for(const t in i)"default"!==t&&(n[t]=()=>i[t]);s.d(e,n);const o=(0,s(51900).default)(i.default,a.render,a.staticRenderFns,!1,null,null,null).exports},94042:(t,e,s)=>{s.r(e),s.d(e,{default:()=>n});var a=s(2519),i={};for(const t in a)"default"!==t&&(i[t]=()=>a[t]);s.d(e,i);const n=a.default},83147:(t,e,s)=>{s.r(e),s.d(e,{default:()=>n});var a=s(41843),i={};for(const t in a)"default"!==t&&(i[t]=()=>a[t]);s.d(e,i);const n=a.default},6667:(t,e,s)=>{s.r(e),s.d(e,{default:()=>n});var a=s(57956),i={};for(const t in a)"default"!==t&&(i[t]=()=>a[t]);s.d(e,i);const n=a.default},64456:(t,e,s)=>{s.r(e);var a=s(64623),i={};for(const t in a)"default"!==t&&(i[t]=()=>a[t]);s.d(e,i)},9638:(t,e,s)=>{s.r(e);var a=s(31294),i={};for(const t in a)"default"!==t&&(i[t]=()=>a[t]);s.d(e,i)},37078:(t,e,s)=>{s.r(e);var a=s(92028),i={};for(const t in a)"default"!==t&&(i[t]=()=>a[t]);s.d(e,i)},64623:(t,e,s)=>{s.r(e),s.d(e,{render:()=>a,staticRenderFns:()=>i});var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[t.loading?s("div",{staticClass:"container"},[s("div",{staticClass:"d-flex justify-content-center align-items-center",staticStyle:{height:"100vh"}},[s("b-spinner")],1)]):s("div",[s("div",{staticClass:"container mb-5"},[s("div",{staticClass:"row mt-3"},[s("div",{staticClass:"col-12 mb-4"},[s("div",{staticClass:"d-flex justify-content-center"},[s("img",{staticClass:"img-fluid mb-4",staticStyle:{"max-height":"80vh","object-fit":"contain"},attrs:{src:t.post.media_attachments[0].url}})])]),t._v(" "),s("div",{staticClass:"col-12 mb-4"},[t.settings.show_captions&&t.post.content_text?s("p",[t._v(t._s(t.post.content_text))]):t._e(),t._v(" "),s("div",{staticClass:"d-md-flex justify-content-between align-items-center"},[s("p",{staticClass:"small text-lighter"},[t._v("by "),s("a",{staticClass:"text-lighter font-weight-bold",attrs:{href:t.profileUrl()}},[t._v("@"+t._s(t.profile.username))])]),t._v(" "),t.settings.show_license&&t.post.media_attachments[0].license?s("p",{staticClass:"small text-muted"},[t._v("Licensed under "+t._s(t.post.media_attachments[0].license.title))]):t._e(),t._v(" "),t.settings.show_location&&t.post.place?s("p",{staticClass:"small text-muted"},[t._v(t._s(t.post.place.name)+", "+t._s(t.post.place.country))]):t._e(),t._v(" "),t.settings.show_timestamp?s("p",{staticClass:"small text-muted"},[t.settings.show_link?s("a",{staticClass:"text-lighter font-weight-bold",staticStyle:{"z-index":"2"},attrs:{href:t.post.url}},[t._v("\n                                "+t._s(t.formatDate(t.post.created_at))+"\n                            ")]):s("span",{staticClass:"user-select-none"},[t._v("\n                                "+t._s(t.formatDate(t.post.created_at))+"\n                            ")])]):t._e()])])])]),t._v(" "),s("div",{staticClass:"container"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-12"},[s("div",{staticClass:"d-flex fixed-bottom p-3 justify-content-between align-items-center"},[t.user?s("a",{staticClass:"logo-mark logo-mark-sm mb-0 p-1",attrs:{href:"/"}},[s("span",{staticClass:"text-gradient-primary"},[t._v("portfolio")])]):s("span",{staticClass:"logo-mark logo-mark-sm mb-0 p-1"},[s("span",{staticClass:"text-gradient-primary"},[t._v("portfolio")])]),t._v(" "),t.user&&t.user.id===t.profile.id?s("p",{staticClass:"text-center mb-0"},[s("a",{staticClass:"text-muted",attrs:{href:t.settingsUrl}},[s("i",{staticClass:"far fa-cog fa-lg"})])]):t._e()])])])])])])},i=[]},31294:(t,e,s)=>{s.r(e),s.d(e,{render:()=>a,staticRenderFns:()=>i});var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"w-100 h-100"},[t.loading?s("div",{staticClass:"container"},[s("div",{staticClass:"d-flex justify-content-center align-items-center",staticStyle:{height:"100vh"}},[s("b-spinner")],1)]):s("div",{staticClass:"container"},[s("div",{staticClass:"row py-5"},[s("div",{staticClass:"col-12"},[s("div",{staticClass:"d-flex align-items-center flex-column"},[s("img",{staticClass:"rounded-circle shadow",attrs:{src:t.profile.avatar,width:"60",height:"60",onerror:"this.onerror=null;this.src='/storage/avatars/default.png?v=0';"}}),t._v(" "),s("div",{staticClass:"py-3 text-center",staticStyle:{"max-width":"60%"}},[s("h1",{staticClass:"font-weight-bold"},[t._v(t._s(t.profile.username))]),t._v(" "),s("p",{staticClass:"font-weight-light mb-0"},[t._v(t._s(t.profile.note_text))])])])])]),t._v(" "),s("div",{staticClass:"container mb-5 pb-5"},[s("div",{class:["masonry"===t.settings.profile_layout?"card-columns":"row"],attrs:{id:"portContainer"}},["grid"===t.settings.profile_layout?t._l(t.feed,(function(e,a){return s("div",{staticClass:"col-12 col-md-4 mb-1 p-1"},[s("div",{staticClass:"square"},[s("a",{attrs:{href:t.postUrl(e)}},[s("img",{staticClass:"square-content pr-1",staticStyle:{overflow:"hidden","object-fit":"cover"},attrs:{src:e.media_attachments[0].url,width:"100%",height:"300"}})])])])})):"album"===t.settings.profile_layout?s("div",{staticClass:"col-12 mb-1 p-1"},[s("div",{staticClass:"d-flex justify-content-center"},[s("p",{staticClass:"text-muted font-weight-bold"},[t._v(t._s(t.albumIndex+1)+" "),s("span",{staticClass:"font-weight-light"},[t._v("/")]),t._v(" "+t._s(t.feed.length))])]),t._v(" "),s("div",{staticClass:"d-flex justify-content-between align-items-center"},[0===t.albumIndex?s("span",[s("i",{staticClass:"fa fa-arrow-circle-left fa-3x text-dark"})]):s("a",{attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.albumPrev()}}},[s("i",{staticClass:"fa fa-arrow-circle-left fa-3x text-muted"})]),t._v(" "),s("transition",{attrs:{name:"slide-fade"}},[s("a",{key:t.albumIndex,staticClass:"mx-4",attrs:{href:t.postUrl(t.feed[t.albumIndex])}},[s("img",{staticClass:"user-select-none",staticStyle:{height:"60vh",overflow:"hidden","object-fit":"contain"},attrs:{src:t.feed[t.albumIndex].media_attachments[0].url,width:"100%",draggable:!1}})])]),t._v(" "),t.albumIndex===t.feed.length-1?s("span",[s("i",{staticClass:"fa fa-arrow-circle-right fa-3x text-dark"})]):s("a",{attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.albumNext()}}},[s("i",{staticClass:"fa fa-arrow-circle-right fa-3x text-muted"})])],1)]):"masonry"===t.settings.profile_layout?s("div",{staticClass:"col-12 p-0 m-0"},t._l(t.feed,(function(e,a){return s("div",{staticClass:"p-1"},[s("a",{attrs:{href:t.postUrl(e),"data-fancybox":"recent","data-src":e.media_attachments[0].url,"data-width":e.media_attachments[0].width,"data-height":e.media_attachments[0].height}},[s("img",{staticClass:"user-select-none",staticStyle:{overflow:"hidden","object-fit":"contain"},attrs:{src:e.media_attachments[0].url,width:"100%",draggable:!1}})])])})),0):t._e()],2)]),t._v(" "),s("div",{staticClass:"d-flex fixed-bottom p-3 justify-content-between align-items-center"},[t.user?s("a",{staticClass:"logo-mark logo-mark-sm mb-0 p-1",attrs:{href:"/"}},[s("span",{staticClass:"text-gradient-primary"},[t._v("portfolio")])]):s("span",{staticClass:"logo-mark logo-mark-sm mb-0 p-1"},[s("span",{staticClass:"text-gradient-primary"},[t._v("portfolio")])]),t._v(" "),t.user&&t.user.id==t.profile.id?s("p",{staticClass:"text-center mb-0"},[s("a",{staticClass:"text-muted",attrs:{href:t.settingsUrl}},[s("i",{staticClass:"far fa-cog fa-lg"})])]):t._e()])])])},i=[]},92028:(t,e,s)=>{s.r(e),s.d(e,{render:()=>a,staticRenderFns:()=>i});var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"portfolio-settings px-3"},[t.loading?s("div",{staticClass:"d-flex justify-content-center align-items-center py-5"},[s("b-spinner",{attrs:{variant:"primary"}})],1):s("div",{staticClass:"row justify-content-center mb-5 pb-5"},[s("div",{staticClass:"col-12 col-md-8 bg-dark py-2 rounded"},[s("ul",{staticClass:"nav nav-pills nav-fill"},t._l(t.tabs,(function(e,a){return s("li",{staticClass:"nav-item",class:{disabled:0!==a&&!t.settings.active}},[0===a||t.settings.active?s("a",{staticClass:"nav-link",class:{active:e===t.tabIndex},attrs:{href:"#"},on:{click:function(s){return s.preventDefault(),t.toggleTab(e)}}},[t._v(t._s(e))]):s("span",{staticClass:"nav-link"},[t._v(t._s(e))])])})),0)]),t._v(" "),s("transition",{attrs:{name:"slide-fade"}},["Configure"===t.tabIndex?s("div",{key:"0",staticClass:"col-12 col-md-8 bg-dark mt-3 py-2 rounded"},[t.user.statuses_count?t._e():s("div",{staticClass:"alert alert-danger"},[s("p",{staticClass:"mb-0 small font-weight-bold"},[t._v("You don't have any public posts, once you share public posts you can enable your portfolio.")])]),t._v(" "),s("div",{staticClass:"d-flex justify-content-between align-items-center py-2"},[s("div",{staticClass:"setting-label"},[s("p",{staticClass:"lead mb-0"},[t._v("Portfolio Enabled")]),t._v(" "),s("p",{staticClass:"small mb-0 text-muted"},[t._v("You must enable your portfolio before you or anyone can view it.")])]),t._v(" "),s("div",{staticClass:"setting-switch mt-n1"},[s("b-form-checkbox",{attrs:{name:"check-button",size:"lg",switch:"",disabled:!t.user.statuses_count},model:{value:t.settings.active,callback:function(e){t.$set(t.settings,"active",e)},expression:"settings.active"}})],1)]),t._v(" "),s("hr"),t._v(" "),s("div",{staticClass:"d-flex justify-content-between align-items-center py-2"},[s("div",{staticClass:"setting-label",staticStyle:{"max-width":"50%"}},[s("p",{staticClass:"mb-0"},[t._v("Portfolio Source")]),t._v(" "),s("p",{staticClass:"small mb-0 text-muted"},[t._v("Choose how you want to populate your portfolio, select Most Recent posts to automatically update your portfolio with recent posts or Curated Posts to select specific posts for your portfolio.")])]),t._v(" "),s("div",{staticClass:"ml-3"},[s("b-form-select",{attrs:{options:t.profileSourceOptions,disabled:!t.user.statuses_count},model:{value:t.settings.profile_source,callback:function(e){t.$set(t.settings,"profile_source",e)},expression:"settings.profile_source"}})],1)])]):"Curate"===t.tabIndex?s("div",{key:"1",staticClass:"col-12 col-md-8 mt-3 py-2 px-0"},[t.recentPostsLoaded?[s("div",{staticClass:"mt-n2 mb-4"},[s("p",{staticClass:"text-muted small"},[t._v("Select up to 24 photos from your 100 most recent posts. You can only select public photo posts, videos are not supported at this time.")]),t._v(" "),s("div",{staticClass:"d-flex align-items-center justify-content-between"},[s("p",{staticClass:"font-weight-bold mb-0"},[t._v("Selected "+t._s(t.selectedRecentPosts.length)+"/24")]),t._v(" "),s("div",[s("button",{staticClass:"btn btn-link font-weight-bold mr-3 text-decoration-none",attrs:{disabled:!t.selectedRecentPosts.length},on:{click:t.clearSelected}},[t._v("\n                                    Clear selected\n                                ")]),t._v(" "),s("button",{staticClass:"btn btn-primary py-0 font-weight-bold",staticStyle:{width:"150px"},attrs:{disabled:!t.canSaveCurated},on:{click:function(e){return t.saveCurated()}}},[t.isSavingCurated?s("b-spinner",{attrs:{small:""}}):[t._v("Save")]],2)])])]),t._v(" "),s("div",{staticClass:"d-flex justify-content-between align-items-center"},[s("span",{on:{click:t.recentPostsPrev}},[s("i",{class:t.prevClass})]),t._v(" "),s("div",{staticClass:"row flex-grow-1 mx-2"},t._l(t.recentPosts.slice(t.rpStart,t.rpStart+9),(function(e,a){return s("div",{staticClass:"col-12 col-md-4 mb-1 p-1"},[s("div",{staticClass:"square user-select-none",on:{click:function(s){return s.preventDefault(),t.toggleRecentPost(e.id)}}},[s("transition",{attrs:{name:"fade"}},[s("img",{key:e.id,staticClass:"square-content pr-1",staticStyle:{overflow:"hidden","object-fit":"cover"},attrs:{src:e.media_attachments[0].url,width:"100%",height:"300",draggable:!1}})]),t._v(" "),-1!==t.selectedRecentPosts.indexOf(e.id)?s("div",{staticStyle:{position:"absolute",right:"-5px",bottom:"-5px"}},[s("div",{staticClass:"selected-badge"},[t._v(t._s(t.selectedRecentPosts.indexOf(e.id)+1))])]):t._e()],1)])})),0),t._v(" "),s("span",{on:{click:function(e){return t.recentPostsNext()}}},[s("i",{class:t.nextClass})])])]:s("div",{staticClass:"d-flex align-items-center justify-content-center py-5 my-5"},[s("div",{staticClass:"text-center"},[s("div",{staticClass:"spinner-border",attrs:{role:"status"}},[s("span",{staticClass:"sr-only"},[t._v("Loading...")])]),t._v(" "),s("p",{staticClass:"text-muted"},[t._v("Loading recent posts...")])])])],2):"Customize"===t.tabIndex?s("div",{key:"2",staticClass:"col-12 col-md-8 mt-3 py-2"},[t._l(t.customizeSettings,(function(e){return s("div",{staticClass:"card bg-dark mb-5"},[s("div",{staticClass:"card-header"},[t._v(t._s(e.title))]),t._v(" "),s("div",{staticClass:"list-group bg-dark"},t._l(e.items,(function(e){return s("div",{staticClass:"list-group-item"},[s("div",{staticClass:"d-flex justify-content-between align-items-center py-2"},[s("div",{staticClass:"setting-label"},[s("p",{staticClass:"mb-0"},[t._v(t._s(e.label))]),t._v(" "),e.description?s("p",{staticClass:"small text-muted mb-0"},[t._v(t._s(e.description))]):t._e()]),t._v(" "),s("div",{staticClass:"setting-switch mt-n1"},[s("b-form-checkbox",{attrs:{name:"check-button",size:"lg",switch:"",disabled:e.requiredWithTrue&&!t.settings[e.requiredWithTrue]},model:{value:t.settings[e.model],callback:function(s){t.$set(t.settings,e.model,s)},expression:"settings[item.model]"}})],1)])])})),0)])})),t._v(" "),s("div",{staticClass:"card bg-dark mb-5"},[s("div",{staticClass:"card-header"},[t._v("Portfolio")]),t._v(" "),s("div",{staticClass:"list-group bg-dark"},[s("div",{staticClass:"list-group-item"},[s("div",{staticClass:"d-flex justify-content-between align-items-center py-2"},[s("div",{staticClass:"setting-label"},[s("p",{staticClass:"mb-0"},[t._v("Layout")])]),t._v(" "),s("div",[s("b-form-select",{attrs:{options:t.profileLayoutOptions},model:{value:t.settings.profile_layout,callback:function(e){t.$set(t.settings,"profile_layout",e)},expression:"settings.profile_layout"}})],1)])])])])],2):"Share"===t.tabIndex?s("div",{key:"0",staticClass:"col-12 col-md-8 bg-dark mt-3 py-2 rounded"},[s("div",{staticClass:"py-2"},[s("p",{staticClass:"text-muted"},[t._v("Portfolio URL")]),t._v(" "),s("p",{staticClass:"lead mb-0"},[s("a",{attrs:{href:t.settings.url}},[t._v(t._s(t.settings.url))])])])]):t._e()])],1)])},i=[]}},t=>{t.O(0,[898],(()=>{return e=33897,t(t.s=e);var e}));t.O()}]);