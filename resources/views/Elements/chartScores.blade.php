<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>

@for ($i = 0; $i < $higher; $i++)
<div class="w-full mt-5 mx-auto">
    <canvas id="myChart_{{$i}}">    </canvas>
</div>
<div class="my-auto">
    <table class="w-3/4 text-green-500 mx-auto">
        <thead>
            <th>Materia:</th>
            <th>Nota</th>
        </thead>
        @foreach ($scores as $desc)
        @if($desc->cicle == $i+1)
        <tbody>
            <tr>
                <td class="text-left">{{$desc->subject->name}}</td>
                <td class="my-auto">{{$desc->score}}</td>
            </tr>
        </tbody>
        @endif
    @endforeach
    </table>
</ul>
</div>
@foreach ($scores as $score)
<script>
    @if($score->cicle == $i+1)
    var ctx{{$i}} = document.getElementById('myChart_{{$i}}').getContext('2d');
    var myChart{{$i}} = new Chart(ctx{{$i}}, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($scores as $scorex)
                @if($scorex->cicle == $i+1)
                    '{{$scorex->subject->name}}',
                @endif
                @endforeach
                ],
                datasets: [{
                    label: 'Ciclo {{$score->cicle}}',
                    data: [
                        @foreach ($scores as $scoren)
                        @if($scoren->cicle == $i+1)
                            {{$scoren->score}},
                        @endif
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.60)',
                        'rgba(255, 206, 86, 0.60)',
                        'rgba(54, 162, 235, 0.60)',
                        'rgba(75, 192, 192, 0.60)',
                        'rgba(153, 102, 255, 0.60)',
                        'rgba(255, 159, 64, 0.60)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
                ticks: {
                    display: false 
                }
            }]
        }
    }
});
@endif
</script>
@endforeach
@endfor