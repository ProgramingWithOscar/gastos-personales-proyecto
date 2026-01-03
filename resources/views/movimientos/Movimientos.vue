<template>
  <div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h3 class="fw-bold display-6 mb-1">Movimientos (Gastos)</h3>
        <p class="text-muted mb-0">
          Historial detallado y auditoría de tus gastos.
        </p>
      </div>

      <div class="d-flex gap-5">
        <button class="btn btn-primary" @click="handleOpenModal(null)">
          Añadir Registro
        </button>
      </div>
    </div>


    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Fecha</th>
              <th>Descripción</th>
              <th>Categoría</th>
              <th>Cuenta</th>
              <th>Monto</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="t in filteredTransactions" :key="t.id">
              <td class="text-muted fw-bold">
                {{ formatDate(t.fecha) }}
              </td>
              <td class="fw-bold">
                {{ t.descripcion || 'Sin descripción' }}
              </td>
              <td> {{ t.categoria?.nombre }}</td>
              <td> {{ t.cuenta?.nombre }}</td>
              <td class="fw-bold" :class="t.tipo === 'INCOME' ? 'text-success' : 'text-danger'">
                {{ t.tipo === 'INCOME' ? '+' : '-' }}{{ new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(t.monto) }}
              </td>

              <td class="text-center">
                <div class="d-flex">
                  <button class="btn btn-light-danger" @click="question(t)">
                    <i class="fa-solid fa-trash-can text-danger"></i>
                  </button>
                 <button  class="btn btn-light-danger" @click="handleOpenModal(t.id)">
                   <i class="fa-regular fa-pen-to-square text-primary mx-2"></i>
                 </button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredTransactions.length === 0">
              <td colspan="5" class="text-center py-4 text-muted">No se encontraron movimientos.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <Form ref="open_modal_movimientos" :idModal="'modal_movimientos_gastos'" @update-modal="getGastos" />

  </div>
</template>

<script>
import Swal from 'sweetalert2';
import Form from './form.vue'
import axios from 'axios'

export default {
  name: 'TransactionsList',

  components: {
    Form
  },

  data() {
    return {
      searchTerm: '',
      typeFilter: 'ALL',
      filters: [
        { id: 'ALL', label: 'Todos' },
        { id: 'INCOME', label: 'Ingresos' },
        { id: 'EXPENSE', label: 'Gastos' }
      ],
      // Inicializamos transactions como array vacío para recibir la API
      transactions: []
    }
  },
  mounted() {
    this.getGastos()
  },
  computed: {
    filteredTransactions() {
      return this.transactions.filter(t => {
        const desc = (t.descripcion || '').toLowerCase();
        const matchesSearch = desc.includes(this.searchTerm.toLowerCase());

        // Asumiendo que por defecto la API de gastos son todos 'EXPENSE' 
        // a menos que tu JSON traiga un campo "tipo"
        const matchesFilter = this.typeFilter === 'ALL' || (t.tipo || 'EXPENSE') === this.typeFilter;

        return matchesSearch && matchesFilter;
      })
    }
  },

  methods: {
    handleOpenModal(id = null) {
      this.$refs.open_modal_movimientos.openModal(id)
    },

    getGastos() {
      this.$loader.presentLoader();

      axios.get("/api/movimientos/gastos")
        .then((response) => {
          this.transactions = response?.data?.data ?? [];
          this.$loader.dismissLoader();

        })
        .catch(error => {
          console.error("Error al obtener gastos:", error);
        });
    },

    formatDate(dateString) {
      if (!dateString) return '---';
      const date = new Date(dateString);
      return date.toLocaleDateString('es-ES');
    },
    question(item){
        Swal.fire({
            title: '¿Esta seguro que desea eliminar el registro?',
            text: 'La información no podrá ser recuperada',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#fe0000',
            customClass: {
                popup: 'swal-small',
                title: 'swal-title-small',
                htmlContainer: 'swal-text-small'
            },
            width: '400px',
        }).then((result) => {
            if (result.isConfirmed) {
               this.deleteItem(item)
            }
        })
    },

    deleteItem(item){
      axios.delete(`api/movimientos/gastos/${item?.id}`)
      .then((response) => {
        if(response){
          this.$toastr.success(`${response?.data?.message}`)
        }
        this.getGastos()
      })
      .catch((err) => {
        console.log(err)
      })
    }
  }
}
</script>