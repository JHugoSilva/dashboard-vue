<script setup>
import axios from "axios";
import { onMounted, ref, watchEffect } from "vue";

const props = defineProps(["toggled"]);

const pages = ref([]);

const getPages = async () => {
  await axios.get("pages").then((res) => {
    pages.value = res.data.pages;
  });
};

const getUser = ref(JSON.parse(localStorage.getItem("perUser")));

onMounted(async () => {
  await getPages();
});

watchEffect(() => {
  if (getUser.value == null) {
    window.location.reload();
  }
});
</script>
<template>
  <ul
    :class="`navbar-nav bg-gradient-primary sidebar sidebar-dark accordion ${toggled}`"
    id="accordionSidebar"
  >
    <!-- Sidebar - Brand -->
    <a
      class="sidebar-brand d-flex align-items-center justify-content-center"
      href="index.html"
    >
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="index.html">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a
      >
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Interface</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li v-for="page in pages" :key="page.id" class="nav-item">
      <a
      v-if="page.pages.length > 0"
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        :data-target="`#collapseTwo${page.id}`"
        aria-expanded="true"
        :aria-controls="`collapseTwo${page.id}`"
      >
        <i :class="page.icon"></i>
        <span>{{ page.name }}</span>
      </a>
      <div
        :id="`collapseTwo${page.id}`"
        class="collapse"
        aria-labelledby="headingTwo"
        data-parent="#accordionSidebar"
      >
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">{{ page.name }}</h6>
          <router-link v-for="sub in page.pages" :key="sub.id" :to="sub.path" class="collapse-item">
            <i :class="sub.icon"></i>
            <span style="color:#CCC;font-weigh:700;">{{ sub.name }}</span>
          </router-link>
        </div>
      </div>
      <router-link v-if="page.path != '#'" :to="page.path" class="nav-link">
        <i :class="page.icon"></i>
        <span>{{ page.name }}</span>
      </router-link>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider" />
  </ul>
</template>
<style>
</style>