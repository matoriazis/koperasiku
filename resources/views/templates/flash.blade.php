@if ($errors->any())
	<div class="alert alert-danger" style="color: white;">
		<strong>Whoops!</strong>
		Tejadi kesalahan pada inputan kamu.<br>
		<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

@if(session('success'))
	<div class="alert alert-info alert-with-icon" data-notify="container" style="color: white;">
      <span data-notify="icon" class="tim-icons icon-bell-55"></span>
      <span data-notify="message">{!! session('success') !!}</span>
    </div>
@endif

@if(session('failed'))
	<div class="alert alert-danger alert-with-icon" data-notify="container" style="color: white;">
      <span data-notify="icon" class="tim-icons icon-alert-circle-exc"></span>
      <span data-notify="message">{!! session('failed') !!}</span>
    </div>
@endif