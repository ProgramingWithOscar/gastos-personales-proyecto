<template>
  <div class="space-y-8 p-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
      <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Movimientos</h1>
        <p class="text-slate-500 font-medium">Historial detallado y auditoría de tus finanzas.</p>
      </div>
      <div class="flex gap-3">
        <button class="px-5 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 flex items-center gap-2">
          <Download :size="18" />
          <span class="hidden sm:inline">Exportar</span>
        </button>
        <button
          @click="showAddModal = true"
          class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 flex items-center gap-2"
        >
          <Plus :size="18" />
          <span>Añadir Registro</span>
        </button>
      </div>
    </div>

    <!-- Buscador y filtros -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4">
      <div class="relative flex-1">
        <Search class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" :size="18" />
        <input
          v-model="searchTerm"
          type="text"
          placeholder="Buscar por concepto o categoría..."
          class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-100 outline-none font-medium text-sm"
        />
      </div>

      <div class="flex gap-2 p-1 bg-slate-100 rounded-xl">
        <button
          v-for="f in filters"
          :key="f.id"
          @click="typeFilter = f.id"
          :class="[
            'px-5 py-2 rounded-lg text-xs font-black uppercase tracking-widest',
            typeFilter === f.id
              ? 'bg-white text-indigo-600 shadow-sm'
              : 'text-slate-500 hover:text-slate-700'
          ]"
        >
          {{ f.label }}
        </button>
      </div>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
      <table class="hidden md:table w-full text-left">
        <tbody class="divide-y divide-slate-50">
          <tr
            v-for="t in filteredTransactions"
            :key="t.id"
            class="hover:bg-slate-50/80 group"
          >
            <td class="px-8 py-5 text-sm font-bold text-slate-500">{{ t.date }}</td>
            <td class="px-8 py-5 text-sm font-black text-slate-900">{{ t.description }}</td>
            <td class="px-8 py-5 flex items-center gap-2">
              <div class="p-2 bg-slate-100 rounded-xl text-slate-500">
                {{ getCategoryIcon(t.categoryId) }}
              </div>
              <span class="text-xs font-bold text-slate-600">
                {{ categoryName(t.categoryId) }}
              </span>
            </td>
            <td class="px-8 py-5">
              <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-lg">
                {{ accountName(t.accountId) }}
              </span>
            </td>
            <td class="px-8 py-5 text-base font-black"
                :class="t.type === 'INCOME' ? 'text-green-600' : 'text-slate-900'">
              {{ t.type === 'INCOME' ? '+' : '-' }}{{ t.amount.toLocaleString('es-ES') }}€
            </td>
            <td class="px-8 py-5 text-right">
              <ChevronRight :size="18" class="text-slate-300 opacity-0 group-hover:opacity-100" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div v-if="showAddModal" class="fixed inset-0 z-[200] flex items-center justify-center bg-slate-900/40">
      <div class="bg-white rounded-[2.5rem] w-full max-w-xl shadow-2xl">
        <div class="p-6 flex justify-between border-b">
          <h3 class="font-black">Nuevo Movimiento</h3>
          <button @click="showAddModal = false">
            <X :size="20" />
          </button>
        </div>

        <div class="p-8 space-y-6">
          <input v-model="newTx.description" placeholder="Descripción" class="w-full px-6 py-4 border rounded-xl" />
          <input v-model.number="newTx.amount" type="number" class="w-full px-6 py-4 border rounded-xl" />

          <button
            @click="handleAdd"
            class="w-full py-4 bg-indigo-600 text-white rounded-xl font-black"
          >
            Guardar Registro
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { Search, Plus, X, ChevronRight, Download } from 'lucide-vue-next'
// import { CATEGORIES, ACCOUNTS, getCategoryIcon } from '../constants'

export default {
  name: 'TransactionsList',

//   components: { Search, Plus, X, ChevronRight, Download },

  props: {
    transactions: Array,
    addTransaction: Function
  },

//   data() {
//     return {
//       searchTerm: '',
//       showAddModal: false,
//       typeFilter: 'ALL',
//       newTx: {
//         amount: 0,
//         type: 'EXPENSE',
//         categoryId: CATEGORIES[0].id,
//         accountId: ACCOUNTS[0].id,
//         date: new Date().toISOString().split('T')[0],
//         description: ''
//       },
//       filters: [
//         { id: 'ALL', label: 'Todos' },
//         { id: 'INCOME', label: 'Ingresos' },
//         { id: 'EXPENSE', label: 'Gastos' }
//       ]
//     }
//   },

//   computed: {
//     filteredTransactions() {
//       return this.transactions.filter(t =>
//         t.description.toLowerCase().includes(this.searchTerm.toLowerCase()) &&
//         (this.typeFilter === 'ALL' || t.type === this.typeFilter)
//       )
//     }
//   },

//   methods: {
//     handleAdd() {
//       if (this.newTx.amount <= 0 || !this.newTx.description) return
//       this.addTransaction(this.newTx)
//       this.showAddModal = false
//       this.newTx.amount = 0
//       this.newTx.description = ''
//     },
//     categoryName(id) {
//       return CATEGORIES.find(c => c.id === id)?.name
//     },
//     accountName(id) {
//       return ACCOUNTS.find(a => a.id === id)?.name
//     }  }
}
</script>
