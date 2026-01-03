<template>
  <!-- SI ESTÁ COLAPSADO, SOLO SE RENDERIZA NIVEL 0 -->
  <div v-if="isOpen || level === 0">

    <div
      @click="onClick"
      class="d-flex align-items-center rounded nav-item-link"
      :class="[
        isActive(item) ? 'bg-primary text-white shadow-sm' : 'text-dark',
        isOpen ? 'justify-content-between p-2' : 'justify-content-center p-2 mb-2'
      ]"
      :style="{ marginLeft: isOpen ? level * 24 + 'px' : '0px' }"
    >
      <div class="d-flex align-items-center" :class="isOpen ? 'gap-3' : ''">
        <i
          :class="item.icon || 'fas fa-circle'"
          :style="!item.icon ? 'font-size: 0.5rem;' : 'width: 20px; text-align: center;'"
        ></i>

        <!-- TEXTO SOLO SI ESTÁ ABIERTO -->
        <span v-if="isOpen" class="fw-medium mx-2">
          {{ item.label }}
        </span>
      </div>

      <!-- CHEVRON SOLO SI ESTÁ ABIERTO -->
      <i
        v-if="item.children && isOpen"
        class="fas fa-chevron-down small transition-icon"
        :class="{ 'rotate-180': openMenus.includes(item.id) }"
      ></i>
    </div>

    <!-- HIJOS SOLO SI ESTÁ ABIERTO -->
    <transition name="expand">
      <div
        v-if="item.children && openMenus.includes(item.id) && isOpen"
        class="submenu-container"
      >
        <SidebarItem
          v-for="child in item.children"
          :key="child.id"
          :item="child"
          :active-section="activeSection"
          :open-menus="openMenus"
          :level="level + 1"
          :is-open="isOpen"
          @set-active="$emit('set-active', $event)"
          @navigate="$emit('navigate', $event)"
        />
      </div>
    </transition>

  </div>
</template>

<script>
export default {
  name: 'SidebarItem',
  props: {
    item: { type: Object, required: true },
    activeSection: { type: String, default: '' },
    openMenus: { type: Array, required: true },
    level: { type: Number, default: 0 },
    isOpen: { type: Boolean, default: true }
  },
  methods: {
    onClick() {
      if (this.item.children) {
        const i = this.openMenus.indexOf(this.item.id)
        i > -1 ? this.openMenus.splice(i, 1) : this.openMenus.push(this.item.id)
      } else {
        this.$emit('set-active', this.item.id)
        this.$emit('navigate', this.item.routeName)
      }
    },
    isActive(item) {
      if (item.id === this.activeSection) return true
      if (item.children) {
        return item.children.some(c => this.isActive(c))
      }
      return false
    }
  }
}
</script>

<style scoped>
.nav-item-link {
  cursor: pointer;
  transition: all 0.2s ease;
}

.nav-item-link:hover {
  background-color: #f8f9fa;
}

.transition-icon {
  transition: transform 0.3s ease;
}

.rotate-180 {
  transform: rotate(180deg);
}

.submenu-container {
  overflow: hidden;
}

.expand-enter-from,
.expand-leave-to {
  max-height: 0;
  opacity: 0;
}

.expand-enter-to,
.expand-leave-from {
  max-height: 500px;
  opacity: 1;
}
</style>