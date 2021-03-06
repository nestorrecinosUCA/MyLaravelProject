<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resultado de las busqueda</title>
    <style>
        .bw-social{
            filter: grayscale(85%);
        }
    </style>
    <link rel="icon" type="image/png" href="/images/logo.png">
</head>
<body class="bg-white h-screen">
@foreach ($users as $user)
    @include('Elements.navbar')
@endforeach
<div class="text-center">
    <p class="italic">Resultado de la busqueda:</p>
</div>
@if(!is_null($results))
@foreach ($results as $result)
<div class="lg:mx-auto lg:w-3/4 text-white">
    <div class=" border-blue-700 max-w-sm w-full lg:max-w-full lg:flex my-2">
        <div class="h-64 lg:h-auto lg:w-56 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-1 text-center overflow-hidden" style="background-image: url({{asset("storage/Universities/{$result->university->logo}")}})" title="Estudiante de UCA">
        </div>
        <div class="border-r border-b border-1 border-gray-400 lg:border-1-0 lg:border-t lg:w-full lg:border-gray-400 bg-{{$result->university->color}} rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
            <div class="mb-8">
                <div class="text-white font-bold text-xl mb-2">{{$result->name}} {{$result->lastname}}</div>
                <p class="text-purple-100 text-base">
                    Estudiante de {{$result->career->name}} en 
                    {{$result->university->name}}, {{$result->country->name}}.
                </p>
                <p>
                    CUM: 
                    @if(!is_null($result->userCUM))
                    {{$result->userCUM}}
                    @else
                    0.0
                    @endif
                    - Materias completadas: 
                    @if(!is_null($result->subjectsDone))
                    {{$result->subjectsDone}}
                    @else
                    0
                    @endif
                    /
                    @foreach($sbyCareer as $as)
                        @if($as->university_id == $result->university_id && $as->career_id == $result->university_id)
                            {{$as->nofSubjects}}
                        @endif
                    @endforeach
                </p>
            </div>
            <div class="flex items-center">
                @if(!is_null($result->image))
                <img src="{{asset("storage/profile/{$result->image}")}}" alt="{{$result->name}} Picture" class="w-32 h-32 rounded-full mr-4">
                @else
                <img src="{{asset("storage/profile/defaultprofpic.jpg")}}" alt="{{$result->name}} Picture" class="w-32 h-32 rounded-full mr-4">
                @endif
                <div class="text-sm">
                    <p class="text-white leading-none">{{$result->name}} {{$result->lastname}}</p>
                    <p class="text-gray-100"> 
                        {{$result->email}} 
                    </p>
                    <div class="w-2/5">
                        <div class="flex">
                            @foreach($userMedia as $uMedia)
                            @if(($uMedia->user_id == $result->id))
                            @if(!is_null($uMedia->link))
                            <a href="{{$uMedia->link}}" target="_blank" class="mx-auto">
                                <img src="{{asset("storage/SocialPhotos/{$uMedia->socialmedia->socialPhoto}")}}" alt="{{$uMedia->socialmedia->socialName}}" class="mx-3 w-5">
                            </a>
                            @endif
                            @endif      
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@else
<div class="text-center">
    <strong>No se encontraron Resultados. :(</strong>
</div>
@endif
</body>
</html>