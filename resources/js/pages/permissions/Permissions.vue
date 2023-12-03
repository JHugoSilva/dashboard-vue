<script setup>
import { onMounted, ref } from "vue";
import { toast } from "vue3-toastify";
import axios from 'axios'

const isEdit = ref(false)
const permission = ref({})
const permissions = ref([])
const role_id = ref(0)
const roles = ref([])
const pages = ref([])

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

const getPermissions = () => {
    axios.get(`permissions/${role_id.value}`).then((res) => {
        permissions.value = res.data.Permissions
    })
}

const getRoles = () => {
  axios.get('roles').then((res) => {
    roles.value = res.data.roles
    notify(res.data.message)
  })
}

const getPages = () => {
  axios.get('pages').then((res)=>{
    pages.value = res.data.pages

  })
}

const permissionEdit = (PermissionSelect) => {
    isEdit.value = true
    permission.value = PermissionSelect
}

onMounted(async ()=> {
    await getPermissions()
    await getRoles()
})

</script>
<template>
<div>
    <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">Permissions Table</div>
        <button class="btn btn-primary btn-circle btn-sm float-end p-3 m-2" @click="PermissionAdd">
            <i class="fas fa-plus"></i>
        </button>
        <div class="card-body p-0">
            <div class="table-responsive">
                 <table class="table table-bordered text-center" width="100%">
                <thead>
                  <th>Actions</th>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Icon</th>
                  <th>Path</th>
                  <th>Order</th>
                  <th>Permission</th>
                </thead>
                <tfoot></tfoot>
                <tbody>
                  <tr v-for="permission in permissions" :key="permission.id">
                    <td>
                      <button hidden
                        class="btn btn-danger btn-circle btn-sm"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                      <button @click="permissionEdit(Permission)"
                        class="btn btn-info btn-circle btn-sm"
                      >
                        <i class="fas fa-pencil"></i>
                      </button>
                    </td>
                    <td>{{ permission.id }}</td>
                    <td>{{ permission.name }}</td>
                    <td>{{ permission.icon }}</td>
                    <td>{{ permission.path }}</td>
                    <td>{{ permission.order }}</td>
                    <td>{{ permission.permission_id }}</td>
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