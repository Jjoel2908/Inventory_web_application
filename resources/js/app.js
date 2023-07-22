import './bootstrap';

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

// Importamos todo lo necesario para utilizar los componentes en VUE
import { createApp } from 'vue';
import Equipo from '../src/Equipo.vue';
import Asignacion from '../src/Asignacion.vue';
import Empleado from '../src/Empleado.vue';
// Importamos VueDate para poder utilizar el calendario
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


// Creamos instancias para los componentes de VUE
createApp(Empleado).mount('#empleado');
createApp(Equipo).mount('#equipo');
createApp(Asignacion).mount('#asignacion');





