<!DOCTYPE html>
<html>
<head>
	<title></title>
	@include('../partials.head')
</head>
<body>
	@include('../partials.nav')

<br><br>
<br><br><br>
@yield('content')

	@include('../partials.footer')

@yield('scripts')
@yield('css')


</body>
</html>
