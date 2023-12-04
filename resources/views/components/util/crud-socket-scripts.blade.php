<div>
    @foreach ($socketListeners as $key => $data)
        <script type="module">
            Echo.channel("global").listen('{{ $data['event'] }}', (e) => {
                window.livewire.emit('socket', '{{ $key }}', e)
            })
        </script>
    @endforeach
</div>
