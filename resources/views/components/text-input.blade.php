@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'p-1 border-black border-solid border-b focus:border-gray-400 focus:border-solid focus:border-b focus:ring-0 focus:outline-none']) !!}>
