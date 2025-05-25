const formulario = document.querySelector('form');
const tiempo = document.querySelector('#tiempo');
const recorridos = document.querySelector('#recorridos');

const calcular = async (e) => {

    try {
        e.preventDefault();
        e.submitter.disabled = true;
        e.submitter.innerText = 'Calculando...';
        const inicio = new Date(); // Hora de inicio

        const body = new FormData(formulario);

        const response = await fetch('index.php', {
            method: 'POST',
            body
        });
        const result = await response.json();
        const fin = new Date();
        const diferenciaMs = fin - inicio;
        const diferenciaSegundos = diferenciaMs / 1000;

        tiempo.innerText = `Tiempo de ejecución: ${diferenciaMs} ms (${diferenciaSegundos} segundos)`;
        tiempo.classList.add('text-success')

        console.log(result);
        recorridos.innerHTML = '';
        const fragmento = document.createDocumentFragment();
        let i = 1;
        result.forEach(recorrido => {
            const titulo = document.createElement('h5');
            titulo.classList.add('text-center', 'mt-3');
            titulo.innerText = `Recorrido ${i++}`;
            fragmento.appendChild(titulo);
            const tablaInicio = document.createElement('table');
            tablaInicio.classList.add('table', 'table-striped', 'table-bordered');
            tablaInicio.innerHTML = `
            <tr>
                <th>W1</th>
                <td>${recorrido.w1}</td>
                <th>W2</th>
                <td>${recorrido.w2}</td>
                <th>UMBRAL</th>
                <td>${recorrido.umbral}</td>
                <th>aprendizaje</th>
                <td>${recorrido.aprendizaje}</td>
            </tr>`

            const tablaDatos = document.createElement('table');
            tablaDatos.classList.add('table', 'table-striped', 'table-bordered');
            let html =
                `<thead>
                <tr>
                    <th>TX1</th>
                    <th>W1</th>
                    <th>TX2</th>
                    <th>W2</th>
                    <th>SE</th>
                    <th>UMBRAL</th>
                    <th>Y</th>
                    <th>RESULTADO</th>
                    <th>CUMPLE</th>
                </tr>
            </thead>`;

            html += `<tbody>`;
            recorrido.calculos.forEach(calculo => {
                html += `
                <tr>
                    <td>${calculo[0]}</td>
                    <td>${calculo[1]}</td>
                    <td>${calculo[2]}</td>
                    <td>${calculo[3]}</td>
                    <td>${calculo[4]}</td>
                    <td>${calculo[5]}</td>
                    <td>${calculo[6]}</td>
                    <td>${calculo[7]}</td>
                    <td>${calculo[8] == 'SI' ? '<i class="bi bi-check-lg text-success"></i>' : '<i class="bi bi-x-lg text-danger"></i>'}</td>
                </tr>`;
            });
            html += `</tbody>`;
            tablaDatos.innerHTML = html;

            fragmento.appendChild(tablaInicio);
            fragmento.appendChild(tablaDatos);
        });

        recorridos.appendChild(fragmento);

    } catch (error) {
        console.log(error);
        tiempo.classList.add('text-danger')
        tiempo.innerText = `Error: ${error.message}`;
        recorridos.innerHTML = '';

    }

    e.submitter.disabled = false;
    e.submitter.innerText = 'Calcular';


}

const limpiar = () => {
    tiempo.innerText = '';
    recorridos.innerHTML = '';
}

formulario.addEventListener('submit', calcular);
formulario.addEventListener('reset', limpiar);