@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.emailConfirmationIssues.title')])

@section('section')
<div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.emailConfirmationIssues.title') }}</h3>
</div>
<hr>
<p>{{ __('helpcenter.emailConfirmationIssues.intro') }}</p>

<ul>
    <li>{{ __('helpcenter.emailConfirmationIssues.reason1') }}</li>
    <li>{{ __('helpcenter.emailConfirmationIssues.reason2') }}</li>
    <li>{{ __('helpcenter.emailConfirmationIssues.reason3') }}</li>
    <li>{{ __('helpcenter.emailConfirmationIssues.reason4') }}</li>
</ul>
@endsection
