@extends('profile.layout')
@section('content')
<h2 class="text-xl font-bold mb-4">{{ __('requests_used') }}</h2>
<form method="POST" action="{{ route('profile.send_request') }}" class="mb-8 flex gap-4 items-end">
    @csrf
    <div class="flex-1">
        <label class="block mb-1 font-semibold">{{ __('send_request_text') }}</label>
        <textarea name="text" rows="2" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition"></textarea>
    </div>
    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">{{ __('send') }}</button>
</form>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded-xl shadow-lg">
        <thead class="bg-blue-100 text-blue-700">
            <tr>
                <th class="py-2 px-4">#</th>
                <th class="py-2 px-4">{{ __('send_request_text') }}</th>
                <th class="py-2 px-4">{{ __('result_type') }}</th>
                <th class="py-2 px-4">{{ __('response') }}</th>
                <th class="py-2 px-4">{{ __('created_at') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->requests()->latest()->limit(20)->get() as $req)
                <tr class="border-b hover:bg-blue-50 transition">
                    <td class="py-2 px-4">{{ $req->id }}</td>
                    <td class="py-2 px-4">{{ $req->text }}</td>
                    <td class="py-2 px-4">{{ __("stat_".$req->result_type) }}</td>
                    <td class="py-2 px-4">{{ $req->response }}</td>
                    <td class="py-2 px-4">{{ $req->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 