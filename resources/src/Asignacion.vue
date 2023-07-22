<template>
    <div>
        <h1 class="text-center"><i class="fas fa-tasks"></i> | Asignaciones</h1>
    </div>

    <!-- Botón para agregar un nuevo registro -->
    <div class="d-flex justify-content-end">
        <button
            @click="
                update = false;
                openModal();
            "
            type="button"
            class="btn btn-dark ml-auto"
        >
            <i class="fas fa-plus"></i>
            Agregar asignación
        </button>
    </div>

    <!-- Modal -->
    <div class="modal" :class="{ show: modal }">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1
                        class="modal-title fs-5 text-center"
                        id="exampleModalLabel"
                    >
                        {{ titleModal }}
                    </h1>
                    <button
                        @click="closeModal()"
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="equipo_id">Equipo</label>
                        <select
                            v-model="asignacion.equipo_id"
                            class="form-control"
                            id="equipo_id"
                        >
                            <option
                                v-for="equipo in equipos"
                                :value="equipo.id"
                                :key="equipo.id"
                            >
                                {{ equipo.marca }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="usuario_id">Usuario</label>
                        <select
                            v-model="asignacion.usuario_id"
                            class="form-control"
                            id="usuario_id"
                        >
                            <option
                                v-for="empleado in empleados"
                                :value="empleado.id"
                                :key="empleado.id"
                            >
                                {{ empleado.nombre }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="fecha_asignacion"
                            >Fecha de asignación</label
                        >
                        <VueDatePicker v-model="asignacion.fecha_asignacion" id="fecha_asignacion">
                        </VueDatePicker>
                    </div>

                </div>
                <div class="modal-footer">
                    <button
                        @click="closeModal()"
                        type="button"
                        class="btn btn-danger"
                        data-bs-dismiss="modal"
                    >
                        Cerrar
                    </button>
                    <button
                        @click="guarda()"
                        type="button"
                        class="btn btn-success"
                    >
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor para la tabla que contendrá todos los registros de la base de datos -->
    <div ref="pdfElement">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Id Equipo</th>
                    <th scope="col">Id Usuario</th>
                    <th scope="col">Fecha</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr v-for="asignacion in asignaciones" :key="asignacion.id">
                    <th scope="row">{{ asignacion.id }}</th>
                    <td>{{ asignacion.equipo_id }}</td>
                    <td>{{ asignacion.usuario_id }}</td>
                    <td>{{ asignacion.fecha_asignacion }}</td>
                    <td>
                        <button
                            @click="
                                update = true;
                                openModal(asignacion);
                            "
                            class="btn btn-warning"
                        >
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                    </td>
                    <td>
                        <button
                            @click="eliminar(asignacion.id)"
                            class="btn btn-danger"
                        >
                            <i class="fas fa-trash-alt"></i>
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Botones para exportar en PDF y Excel -->
    <div class="d-flex justify-content-center align-items-center">
        <div>
            <button @click="exportarPDF" class="btn btn-danger">
                <i class="far fa-file-pdf"></i>
                Exportar a PDF
            </button>
            <button @click="exportarExcel" class="btn btn-success">
                <i class="far fa-file-excel"></i>
                Exportar a Excel
            </button>
        </div>
    </div>
</template>

<script>
import jsPDF from "jspdf";
import html2pdf from "html2pdf.js";
import { writeFile } from "xlsx";
import VueDatePicker from '@vuepic/vue-datepicker';

export default {
    data() {
        return {
            asignacion: {
                equipo_id: "",
                usuario_id: "",
                fecha_asignacion: "",
            },
            id: 0,
            update: true,
            date: null,
            modal: 0,
            titleModal: " ",
            asignaciones: [],
            equipos: [],
            empleados: [],
        };
    },
    components: { VueDatePicker },
    methods: {
        //Método para listar todos los registros de la base de datos
        async listar() {
            const res = await axios.get("asignaciones");

            this.asignaciones = res.data;
        },

        //Método para eliminar un registro de la base de datos
        async eliminar(id) {
            const res = await axios.delete("/asignaciones/" + id);
            this.listar();
        },

        //Método para guardar o actualizar
        async guarda() {
            if (this.update) {
                const res = await axios.put(
                    "/asignaciones/" + this.id,
                    this.asignacion
                );
                console.log(res.data);
                this.closeModal();
            } else {
                console.log(this.asignacion);
                const res = await axios.post("/asignaciones", this.asignacion);
                console.log(res.data);
            }
            this.closeModal();
            this.listar();
        },

        //Abre la ventana modal
        openModal(data = {}) {
            this.modal = 1;
            if (this.update) {
                (this.id = data.id), (this.titleModal = "Editar información");
                this.asignacion.equipo_id = data.equipo_id;
                this.asignacion.usuario_id = data.usuario_id;
                this.asignacion.fecha_asignacion = data.fecha_asignacion;
            } else {
                (this.id = 0), (this.titleModal = "Agregar equipo");
                this.asignacion.equipo_id = data.equipo_id;
                this.asignacion.usuario_id = data.usuario_id;
                this.asignacion.fecha_asignacion = data.fecha_asignacion;
            }
        },
        //Cierra la ventana modal
        closeModal() {
            this.modal = 0;
        },

        //Método para exportar en PDF al pulsar el botón
        exportarPDF() {
            const pdfElement = this.$refs.pdfElement;

            html2pdf().from(pdfElement).save("tabla_asignaciones.pdf");
        },

        //Método para exportar en Excel al pulsar el botón
        exportarExcel() {
            const exportData = async () => {
                await this.listar();

                const jsonData = this.asignaciones.map((asignacion) => ({
                    Id: asignacion.id,
                    Equipo_id: asignacion.equipo_id,
                    Usuario_id: asignacion.usuario_id,
                }));

                const worksheet = XLSX.utils.json_to_sheet(jsonData);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(
                    workbook,
                    worksheet,
                    "Asignaciones"
                );
                writeFile(workbook, "tabla_asignaciones.xlsx");
            };

            exportData();
        },

        async listarEquipos() {
            const res = await axios.get("/equipos");
            this.equipos = res.data;
        },

        async listarEmpleados() {
            const res = await axios.get("/empleados");
            this.empleados = res.data;
        },
    },
    created() {
        this.listarEmpleados();
        this.listarEquipos();
        this.listar();
    },
};
</script>

<style>
.show {
    display: list-item;
    opacity: 1;
    background: rgba(44, 38, 75, 0.849);
}

@import '@vuepic/vue-datepicker/dist/main.css';
</style>
