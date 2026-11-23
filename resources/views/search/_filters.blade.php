{{-- Filter pencarian. Data: $categories, $operatingSystems, $filters (array dari request). --}}
<form method="GET" action="{{ route('search') }}">
    <x-ui.panel>
        <h2 class="mb-3 text-lg font-black">Filter</h2>
        <x-form.input name="q" label="Kata kunci" :value="$filters['q'] ?? null" />
        <x-form.select name="category" label="Kategori" placeholder="Semua kategori"
                       :options="$categories->pluck('category_name', 'category_id')->all()" :selected="$filters['category'] ?? null" />
        <x-form.select name="os" label="Sistem operasi" placeholder="Semua"
                       :options="$operatingSystems->pluck('os_name', 'os_id')->all()" :selected="$filters['os'] ?? null" />
        <x-form.input name="max_price" label="Harga maksimum (Rp)" type="number" :value="$filters['max_price'] ?? null" />
        <x-form.select name="sort" label="Urutkan"
                       :options="['relevant' => 'Paling relevan', 'newest' => 'Terbaru', 'cheapest' => 'Harga terendah']" :selected="$filters['sort'] ?? 'relevant'" />
        <x-ui.button type="submit" block>Terapkan</x-ui.button>
    </x-ui.panel>
</form>
