    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/app.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>
<body style="background-image: url('../public/fon.jpg')">
    <div class="app">
        <header>
            @yield('message_header')
            @yield('main_header')
            @yield('href')
            <br>
            @yield('button_header')
            <br>
        </header>

    </div>
    <div class="hstack gap-5">

        @yield('people')
        @yield('message')
    </div>

    @yield('main')
    <script>
        $('.page_friend_new').hide();
        function show_page(){
            $('.page_friend').hide(100);
            $('.page_friend_new').show(100);
        }
        function show_page_friend(){
            $('.page_friend_new').hide(100);
            $('.page_friend').show(100);
        }
    </script>
    <script>
        if( window.localStorage )
        {
            if( !localStorage.getItem('firstLoad') )
            {
                localStorage['firstLoad'] = true;
                window.location.reload();
            }
            else
                localStorage.removeItem('firstLoad');
        }
    </script>
    <script src="./js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>
