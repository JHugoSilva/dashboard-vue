
<script setup>
import { onMounted, ref } from "vue";
import axios from 'axios'
import { toast } from "vue3-toastify";
import AddUser from './UserAdd.vue'

const isEdit = ref(false)
const user = ref([])
const users = ref([])
const page = ref(1)

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
    user.value = false
    getUsers(page)
}

const addUser = () => {
    isEdit.value = true
    user.value = {}
}

const getUsers = (page) => {
    axios.get(`index?page=${page}`).then((res) => {
        users.value = res.data.users.data
        // notify(res.data.message)
    })
}

const userEdit = (userSelect) => {
    isEdit.value = true
    user.value = userSelect
}

onMounted(()=>{
    getUsers(page)
})

</script>
<template>
<div>
    <AddUser v-if="isEdit" :user="user" @goBack="goBack($event)"/>
    <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">Users Table</div>
        <button class="btn btn-primary btn-circle btn-sm float-end p-3 m-2" @click="addUser">
            <i class="fas fa-plus"></i>
        </button>
        <div class="card-body p-0">
            <div class="table-responsive">
                 <table class="table table-bordered text-center" width="100%">
                <thead>
                  <th>Actions</th>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                </thead>
                <tfoot></tfoot>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>
                      <button hidden
                        class="btn btn-danger btn-circle btn-sm"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                      <button @click="userEdit(user)"
                        class="btn btn-info btn-circle btn-sm"
                      >
                        <i class="fas fa-pencil"></i>
                      </button>
                    </td>
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.mobile }}</td>
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