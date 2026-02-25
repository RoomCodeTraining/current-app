@extends('layouts.app')

@section('title', 'Mes cartes')

@section('content')
    <div class="max-w-sm mx-auto py-10 md:py-16">
        <p class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Entrez vos infos pour accéder à vos cartes
        </p>

        @if ($errors->any())
            <p class="mt-4 text-center text-sm text-red-600 dark:text-red-400">
                {{ $errors->first('code') ?: $errors->first('identifier') }}
            </p>
        @endif

        <form action="{{ route('modifier.login') }}" method="post" class="mt-8 space-y-4">
            @csrf
            <div>
                <label for="identifier" class="block text-xs font-medium mb-0.5 text-[#1b1b18] dark:text-white">Identifiant</label>
                <input
                    type="text"
                    name="identifier"
                    id="identifier"
                    value="{{ old('identifier') }}"
                    placeholder="AB3X9K"
                    required
                    autocomplete="username"
                    maxlength="8"
                    class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-white text-sm uppercase tracking-wider"
                >
                @error('identifier')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="code" class="block text-xs font-medium mb-0.5 text-[#1b1b18] dark:text-white">Code à 6 chiffres</label>
                <input
                    type="text"
                    name="code"
                    id="code"
                    value="{{ old('code') }}"
                    placeholder="123456"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    maxlength="6"
                    required
                    autocomplete="one-time-code"
                    class="w-full px-3 py-2 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-white text-sm"
                >
                @error('code')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full py-2.5 rounded-xl bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] text-sm font-medium hover:opacity-90 active:opacity-80 transition-opacity"
            >
                Accéder
            </button>
        </form>
    </div>
@endsection
