<template>
  <div class="d-flex vh-100 bg-light overflow-hidden">

    <!-- SIDEBAR -->
    <aside
      class="sidebar-wrapper"
      :class="{ collapsed: !showSidebar }"
    >
      <Sidebar @toggle-sidebar="toggleSidebar" />
    </aside>

    <!-- MAIN -->
    <main class="flex-fill overflow-auto position-relative">

      <!-- BOTÓN MOSTRAR SIDEBAR -->
      <button
        v-if="!showSidebar"
        class="btn btn-sm btn-outline-primary toggle-btn"
        @click="toggleSidebar"
      >
        <i class="fa-solid fa-arrow-right-long fw-bold text-primar"></i>
      </button>

      <router-view />
    </main>

  </div>
</template>

<script>
import Sidebar from '../views/components/Sidebar.vue'

export default {
  name: 'App',
  components: {
    Sidebar
  },
  data() {
    return {
      showSidebar: true
    }
  },
  methods: {
    toggleSidebar() {
      this.showSidebar = !this.showSidebar
    }
  }
}
</script>

<style scoped>
/* CONTENEDOR SIDEBAR */
.sidebar-wrapper {
  width: 260px;
  transition: width 0.3s ease;
  overflow: hidden;
}

/* SIDEBAR COLAPSADO */
.sidebar-wrapper.collapsed {
  width: 0;
}

/* BOTÓN FIJO (NO SE MUEVE) */
.toggle-btn {
  position: fixed;
  top: 16px;
  left: 16px;
  z-index: 1050;
}
</style>
