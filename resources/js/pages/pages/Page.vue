<script setup>
import { onMounted, ref } from "vue";
import axios from 'axios'
import { toast } from "vue3-toastify";
import PageAdd from './PageAdd.vue'

const isEdit = ref(false)
const page = ref([])
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

const goBack = (event) => {
    isEdit.value = event
    page.value = false
    getpages()
}

const pageAdd = () => {
    isEdit.value = true
    page.value = {}
}

const getpages = () => {
    axios.get('pages').then((res) => {
        pages.value = res.data.pages
    })
}

const pageEdit = (pageSelect) => {
    isEdit.value = true
    page.value = pageSelect
}

onMounted(()=>{
    getpages()
})

</script>
<template>
<div>
    <PageAdd v-if="isEdit" :page="page" @goBack="goBack($event)"/>
    <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">pages Table</div>
        <button class="btn btn-primary btn-circle btn-sm float-end p-3 m-2" @click="pageAdd">
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
                  <th>Page</th>
                </thead>
                <tfoot></tfoot>
                <tbody>
                  <tr v-for="page in pages" :key="page.id">
                    <td>
                      <button hidden
                        class="btn btn-danger btn-circle btn-sm"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                      <button @click="pageEdit(page)"
                        class="btn btn-info btn-circle btn-sm"
                      >
                        <i class="fas fa-pencil"></i>
                      </button>
                    </td>
                    <td>{{ page.id }}</td>
                    <td>{{ page.name }}</td>
                    <td>{{ page.icon }}</td>
                    <td>{{ page.path }}</td>
                    <td>{{ page.order }}</td>
                    <td>{{ page.page_id }}</td>
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