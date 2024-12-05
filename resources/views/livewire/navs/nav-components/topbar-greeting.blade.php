<div>
    {{-- welcome variant --}}
    @if ($welcome)
        <h1 class="flex flex-col pb-4 text-center text-4xl font-bold">
            @if ($this->greeting === null)
                <span>&nbsp;</span>
            @else
                <span class="animate-fade-in-up text-accent-secondary">{{ strtoupper($this->greeting) }}</span>
            @endif
            <span>{{ strtoupper(__('Let\'s begin!')) }}</span>
        </h1>
    @else
        {{-- regular variant --}}
        @persist('greeting')
            <div class="flex w-max -translate-y-2 flex-col justify-start text-lg leading-5" id="greeting">
                @if ($this->greeting === null)
                    <span>&nbsp;</span>
                @else
                    <span class="animate-fade-in delay-500">{{ strtoupper($this->greeting) . ',' }}</span>
                @endif
                <span class="text-accent-secondary animate-fade-in delay-75">{{ strtoupper($this->name) }}</span>
            </div>
        @endpersist
    @endif

    @if ($this->greeting === null)
        @script
            <script>
                const hour = new Date().getHours();
                $wire.dispatch('client-time', {
                    client_hour: hour
                });
            </script>
        @endscript
    @endif
</div>
