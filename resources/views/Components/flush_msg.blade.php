{{-- フラッシュメッセージ --}}

<script type="text/javascript">
    // {{-- 成功時 --}}
    @if (session('msg_success'))
        $(function () {
        toastr.success('{{ session('msg_success') }}');
        });
    @endif

    // {{-- 失敗時 --}}
    @if (session('msg_error'))
        $(function () {
        toastr.error('{{ session('msg_error') }}');
        });
    @endif
</script>
