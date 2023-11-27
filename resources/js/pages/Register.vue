<script setup>
import { ref } from "vue";
const user = ref({
  name: "",
  email: "",
  password: "",
  confirm_password: "",
});

const confirmPassword = () => {
  if (user.password !== user.confirm_password) {
    alert("Password not match");
  }
};

const register = (evt) => {
  evt.preventDefault();
  if (
    user.name === "" ||
    user.email === "" ||
    user.password === "" ||
    user.password_confirmation === ""
  ) {
    alert("Please fill all fields")
  } else {
    axios
      .post("register", user.value)
      .then((resp) => {
        console.log(resp)
        localStorage.setItem("token", resp.data.token);
        localStorage.setItem("user", JSON.stringify(resp.data.user));
        window.location.href = "/admin";
      })
      .catch((err) => {
        console.log(err);
      });
  }
};
</script>
<template>
  <div class="container">
    {{ user }}
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form @submit.prevent="register" class="user" method="post">
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
                  Register Account
                </button>
              </form>
              <hr />
              <div class="text-center">
                <router-link class="small" to="forgot-password"
                  >Forgot Password?</router-link
                >
              </div>
              <div class="text-center">
                <router-link class="small" to="login"
                  >Login!</router-link
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>