<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>Añadir datos</title>
</head>
<body>
    @foreach ($users as $user)
    @include('Elements.navbar')
    <div class="mt-3 text-center text-lg text-purple-500">
        <h3 class="bold">
            Seleccione su materia y digite su nota y número de unidades valorativas (En este orden)
        </h3>
    </div>
    <div class="container mt-5 lg:w-1/2  text-center text-black sm:mx-auto">
        <form action="/profile/me/myScores/adding" method="POST">
            @csrf
            <input type="hidden" value="{{$nOfSub}}" name="nOfS">
            <input type="hidden" value="{{$cicle}}" name="cicle">
            <input type="hidden" name="s_ID" value=" {{ $user->id_student }} ">
            @for ($i = 0; $i < $nOfSub; $i++)
            @include('Elements.subjectsForm')
            @endfor
            <button class="text-white bg-green-400 lg:w-auto lg:mx-1 my-2 lg:px-2 py-2 hover:bg-green-200 rounded lg:w-1/4 mx-1 sm:w-1/2">
                Agregar Materias
            </button>
        </form>    
    </div>
    @endforeach
</body>
</html>