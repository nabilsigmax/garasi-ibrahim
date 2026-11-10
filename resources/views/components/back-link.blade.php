@props(['href', 'label' => 'Kembali'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 rounded-lg bg-slate-100 px-3.5 py-2 text-xs font-semibold text-slate-600 transition-all hover:bg-blue-50 hover:text-blue-600']) }}>
    <i class="fas fa-arrow-left"></i>
    <span>{{ $label }}</span>
</a>
