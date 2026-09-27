@props(['name', 'class' => 'w-8 h-8'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}" aria-hidden="true">
    @switch($name)
        @case('kitchen')
            <path d="M3 8h18M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8M9 8V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v3" />
            <path d="M8 13h1M8 16h1" />
            @break

        @case('bathroom')
            <path d="M4 12h16v3a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4v-3Z" />
            <path d="M4 12V7a2 2 0 0 1 2-2h1v3M7 5V4" />
            <path d="M9 19v1M15 19v1" />
            @break

        @case('pmr')
            <circle cx="14" cy="5" r="1.75" />
            <path d="M12.5 8.5 11 13h6l2.5 5M11 13l-2 6M11 13H8" />
            <path d="M9.5 16.5a4 4 0 1 0 6.7 3" />
            @break

        @case('renovation')
            <path d="M14 6 18 10M4 20l7.5-7.5M17 5l2 2-8.5 8.5-2.8.8.8-2.8L17 5Z" />
            @break

        @case('plumbing')
            <path d="M7 4v4a3 3 0 0 0 3 3h1v9M11 11a3 3 0 0 0 3-3V4M9 4h4M18 15a3 3 0 1 1-6 0c0-1.5 3-4.5 3-4.5s3 3 3 4.5Z" />
            @break

        @case('electricity')
            <path d="M13 3 5 14h5l-1 7 8-11h-5l1-7Z" />
            @break

        @case('painting')
            <path d="M4 21v-3a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v3M9 16v-3h6v3M9 13V8a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v5M11 6V3h2v3" />
            @break

        @case('partition')
            <path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z" />
            @break

        @case('ruler')
            <path d="M3 16 8 21 21 8 16 3 3 16Z" />
            <path d="M7 12l2 2M10 9l2 2M13 6l2 2" />
            @break

        @case('shield')
            <path d="M12 3 4 6v6c0 4.5 3.4 7.7 8 9 4.6-1.3 8-4.5 8-9V6l-8-3Z" />
            <path d="m9 12 2 2 4-4" />
            @break

        @case('clock')
            <circle cx="12" cy="12" r="9" />
            <path d="M12 7v5l3.5 2" />
            @break

        @case('phone')
            <path d="M6 3h3l1.5 4.5L8 9.5a11 11 0 0 0 6.5 6.5l2-2.5L21 15v3a2 2 0 0 1-2 2C11.5 20 4 12.5 4 5a2 2 0 0 1 2-2Z" />
            @break

        @case('pin')
            <path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" />
            <circle cx="12" cy="9" r="2.25" />
            @break

        @case('star')
            <path d="m12 3 2.6 5.6 6 .7-4.5 4.1 1.2 6-5.3-3-5.3 3 1.2-6-4.5-4.1 6-.7L12 3Z" />
            @break

        @case('check')
            <circle cx="12" cy="12" r="9" />
            <path d="m8 12.5 2.5 2.5L16 9.5" />
            @break

        @case('quote')
            <path d="M7 8a3 3 0 0 0-3 3v2a3 3 0 0 0 3 3M17 8a3 3 0 0 0-3 3v2a3 3 0 0 0 3 3" />
            @break

        @case('handshake')
            <path d="M3 11h4l3-2 3 2 3-2 4 2M7 9l3 6h3.5M13 15l2-1M4 11v4l3 2M20 11v4l-3 2" />
            @break

        @case('user')
            <circle cx="12" cy="8" r="3.5" />
            <path d="M5 20c0-3.9 3.1-6 7-6s7 2.1 7 6" />
            @break

        @case('mail')
            <rect x="3" y="5" width="18" height="14" rx="1" />
            <path d="m4 6.5 8 6 8-6" />
            @break

        @case('message')
            <path d="M4 5h16v11H8l-4 4V5Z" />
            @break

        @default
            <circle cx="12" cy="12" r="9" />
    @endswitch
</svg>
