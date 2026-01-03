<template>
  <div class="d-flex flex-column">
    <label v-if="label" :for="id" :class="{ 'required': required }">
      {{ label }}
    </label>
    <v-select
      :id="id"
      v-model="selectedValue"
      :options="categorias"
      :reduce="categoria => categoria.id"
      label="nombre"
      :placeholder="loading ? 'Cargando...' : placeholder"
      :disabled="loading || disabled"
      :loading="loading"
      clearable
      @option:selected="handleChange"
    >
      <template #no-options>
        No se encontraron resultados
      </template>
    </v-select>
    <small v-if="error" class="text-danger mt-1">{{ error }}</small>
  </div>
</template>

<script>
import axios from 'axios'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
  name: 'SelectCategorias',

  components: {
    vSelect
  },

  props: {
    modelValue: {
      type: [String, Number],
      default: ''
    },
    id: {
      type: String,
      default: 'categoria'
    },
    label: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: 'Seleccione una categoría'
    },
    required: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },

  emits: ['update:modelValue', 'change'],

  data() {
    return {
      categorias: [],
      loading: false,
      error: null
    }
  },

  computed: {
    selectedValue: {
      get() {
        return this.modelValue
      },
      set(value) {
        this.$emit('update:modelValue', value)
      }
    }
  },

  mounted() {
    this.loadCategorias()
  },

  methods: {
    async loadCategorias() {
      this.loading = true
      this.error = null

      try {
        const response = await axios.get('/api/movimientos/categorias')
        this.categorias = response.data?.data || []
      } catch (err) {
        this.error = 'Error al cargar categorías'
        console.error('Error:', err)
      } finally {
        this.loading = false
      }
    },

    handleChange(categoria) {
      this.$emit('change', categoria)
    }
  }
}
</script>

<style>
/* Sin scoped para que funcione */
.vs__dropdown-toggle {
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  padding: 0.375rem 0.75rem;
}

.vs__search {
  padding: 0;
  margin: 0;
}

.vs__search::placeholder {
  color: #6c757d;
}

/* Ocultar el indicador de dropdown cuando hay selección */
.vs__open-indicator {
  display: none !important;
}
</style>

<style scoped>
.required::after {
  content: " *";
  color: red;
}
</style>