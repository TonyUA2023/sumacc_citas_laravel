<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login Admin</title>
</head>
<body>
    <h1>Login Admin</h1>

    @if($errors->any())
        <div style="color: red;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <label>Email:</label><br/>
        <input type="email" name="email" required autofocus><br/><br/>
        <label>Contraseña:</label><br/>
        <input type="password" name="password" required><br/><br/>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>