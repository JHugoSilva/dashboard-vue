<template>
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          {{ props.page.id }}
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 v-if="!props.page.id" class="h4 text-gray-900 mb-4">
                  Create an Page!
                </h1>
                <h1 v-else class="h4 text-gray-900 mb-4">Update a Page!</h1>
              </div>
              <form @submit.prevent="props.page.id ? updatePage($event) : createPage($event)" class="user" method="post">
                <div class="form-group">
                  <input
                    type="text"
                    v-model="item.name"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Name"
                  />
                </div>
                 <div class="form-group">
                  <input
                    type="text"
                    v-model="item.path"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Path"
                  />
                </div>
                   <div class="form-group">
                  <input
                    type="text"
                    v-model="item.icon"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Icon"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    v-model="item.page_id"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Page Id"
                  />
                </div>
                   <div class="form-group">
                  <input
                    type="number"
                    v-model="item.order"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Order"
                  />
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-page btn-block"
                >
                  {{ props.page.id ? "Update Page" : "Create Page" }}
                </button>
                <button
                  type="button"
                  @click="goBack()"
                  class="btn btn-info btn-page btn-block"
                >
                  Voltar
                </button>
              </form>
              <hr />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { toast } from "vue3-toastify";
import { watchEffect } from "@vue/runtime-core";
const emit = defineEmits(["goBack"]);
const props = defineProps({
  page: {
    type: Object,
    default: "",
  },
});

const item = ref({
  
})
const notify = (message) => {
  toast.success(message, {
    autoClose: 3000,
    position: toast.POSITION.TOP_CENTER,
  });
};

const notifyErro = (message) => {
  toast.error(message, {
    autoClose: 3000,
    position: toast.POSITION.TOP_CENTER,
  });
};

const goBack = () => {
  emit("goBack", false);
  item.value = [];
};

const createPage = (evt) => {
  evt.preventDefault();
  if (
    item.value === ''
  ) {
    notifyErro("Please fill all fields");
  } else {
    axios
      .post("create_page", item.value)
      .then((resp) => {
        notify(resp.data.message);
        emit("goBack", false);
      })
      .catch((err) => {
        notifyErro(err.response.data.message)
        // for (let errors of err.response) {
        //   console.log(errors)
        //   notifyErro(errors);
        // }
      });
  }
};

const updatePage = (evt) => {
  evt.preventDefault();
   axios
      .post("update_page/"+props.page.id, item.value)
      .then((resp) => {
        notify(resp.data.message);
        emit("goBack", false);
      })
      .catch((err) => {
        for (let errors of err.response.data.errors) {
          notifyErro(errors);
        }
      });
};

watchEffect(() => {
  if (props.page) {
      item.value = props.page;
  }
});
</script>