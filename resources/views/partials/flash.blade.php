@if (session('status'))
    <div class="mb-4 rounded-sm border border-accent-2/40 bg-panel px-4 py-3 text-sm backdrop-blur-md">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded-sm border border-accent/50 bg-panel px-4 py-3 text-sm backdrop-blur-md">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
