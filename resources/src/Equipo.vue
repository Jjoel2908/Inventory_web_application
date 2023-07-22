<template>
    <div>
        <h1 class="text-center">
            <i class="fas fa-desktop"></i> | Equipos de cómputo
        </h1>
    </div>

    <!-- Botón para agregar un nuevo registro -->
    <div class="d-flex justify-content-end">
        <button
            @click="
                update = false;
                openModal();
            "
            type="button"
            class="btn btn-dark"
        >
            <i class="fas fa-plus"></i>
            Agregar equipo
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
                        <label for="marca">Marca</label>
                        <input
                            v-model="equipo.marca"
                            type="text"
                            class="form-control"
                            id="marca"
                            placeholder="Marca de equipo"
                            name=""
                        />
                    </div>

                    <div>
                        <label for="modelo">Modelo</label>
                        <input
                            v-model="equipo.modelo"
                            type="text"
                            class="form-control"
                            id="modelo"
                            placeholder="Modelo de equipo"
                            name=""
                        />
                    </div>

                    <div>
                        <label for="caracteristicas">Caracteristicas</label>
                        <input
                            v-model="equipo.caracteristicas"
                            type="text"
                            class="form-control"
                            id="caracteristicas"
                            placeholder="Información sobre equipo"
                            name=""
                        />
                    </div>

                    <div>
                        <label for="estado">Estado</label>
                        <select
                            v-model="equipo.estado"
                            class="form-select"
                            id="estado"
                            name="estado"
                        >
                            <option value="En resguardo">En resguardo</option>
                            <option value="Disponible">Disponible</option>
                            <option value="En reparación">En reparación</option>
                        </select>
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
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Características</th>
                    <th scope="col">Estado</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr v-for="equipo in equipos" :key="equipo.id">
                    <th scope="row">{{ equipo.id }}</th>
                    <td>{{ equipo.marca }}</td>
                    <td>{{ equipo.modelo }}</td>
                    <td>{{ equipo.caracteristicas }}</td>
                    <td>{{ equipo.estado }}</td>
                    <td>
                        <button
                            @click="
                                update = true;
                                openModal(equipo);
                            "
                            class="btn btn-warning"
                        >
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                    </td>
                    <td>
                        <button
                            @click="eliminar(equipo.id)"
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

export default {
    data() {
        return {
            equipo: {
                marca: "",
                modelo: "",
                caracteristicas: "",
                estado: "",
            },
            id: 0,
            update: true,
            modal: 0,
            titleModal: " ",
            equipos: [],
        };
    },
    methods: {
        //Método para listar todos los registros de la base de datos
        async listar() {
            const res = await axios.get("equipos");

            this.equipos = res.data;
        },

        //Método para eliminar un registro de la base de datos
        async eliminar(id) {
            const res = await axios.delete("/equipos/" + id);
            this.listar();
        },

        //Método para guardar o actualizar
        async guarda() {
            if (this.update) {
                console.log(this.id);
                console.log(this.equipo);
                const res = await axios.put("/equipos/" + this.id, this.equipo);
                console.log(res.data);
            } else {
                console.log(this.equipo);
                const res = await axios.post("/equipos", this.equipo);
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
                this.equipo.marca = data.marca;
                this.equipo.modelo = data.modelo;
                this.equipo.caracteristicas = data.caracteristicas;
                this.equipo.estado = data.estado;
            } else {
                (this.id = 0), (this.titleModal = "Agregar equipo");
                this.equipo.marca = data.marca;
                this.equipo.modelo = data.modelo;
                this.equipo.caracteristicas = data.caracteristicas;
                this.equipo.estado = data.estado;
            }
        },
        //Cierra la ventana modal
        closeModal() {
            this.modal = 0;
        },

        //Método para exportar en PDF al pulsar el botón
        exportarPDF() {
            const pdfElement = this.$refs.pdfElement;

            html2pdf().from(pdfElement).save("tabla_equipos.pdf");
        },

        //Método para exportar en Excel al pulsar el botón
        exportarExcel() {
            const exportData = async () => {
                await this.listar();

                const jsonData = this.equipos.map((equipo) => ({
                    Id: equipo.id,
                    Marca: equipo.marca,
                    Modelo: equipo.modelo,
                    Caracteristicas: equipo.caracteristicas,
                    Estado: equipo.estado,
                }));

                const worksheet = XLSX.utils.json_to_sheet(jsonData);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Equipos");
                writeFile(workbook, "tabla_equipos.xlsx");
            };

            exportData();
        },
    },
    created() {
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
</style>
