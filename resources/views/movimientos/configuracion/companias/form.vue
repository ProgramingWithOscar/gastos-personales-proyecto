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
            Añadir compañia
          </h2>
          <h2 v-else class="h5 fw-bold text-dark mb-3">
            Editar compañia
          </h2>

          <p class="text-secondary small mb-4">
             Te permitirá clasificar tus gastos e ingresos por compañia.
          </p>

          <div>

            <div class="d-flex mb-2 flex-column">
                <div class="d-flex flex-column col-12">
                    <label for="categoria">Nombre</label>
                    <input v-model="objeto.nombre" type="text" class="form-control" id="categoria" :class="{'is-invalid': v$.objeto.nombre.$error}">
                    <div class="invalid-feedback" v-if="v$.objeto.nombre.$error">
                        Este campo es requerido
                    </div>
                </div>
                
                <div class="d-flex flex-column col-12 mt-2">
                    <label for="descripcion">Descripción</label>
                    <textarea v-model="objeto.descripcion" class="form-control" placeholder="Ingresa la descripción de la categoria"></textarea>
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
import Swal from 'sweetalert2';
import useVuelidate from '@vuelidate/core';
import {required } from '@vuelidate/validators';


export default {
  setup() {
    return { v$: useVuelidate() }
  },
  validations() {
    return {
        objeto: {
            nombre: {required}
        }
    }
  },
  props: {
    idModal: {
      type: String,
      required: false,
      default: 'kt_modal_movimientos_companias'
    }
  },
  data(){
    return {
        objeto: {
           nombre: null, 
           descripcion: null
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
    save() {
        if(this.id){
            this.update()
        }else if(!this.id){
            this.create()
        }
    },
    create(){
        axios.post("/api/movimientos/companias", this.objeto)
        .then((response) => {
            if(response?.data){
                this.$toastr.success(`${response?.data?.message}`)
                this.cancel()
            }
        }).catch((err) => {
            console.log(err)
        })
    },
    update(){
        axios.put(`/api/movimientos/companias/${this.id}`, this.objeto)
        .then((response) => {
            if(response?.data){
                this.$toastr.success(`${response?.data?.message}`)
                this.cancel()
            }
        }).catch((err) => {
            console.log(err)
        })
    },
    getCompanias(){
        this.$loader.presentLoader();
        axios.get(`/api/movimientos/companias/${this.id}`)
        .then((response) => {
            
            this.objeto = response?.data?.data ?? {};
            this.$loader.dismissLoader();
        })
        .catch((err) => {
            console.log(err)
        })
    },
    openModal(id = null) {
      this.id = id;

      if(this.id){
        this.getCompanias()
      }
      
      $(`#${this.idModal}`).modal('show')
    },
    
    close() {
      $(`#${this.idModal}`).modal('hide')
    },
    cancel(){
        this.v$.$reset();
        this.objeto = { nombre: null, descripcion: null };
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