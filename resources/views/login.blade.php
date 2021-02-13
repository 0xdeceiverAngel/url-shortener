<meta name="csrf-token" content="{{ csrf_token() }}">
<form method="POST" action="login">
    {!! csrf_field() !!}

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password" id="password">
    </div>

    <div>
        <input type="checkbox" name="remember"> Remember Me
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
</form>

<meta name="csrf-token" content="{{ csrf_token() }}">
<form method="POST" action="register">
    {!! csrf_field() !!}
    <div>
        Name
        <input type="name" name="name" value="">
    </div>
    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password" id="password">
    </div>



    <div>
        <button type="submit">register</button>
    </div>
</form>