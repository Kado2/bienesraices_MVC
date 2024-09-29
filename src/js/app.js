document.addEventListener('DOMContentLoaded', function() {
    eventListeners();
    darkMode();
});



function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', ResponsiveNav);

    //Muestra mensajes condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contactar]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
}

function mostrarMetodosContacto (e) {
    const contactoDiv = document.querySelector('#contacto');
    if (e.target.value === 'telefono'){
        contactoDiv.innerHTML= `
            <label for="tel">Teléfono</label>
            <input id="tel" name="contacto[tel]" type="text" placeholder="Tu teléfono.." required>
            <p>Elija la fecha y hora para ser contactado</p>

            <label for="fecha">Fecha</label>
            <input id="fecha" name="contacto[fecha]" type="date">

            <label for="hora">Hora</label>
            <input id="hora" name="contacto[hora]" type="time" min="9:00" max="18:00">
        `;
    } else {
        contactoDiv.innerHTML= `
            <label for="email">Email</label>
            <input id="email" name="contacto[email]" type="text" placeholder="Tu email.." required>`;
    }
}


function ResponsiveNav() {
    const navegacion = document.querySelector('.navegacion');
    navegacion.classList.toggle('mostrar');
}

function darkMode() {
    let savedResult = localStorage.getItem('DarkModeResult');
    const prefiereDarkM = window.matchMedia('(prefers-colors-scheme: dark)');
    //console.log(prefiereDarkM.matches);
    if ((prefiereDarkM.matches) || savedResult === 'true') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
    prefiereDarkM.addEventListener('change', function(){
        if (prefiereDarkM.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    })

    const btnDarkMode = document.querySelector('.dark-mode-boton');
    btnDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
        if ((savedResult === 'false') || (savedResult === null)) {
            savedResult = 'true';
            localStorage.setItem('DarkModeResult', savedResult);
        } else {
            savedResult = 'false';
            localStorage.setItem('DarkModeResult', savedResult);
        }
    })
}
