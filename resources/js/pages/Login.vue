<script setup>
import { ref } from "vue";
const user = ref({
  email: "",
  password: ""
});

const login = (evt) => {
  evt.preventDefault();
  if (
    user.email === "" ||
    user.password === ""
  ) {
    alert("Please fill all fields")
  } else {
    axios
      .post("login", user.value)
      .then((resp) => {
        console.log(resp)
        if (resp.data.status === 200) {
          localStorage.setItem("token", resp.data.access_token);
          localStorage.setItem("user", JSON.stringify(resp.data.user));
          window.location.href = "/admin";
        } else {
          alert(resp.data.message)
        }
      })
      .catch((err) => {
        console.log(err);
      });
  }
};
</script>
<template>
  <div>
    <div class="container">
      <!-- Outer Row -->
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                    </div>
                    <form @submit.prevent="login" class="user">
                      <div class="form-group">
                        <input
                          type="email"
                          v-model="user.email"
                          class="form-control form-control-user"
                          id="exampleInputEmail"
                          aria-describedby="emailHelp"
                          placeholder="Enter Email Address..."
                        />
                      </div>
                      <div class="form-group">
                        <input
                          type="password"
                          v-model="user.password"
                          class="form-control form-control-user"
                          id="exampleInputPassword"
                          placeholder="Password"
                        />
                      </div>
                      <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                          <input
                            type="checkbox"
                            class="custom-control-input"
                            id="customCheck"
                          />
                          <label class="custom-control-label" for="customCheck"
                            >Remember Me</label
                          >
                        </div>
                      </div>
                      <button type="submit"
                        class="btn btn-primary btn-user btn-block"
                      >
                        Login
                      </button>
                    </form>
                    <hr />
                    <div class="text-center">
                      <router-link class="small" to="/forgot-password"
                        >Forgot Password?</router-link
                      >
                    </div>
                    <div class="text-center">
                      <router-link class="small" to="register"
                        >Create an Account!</router-link
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
</script>

<style>
</style>