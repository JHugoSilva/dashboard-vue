<template>
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 v-if="!props.role.id" class="h4 text-gray-900 mb-4">
                  Create an role!
                </h1>
                <h1 v-else class="h4 text-gray-900 mb-4">Update a role!</h1>
              </div>
              <form @submit.prevent="props.role.id ? updateRole($event) : createRole($event)" class="user" method="post">
                <div class="form-group">
                  <input
                    type="text"
                    v-model="item.name_role"
                    class="form-control form-control-page"
                    id="exampleFirstName"
                    placeholder="Name"
                  />
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-role btn-block"
                >
                  {{ props.role.id ? "Update role" : "Create role" }}
                </button>
                <button
                  type="button"
                  @click="goBack()"
                  class="btn btn-info btn-role btn-block"
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
  role: {
    type: Object,
    default: "",
  },
});

const item = ref({
    name_role:"",
})
const notify = (messrole) => {
  toast.success(messrole, {
    autoClose: 3000,
    position: toast.POSITION.TOP_CENTER,
  });
};

const notifyErro = (messrole) => {
  toast.error(messrole, {
    autoClose: 3000,
    position: toast.POSITION.TOP_CENTER,
  });
};

const goBack = () => {
  emit("goBack", false);
  item.value = [];
};

const createRole = (evt) => {
  evt.preventDefault();
  if (
    item.value === ''
  ) {
    notifyErro("Please fill all fields");
  } else {
    axios
      .post("create", item.value)
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

const updateRole = (evt) => {
  evt.preventDefault();
   axios
      .put("update_role/"+props.role.id, item.value)
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
  if (props.role) {
      item.value.name_role = props.role.name_role;
  }
});
</script>