<template>
  <!-- Sidebar Desktop -->
  <aside class="hidden lg:flex flex-col w-64 xl:w-72 bg-white border-r border-slate-200">
    <div class="p-8">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-100">
          F
        </div>
        <span class="font-bold text-xl text-slate-900 tracking-tight">FinanzaPro</span>
      </div>
    </div>

    <nav class="flex-1 px-4 space-y-2 mt-4">
      <button
        v-for="item in menuItems"
        :key="item.id"
        @click="$emit('change-section', item.id)"
        :class="[
          'w-full flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-200',
          activeSection === item.id
            ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100 font-semibold'
            : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'
        ]"
      >
        <component
          :is="item.icon"
          :size="20"
          :class="activeSection === item.id ? 'text-white' : 'text-slate-400'"
        />
        <span>{{ item.label }}</span>
      </button>
    </nav>

    <div class="p-6 border-t border-slate-100">
      <div class="bg-slate-50 p-4 rounded-2xl">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">
          Tu Plan
        </p>
        <p class="text-sm font-bold text-indigo-600">Premium Pro</p>
      </div>
    </div>
  </aside>

  <!-- Mobile Drawer -->
  <div
    class="lg:hidden fixed inset-0 z-[100] transition-opacity duration-300"
    :class="isOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
  >
    <div
      class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
      @click="$emit('close')"
    ></div>

    <aside
      class="absolute top-0 left-0 h-full w-72 bg-white shadow-2xl transition-transform duration-300"
      :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <div class="p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">
            F
          </div>
          <span class="font-bold text-lg text-slate-800">FinanzaPro</span>
        </div>
        <button @click="$emit('close')" class="p-2 text-slate-400">
          <X :size="20" />
        </button>
      </div>

      <nav class="p-4 space-y-2">
        <button
          v-for="item in menuItems"
          :key="item.id"
          @click="handleMobileClick(item.id)"
          :class="[
            'w-full flex items-center gap-4 px-4 py-4 rounded-xl',
            activeSection === item.id
              ? 'bg-indigo-50 text-indigo-700 font-bold'
              : 'text-slate-500'
          ]"
        >
          <component :is="item.icon" :size="20" />
          <span>{{ item.label }}</span>
        </button>
      </nav>
    </aside>
  </div>
</template>

<script>
// import {
//   LayoutDashboard,
//   Receipt,
//   CreditCard,
//   Sparkles,
//   Target,
//   X
// } from 'lucide-vue-next'

export default {
  name: 'Sidebar',

//   components: {
//     LayoutDashboard,
//     Receipt,
//     CreditCard,
//     Sparkles,
//     Target,
//     X
//   },

//   props: {
//     activeSection: {
//       type: String,
//       required: true
//     },
//     isOpen: {
//       type: Boolean,
//       default: false
//     }
//   },

  data() {
    return {
      menuItems: [
        { id: 'DASHBOARD', label: 'Dashboard' },
        { id: 'TRANSACTIONS', label: 'Movimientos' },
        { id: 'ACCOUNTS', label: 'Cuentas'  },
        { id: 'BUDGETS', label: 'Presupuestos'},
        { id: 'AI_INSIGHTS', label: 'IA Insights' }
      ]
    }
  },

//   methods: {
//     handleMobileClick(section) {
//       this.$emit('change-section', section)
//       this.$emit('close')
//     }
//   }
}
</script>
