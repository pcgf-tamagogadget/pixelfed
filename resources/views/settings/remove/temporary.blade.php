@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.remove.temporarily_disable_your_account') }}</h3>
  </div>
  <hr>
  <div class="mt-3">
  	<p>{!! __('settings.remove.hi_username', ['username' => e(Auth::user()->username)]) !!}</p>

  	<p>{{ __('settings.remove.you_can_disable_your_account_instead_of_deleting_it_etc') }}</p>

  	<p class="pb-1">{{ __('settings.remove.you_can_only_disable_your_account_once_a_week') }}</p>

  	<p class="font-weight-bold">{{ __('settings.remove.keeping_your_data_safe') }}</p>
  	<p class="pb-3">{{ __('settings.remove.nothing_is_more_important_to_us_than_the_safety_etc') }}</p>

  	<p class="pb-2">{{ __('settings.remove.when_you_press_the_button_below_your_photos_will_be_hidden_etc') }}</p>

  	<p>
  		<form method="post">
        @csrf
  		  <button type="submit" class="btn btn-primary font-weight-bold py-0">{{ __('settings.security.temporarily_disable_account') }}</button>
  		</form>
  	</p>
  </div>


@endsection