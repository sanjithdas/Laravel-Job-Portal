<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>Document</title>

</head>
<body>
    
    <div class="container">
        {{-- Vue part starts.. --}}
        <div id="app">
                {{-- <div>@{{ result }}</div> --}}
                
    <message-component color='warning' username='{{Auth::user()->name?Auth::user()->name:Auth::user()->company->cname}}'></message-component>
            
        </div>


    </div>

    <script src="{{asset('js/app.js')}}"></script>	
</body>
</html>
