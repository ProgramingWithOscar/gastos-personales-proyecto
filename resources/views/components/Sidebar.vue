<template>
  <aside
    class="d-none d-lg-flex flex-column bg-white border-end sidebar"
    :style="{ width: collapsed ? '70px' : '18rem', minHeight: '100vh' }"
  >

    <!-- HEADER -->
    <div class="p-4 border-bottom d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <div
          class="bg-primary text-white fw-bold d-flex align-items-center justify-content-center rounded"
          style="width: 36px; height: 36px;"
        >
          F
        </div>
        <span v-if="!collapsed" class="fw-bold fs-5">FinanzaPro</span>
      </div>

      <!-- BOTÓN OCULTAR SIDEBAR -->
      <button
        v-if="!collapsed"
        class="btn btn-sm btn-outline-secondary"
        title="Ocultar menú"
        @click="$emit('toggle-sidebar')"
      >
       <i class="fa-solid fa-arrow-left"></i>
      </button>
      <button
        v-else
        class="btn btn-sm btn-outline-secondary p-1"
        title="Mostrar menú"
        @click="$emit('toggle-sidebar')"
        style="width: 30px; height: 30px;"
      >
       <i class="fa-solid fa-arrow-right"></i>
      </button>
    </div>

    <!-- NAV -->
    <nav class="flex-grow-1 p-3">
      <SidebarItem
        v-for="item in menuItems"
        :key="item.id"
        :item="item"
        :active-section="activeSection"
        :open-menus.sync="openMenus"
        :level="0"
        :is-open="!collapsed"
        @set-active="activeSection = $event"
        @navigate="handleRouteChange"
      />
    </nav>

    <!-- FOOTER -->
    <div v-if="!collapsed" class="p-3 border-top">
      <div class="bg-light rounded p-3">
        <p
          class="text-uppercase text-muted fw-bold mb-1"
          style="font-size: 0.65rem; letter-spacing: 1px;"
        >
          Tu plan
        </p>
        <p class="fw-bold text-primary mb-0">Premium Pro</p>
      </div>
    </div>

  </aside>
</template>

<script>
import SidebarItem from './SidebarItem.vue'

export default {
  name: 'Sidebar',
  components: { SidebarItem },
  props: {
    activeSection: { type: String, default: '' },
    collapsed: { type: Boolean, default: false }
  },
  data() {
    return {
      openMenus: [],
      menuItems: [
        {
          id: 'DASHBOARD',
          label: 'Dashboard',
          icon: 'fas fa-th-large'
        },
        {
          id: 'TRANSACTIONS',
          label: 'Movimientos',
          icon: 'fas fa-history',
          routeName: 'transactions',
          children: [
            {
              id: 'gastos',
              label: 'Gastos',
              routeName: 'movimientos-gastos',
              icon: 'fa-solid fa-dollar-sign'
            },
            {
              id: 'settings',
              label: 'Configuración',
              routeName: 'movimientos-configuracion',
              icon: 'fa-solid fa-gears',
              children: [
                {
                  id: 'category',
                  label: 'Categorias',
                  routeName: 'movimientos-categorias',
                  icon: 'fa-regular fa-circle-dot'
                },
                {
                  id: 'company',
                  label: 'Compañias',
                  routeName: 'movimientos-companias',
                  icon: 'fa-regular fa-circle-dot'
                }
              ]
            }
          ]
        },
        {
          id: 'ACCOUNTS',
          label: 'Cuentas',
          icon: 'fas fa-wallet',
          routeName: 'accounts'
        },
        {
          id: 'SETTINGS',
          label: 'Ajustes',
          routeName: 'settings'
        }
      ]
    }
  },
  methods: {
    handleRouteChange(routeName) {
      if (routeName) {
        this.$router.push({ name: routeName }).catch(() => {})
      }
    }
  }
}
</script>

<style scoped>
.sidebar {
  margin-right: 20px;
  padding-right: 15px;
  transition: all 0.3s ease;
}
</style>