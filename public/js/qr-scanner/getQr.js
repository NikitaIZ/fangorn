import QrScanner from '../qr-scanner/qr-scanner.min.js'; // if using plain es6 import


const videoElem = document.querySelector("#qrScanner");
const container = document.querySelector("#container")
const qrScanner = new QrScanner(
    videoElem,
    onScan,
    {
        highlightScanRegion: true,
        onDecodeError : onError,
        maxScansPerSecond : 1,
        highlightCodeOutline : true,
    }

)



function getErrorTemplate(message){
    return `
    <div class="alert alert-danger text-center p-4" role="alert">
        ${message}
    </div>
    `

}

function getResultTemplate(message){
    return `
    <div class="alert alert-info text-center p-4" role="alert">
        ${message}
    </div>
    `
    
}

function onScan(e){
    try {
        const data = JSON.parse(e.data)
        container.innerHTML = getResultTemplate(data)
        qrScanner.stop()
        window.location.replace(`/security/qrScanner/QR/${data}`)
    } catch (error) {
        container.innerHTML = getErrorTemplate("Invalid QR")
    }
    
}

function onError(e){
    
    container.innerHTML = getErrorTemplate("No se detecto ningun codigo QR")

}


qrScanner.start()