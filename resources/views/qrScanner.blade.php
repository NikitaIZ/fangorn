



<?php

/**
 * QR - Src - Module - Header
 * php version 7
 *
 * @category Ninguno
 * @package  Ninguno
 * @author   Ninguno <Ninguno@ninguno.com>
 * @license  Ninguno Ninguno.com
 * @link     Ninguno
 */
?>
<div class="column has-text-centered is-10-mobile is-10-tablet is-10-touch is-10-desktop is-10-widescreen is-10-fullhd is-offset-1-mobile is-offset-1-tablet is-offset-1-touch is-offset-1-desktop is-offset-1-widescreen is-offset-1-fullhd">

    <div class="notification is-warning" id="loadingMessage">
        🎥 No se puede acceder al flujo de vídeo
        (por favor, asegúrese de que tiene una cámara web habilitada)
    </div>
    <canvas id="canvas" hidden>
    </canvas>
    <div id="output" hidden>
        <div id="outputMessage">
            <p>
                <span class="icon">
                    <i class="fas fa-ban"></i>
                </span>
            </p>
            <p>
                No se detecta ningún código QR.
            </p>
        </div>
        <div hidden><span id="outputData"></span></div>
    </div>
</div>

<div id="scan"></div>

<script src="/js/qr-scanner/getQr.js"></script>