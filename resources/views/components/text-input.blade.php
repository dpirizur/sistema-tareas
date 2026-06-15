@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-2xl border border-slate-700 bg-slate-950 text-slate-100 placeholder:text-slate-500 focus:border-blue-500 focus:ring-blue-500 focus:ring-2 shadow-sm']) }}>
