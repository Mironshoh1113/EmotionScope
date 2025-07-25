@extends('profile.layout')
@section('content')
<h2 class="text-xl font-bold mb-4">{{ __('request_stats') }}</h2>
<div class="flex flex-col md:flex-row gap-8 items-center">
    <canvas id="requestStatsChart" height="120" class="max-w-xs"></canvas>
    <div class="flex flex-wrap gap-4 mt-4">
        @foreach($user->requestStats as $stat)
            <div class="bg-gray-100 px-3 py-1 rounded text-blue-700">
                {{ __("stat_".$stat->type) }}: <b>{{ $stat->count }}</b>
            </div>
        @endforeach
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const stats = @json($user->requestStats->pluck('count', 'type'));
    const ctx = document.getElementById('requestStatsChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(stats).map(type => {
                switch(type) {
                    case 'positive': return '{{ __('stat_positive') }}';
                    case 'negative': return '{{ __('stat_negative') }}';
                    case 'neutral': return '{{ __('stat_neutral') }}';
                    case 'offensive': return '{{ __('stat_offensive') }}';
                    case 'other': return '{{ __('stat_other') }}';
                }
            }),
            datasets: [{
                data: Object.values(stats),
                backgroundColor: [
                    '#22c55e', // positive
                    '#ef4444', // negative
                    '#facc15', // neutral
                    '#6366f1', // offensive
                    '#a3a3a3', // other
                ],
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection 