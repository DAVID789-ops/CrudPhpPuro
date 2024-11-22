<?php include_once "encabezado.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Devoluciones</title>
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <style>
        #video {
            width: 100%;
            height: auto;
            max-width: 600px; /* Tamaño máximo del video */
            margin: 0 auto; /* Centrar video */
        }
        .codigo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
            padding: 5px;
            border: 1px solid #ccc;
        }
        #codigoManual {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Escanea un Código de Barras</h1>
    <video id="video" autoplay></video>
    <div id="codigos-container"></div>
    <input type="text" id="codigoManual" placeholder="Ingresa código manualmente" />
    <button id="agregarManual">Agregar Código Manual</button>
    <button id="guardar">Guardar</button>
    
    <audio id="beep-sound" src="beep.mp3" preload="auto"></audio> <!-- Sonido de confirmación -->
    
    <script>
        const codeReader = new ZXing.BrowserMultiFormatReader();
        const videoInputDevices = [];
        let codigos = [];
        const beepSound = document.getElementById('beep-sound');

        // Obtener los dispositivos de video disponibles
        codeReader.getVideoInputDevices()
            .then((videoInputDevicesList) => {
                videoInputDevices.push(...videoInputDevicesList);
                const backCamera = videoInputDevices.find(device => device.label.toLowerCase().includes('back')) || videoInputDevices[0];
                const selectedDeviceId = backCamera.deviceId;

                // Iniciar la lectura de códigos desde la cámara seleccionada
                codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
                    if (result) {
                        if (!codigos.includes(result.text)) {  // Evitar códigos duplicados
                            codigos.push(result.text);  // Agregamos el código a la lista
                            mostrarCodigos();  // Muestra los códigos en la interfaz
                            beepSound.play();  // Reproducir sonido de confirmación
                        } else {
                            alert('El código ya fue escaneado.');
                        }
                    }
                    if (err && !(err instanceof ZXing.NotFoundException)) {
                        console.error(err);
                    }
                });
            })
            .catch((err) => {
                console.error(err);
            });

        function mostrarCodigos() {
            const container = document.getElementById('codigos-container');
            container.innerHTML = ''; // Limpiamos el contenedor

            codigos.forEach((codigo, index) => {
                const div = document.createElement('div');
                div.className = 'codigo';
                div.innerHTML = `
                    <span>${codigo}</span>
                    <button onclick="eliminarCodigo(${index})">Eliminar</button>
                `;
                container.appendChild(div);
            });
        }

        function eliminarCodigo(index) {
            codigos.splice(index, 1); // Eliminar el código del array
            mostrarCodigos(); // Actualizar la vista
        }

        document.getElementById('agregarManual').addEventListener('click', () => {
            const codigoManual = document.getElementById('codigoManual').value.trim();
            if (codigoManual) {
                if (!codigos.includes(codigoManual)) {  // Evitar códigos duplicados manuales
                    codigos.push(codigoManual);  // Agregamos el código manual a la lista
                    mostrarCodigos();  // Actualizar la vista
                    beepSound.play();  // Reproducir sonido de confirmación
                    document.getElementById('codigoManual').value = ''; // Limpiar el campo de entrada
                } else {
                    alert('El código ya fue agregado.');
                }
            } else {
                alert('Por favor ingresa un código.');
            }
        });

        document.getElementById('guardar').addEventListener('click', () => {
            if (codigos.length > 0) {
                fetch('procesar_eliminado.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ codigos }),
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    codigos = []; // Limpiar la lista de códigos después de guardar
                    mostrarCodigos(); // Actualizar la vista
                });
            } else {
                alert('No hay códigos para guardar.');
            }
        });
    </script>
</body>
</html>
<?php include_once "pie.php"; ?> 
