<template>
   <div
    :id="idModal"
    class="modal fade"
    data-backdrop="static" 
    data-keyboard="false" 
    tabindex="-1"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-body p-4">
          <h2 v-if="!id" class="h5 fw-bold text-dark mb-3">
            Añadir movimiento (gastos)
          </h2>
          <h2 v-else class="h5 fw-bold text-dark mb-3">
            Editar movimiento (gastos)
          </h2>

          <p class="text-secondary small mb-4">
            Añade un nuevo movimiento a tu registro financiero completando el formulario a continuación.
          </p>

          <div>

            <div class="d-flex mb-2">
                <div class="d-flex flex-column col-6">
                    <label for="fecha">Fecha en que se realizó</label>
                    <input v-model="objeto.fecha" type="date" class="form-control" id="fecha">
                </div>
                <div class="d-flex flex-column col-6">
                    <label for="descripcion">Descripción</label>
                    <textarea v-model="objeto.descripcion" class="form-control" placeholder="Ingresa la descripción del gasto"></textarea>
                </div>
            </div>
            <div class="d-flex  mb-2">
                <div class="d-flex flex-column col-6">
                    <label for="categoria" >
                        <span class="required">Categoría</span>
                    </label>
                    <SelectCategorias v-model="objeto.categoria_id" :class="{'is-invalid': v$.objeto.categoria_id.$error}"/>
                    <div class="invalid-feedback" v-if="v$.objeto.categoria_id.$error">
                        Este campo es requerido
                    </div>
                </div>
                <div class="d-flex flex-column col-6">
                    <label for="cuenta" class="required">Cuenta</label>
                    <SelectCuentas v-model="objeto.cuenta_id" :class="{'is-invalid': v$.objeto.cuenta_id.$error}"/>
                    <div class="invalid-feedback" v-if="v$.objeto.cuenta_id.$error">
                        Este campo es requerido
                    </div>
                </div>
            </div>
            <div class="d-flex  mb-2">
                <div class="d-flex flex-column col-12">
                    <label for="compania_id" >
                        <span>Compañia</span>
                    </label>
                    <SelectCompanias v-model="objeto.compania_id" />
                </div>
            </div>
            <div class="d-flex mb-2">
                <div class="d-flex flex-column col-6">
                    <label for="monto" class="required">Monto</label>
                    <input v-model="objeto.monto" class="form-control" type="number" name="monto" id="monto" placeholder="Ingresa el monto" :min="0" :class="{'is-invalid': v$.objeto.monto.$error}">
                    <div class="invalid-feedback" v-if="v$.objeto.monto.$error">
                        Este campo es requerido y debe ser mayor a 0
                    </div>
                </div>
                <div class="d-flex flex-column col-6">
                    <label for="periodicidad">Períodicidad</label>
                    <select v-model="objeto.periodicidad" class="form-control" name="periodicidad" id="periodicidad">
                        <option value="" disabled>Seleccione una opción</option>
                        <option value="mensual" >Mensual</option>
                        <option value="diario" >Diario</option>
                        <option value="trimestral" >Trimestral</option>
                        <option value="semestral" >Semestral</option>
                        <option value="anual" >Anual</option>
                    </select>
                </div>
            </div>

          </div>

          <div class="d-flex justify-content-center gap-5 mt-5">
            <button
              class="btn btn-light fw-semibold mx-3"
              @click="question2()"
            >
              Cancelar
            </button>

            <button @click="question()" class="btn btn-primary fw-semibold">
              Guardar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import SelectCategorias from '../components/SelectCategorias.vue';
import SelectCuentas from '../components/SelectCuentas.vue';
import SelectCompanias from '../components/SelectCompanias.vue';
import Swal from 'sweetalert2';
import useVuelidate from '@vuelidate/core';
import { minValue, required } from '@vuelidate/validators';


export default {
  setup() {
    return { v$: useVuelidate() }
  },
  validations() {
    return {
        objeto: {
            categoria_id: { required },
            cuenta_id: { required },
            monto: { required, minValue: minValue(1) }
        }
    }
  },
  name: 'FormMovimientos',
  props: {
    idModal: {
      type: String,
      required: false,
      default: 'modalMovimientos'
    }
  },
  components: {
    SelectCategorias,
    SelectCuentas,
    SelectCompanias
  },
  data(){
    return {
        objeto: {
           fecha: null,
           descripcion: null,
           categoria_id: null,
           cuenta_id: null,
           monto: null,
           periodicidad: "",
           compania_id: null
        },
        emptyObject: {},
        id: null
    }
  },
  methods: {
    question(){
        this.v$.$touch()

        if (this.v$.$invalid) {
            this.$toastr.error('Completa los campos obligatorios')
            return
        }

        Swal.fire({
            title: '¿Desea guardar la información?',
            text: 'La información ingresada será guardada',
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
                this.save()
            }
        })
    },
    question2(){
        Swal.fire({
            title: '¿Esta seguro que desea salir?',
            text: 'La información ingresada será eliminada',
            icon: 'question',
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
                this.cancel()
            }
        })
    },
    save(){
        axios.post("api/movimientos/gastos", this.objeto)
        .then((response) => {
            if(response?.data){
                this.$toastr.success(`${response?.data?.message}`)
                this.cancel()
            }
        }).catch((err) => {
            console.log(err)
        })
    },
    getGasto(){
        this.$loader.presentLoader();
        axios.get(`api/movimientos/gastos/${this.id}`)
        .then((response) => {
            
            this.objeto = response?.data?.data ?? {};
            this.objeto.fecha = response?.data?.data?.fecha.split(' ')[0]; 
            this.$loader.dismissLoader();
        })
        .catch((err) => {
            console.log(err)
        })
    },
    openModal(id = null) {
      this.id = id;

      if(this.id){
        this.getGasto()
      }
      
      $(`#${this.idModal}`).modal('show')
    },
    
    close() {
      $(`#${this.idModal}`).modal('hide')
    },
    cancel(){
        this.v$.$reset();
        this.objeto = { fecha: null, descripcion: null, categoria_id: null, cuenta_id: null, monto: null, periodicidad: "", compania_id: null };
        this.id = null;
        this.objeto.periodicidad = ""
        this.close()
        this.$emit('update-modal');
    }
  }
}
</script>
<style scoped>
.required::after {
  content: " *" !important;
  color: red !important;
}
</style>