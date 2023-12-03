<script setup>
import { onMounted, ref } from "vue";
import axios from 'axios'
import { toast } from "vue3-toastify";
import RoleAdd from './RoleAdd.vue'

const isEdit = ref(false)
const role = ref([])
const roles = ref([])

const notify = (message) => {
    toast.success(message, {
        autoClose: 3000,
        position: toast.POSITION.TOP_CENTER
    })
}

const notifyErro = (message) => {
    toast.error(message, {
        autoClose: 3000,
        position: toast.POSITION.TOP_CENTER
    })
}

const goBack = (event) => {
    isEdit.value = event
    role.value = false
    getroles()
}

const roleAdd = () => {
    isEdit.value = true
    role.value = {}
}

const getroles = () => {
    axios.get('roles').then((res) => {
        roles.value = res.data.roles
        console.log(res.data.roles)
        // notify(res.data.message)
    })
}

const roleEdit = (roleSelect) => {
    isEdit.value = true
    role.value = roleSelect
}

onMounted(()=>{
    getroles()
})

</script>
<template>
<div>
    <RoleAdd v-if="isEdit" :role="role" @goBack="goBack($event)"/>
    <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">roles Table</div>
        <button class="btn btn-primary btn-circle btn-sm float-end p-3 m-2" @click="roleAdd">
            <i class="fas fa-plus"></i>
        </button>
        <div class="card-body p-0">
            <div class="table-responsive">
                 <table class="table table-bordered text-center" width="100%">
                <thead>
                  <th>Actions</th>
                  <th>Id</th>
                  <th>Name</th>
                </thead>
                <tfoot></tfoot>
                <tbody>
                  <tr v-for="role in roles" :key="role.id">
                    <td>
                      <button hidden
                        class="btn btn-danger btn-circle btn-sm"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                      <button @click="roleEdit(role)"
                        class="btn btn-info btn-circle btn-sm"
                      >
                        <i class="fas fa-pencil"></i>
                      </button>
                    </td>
                    <td>{{ role.id }}</td>
                    <td>{{ role.name_role }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
</template>


<style>

</style>