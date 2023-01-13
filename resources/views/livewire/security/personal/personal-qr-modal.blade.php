<div>
    <div wire:ignore.self class="modal fade" id="qr-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Codigo QR</h5>
                    <button wire:click="cleanPropertys" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                @if($readyToLoad)
                    <div class="qr-code d-flex justify-content-center align-items-center flex-column gap-3">
                        <div id="qr-code-container">
                            <div>
                                @can('personal.qr')
                                    {{\QrCode::format("svg")->size(250)->generate($encryptedData);}}
                                @endcan
                            </div>
                        </div>
                        @can('personal.qr')
                            <div class="btn-group">
                                <a class="btn btn-primary" href="{{route('security.qrScanner.download',$encryptedData)}}">Descargar QR</a>
                                <button id="btn-print-qr" class="btn btn-info btn-print">Imprimir QR</button>
                            </div>
                        @endcan
                    </div>
                    @can('personal.qr')
                        <script>
                            function setPrint(){
                                const qr = document.querySelector(`#qr-code-container`)
                                const div_to_print = window.open('', '', 'height=500, width=500');
                                div_to_print.document.write('<html>');
                                div_to_print.document.write('<body');
                                div_to_print.document.write(qr.innerHTML);
                                div_to_print.document.write('</body></html>');
                                div_to_print.document.close();
                                div_to_print.print()
                            }
                            const btn =  document.querySelector("#btn-print-qr")
                            btn.addEventListener("click",setPrint)
                        </script>
                    @endcan
                @else
                <div wire:loading  class="container-fluid  d-flex justify-content-center">
                    <div wire:loading     class="spinner-grow text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                @endif
            </div>
                <div class="modal-footer">
                    <button wire:click="cleanPropertys" type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>
