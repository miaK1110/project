{{-- ヘッダーとフッターなしのレイアウト --}}

{{-- ヘッドを読み込み --}}
@Component('Components.head')
@endcomponent

<body>

    {{-- フラッシュメッセージ --}}
    @Component('Components.flush_msg')
    @endcomponent

    <div id="app" v-cloak>
        @yield('content')
    </div>

</body>

</html>
