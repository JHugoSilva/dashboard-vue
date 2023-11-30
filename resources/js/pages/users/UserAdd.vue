<script setup>
import { ref, watchEffect } from "vue";
import { toast } from "vue3-toastify";
const emit = defineEmits(['goBack'])
const props = defineProps(['user'])

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

const goBack = () => {
   emit('goBack',false)
   user.value = []
}

const user = ref({
  name: "",
  email: "",
  father_name: "",
  mobile: "",
  date_of_birth: "",
  gender:"",
  password: "",
  password_confirmation: "",
});

const genders = ref([
    {type: 'M'},
    {type: 'F'}
])


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
    notifyErro("Please fill all fields")
  } else {
    axios
      .post("create", user.value)
      .then((resp) => {
        notify(resp.data.message)
        emit('goBack', false)
      })
      .catch((err) => {
        notifyErro(err);
      });
  }
};
</script>
<template>
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form @submit.prevent="createUser" class="user" method="post">
                <div class="form-group">
                  <input
                    type="text"
                    v-model="user.name"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    v-model="user.father_name"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Father Name"
                  />
                </div>
                 <div class="form-group">
                 <input
                    type="text"
                    v-model="user.mobile"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Mobile"
                  />
                </div>
                <div class="form-group">
                 <select class="form-control"  v-model="user.gender"> 
                    <option disabled="disabled">Escolha uma opção</option>
                    <option v-for="gender in genders" :key="gender.type" :value="gender.type">{{ gender.type }}</option>
                 </select>
                </div>
                <div class="form-group">
                  <input
                    type="date"
                    v-model="user.date_of_birth"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Date of Birth"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="email"
                    v-model="user.email"
                    class="form-control form-control-user"
                    id="exampleInputEmail"
                    placeholder="Email Address"
                  />
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="password"
                      v-model="user.password"
                      class="form-control form-control-user"
                      id="exampleInputPassword"
                      placeholder="Password"
                    />
                  </div>
                  <div class="col-sm-6">
                    <input
                      type="password"
                      @change="confirmPassword"
                      v-model="user.password_confirmation"
                      class="form-control form-control-user"
                      id="exampleRepeatPassword"
                      placeholder="Repeat Password"
                    />
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  Create User
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