(self.webpackChunkpixelfed=self.webpackChunkpixelfed||[]).push([[2062],{99662:(t,e,i)=>{"use strict";i.r(e),i.d(e,{default:()=>s});var a=i(19755);const s={props:["code"],data:function(){return{instance:{},inviteConfig:{},tabIndex:0,isProceeding:!1,errors:{username:void 0,email:void 0,password:void 0,password_confirm:void 0},form:{username:void 0,email:void 0,password:void 0,password_confirm:void 0,display_name:void 0}}},mounted:function(){this.fetchInstanceData()},methods:{fetchInstanceData:function(){var t=this;axios.get("/api/v1/instance").then((function(e){t.instance=e.data})).then((function(e){t.verifyToken()})).catch((function(t){console.log(t)}))},verifyToken:function(){var t=this;axios.post("/api/v1.1/auth/invite/admin/verify",{token:this.code}).then((function(e){t.tabIndex=1,t.inviteConfig=e.data})).catch((function(e){t.tabIndex="invalid-code"}))},checkUsernameAvailability:function(){var t=this;axios.post("/api/v1.1/auth/invite/admin/uc",{token:this.code,username:this.form.username}).then((function(e){e&&e.data?(t.isProceeding=!1,t.tabIndex=2):(t.tabIndex="invalid-code",t.isProceeding=!1)})).catch((function(e){e.response.data&&e.response.data.username?(t.errors.username=e.response.data.username[0],t.isProceeding=!1):(t.tabIndex="invalid-code",t.isProceeding=!1)}))},checkEmailAvailability:function(){var t=this;axios.post("/api/v1.1/auth/invite/admin/ec",{token:this.code,email:this.form.email}).then((function(e){e&&e.data?(t.isProceeding=!1,t.tabIndex=3):(t.tabIndex="invalid-code",t.isProceeding=!1)})).catch((function(e){e.response.data&&e.response.data.email?(t.errors.email=e.response.data.email[0],t.isProceeding=!1):(t.tabIndex="invalid-code",t.isProceeding=!1)}))},validateEmail:function(){return!(!this.form.email||!this.form.email.length)&&/^[a-zA-Z]+[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+[a-zA-Z]$/i.test(this.form.email)},handleRegistration:function(){var t=a("<form>",{action:"/api/v1.1/auth/invite/admin/re",method:"post"}),e={_token:document.head.querySelector('meta[name="csrf-token"]').content,token:this.code,username:this.form.username,name:this.form.display_name,email:this.form.email,password:this.form.password,password_confirm:this.form.password_confirm};a.each(e,(function(e,i){a("<input>").attr({type:"hidden",name:e,value:i}).appendTo(t)})),t.appendTo("body").submit()},proceed:function(t){switch(this.isProceeding=!0,event.currentTarget.blur(),t){case 1:this.checkUsernameAvailability();break;case 2:this.checkEmailAvailability();break;case 3:this.isProceeding=!1,this.tabIndex=4;break;case 4:this.isProceeding=!1,this.tabIndex=5;break;case 5:this.tabIndex=6,this.handleRegistration()}}}}},80740:(t,e,i)=>{"use strict";i.r(e),i.d(e,{render:()=>a,staticRenderFns:()=>s});var a=function(){var t=this,e=t._self._c;return e("div",{staticClass:"admin-invite-component"},[e("div",{staticClass:"admin-invite-component-inner"},[e("div",{staticClass:"card bg-dark"},[0===t.tabIndex?e("div",{staticClass:"card-body d-flex align-items-center justify-content-center"},[e("div",{staticClass:"text-center"},[e("b-spinner",{attrs:{variant:"muted"}}),t._v(" "),e("p",{staticClass:"text-muted mb-0"},[t._v("Loading...")])],1)]):1===t.tabIndex?e("div",{staticClass:"card-body"},[t._m(0),t._v(" "),e("div",{staticClass:"d-flex flex-column align-items-center justify-content-center"},[e("p",{staticClass:"lead mb-1 text-muted"},[t._v("You've been invited to join")]),t._v(" "),e("p",{staticClass:"h3 mb-2"},[t._v(t._s(t.instance.uri))]),t._v(" "),e("p",{staticClass:"mb-0 text-muted"},[e("span",[t._v(t._s(t.instance.stats.user_count.toLocaleString("en-CA",{compactDisplay:"short",notation:"compact"}))+" users")]),t._v(" "),e("span",[t._v("·")]),t._v(" "),e("span",[t._v(t._s(t.instance.stats.status_count.toLocaleString("en-CA",{compactDisplay:"short",notation:"compact"}))+" posts")])]),t._v(" "),"You've been invited to join"!=t.inviteConfig.message?e("div",[e("div",{staticClass:"admin-message"},[e("p",{staticClass:"small text-light mb-0"},[t._v("Message from admin(s):")]),t._v("\n                            "+t._s(t.inviteConfig.message)+"\n                        ")])]):t._e()]),t._v(" "),e("div",{staticClass:"mt-5"},[e("div",{staticClass:"form-group"},[e("label",{attrs:{for:"username"}},[t._v("Username")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.form.username,expression:"form.username"}],staticClass:"form-control form-control-lg",attrs:{type:"text",placeholder:"What should everyone call you?",minlength:"2",maxlength:"15"},domProps:{value:t.form.username},on:{input:function(e){e.target.composing||t.$set(t.form,"username",e.target.value)}}}),t._v(" "),t.errors.username?e("p",{staticClass:"form-text text-danger"},[e("i",{staticClass:"far fa-exclamation-triangle mr-1"}),t._v("\n                            "+t._s(t.errors.username)+"\n                        ")]):t._e()]),t._v(" "),e("button",{staticClass:"btn btn-primary btn-block font-weight-bold",attrs:{disabled:t.isProceeding||!t.form.username||t.form.username.length<2},on:{click:function(e){return t.proceed(t.tabIndex)}}},[t.isProceeding?[e("b-spinner",{attrs:{small:""}})]:[t._v("\n                            Continue\n                        ")]],2),t._v(" "),t._m(1),t._v(" "),t._m(2)])]):2===t.tabIndex?e("div",{staticClass:"card-body"},[t._m(3),t._v(" "),e("div",{staticClass:"d-flex flex-column align-items-center justify-content-center"},[e("p",{staticClass:"lead mb-1 text-muted"},[t._v("You've been invited to join")]),t._v(" "),e("p",{staticClass:"h3 mb-2"},[t._v(t._s(t.instance.uri))])]),t._v(" "),e("div",{staticClass:"mt-5"},[e("div",{staticClass:"form-group"},[e("label",{attrs:{for:"username"}},[t._v("Email Address")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.form.email,expression:"form.email"}],staticClass:"form-control form-control-lg",attrs:{type:"email",placeholder:"Your email address"},domProps:{value:t.form.email},on:{input:function(e){e.target.composing||t.$set(t.form,"email",e.target.value)}}}),t._v(" "),t.errors.email?e("p",{staticClass:"form-text text-danger"},[e("i",{staticClass:"far fa-exclamation-triangle mr-1"}),t._v("\n                            "+t._s(t.errors.email)+"\n                        ")]):t._e()]),t._v(" "),e("button",{staticClass:"btn btn-primary btn-block font-weight-bold",attrs:{disabled:t.isProceeding||!t.form.email||!t.validateEmail()},on:{click:function(e){return t.proceed(t.tabIndex)}}},[t.isProceeding?[e("b-spinner",{attrs:{small:""}})]:[t._v("\n                            Continue\n                        ")]],2)])]):3===t.tabIndex?e("div",{staticClass:"card-body"},[t._m(4),t._v(" "),e("div",{staticClass:"d-flex flex-column align-items-center justify-content-center"},[e("p",{staticClass:"lead mb-1 text-muted"},[t._v("You've been invited to join")]),t._v(" "),e("p",{staticClass:"h3 mb-2"},[t._v(t._s(t.instance.uri))])]),t._v(" "),e("div",{staticClass:"mt-5"},[e("div",{staticClass:"form-group"},[e("label",{attrs:{for:"username"}},[t._v("Password")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.form.password,expression:"form.password"}],staticClass:"form-control form-control-lg",attrs:{type:"password",placeholder:"Use a secure password",minlength:"8"},domProps:{value:t.form.password},on:{input:function(e){e.target.composing||t.$set(t.form,"password",e.target.value)}}}),t._v(" "),t.errors.password?e("p",{staticClass:"form-text text-danger"},[e("i",{staticClass:"far fa-exclamation-triangle mr-1"}),t._v("\n                            "+t._s(t.errors.password)+"\n                        ")]):t._e()]),t._v(" "),e("button",{staticClass:"btn btn-primary btn-block font-weight-bold",attrs:{disabled:t.isProceeding||!t.form.password||t.form.password.length<8},on:{click:function(e){return t.proceed(t.tabIndex)}}},[t.isProceeding?[e("b-spinner",{attrs:{small:""}})]:[t._v("\n                            Continue\n                        ")]],2)])]):4===t.tabIndex?e("div",{staticClass:"card-body"},[t._m(5),t._v(" "),e("div",{staticClass:"d-flex flex-column align-items-center justify-content-center"},[e("p",{staticClass:"lead mb-1 text-muted"},[t._v("You've been invited to join")]),t._v(" "),e("p",{staticClass:"h3 mb-2"},[t._v(t._s(t.instance.uri))])]),t._v(" "),e("div",{staticClass:"mt-5"},[e("div",{staticClass:"form-group"},[e("label",{attrs:{for:"username"}},[t._v("Confirm Password")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.form.password_confirm,expression:"form.password_confirm"}],staticClass:"form-control form-control-lg",attrs:{type:"password",placeholder:"Use a secure password",minlength:"8"},domProps:{value:t.form.password_confirm},on:{input:function(e){e.target.composing||t.$set(t.form,"password_confirm",e.target.value)}}}),t._v(" "),t.errors.password_confirm?e("p",{staticClass:"form-text text-danger"},[e("i",{staticClass:"far fa-exclamation-triangle mr-1"}),t._v("\n                            "+t._s(t.errors.password_confirm)+"\n                        ")]):t._e()]),t._v(" "),e("button",{staticClass:"btn btn-primary btn-block font-weight-bold",attrs:{disabled:t.isProceeding||!t.form.password_confirm||t.form.password!==t.form.password_confirm},on:{click:function(e){return t.proceed(t.tabIndex)}}},[t.isProceeding?[e("b-spinner",{attrs:{small:""}})]:[t._v("\n                            Continue\n                        ")]],2)])]):5===t.tabIndex?e("div",{staticClass:"card-body"},[t._m(6),t._v(" "),e("div",{staticClass:"d-flex flex-column align-items-center justify-content-center"},[e("p",{staticClass:"lead mb-1 text-muted"},[t._v("You've been invited to join")]),t._v(" "),e("p",{staticClass:"h3 mb-2"},[t._v(t._s(t.instance.uri))])]),t._v(" "),e("div",{staticClass:"mt-5"},[e("div",{staticClass:"form-group"},[e("label",{attrs:{for:"username"}},[t._v("Display Name")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.form.display_name,expression:"form.display_name"}],staticClass:"form-control form-control-lg",attrs:{type:"text",placeholder:"Add an optional display name",minlength:"8"},domProps:{value:t.form.display_name},on:{input:function(e){e.target.composing||t.$set(t.form,"display_name",e.target.value)}}}),t._v(" "),t.errors.display_name?e("p",{staticClass:"form-text text-danger"},[e("i",{staticClass:"far fa-exclamation-triangle mr-1"}),t._v("\n                            "+t._s(t.errors.display_name)+"\n                        ")]):t._e()]),t._v(" "),e("button",{staticClass:"btn btn-primary btn-block font-weight-bold",attrs:{disabled:t.isProceeding},on:{click:function(e){return t.proceed(t.tabIndex)}}},[t.isProceeding?[e("b-spinner",{attrs:{small:""}})]:[t._v("\n                            Continue\n                        ")]],2)])]):6===t.tabIndex?e("div",{staticClass:"card-body d-flex flex-column"},[t._m(7),t._v(" "),e("div",{staticClass:"d-flex flex-column align-items-center justify-content-center"},[e("p",{staticClass:"lead mb-1 text-muted"},[t._v("You've been invited to join")]),t._v(" "),e("p",{staticClass:"h3 mb-2"},[t._v(t._s(t.instance.uri))])]),t._v(" "),e("div",{staticClass:"mt-5 d-flex align-items-center justify-content-center flex-column flex-grow-1"},[e("b-spinner",{attrs:{variant:"muted"}}),t._v(" "),e("p",{staticClass:"text-muted"},[t._v("Registering...")])],1)]):"invalid-code"===t.tabIndex?e("div",{staticClass:"card-body d-flex align-items-center justify-content-center"},[t._m(8)]):e("div",{staticClass:"card-body"},[e("p",[t._v("An error occured.")])])])])])},s=[function(){var t=this._self._c;return t("div",{staticClass:"d-flex justify-content-center my-3"},[t("img",{attrs:{src:"/img/pixelfed-icon-color.png",width:"60",alt:"Pixelfed logo"}})])},function(){var t=this._self._c;return t("p",{staticClass:"login-link"},[t("a",{attrs:{href:"/login"}},[this._v("Already have an account?")])])},function(){var t=this,e=t._self._c;return e("p",{staticClass:"register-terms"},[t._v("\n                        By registering, you agree to our "),e("a",{attrs:{href:"/site/terms"}},[t._v("Terms of Service")]),t._v(" and "),e("a",{attrs:{href:"/site/privacy"}},[t._v("Privacy Policy")]),t._v(".\n                    ")])},function(){var t=this._self._c;return t("div",{staticClass:"d-flex justify-content-center my-3"},[t("img",{attrs:{src:"/img/pixelfed-icon-color.png",width:"60",alt:"Pixelfed logo"}})])},function(){var t=this._self._c;return t("div",{staticClass:"d-flex justify-content-center my-3"},[t("img",{attrs:{src:"/img/pixelfed-icon-color.png",width:"60",alt:"Pixelfed logo"}})])},function(){var t=this._self._c;return t("div",{staticClass:"d-flex justify-content-center my-3"},[t("img",{attrs:{src:"/img/pixelfed-icon-color.png",width:"60",alt:"Pixelfed logo"}})])},function(){var t=this._self._c;return t("div",{staticClass:"d-flex justify-content-center my-3"},[t("img",{attrs:{src:"/img/pixelfed-icon-color.png",width:"60",alt:"Pixelfed logo"}})])},function(){var t=this._self._c;return t("div",{staticClass:"d-flex justify-content-center my-3"},[t("img",{attrs:{src:"/img/pixelfed-icon-color.png",width:"60",alt:"Pixelfed logo"}})])},function(){var t=this,e=t._self._c;return e("div",[e("h1",{staticClass:"text-center"},[t._v("Invalid Invite Code")]),t._v(" "),e("hr"),t._v(" "),e("p",{staticClass:"text-muted mb-1"},[t._v("The invite code you were provided is not valid, this can happen when:")]),t._v(" "),e("ul",{staticClass:"text-muted"},[e("li",[t._v("Invite code has typos")]),t._v(" "),e("li",[t._v("Invite code was already used")]),t._v(" "),e("li",[t._v("Invite code has reached max uses")]),t._v(" "),e("li",[t._v("Invite code has expired")]),t._v(" "),e("li",[t._v("You have been rate limited")])]),t._v(" "),e("hr"),t._v(" "),e("a",{staticClass:"btn btn-primary btn-block rounded-pill font-weight-bold",attrs:{href:"/"}},[t._v("Go back home")])])}]},2462:(t,e,i)=>{Vue.component("admin-invite",i(34421).default)},45950:(t,e,i)=>{"use strict";i.r(e),i.d(e,{default:()=>n});var a=i(1519),s=i.n(a)()((function(t){return t[1]}));s.push([t.id,".admin-invite-component{font-family:var(--font-family-sans-serif)}.admin-invite-component-inner{align-items:center;display:flex;height:100vh;justify-content:center;width:100wv}.admin-invite-component-inner .card{border-radius:10px;color:#fff;min-height:530px;padding:1.25rem 2.5rem;width:100%}@media (min-width:768px){.admin-invite-component-inner .card{width:30%}}.admin-invite-component-inner .card label{color:var(--muted);font-weight:700;text-transform:uppercase}.admin-invite-component-inner .card .login-link{font-weight:600;margin-top:10px}.admin-invite-component-inner .card .register-terms{color:var(--muted);font-size:12px}.admin-invite-component-inner .card .form-control{color:#fff}.admin-invite-component-inner .card .admin-message{border:1px solid var(--dropdown-item-hover-color);border-radius:5px;color:var(--text-lighter);margin-top:20px;padding:1rem}",""]);const n=s},91046:(t,e,i)=>{"use strict";i.r(e),i.d(e,{default:()=>o});var a=i(93379),s=i.n(a),n=i(45950),r={insert:"head",singleton:!1};s()(n.default,r);const o=n.default.locals||{}},34421:(t,e,i)=>{"use strict";i.r(e),i.d(e,{default:()=>r});var a=i(17367),s=i(82879),n={};for(const t in s)"default"!==t&&(n[t]=()=>s[t]);i.d(e,n);i(23479);const r=(0,i(51900).default)(s.default,a.render,a.staticRenderFns,!1,null,null,null).exports},82879:(t,e,i)=>{"use strict";i.r(e),i.d(e,{default:()=>n});var a=i(99662),s={};for(const t in a)"default"!==t&&(s[t]=()=>a[t]);i.d(e,s);const n=a.default},17367:(t,e,i)=>{"use strict";i.r(e);var a=i(80740),s={};for(const t in a)"default"!==t&&(s[t]=()=>a[t]);i.d(e,s)},23479:(t,e,i)=>{"use strict";i.r(e);var a=i(91046),s={};for(const t in a)"default"!==t&&(s[t]=()=>a[t]);i.d(e,s)}},t=>{t.O(0,[8898],(()=>{return e=2462,t(t.s=e);var e}));t.O()}]);