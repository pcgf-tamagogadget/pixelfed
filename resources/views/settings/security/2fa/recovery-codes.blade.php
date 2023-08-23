@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-12">
    <div class="card shadow-none border mt-5">
      <div class="card-body">
        <div class="row">
          <div class="col-12 p-3 p-md-5">
			  <div class="title">
			    <h3 class="font-weight-bold">{{__('settings.2faRecoveryCodes')}}</h3>
			  </div>

			  <hr>
			    @if(count($codes) > 0)
			      <p class="lead pb-3">
			      	{{__('settings.codeUsedOnce')}}
			      </p>
			      <ul class="list-group">
			      	@foreach($codes as $code)
			      	<li class="list-group-item"><code>{{$code}}</code></li>
			      	@endforeach
			      </ul>
			    @else
			    <div class="pt-5">
			      <h4 class="font-weight-bold">{{__('settings.outOfCode')}}</h4>
			      <p class="lead">{{__('settings.generateMoreCode')}}</p>
			      <p>
			        <form method="post">
			          @csrf
			          <button type="submit" class="btn btn-primary font-weight-bold">{{__('settings.generateRecoveryCode')}}</button>
			        </form>
			      </p>
			    </div>
			    @endif
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
