<script setup>
import { ref } from "vue";
import SidebarComponent from '../layouts/SidbarComponent.vue'
import TopbarComponent from '../layouts/TopbarComponent.vue'
import FooterComponent from '../layouts/FooterComponent.vue'

const toggled = ref("")

const token = localStorage.getItem('token')
const user = ref("")

axios.get('user').then((resp) => {
    user.value = resp.data.user
})

</script>


<template>
    <div id="wrapper">

        <!-- Sidebar -->
        <SidebarComponent v-if="token" :toggled="toggled"/>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <TopbarComponent v-if="token" @emitToggled="toggled=$event" :user="user"/>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                   <router-view :user="user"></router-view>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <FooterComponent v-if="token"/>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
</template>