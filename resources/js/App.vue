<template>
  <div class="flex h-screen bg-[#F8FAFC] overflow-hidden">
    <Sidebar />

    <main class="flex-1 min-w-0 overflow-y-auto">
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
  }
}
</script>
