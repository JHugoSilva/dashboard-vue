<template>
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        {{  user.roles.value }} 
        {{ props.user.role_id }}
        <div class="row">
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 v-if="!props.user.id" class="h4 text-gray-900 mb-4">
                  Create an Account!
                </h1>
                <h1 v-else class="h4 text-gray-900 mb-4">Update a Account!</h1>
              </div>
              <form @submit.prevent="props.user.id ? updateUser($event) : createUser($event)" class="user" method="post">
                <div class="form-group">
                  <input
                    type="text"
                    v-model="user.name"
                    class="form-control form-control-user"
                    placeholder="Name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    v-model="user.father_name"
                    class="form-control form-control-user"
                    placeholder="Father Name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    v-model="user.mobile"
                    class="form-control form-control-user"
                    placeholder="Mobile"
                  />
                </div>
                <div class="form-group">
                  <select class="form-control" v-model="user.gender">
                    <option disabled="disabled">Escolha uma opção</option>
                    <option
                      v-for="gender in genders"
                      :key="gender.type"
                      :value="gender.type"
                    >
                      {{ gender.type }}
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <input
                    type="date"
                    v-model="user.date_of_birth"
                    class="form-control form-control-user"
                    placeholder="Date of Birth"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="email"
                    v-model="user.email"
                    class="form-control form-control-user"
                    placeholder="Email Address"
                  />
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="password"
                      v-model="user.password"
                      class="form-control form-control-user"
                      placeholder="Password"
                      autocomplete="0"
                    />
                  </div>
                  <div class="col-sm-6">
                    <input
                      type="password"
                      @change="confirmPassword"
                      v-model="user.password_confirmation"
                      class="form-control form-control-user"
                      placeholder="Repeat Password"
                      autocomplete="0"
                    />
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  {{ props.user.id ? "Update User" : "Create User" }}
                </button>
                <button
                  type="button"
                  @click="goBack()"
                  class="btn btn-info btn-user btn-block"
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
import { ref, onMounted, watchEffect } from "vue";
import { toast } from "vue3-toastify";
// import { onMounted, watchEffect } from "@vue/runtime-core";
import axios from "axios";
const emit = defineEmits(["goBack"]);
const props = defineProps({
  user: {
    type: Object,
    default: "",
  },
});

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
  user.value = "";
};

const user = ref({
  name: "",
  email: "",
  father_name: "",
  mobile: "",
  date_of_birth: "",
  gender: "",
  password: "",
  password_confirmation: "",
  roles: ""
});

const getRoles = () => {
  axios.get('roles').then((res) => {
    user.roles = res.data.roles
  }).catch((err) => {
    console.log(err)
  })
}

const genders = ref([{ type: "M" }, { type: "F" }]);

const confirmPassword = () => {
  if (user.password !== user.password_confirmation) {
    notifyErro("Password not match");
  }
};

const createUser = (evt) => {
  evt.preventDefault();
  if (
    user.name === "" ||
    user.email === "" ||
    user.password === "" ||
    user.password_confirmation === ""
  ) {
    notifyErro("Please fill all fields");
  } else {
    axios
      .post("create", user.value)
      .then((resp) => {
        notify(resp.data.message);
        emit("goBack", false);
      })
      .catch((err) => {
        for (let errors of err.response.data.errors) {
          notifyErro(errors);
        }
      });
  }
};

const updateUser = (evt) => {
  evt.preventDefault();
   axios
      .post("update/"+props.user.id, user.value)
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
  if (props.user) {
      user.value.id = props.user.id;
      user.value.name = props.user.name;
      user.value.email = props.user.email;
      user.value.father_name = props.user.father_name;
      user.value.date_of_birth = props.user.date_of_birth;
      user.value.gender = props.user.gender;
      user.value.mobile = props.user.mobile;
      // user.roles.value = props.user.role_id;
  }
});

onMounted(async ()=>{
  await getRoles()
})
</script>