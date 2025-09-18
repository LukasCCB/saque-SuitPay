<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-white dark:bg-zinc-800">

        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="banknotes" :href="route('home')" :current="request()->routeIs('home')" wire:navigate.hover>
                    {{ __('Sacar') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">

                <flux:tooltip :content="__('Documentação de Integração')" position="bottom">
                    <flux:navbar.item icon="document-text" arget="_blank" href="https://api.suitpay.app/?_gl=1*1jb0u2t*_gcl_au*OTAyMDA0MDguMTc1MjYyMTk3MA..">
                        Documentação
                    </flux:navbar.item>
                </flux:tooltip>

                <flux:tooltip :content="__('Contatar Desenvolvedor')" position="bottom">
                    <flux:navbar.item icon="chat-bubble-left-right" target="_blank" href="https://wa.me/5547999302240?text=Ajuda na plataforma de saque SuitPay">
                        Desenvolvedor
                    </flux:navbar.item>
                </flux:tooltip>

            </flux:navbar>

        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">

                <flux:navlist.group :heading="__('Platform')">
                    <flux:navbar.item icon="banknotes" :href="route('home')" :current="request()->routeIs('home')" wire:navigate.hover>
                        {{ __('Sacar') }}
                    </flux:navbar.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navbar.item icon="document-text" arget="_blank" href="https://api.suitpay.app/?_gl=1*1jb0u2t*_gcl_au*OTAyMDA0MDguMTc1MjYyMTk3MA..">
                    Documentação
                </flux:navbar.item>

                <flux:navbar.item icon="chat-bubble-left-right" target="_blank" href="https://wa.me/5547999302240?text=Ajuda na plataforma de saque SuitPay">
                    Desenvolvedor
                </flux:navbar.item>
            </flux:navlist>
        </flux:sidebar>

        {{ $slot }}

        @persist('toast')
        <flux:toast.group  position="top center">
            <flux:toast expanded/>
        </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
