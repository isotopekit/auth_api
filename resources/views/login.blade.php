<form action="{{ url('/login') }}" method="post">
	{{ csrf_field() }}

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
	
	<button type="submit">Login</button>
</form>