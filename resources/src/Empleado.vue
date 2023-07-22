<template>
    <div>
        <h1 class="text-center"><i class="fas fa-users"></i> | Empleados</h1>
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
            Agregar empleado
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
                        <label for="nombre">Nombre</label>
                        <input
                            v-model="empleado.nombre"
                            type="text"
                            class="form-control"
                            id="nombre"
                            placeholder="Nombre de empleado"
                            name=""
                        />
                    </div>

                    <div>
                        <label for="departamento">Departamento</label>
                        <select
                            v-model="empleado.departamento"
                            class="form-select"
                            id="departamento"
                            name="departamento"
                        >
                            <option value="Finanzas">Finanzas</option>
                            <option value="Recursos Humanos">
                                Recursos Humanos
                            </option>
                            <option value="Marketing y Publicidad">
                                Marketing y Publicidad
                            </option>
                            <option value="Comercial">Comercial</option>
                            <option value="Compras">Compras</option>
                            <option value="Logística">Logística</option>
                            <option value="Gestión y Administración">
                                Gestión y Administración
                            </option>
                            <option value="Directivo">Directivo</option>
                            <option value="Sistemas">Sistemas</option>
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
                    <th scope="col">Nombre</th>
                    <th scope="col">Departamento</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr v-for="empleado in empleados" :key="empleado.id">
                    <th scope="row">{{ empleado.id }}</th>
                    <td>{{ empleado.nombre }}</td>
                    <td>{{ empleado.departamento }}</td>
                    <td>
                        <button
                            @click="
                                update = true;
                                openModal(empleado);
                            "
                            class="btn btn-warning"
                        >
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                    </td>
                    <td>
                        <button
                            @click="eliminar(empleado.id)"
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
            empleado: {
                nombre: "",
                departamento: "",
            },
            id: 0,
            update: true,
            modal: 0,
            titleModal: " ",
            empleados: [],
        };
    },
    methods: {
        //Método para listar todos los registros de la base de datos
        async listar() {
            const res = await axios.get("empleados");

            this.empleados = res.data;
        },

        //Método para eliminar un registro de la base de datos
        async eliminar(id) {
            const res = await axios.delete("/empleados/" + id);
            this.listar();
        },

        //Método para guardar o actualizar
        async guarda() {
            if (this.update) {
                const res = await axios.put(
                    "/empleados/" + this.id,
                    this.empleado
                );
                console.log(res.data);
            } else {
                const res = await axios.post("/empleados", this.empleado);
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
                this.empleado.nombre = data.nombre;
                this.empleado.departamento = data.departamento;
            } else {
                (this.id = 0), (this.titleModal = "Agregar Empleado");
                this.empleado.nombre = data.nombre;
                this.empleado.departamento = data.departamento;
            }
        },
        //Cierra la ventana modal
        closeModal() {
            this.modal = 0;
        },

        //Método para exportar en PDF al pulsar el botón
        exportarPDF() {
            const pdfElement = this.$refs.pdfElement;

            html2pdf().from(pdfElement).save("tabla_empleados.pdf");
        },

        //Método para exportar en Excel al pulsar el botón
        exportarExcel() {
            const exportData = async () => {
                await this.listar();

                const jsonData = this.empleados.map((empleado) => ({
                    Id: empleado.id,
                    Nombre: empleado.nombre,
                    Departamento: empleado.departamento,
                }));

                const worksheet = XLSX.utils.json_to_sheet(jsonData);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Empleados");
                writeFile(workbook, "tabla_empleados.xlsx");
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
