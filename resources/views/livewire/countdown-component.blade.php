<div>
    <span id="countdown" class="countdown font-mono text-xs {{ $remainingDays < 5 ? 'text-red-500' : '' }}">
        {{ $remainingDays }}d {{ __('countdown.label') }}
    </span>
</div>
