{{-- ヘッダー・フッターありのレイアウト --}}

{{-- ヘッドを読み込み --}}
@Component('Components.head')
@endcomponent

<body>

    {{-- フラッシュメッセージ --}}
    @Component('Components.flush_msg')
    @endcomponent

    <div id="app">
        {{-- ヘッダーを読み込み --}}
        @component('Components.header')
        @endcomponent

        @yield('content')

        {{-- フッターを読み込み --}}
        @component('Components.footer')
        @endcomponent
    </div>

</body>

</html>
