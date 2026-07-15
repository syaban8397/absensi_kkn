@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'rounded-xl border-slate-200 bg-white text-slate-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 disabled:cursor-not-allowed disabled:bg-slate-100'
]) }}>
