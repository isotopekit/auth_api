<form action="{{ route('post_register_route') }}" method="post">
	{{ csrf_field() }}
	
	<label for="">First Name</label>
	<input type="text" name="first_name" id="">
	@if($errors->has('first_name'))
		{{ $errors->first('first_name') }}
	@endif

	<br>

	<label for="">Last Name</label>
	<input type="text" name="last_name" id="">
	@if($errors->has('last_name'))
		{{ $errors->first('last_name') }}
	@endif

	<br>

	<label for="">Email</label>
	<input type="text" name="email" id="">
	@if($errors->has('email'))
		{{ $errors->first('email') }}
	@endif

	<br>

	<label for="">Password</label>
	<input type="password" name="password" id="">
	@if ($errors->has('password'))
		{{ $errors->first('password') }}
	@endif

	<br>

	<label for="">Level</label>
	<select name="plan_id" id="">
		@foreach($plans as $plan)
			<option value="{{ $plan->id }}">{{ $plan->name }}</option>
		@endforeach
	</select>
	@if ($errors->has('plan_id'))
		{{ $errors->first('plan_id') }}
	@endif

	<br>
	
	
	<button type="submit">Register</button>
</form>