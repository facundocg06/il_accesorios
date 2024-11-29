@php
    $containerFooter =
        isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact'
            ? 'container-xxl'
            : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>, hecho por el Grupo 19
            </div>
            <div class="d-none d-lg-inline-block">
                {{-- Ejemplo de cómo mostrar el contador de visitas --}}
                @php
                    $pageUrl = Route::current()->uri();
                    $pageView = \App\Models\PageView::where('page_url', $pageUrl)->first();
                @endphp

                @if ($pageView)
                    <p>Esta página ha sido visitada {{ $pageView->visits }} veces.</p>
                @endif
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->
