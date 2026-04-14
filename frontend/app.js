const API = "http://localhost/sistema_asientos/backend/";

const LIMIT_TIME = 300;

// Obtener asientos desde backend
function loadSeats() {
    fetch(API)
        .then(res => res.json())
        .then(data => render(data));
}

// Renderizar los asientos en el html del sitio
function render(asientos) {
    const container = document.getElementById("container");
    container.innerHTML = "";

    let filaActual = "";
    let filaDiv;

    asientos.forEach(element => {

        // Crear nueva fila
        if (filaActual !== element.fila) {
            filaActual = element.fila;

            filaDiv = document.createElement("div");
            filaDiv.className = "queue mb-3";

            const title = document.createElement("h3");
            title.innerText = "Fila: " + filaActual;
            filaDiv.appendChild(title);
            container.appendChild(filaDiv);
        }

        // Crear botón de los asientos
        const btn = document.createElement("button");

        btn.innerText = element.fila + element.numero;

        // Estado Visual si el asiento está disponible o no
        if (element.estado.trim().toLowerCase() === "disponible") {
            btn.className = "btn btn-success m-1";
        } else {
            btn.className = "btn btn-danger m-1";

            // Calcular el tiempo restante de cuando el asiento está ocupado
            const time = element.tiempo_ocupado || 0;
            const remainingTime = LIMIT_TIME - time;

            if (remainingTime > 0) {
                // ⏱️ Formato mm:ss
                const min = Math.floor(remainingTime / 60);
                const sec = remainingTime % 60;

                btn.innerText += ` (${min}:${sec.toString().padStart(2, "0")})`;

                if (remainingTime <= 10) {
                    btn.classList.remove("btn-danger");
                    btn.classList.add("btn-warning");

                    showAlert(`⚠️ El asiento ${element.fila}${element.numero} se liberará pronto`);
                }
            }
        }

        btn.onclick = () => toggleSeat(element.id);
        filaDiv.appendChild(btn)
    });
}


//  Cambiar el estado del asiento

function toggleSeat(id) {
    fetch(API, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id })
    })
        .then(res => res.json())
        .then(() => {
            setTimeout(loadSeats, 200);
        });
}

// la alerta visual posicionado a la arriba esquina derecha
function showAlert(mensaje) {

    const alerta = document.createElement("div");

    alerta.className = "alert alert-warning position-fixed top-0 end-0 m-3";
    alerta.innerText = mensaje;

    document.body.appendChild(alerta);

    setTimeout(() => {
        alerta.remove();
    }, 3000);
}


setInterval(loadSeats, 1000);