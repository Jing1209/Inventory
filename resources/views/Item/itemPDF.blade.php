<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($data as $data1)
       <p> {{$data1->title}} </p>
        
    @endforeach
   {{-- <p>Bad of first index{{$countBad}}</p>
   <p>Good of first index{{$countGood}}</p>
   <p>Broken of first index{{$countBroken}}</p>
   <p>Medium of first index{{$countMedium}}</p> --}}

   @foreach ($countBad as $bad )
    <p>{{$bad->title}}</p>
    <p>{{$bad->status}}</p>
       
   @endforeach
</body>
</html>