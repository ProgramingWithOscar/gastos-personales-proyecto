<template>
  <div class="generic-table-container">
    <!-- Header con título, descripción y botones -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h3 class="fw-bold display-6 mb-1">{{ title }}</h3>
        <p v-if="description" class="text-muted mb-0">{{ description }}</p>
      </div>

      <div class="d-flex gap-2">
        <slot name="header-actions"></slot>
      </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div v-if="showSearch || $slots.filters" class="card mb-3">
      <div class="card-body">
        <div class="row g-3">
          <!-- Búsqueda -->
          <div v-if="showSearch" class="col-md-6">
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-search"></i>
              </span>
              <input
                type="text"
                class="form-control"
                :placeholder="searchPlaceholder"
                v-model="internalSearch"
                @input="handleSearch"
              />
              <button
                v-if="internalSearch"
                class="btn btn-outline-secondary"
                type="button"
                @click="clearSearch"
              >
                <i class="fa-solid fa-times"></i>
              </button>
            </div>
          </div>

          <!-- Slot para filtros adicionales -->
          <div v-if="$slots.filters" class="col-md-6">
            <slot name="filters"></slot>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <div class="card">
      <!-- Slot para contenido antes de la tabla -->
      <slot name="before-table"></slot>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <!-- Columna de selección -->
              <th v-if="selectable" style="width: 50px">
                <input
                  type="checkbox"
                  class="form-check-input"
                  @change="toggleSelectAll"
                  :checked="allSelected"
                />
              </th>

              <!-- Columnas dinámicas -->
              <th
                v-for="column in columns"
                :key="column.key"
                :style="column.width ? `width: ${column.width}` : ''"
                :class="[column.headerClass, { 'cursor-pointer': column.sortable }]"
                @click="column.sortable && handleSort(column.key)"
              >
                {{ column.label }}
                <i
                  v-if="column.sortable"
                  class="fa-solid ms-1"
                  :class="{
                    'fa-sort': sortKey !== column.key,
                    'fa-sort-up': sortKey === column.key && sortOrder === 'asc',
                    'fa-sort-down': sortKey === column.key && sortOrder === 'desc'
                  }"
                ></i>
              </th>

              <!-- Columna de acciones -->
              <th v-if="actions.length > 0 || $slots.actions" :style="actionsWidth">
                {{ actionsLabel }}
              </th>
            </tr>
          </thead>

          <tbody>
            <!-- Loading state -->
            <tr v-if="loading">
              <td :colspan="totalColumns" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                  <!-- <span class="visually-hidden">Cargando...</span> -->
                </div>
                <p class="text-muted mt-2 mb-0">{{ loadingText }}</p>
              </td>
            </tr>

            <!-- Empty state -->
            <tr v-else-if="paginatedData.length === 0">
              <td :colspan="totalColumns" class="text-center py-5">
                <slot name="empty-state">
                  <i class="fa-solid fa-inbox fa-3x text-muted mb-3"></i>
                  <p class="text-muted mb-0">{{ emptyText }}</p>
                </slot>
              </td>
            </tr>

            <!-- Data rows -->
            <tr
              v-else
              v-for="(item, index) in paginatedData"
              :key="getRowKey(item, index)"
              :class="getRowClass(item)"
              @click="handleRowClick(item)"
            >
              <!-- Checkbox de selección -->
              <td v-if="selectable">
                <input
                  type="checkbox"
                  class="form-check-input"
                  :checked="isSelected(item)"
                  @change="toggleSelect(item)"
                  @click.stop
                />
              </td>

              <!-- Celdas dinámicas -->
              <td
                v-for="column in columns"
                :key="column.key"
                :class="column.cellClass"
              >
                <!-- Slot personalizado por columna -->
                <slot
                  :name="`cell-${column.key}`"
                  :item="item"
                  :value="getNestedValue(item, column.key)"
                  :index="index"
                >
                  <!-- Formato por defecto -->
                  <span v-if="column.format">
                    {{ column.format(getNestedValue(item, column.key), item) }}
                  </span>
                  <span v-else>
                    {{ getNestedValue(item, column.key) || column.defaultValue || '-' }}
                  </span>
                </slot>
              </td>

              <!-- Columna de acciones -->
              <td v-if="actions.length > 0 || $slots.actions">
                <slot name="actions" :item="item" :index="index">
                  <div class="d-flex gap-1">
                    <button
                      v-for="action in actions"
                      :key="action.name"
                      :class="action.class || 'btn btn-sm btn-light'"
                      @click.stop="handleAction(action.name, item)"
                      :title="action.title"
                    >
                      <i v-if="action.icon" :class="action.icon"></i>
                      <span v-if="action.label">{{ action.label }}</span>
                    </button>
                  </div>
                </slot>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Slot para contenido después de la tabla -->
      <slot name="after-table"></slot>

      <!-- Paginación -->
      <div v-if="showPagination && totalPages > 1" class="card-footer">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
          <!-- Info de registros -->
          <div class="text-muted">
            Mostrando {{ startRecord }} - {{ endRecord }} de {{ filteredData.length }} registros
            <span v-if="selectedItems.length > 0">
              ({{ selectedItems.length }} seleccionados)
            </span>
          </div>

          <!-- Controles de paginación -->
          <div class="d-flex align-items-center gap-2">
            <!-- Items por página -->
            <select
            
              v-if="showPerPageSelector"
              class="form-select form-select-sm bg-light text-dark"
              style="width: auto"
              v-model.number="internalPerPage"
              @change="handlePerPageChange"
            >
              <option v-for="option in perPageOptions" :key="option" :value="option">
                {{ option }} por página
              </option>
            </select>

            <!-- Navegación -->
            <nav>
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a class="page-link" @click.prevent="goToPage(1)">
                    <i class="fa-solid fa-angles-left"></i>
                  </a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a class="page-link" @click.prevent="goToPage(currentPage - 1)">
                    <i class="fa-solid fa-angle-left"></i>
                  </a>
                </li>

                <li
                  v-for="page in visiblePages"
                  :key="page"
                  class="page-item"
                  :class="{ active: page === currentPage }"
                >
                  <a class="page-link" @click.prevent="goToPage(page)">
                    {{ page }}
                  </a>
                </li>

                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                  <a class="page-link" @click.prevent="goToPage(currentPage + 1)">
                    <i class="fa-solid fa-angle-right"></i>
                  </a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                  <a class="page-link" @click.prevent="goToPage(totalPages)">
                    <i class="fa-solid fa-angles-right"></i>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'GenericTable',

  props: {
    // Datos
    data: {
      type: Array,
      required: true
    },

    // Configuración de columnas
    columns: {
      type: Array,
      required: true,
      // Ejemplo: [{ key: 'nombre', label: 'Nombre', sortable: true, width: '200px' }]
    },

    // Títulos y textos
    title: {
      type: String,
      default: ''
    },
    description: {
      type: String,
      default: ''
    },
    emptyText: {
      type: String,
      default: 'No se encontraron registros'
    },
    loadingText: {
      type: String,
      default: 'Cargando datos...'
    },
    actionsLabel: {
      type: String,
      default: 'Acciones'
    },

    // Acciones
    actions: {
      type: Array,
      default: () => []
      // Ejemplo: [{ name: 'edit', icon: 'fa-edit', class: 'btn-primary', title: 'Editar' }]
    },
    actionsWidth: {
      type: String,
      default: 'width: 150px'
    },

    // Búsqueda
    showSearch: {
      type: Boolean,
      default: true
    },
    searchPlaceholder: {
      type: String,
      default: 'Buscar...'
    },
    searchKeys: {
      type: Array,
      default: () => []
      // Claves para buscar, si está vacío busca en todas las columnas
    },

    // Paginación
    showPagination: {
      type: Boolean,
      default: true
    },
    perPage: {
      type: Number,
      default: 10
    },
    showPerPageSelector: {
      type: Boolean,
      default: true
    },
    perPageOptions: {
      type: Array,
      default: () => [5, 10, 25, 50, 100]
    },

    // Ordenamiento
    defaultSortKey: {
      type: String,
      default: ''
    },
    defaultSortOrder: {
      type: String,
      default: 'asc',
      validator: val => ['asc', 'desc'].includes(val)
    },

    // Selección
    selectable: {
      type: Boolean,
      default: false
    },

    // Estados
    loading: {
      type: Boolean,
      default: false
    },

    // Personalización
    rowKey: {
      type: String,
      default: 'id'
    },
    rowClass: {
      type: [String, Function],
      default: ''
    },
    clickableRows: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      internalSearch: '',
      internalPerPage: this.perPage,
      currentPage: 1,
      sortKey: this.defaultSortKey,
      sortOrder: this.defaultSortOrder,
      selectedItems: []
    }
  },

  computed: {
    // Datos filtrados por búsqueda
    filteredData() {
      if (!this.internalSearch) return this.data

      const search = this.internalSearch.toLowerCase()
      const keysToSearch = this.searchKeys.length > 0
        ? this.searchKeys
        : this.columns.map(col => col.key)

      return this.data.filter(item => {
        return keysToSearch.some(key => {
          const value = this.getNestedValue(item, key)
          return value && String(value).toLowerCase().includes(search)
        })
      })
    },

    // Datos ordenados
    sortedData() {
      if (!this.sortKey) return this.filteredData

      const sorted = [...this.filteredData].sort((a, b) => {
        const aVal = this.getNestedValue(a, this.sortKey)
        const bVal = this.getNestedValue(b, this.sortKey)

        if (aVal === bVal) return 0
        if (aVal === null || aVal === undefined) return 1
        if (bVal === null || bVal === undefined) return -1

        const comparison = aVal > bVal ? 1 : -1
        return this.sortOrder === 'asc' ? comparison : -comparison
      })

      return sorted
    },

    // Datos paginados
    paginatedData() {
      if (!this.showPagination) return this.sortedData

      const start = (this.currentPage - 1) * this.internalPerPage
      const end = start + this.internalPerPage
      return this.sortedData.slice(start, end)
    },

    // Cálculos de paginación
    totalPages() {
      return Math.ceil(this.filteredData.length / this.internalPerPage)
    },

    startRecord() {
      return (this.currentPage - 1) * this.internalPerPage + 1
    },

    endRecord() {
      return Math.min(this.currentPage * this.internalPerPage, this.filteredData.length)
    },

    visiblePages() {
      const pages = []
      const maxVisible = 5
      let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2))
      let end = Math.min(this.totalPages, start + maxVisible - 1)

      if (end - start < maxVisible - 1) {
        start = Math.max(1, end - maxVisible + 1)
      }

      for (let i = start; i <= end; i++) {
        pages.push(i)
      }

      return pages
    },

    totalColumns() {
      let count = this.columns.length
      if (this.selectable) count++
      if (this.actions.length > 0 || this.$slots.actions) count++
      return count
    },

    allSelected() {
      return this.paginatedData.length > 0 &&
        this.paginatedData.every(item => this.isSelected(item))
    }
  },

  watch: {
    data() {
      // Resetear a la primera página cuando cambien los datos
      this.currentPage = 1
    },

    filteredData() {
      // Ajustar página actual si es necesario
      if (this.currentPage > this.totalPages) {
        this.currentPage = Math.max(1, this.totalPages)
      }
    }
  },

  methods: {
    // Obtener valor de propiedad anidada
    getNestedValue(obj, path) {
      return path.split('.').reduce((current, prop) => current?.[prop], obj)
    },

    // Obtener key única de la fila
    getRowKey(item, index) {
      return this.getNestedValue(item, this.rowKey) || index
    },

    // Obtener clase de la fila
    getRowClass(item) {
      if (typeof this.rowClass === 'function') {
        return this.rowClass(item)
      }
      return this.rowClass
    },

    // Búsqueda
    handleSearch() {
      this.currentPage = 1
      this.$emit('search', this.internalSearch)
    },

    clearSearch() {
      this.internalSearch = ''
      this.handleSearch()
    },

    // Ordenamiento
    handleSort(key) {
      if (this.sortKey === key) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc'
      } else {
        this.sortKey = key
        this.sortOrder = 'asc'
      }
      this.$emit('sort', { key: this.sortKey, order: this.sortOrder })
    },

    // Paginación
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page
        this.$emit('page-change', page)
      }
    },

    handlePerPageChange() {
      this.currentPage = 1
      this.$emit('per-page-change', this.internalPerPage)
    },

    // Selección
    toggleSelect(item) {
      const key = this.getRowKey(item)
      const index = this.selectedItems.findIndex(i => this.getRowKey(i) === key)

      if (index > -1) {
        this.selectedItems.splice(index, 1)
      } else {
        this.selectedItems.push(item)
      }

      this.$emit('selection-change', this.selectedItems)
    },

    toggleSelectAll() {
      if (this.allSelected) {
        // Deseleccionar todos de la página actual
        this.paginatedData.forEach(item => {
          const key = this.getRowKey(item)
          const index = this.selectedItems.findIndex(i => this.getRowKey(i) === key)
          if (index > -1) {
            this.selectedItems.splice(index, 1)
          }
        })
      } else {
        // Seleccionar todos de la página actual
        this.paginatedData.forEach(item => {
          if (!this.isSelected(item)) {
            this.selectedItems.push(item)
          }
        })
      }

      this.$emit('selection-change', this.selectedItems)
    },

    isSelected(item) {
      const key = this.getRowKey(item)
      return this.selectedItems.some(i => this.getRowKey(i) === key)
    },

    // Acciones
    handleAction(actionName, item) {
      this.$emit('action', { action: actionName, item })
    },

    handleRowClick(item) {
      if (this.clickableRows) {
        this.$emit('row-click', item)
      }
    },

    // Métodos públicos
    clearSelection() {
      this.selectedItems = []
      this.$emit('selection-change', this.selectedItems)
    },

    refresh() {
      this.$emit('refresh')
    }
  }
}
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
  user-select: none;
}

.generic-table-container .table th {
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.5px;
}

.generic-table-container .page-link {
  cursor: pointer;
}
</style>