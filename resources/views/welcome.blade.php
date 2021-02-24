<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>Example</title>
</head>
<body>
    <div class="container mx-auto">
        <x-alert color="indigo" class="mb-2">
            <x-slot name="title">
                TEST
            </x-slot>
            Lorem Ipsum osaijdoiasjdoia
        </x-alert>
        <x-alert color="red">
            <x-slot name="title">
                fnoisdfnsf
            </x-slot>
             Ipsum osaijdoiasjdoia
        </x-alert>
    </div>
</body>
</html>