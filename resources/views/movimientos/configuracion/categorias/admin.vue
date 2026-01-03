<template>
  <div class="container py-4">
    <GenericTable
      title="Categorias"
      description="Categorias para los movimientos (gastos, ingresos)."
      :data="categorias"
      :columns="columns"
      :actions="tableActions"
      :loading="loading"
      empty-text="No se encontraron categorías"
      search-placeholder="Buscar categoría..."
      :per-page="10"
      :show-pagination="true"
      :selectable="false"
      row-key="id"
      @action="handleTableAction"
    >
      <!-- Botón de añadir en el header -->
      <template #header-actions>
        <button class="btn btn-primary" @click="handleOpenModal(null)">
          <i class="fa-solid fa-plus me-2"></i>
          Añadir Categoría
        </button>
      </template>

      <!-- Slot personalizado para la columna nombre -->
      <template #cell-nombre="{ value, item }">
        <span class="fw-bold">{{ value }}</span>
      </template>

      <!-- Slot personalizado para descripción -->
      <template #cell-descripcion="{ value }">
        <span class="text-muted">{{ value || 'Sin descripción' }}</span>
      </template>

      <!-- Slot para acciones personalizadas (opcional, si no se usa el prop actions) -->
      <!-- 
      <template #actions="{ item }">
        <div class="d-flex gap-1">
          <button class="btn btn-sm btn-light" @click="handleOpenModal(item.id)">
            <i class="fa-regular fa-pen-to-square text-primary"></i>
          </button>
          <button class="btn btn-sm btn-light" @click="question(item)">
            <i class="fa-solid fa-trash-can text-danger"></i>
          </button>
        </div>
      </template>
      -->
    </GenericTable>

    <Form 
      ref="open_modal_movimientos" 
      :idModal="'modal_movimientos_gastos'" 
      @update-modal="getCategorias" 
    />
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import Form from './form.vue';
import axios from 'axios';
import GenericTable from '../../../components/GenericTable.vue';

export default {
  name: 'CategoriasView',

  components: {
    GenericTable,
    Form
  },

  data() {
    return {
      categorias: [],
      loading: false,
      
      // Definición de columnas
      columns: [
        {
          key: 'nombre',
          label: 'Nombre',
          sortable: true,
          width: '30%'
        },
        {
          key: 'descripcion',
          label: 'Descripción',
          sortable: true
        }
      ],

      // Definición de acciones
      tableActions: [
        {
          name: 'edit',
          icon: 'fa-regular fa-pen-to-square',
          class: 'btn btn-sm btn-light',
          title: 'Editar'
        },
        {
          name: 'delete',
          icon: 'fa-solid fa-trash-can text-danger',
          class: 'btn btn-sm btn-light',
          title: 'Eliminar'
        }
      ]
    }
  },

  mounted() {
    this.getCategorias();
  },

  methods: {
    handleOpenModal(id = null) {
      this.$refs.open_modal_movimientos.openModal(id);
    },

    getCategorias() {
      this.loading = true;

      axios.get("/api/movimientos/categorias")
        .then((response) => {
          this.categorias = response?.data?.data ?? [];
        })
        .catch(error => {
          console.error("Error al obtener categorías:", error);
          this.$toastr.error('Error al cargar las categorías');
        })
        .finally(() => {
          this.loading = false;
        });
    },

    handleTableAction({ action, item }) {
      switch (action) {
        case 'edit':
          this.handleOpenModal(item.id);
          break;
        case 'delete':
          this.question(item);
          break;
      }
    },

    question(item) {
      Swal.fire({
        title: '¿Está seguro que desea eliminar el registro?',
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
          this.deleteItem(item);
        }
      });
    },

    deleteItem(item) {
      axios.delete(`/api/movimientos/categorias/${item?.id}`)
        .then((response) => {
          if (response) {
            this.$toastr.success(`${response?.data?.message}`);
          }
          this.getCategorias();
        })
        .catch((err) => {
          console.error(err);
          this.$toastr.error('Error al eliminar la categoría');
        });
    }
  }
}
</script>